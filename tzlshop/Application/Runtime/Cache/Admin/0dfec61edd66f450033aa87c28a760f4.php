<?php if (!defined('THINK_PATH')) exit();?><!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml"><head>
<title>特战旅后台登录</title> 
<meta http-equiv="Content-Type" content="text/html; charset=utf-8">
<link href="/Public/Admin/Styles/login2.css" rel="stylesheet" type="text/css" />
</head>
<body>
<h1>特战旅商城后台登录<sup>2016</sup></h1>

<div class="login" style="margin-top:50px;">
    
    <div class="header">
        <div class="switch" id="switch"><a class="switch_btn_focus" id="switch_qlogin" href="javascript:void(0);" tabindex="7">后台登录</a>
        </div>
    </div>    
  
    
    <div class="web_qr_login" id="web_qr_login" style="display: block; height: 345px;">    

            <!--登录-->
            <div class="web_login" id="web_login">
               <div class="login-box">
			<div class="login_form">
				<form method="post" name="loginform" accept-charset="utf-8" id="login_form" class="loginForm"><input type="hidden" name="did" value="0"/>
               <input type="hidden" name="to" value="log"/>
                <div class="uinArea" id="uinArea">
                  <label class="input-tips" for="u">帐号：</label>
                  <div class="inputOuter" id="uArea">
                      <input type="text" id="u" name="account" class="inputstyle"/>
                  </div>
                </div>

                <div class="pwdArea" id="pwdArea">
               <label class="input-tips" for="p">密码：</label> 
               <div class="inputOuter" id="pArea">
                    <input type="password" id="p" name="password" class="inputstyle"/>
                </div>
                </div>

                 <div class="pwdArea">
               <label class="input-tips" for="p">验证码：</label> 
               <div class="inputOuter" id="pArea">
                    <input type="password" id="p" name="captcha" class="inputstyle"/>
                </div>
                </div>
                <img style="cursor: pointer;" onclick="this.src='<?=U('captcha')?>?'+Math.random();" src="<?=U('captcha')?>">
               
                <div style="padding-left:50px;margin-top:20px;"><input type="submit" value="登 录" style="width:150px;" class="button_blue"/></div>
              </form>
           </div>
           
            	</div>
               
            </div>
            <!--登录end-->
  </div>
</div>
</body></html>