<?php
namespace Admin\Controller;
use Think\Controller;
class CategoryController extends ParentController
{
	public function lst()
	{
		echo '<meta charset="utf-8">';
		//获取数据库的对象
		$model=D("Category");
		//var_dump($model);die;
		$data=$model->tree();
		$this->assign('data',$data);
		$this->display('lst');
	}
	public function delete()
	{
		$model=D('Category');
		//在调用子类中删除这个分类以及子类的函数
		$model->deleteCatAndChildren((int)I('get.id',0));
		$this->success('删除成功',U('lst'));
	}
	public function add()
	{
		$model=D('Category');
		if(IS_POST)
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
		}	
	}
	public function edit()
	{
		//先取出所有的分类
		$model=D('Category');
		if(IS_POST)
		{
			if($model->create())
			{
				$model->save();
				$this->success('修改成功',U('lst'));
				exit;
			}
			else
			{
				$this->error($model->getError());
			}		
		}
		else
		{
			//取出所有的分类
			$data=$model->tree();
			$this->assign('data',$data);
			//取出这个分类的所有信息
			$info=$model->find((int)I('get.id'),0);
			$this->assign('info',$info);
			//然后在取出这个分类的子分类的ID
			$children=$model->children($info['id']);
			$this->assign('children',$children);
			$this->display('edit');
		}
	}
}