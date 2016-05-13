<?php
namespace Admin\Model;
use Think\Model;
class RoleModel extends Model
{
	protected $_validate=[
	['role_name','require','角色名称不能为空',1],
	//用一个回调函数来验证
	['pri_id','chkPriId','必须选权限',1,'callback'],
	['role_name','','角色名称已经存在，不能重复添加！',1,'unique']
	];
	public function chkPriId($priId)
	{
		return !empty($priId);
	}
	public function adv_add()
	{
		//把角色名称插入到角色表
		//返回新记录的ID
		$id=$this->add();
		//var_dump($id);die;
		//把表单中的权限表插入到角色权限表
		$priId=I('post.pri_id');
		//获取角色权限表的模型
		$prmodel=D('role_pri');
		//循环每个权限
		foreach ($priId as $k => $v)
		{
			$prmodel->add([
				'role_id'=>$id,
				'pri_id'=>$v,
				]);
		}
	}
	public function search()
	{
		//搜索
		$where=[];
		$rn=I('get.rn');
		//如果$rn存在的话
		if($rn)
			$where['role_name']=['LIKE',"%$rn%"];
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
					->field('a.*,GROUP_CONCAT(c.pri_name) pri_name')
					->join('LEFT JOIN __ROLE_PRI__ b ON a.id=b.role_id
							LEFT JOIN __PRIVILEGE__ c ON b.pri_id=c.id'
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
	public function adv_delete($roleId)
	{
		//把角色表中的角色删除
		$this->delete($roleId);
		//把角色权限表的数据也删除
		$rpModel=D('role_pri');
		//
		$rpModel->where([
			'role_id'=>['eq',$roleId],
			])->delete();
	}
	public function adv_save()
	{
		//更新角色名称
		$this->save();
		//更新权限
		//1先删除旧权限
		$roleId=(int)I('post.id',0);
		$rpModel=D('role_pri');
		$rpModel->where([
			'role_id'=>['eq',$roleId],
			])->delete();

		//把新勾选的权限添加到角色权限表中
		$priId=I('post.pri_id');
		foreach ($priId as $k=>$v)
		{
			$rpModel->add([
				'role_id'=>$roleId,
				'pri_id'=>$v,
				]);

		}
	}
}