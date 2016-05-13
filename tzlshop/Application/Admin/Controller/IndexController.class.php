<?php
namespace Admin\Controller;
use Think\Controller;
class IndexController extends ParentController
{
	public function index()
	{
		$this->display('index');
	}
	public function main()
	{
		$this->display('main');
	}
	public function menu()
	{
		$model=D('Admin');
		$this->assign('menu',$model->getMenu());
		$this->display('menu');
	}
	public function top()
	{
		$this->display('top');
	}
}