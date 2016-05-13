<?php
namespace Admin\Controller;
use Think\Controller;
class RoleController extends ParentController
{
	public function lst()
	{
		//echo '<meta charset="utf-8">';
		//获取数据库中角色的数据
		//取角色权限表中的数据
		//获取数据库的对象
		$model=D('Role');
		$data=$model->search();
		$this->assign($data);
		$this->display();
	}
	public function delete()
	{
		$model=D('Role');
		//在调用子类中删除这个分类以及子类的函数
		$model->adv_delete((int)I('get.id',0));
		$this->success('删除成功',U('lst'));
	}
	public function add()
	{
		
		if(IS_POST)
		{

			$rm =D('Role');
			// dump($rm->create());die;
			if($rm->create())
			{
				$rm->adv_add();
				$this->success('添加成功',U('lst'));
				exit;
			}
			$this->error($rm->getError());
		}
		$primodel=D('Privilege');
		$priData=$primodel->tree();
		//var_dump($priData);die;
		$this->assign('priData',$priData);
		$this->display();
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
		$rModel=D('Role');
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
		//先取出所有的权限
		$priModel=D('Privilege');
		$priData=$priModel->tree();
		//var_dump($priData['role_name']);die;
		$this->assign('priData',$priData);
		
		//取出要修改的这个角色的基本信息
		
		$info=$rModel->find((int)I('get.id',0));
		$this->assign('info',$info);


		$rpModel=D('role_pri');
		$rpData=$rpModel->field('GROUP_CONCAT(pri_id) pri_id')->where([
			'role_id'=>['eq',$info['id']],
			])->find();
		$this->assign('pri_id',$rpData['pri_id']);
		$this->display();
	}
}