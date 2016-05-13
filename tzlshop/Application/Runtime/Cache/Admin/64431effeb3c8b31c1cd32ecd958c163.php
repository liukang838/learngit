<?php if (!defined('THINK_PATH')) exit();?><!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<title>管理中心 - 角色列表 </title>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<link href="/Public/Admin/Styles/general.css" rel="stylesheet" type="text/css" />
<link href="/Public/Admin/Styles/main.css" rel="stylesheet" type="text/css" />
</head>
<body>
<h1>
    <span class="action-span"><a href="<?=U('add')?>">添加新角色</a></span>
    <span class="action-span1"><a href="__GROUP__">管理中心</a></span>
    <span id="search_id" class="action-span1"> - 角色列表 </span>
    <div style="clear:both"></div>
</h1>
<div class="form-div">
    <form>
        <img src="/public/Admin/Images/icon_search.gif" width="26" height="22" border="0" alt="search" />
        角色名称<input value="<?=I('get.rn')?>"  type="text" name="rn" size="25" />
        <input type="submit" value="搜索" class="button" />
    </form>
</div>

<!-- 角色列表 -->
    <div class="list-div" id="listDiv">
        <table cellpadding="3" cellspacing="1">
            <tr>
                <th width="40">Id</th>
                <th>角色名称</th>
                <th>权限名称</th>
                <th width="80">操作</th>
            </tr>
            <?php foreach($data as $k => $v): ?>
                <tr>
                    <td><?=$v['id']?></td>
                    <td><?=$v['role_name']?></td>
                    <td><?=$v['pri_name']?></td>
                    <td>
                    <a href="<?=U('edit?id='.$v['id'])?>">修改</a>
                    <a onclick="return confirm('确定要删除吗？')" href="<?=U('delete?id='.$v['id'])?>">删除</a>
                    </td>
                </tr>
            <?php endforeach; ?>
            <tr>
                <tr><td colspan="4" align="center" class="page"><?=$page?></td> </tr>
            </tr>
        </table>
    </div>

<div id="footer">特战旅商城后台2016</div>
</body>
</html>