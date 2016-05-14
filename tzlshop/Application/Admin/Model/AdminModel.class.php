<?php
namespace Admin\Model;
use Think\Model;
class AdminModel extends Model
{
	protected $_validate=[
	['account','require','角色名称不能为空',1],
	//用一个回调函数来验证
	['role_id','chkPriId','必须选角色',1,'callback'],
	//['pri_id','chkPriId','必须选权限',1,'callback'],
	['account','','管理员名称已经存在，不能重复添加！',1,'unique'],
	];

	public $_login_validate=[
		['account','require','账号不能为空',1],
		['password','require','密码不能为空',1,'regex',1],
		['captcha','require','验证码不能为空',1],
		['captcha','chkCaptcha','验证码不正确',1,'callback'],
	];
	//用来验证验证码
	public function chkCaptcha($captcha)
	{
		$verify =new \Think\Verify();
		return $verify->check($captcha);
	}

	public function chkPriId($priId)
	{
		return !empty($priId);
	}
	public function adv_add()
	{
		//把角色名称插入到角色表
		//返回新记录的ID
		$this->password=md5($this->password.C('MD5_SALT'));
		$adminId=$this->add();
		//var_dump($adminId);die;
		//把表单中的权限表插入到角色权限表
		$roleId=I('post.role_id');
		//var_dump($roleId);die;
		//获取角色权限表的模型
		$armodel=D('admin_role');
		//var_dump($armodel);die;
		//循环每个权限
		foreach ($roleId as $k => $v)
		{
			$armodel->add([
				'admin_id'=>$adminId,
				'role_id'=>$v,
				]);
			//echo $this->getLastSql();die;
		}

	}
	public function search()
	{
		//搜索
		$where=[];
		$an=I('get.account');
		//如果$rn存在的话
		if($an)
			$where['account']=['LIKE',"%$an%"];
		//排序
		$orderby='id';
		$orderway='desc';
		//翻页
		//取出总的记录数
		$count=$this->where($where)->count();
		$pageOgj=new \Think\Page($count,4);
		$pageOgj->setConfig('prev','上一页');
		$pageOgj->setConfig('next','下一页');
		$pageString=$pageOgj->show();
		//取数据
		$data=$this->alias('a')
					->field('a.*,GROUP_CONCAT(c.role_name) role_name')
					->join('LEFT JOIN __ADMIN_ROLE__ b ON a.id=b.admin_id
							LEFT JOIN __ROLE__ c ON b.role_id=c.id'
							)
					->where($where)
					->group('a.id')
					->order("$orderby $orderway")
					->limit($pageOgj->firstRow.','.$pageOgj->listRows)
					->select();
		return [
		'page'=>$pageString,
		'data'=>$data,
		];
	}
	public function adv_delete($adminId)
	{
		//把管理员表中的角色删除
		$this->delete($adminId);
		//把管理员角色表的数据也删除
		$rpModel=D('admin_role');
		//
		$rpModel->where([
			'admin_id'=>['eq',$adminId],
			])->delete();
	}
	public function adv_save()
	{
		//更新管理员名称
		$this->save();
		//更新权限
		//1先删除旧角色
		$adminId=(int)I('post.id',0);
		$arModel=D('admin_role');
		$arModel->where([
			'admin_id'=>['eq',$adminId],
			])->delete();

		//把新勾选的角色添加到管理员角色表中
		$roleId=I('post.role_id');
		var_dump($roleId);die;
		foreach ($roleId as $k=>$v)
		{
			$arModel->add([
				'admin_id'=>$adminId,
				'role_id'=>$v,
				]);

		}
	}
	public function login()
	{
		//先获取用户名和密码
		$account=$this->account;
		$passwor=md5($this->password.C('MD5_SALT'));
		//根据用户名取出用户的信息
		$user=$this->where([
			'account'=>$account,
			])->find();
		if($user)
		{
			if($user['password']=md5($password.C('MD5_SALT')))
			{
				$_SESSION['id']=$user['id'];
				$_SESSION['account']=$user['account'];
				return TRUE;
			}
			else
				return FALSE;
		}
		else
			return FALSE;
	}
	public function myPrivilege()
	{
		//管理员角色表中取出数据
		$armodel=D('admin_role');
		$priData=$armodel->alias('a')
		->field('DISTINCT c.m_name,c.c_name,c.a_name')
		->join('LEFT JOIN __ROLE_PRI__ b ON a.role_id=b.role_id
				LEFT JOIN __PRIVILEGE__ c ON b.pri_id=c.id')
		->where([
			'admin_id'=>$_SESSION['id'],
			'id'=>['EXP','is not null'],
			'c_name'=>['neq',''],
			])->select();
		//var_dump($priData);die;
		return $priData;
	}
	public function getMenu()
	{
		//先取出所有的权限
		$arModel =D('admin_role');
		if($_SESSION['id']==1)
		{
			$priModel=D('Privilege');
			$all=$priModel->select();
		}
		else
		{
			$all=$arModel->alias('a')
						->field('DISTINCT c.*')
						->join('LEFT JOIN __ROLE_PRI__ b ON a.role_id=b.role_id
							LEFT JOIN __PRIVILEGE__ c ON b.pri_id=c.id
							')
						->where([
							'admin_id'=>$_SESSION['id'],
							'id'=>['EXP','is not null'],
							])->select();
						//echo $this->getLastSql;die;
		}
		$menus=[];
		foreach($all as $k=>$v)
		{
			if($v['parent_id']==0)
			{
				foreach($all as $k1=>$v1)
				{
					if($v1['parent_id']==$v['id'])
						$v['children'][]=$v1;
				}
				$menus[]=$v;
			}
		}
		return $menus;
	}

}