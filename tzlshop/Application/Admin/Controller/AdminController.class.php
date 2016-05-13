<?php
namespace Admin\Controller;
use Think\Controller;
class AdminController extends ParentController
{
	public function lst()
	{
		//echo '<meta charset="utf-8">';
		//获取数据库中角色的数据
		//取角色权限表中的数据
		//获取数据库的对象
		$model=D('Admin');
		$data=$model->search();
		$this->assign($data);
		$this->display();
	}
	public function delete()
	{
		$model=D('Admin');
		//在调用子类中删除这个分类以及子类的函数
		$id=(int)I('get.id',0);
		if($id>1)
		 	$model->adv_delete($id);
		$this->success('删除成功',U('lst'));
	}
	public function add()
	{
		
		if(IS_POST)
		{
			//var_dump($_POST);die;
			$am =D('Admin');
			//dump($am);die;

			if($am->create())
			{
				//var_dump($am->create());die;
				//var_dump($am->create());die;
				$am->adv_add();
				$this->success('添加成功',U('lst'));
				exit;
			}
			else
			{
				$this->error($am->getError('添加失败'));
			}
			
		}
		else
		{
			$rmodel=D('Role');
			$rData=$rmodel->select();
			//var_dump($rData);die;
			//var_dump($priData);die;
			$this->assign('rData',$rData);
			$this->display();
		}
		
		/*if(IS_POST)
		{
			if($model->create())
			{
				$model->add();
				$this->success('添加成功',U('lst'));
			}
			else
			$this->error($model->getError());	
		}
		else 
		{
			$data=$model->tree();
			$this->assign('data',$data);
			$this->display('add');
		}	*/
	}
	public function edit()
	{
		$rModel=D('Admin');
		if(IS_POST)
		{
			if($rModel->create())
			{
				$rModel->adv_save();
				$this->success('修改成功',U('lst'));
				exit;
			}
			else
			{
				$this->error($rModel->getError());
			}	
		}
		//先取出所有的角色
		$roleModel=D('Role');
		$roleData=$roleModel->select();
		//var_dump($priData['role_name']);die;
		$this->assign('roleData',$roleData);
		
		//取出要修改的这个管理员的基本信息
		
		$info=$rModel->find((int)I('get.id',0));
		//var_dump($info);die;
		$this->assign('info',$info);


		$arModel=D('admin_role');
		$arData=$arModel->field('GROUP_CONCAT(role_id) role_id')->where([
			'admin_id'=>['eq',$info['id']],
			])->find();
		$this->assign('role_id',$arData['role_id']);
		$this->display();
	}
}