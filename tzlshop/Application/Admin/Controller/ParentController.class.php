<?php
namespace Admin\Controller;
use Think\Controller;
class ParentController extends Controller
{
	public function __construct()
	{
		//固定语法
		parent::__construct();
		if(!isset($_SESSION['id']))
			$this->error('必须先登录！',U('Login/login'));
		//////////////////////再判断是否有权限访问
		if($_SESSION['id']>1)
		{
			$a=D('admin');
			$priData=$a->myPrivilege();
			foreach ($priData as $k=>$v)
			{	
				//var_dump($v);
				if($v['m_name']==MODULE_NAME && $v['c_name']==CONTROLLER_NAME && $v['a_name']==ACTION_NAME)
				{
					$ok=1;
					break;
				}
			}
			//var_dump($ok);die;
			if(!isset($ok))
				$this->error('无权访问');
		}
		
	}
}