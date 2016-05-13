<?php
namespace Admin\Controller;
use Think\Controller;
class LoginController extends Controller
{
	public function login()
	{
		if(IS_POST)
		{
			$model=D('Admin');
			//想要用自己设置的验证规则来验证就要用到下面的代码格式
			if($model->validate($model->_login_validate)->create())
			{						
				if($model->login())
					$this->success('登录成功',U('Index/index'));
				else
					$this->error('用户名或者密码错误');
			}
			else
				$this->error($model->getError());
		}
		else
			$this->display();
	}
	public function captcha()
	{
		$Verify=new \Think\Verify();
		$Verify->entry();
	}
	public function logout()
	{
		$_SESSION['id']='';
		$this->redirect('Login/login');
	}
}