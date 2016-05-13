<?php if (!defined('THINK_PATH')) exit();?><!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<title>管理中心 - 权限列表 </title>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<link href="/Public/Admin/Styles/general.css" rel="stylesheet" type="text/css" />
<link href="/Public/Admin/Styles/main.css" rel="stylesheet" type="text/css" />
</head>
<body>
<h1>
    <span class="action-span"><a href="<?=U('add')?>">添加新权限</a></span>
    <span class="action-span1"><a href="__GROUP__">管理中心</a></span>
    <span id="search_id" class="action-span1"> - 权限列表 </span>
    <div style="clear:both"></div>
</h1>


<!-- 权限列表 -->
    <div class="list-div" id="listDiv">
        <table cellpadding="3" cellspacing="1">
            <tr>
                <th width="40">Id</th>
                <th>权限名称</th>
                <th>模块名称</th>
                <th>控制器名称</th>
                <th>方法名称</th>
                <th width="80">操作</th>
            </tr>
            <?php foreach($data as $k => $v): ?>
                <tr>
                    <td><?=$v['id']?></td>
                    <td><?=str_repeat('*',$v['level']*8).$v['pri_name']?></td>
                    <td><?=$v['m_name']?></td>
                    <td><?=$v['c_name']?></td>
                    <td><?=$v['a_name']?></td>
                    <td>
                    <a href="<?=U('edit?id='.$v['id'])?>">修改</a>
                    <a onclick="return confirm('确定要删除吗？')" href="<?=U('delete?id='.$v['id'])?>">删除</a>
                    </td>
                </tr>
            <?php endforeach; ?>
        </table>
    </div>

<div id="footer">特战旅商城后台2016</div>
</body>
</html>