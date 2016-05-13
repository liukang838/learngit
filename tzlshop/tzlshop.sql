CREATE DATABASE tzl_shop DEFAULT CHARSET utf8;
USE tzl_shop;
SET NAMES utf8;

CREATE TABLE tzl_goods
(
	id mediumint unsigned not null auto_increment,
	goods_name varchar(150) not null comment '商品名称',
	goods_desc longtext comment '商品描述',
	market_price decimal(10,2) not null comment '市场价格-最多10位，其中2位是小数',
	shop_price decimal(10,2) not null comment '本店价格',
	logo varchar(150) not null default '' comment 'logo原图',
	sm_logo varchar(150) not null default '' comment '小的LOGO',
	mid_logo varchar(150) not null default '' comment '中的LOGO',
	big_logo varchar(150) not null default '' comment '大的LOGO',
	primary key (id)
)engine=InnoDB;

create table tzl_category
(
 	id mediumint unsigned not null auto_increment,
 	cat_name varchar(30) not null comment '分类名称',
 	primary key(id)
)engine=InnoDB comment '分类表';

create table tzl_cat_property
(
	id mediumint unsigned not null auto_increment,
	pro_name varchar(30) not null comment '属性名称',
	pro_cat enum('全部','唯一','可选') not null comment '属性的类型',
	pro_choose varchar(30) not null comment '可选属性'
	cat_id mediumint unsigned not null comment '类型的ID',
	primary key (id)
)engine=InnoDB comment '类型属性表';

create table tzl_vip
(
	id mediumint unsigned not null auto_increment,
	vip_name varchar(30) not null comment '会员账户名称',
	vip_password varchar(30) not null comment '会员密码',
	vip_ integral mediumint unsigned not null comment '会员积分',
	class_id mediumint unsigned not null comment '会员等级ID',
	primary key (id)
)engine=InnoDB comment '会员积分信息表';

create table tzl_vip_class
(
	id mediumint unsigned not null auto_increment,
	vip_class varchar(30) not null,
	primary key (id)
)engine=InnoDB comment '会员等级表'

create table tzl_price
(
	id mediumint unsigned not null auto_increment,
	price mediumint unsigned not null,
	vip_price mediumint unsigned not null,
	svip_price mediumint unsigned not null,
	ssvip_price mediumint unsigned not null,
	primary key(id)
)engine=InnoDB comment '价格表';



create table tzl_privilege
(
	id mediumint unsigned not null auto_increment,
	pri_name varchar(30) not null comment '权限名称',
	m_name varchar(30) not null comment '模块名称',
	c_name varchar(30) not null comment '控制器名称',
	a_name varchar(30) not null comment '方法名称',
	parent_id mediumint not null default '0' comment '上级权限，0：顶级权限',
	primary key(id)
)engine=InnoDB comment '权限表';

create table tzl_role
(
	id mediumint unsigned not null auto_increment,
	role_name varchar(30) not null comment '角色名称',
	primary key(id)
)engine=InnoDB comment '角色表';

create table tzl_role_pri
(
	role_id mediumint unsigned not null comment '角色ID',
	pri_id mediumint unsigned not null comment '权限ID',
	primary key(role_id,pri_id)
)engine=InnoDB  comment '角色权限表';

create table tzl_admin
(
	id mediumint unsigned not null auto_increment comment '管理员ID',
	account varchar(30) not null comment '账号',
	password char(32) not null comment '密码',
	tel char(11) not null comment '手机',
	primary key(id)
)engine=InnoDB comment '管理员表';
INSERT INTO tzl_admin (id,account,password) VALUES(1,'root','6619a629a29f07c978b604cc16aeeb48');

create table tzl_admin_role
(
	admin_id mediumint unsigned not null comment '管理员ID',
	role_id mediumint unsigned not null comment '角色ID',
	primary key(admin_id,role_id)
)engine=InnoDB comment '管理员所在的角色';

