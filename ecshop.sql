truncate goods;
truncate goods_cat;
truncate member_price;


create database ecshop;
use ecshop;

create table goods
(
	id mediumint unsigned not null auto_increment comment 'Id',
	goods_name varchar(150) not null comment '商品名称',
	market_price decimal(10,2) not null comment '市场价格',
	shop_price decimal(10,2) not null comment '本店价格',
	goods_desc longtext comment '商品描述',
	is_on_sale enum('是','否') not null default '是' comment '是否上架',
	is_delete enum('是','否') not null default '否' comment '是否放到回收站',
	addtime datetime not null comment '添加时间',
	logo varchar(150) not null default '' comment '原图',
	sm_logo varchar(150) not null default '' comment '小图',
	mid_logo varchar(150) not null default '' comment '中图',
	big_logo varchar(150) not null default '' comment '大图',
	mbig_logo varchar(150) not null default '' comment '更大图',
	brand_id mediumint unsigned not null default 0 comment'品牌id',
	cat_id int unsigned not null default 0 comment'分类id',
	type_id mediumint unsigned not null default '0' comment '类型Id',
	primary key (id),
	key cat_id(cat_id),
	key shop_price(shop_price),
	key addtime(addtime),
	key brand_id(brand_id),
	key is_on_sale(is_on_sale),
	key type_id(type_id)
)engine=InnoDB default charset=utf8 comment '商品';

create table brand
(
	id mediumint unsigned not null auto_increment comment 'Id',
	brand_name varchar(30) not null comment '品牌名称',
	site_url varchar(150) not null default '' comment '官方网址',
	logo varchar(150) not null default '' comment '品牌Logo图片',
	primary key (id)
)engine=InnoDB default charset=utf8 comment '品牌';


create table member_level
(
	id mediumint unsigned not null primary key auto_increment comment 'Id',
	level_name varchar(30) not null comment '级别名称',
	jifen_bottom mediumint unsigned not null comment '积分下限',
	jifen_top mediumint unsigned not null comment '积分上限'
)engine=InnoDB default charset=utf8 comment '会员级别';

create table member_price
(
	price decimal(10,2) not null comment '会员价格',
	level_id mediumint unsigned not null comment '级别Id',
	goods_id mediumint unsigned not null comment '商品Id',
	key level_id(level_id),
	key goods_id(goods_id)
)engine=InnoDB default charset=utf8 comment '会员价格';

create table category
(
	cat_id int unsigned primary key auto_increment comment'商品分类id',
	cat_name varchar(50) not null comment'商品分类名称',
	pid int not null default 0 comment'商品分类父类id 0代表顶级菜单',
	key cat_id (cat_id)
)engine=InnoDB default charset=utf8 comment '商品分类';

INSERT  category (`cat_id`, `cat_name`, `pid`) VALUES
(1, '家用电器', 0),
(2, '手机、数码、京东通信', 0),
(3, '电脑、办公', 0),
(4, '家居、家具、家装、厨具', 0),
(5, '男装、女装、内衣、珠宝', 0),
(6, '个护化妆', 0),
(21, 'iphone', 2),
(8, '运动户外', 0),
(9, '汽车、汽车用品', 0),
(10, '母婴、玩具乐器', 0),
(11, '食品、酒类、生鲜、特产', 0),
(12, '营养保健', 0),
(13, '图书、音像、电子书', 0),
(14, '彩票、旅行、充值、票务', 0),
(15, '理财、众筹、白条、保险', 0),
(16, '大家电', 1),
(17, '生活电器', 1),
(18, '厨房电器', 1),
(19, '个护健康', 1),
(20, '五金家装', 1),
(22, '冰箱', 16);

create table goods_cat
(
	cat_id int not null comment'分类Id',
	goods_id int not null comment'商品Id',
	key cat_id(cat_id),
	key goods_id(goods_id)
)engine=InnoDB default charset=utf8 comment '扩展类';


create table goods_pic
(
	id mediumint unsigned not null auto_increment comment 'Id',
	pic varchar(150) not null comment '原图',
	sm_pic varchar(150) not null comment '小图',
	mid_pic varchar(150) not null comment '中图',
	big_pic varchar(150) not null comment '大图',
	goods_id mediumint unsigned not null comment '商品Id',
	primary key (id),
	key goods_id(goods_id)
)engine=InnoDB default charset=utf8 comment '商品相册';

/****************************** 属性相关表 ****************************************/
create table type
(
	id mediumint unsigned not null auto_increment comment 'Id',
	type_name varchar(30) not null comment '类型名称',
	primary key (id)
)engine=InnoDB default charset=utf8 comment '类型';

insert type (type_name) value
("手机"),
("服饰");


create table attribute
(
	id mediumint unsigned not null auto_increment comment 'Id',
	attr_name varchar(30) not null comment '属性名称',
	attr_type enum('唯一','可选') not null comment '属性类型',
	attr_option_values varchar(300) not null default '' comment '属性可选值',
	type_id mediumint unsigned not null comment '所属类型Id',
	primary key (id),
	key type_id(type_id)
)engine=InnoDB default charset=utf8 comment '属性表';

insert attribute (attr_name,attr_type,attr_option_values,type_id) value ("颜色","可选","白色,黑色,绿色,紫色,蓝色,金色,银色,粉色,富士白",1);
insert attribute (attr_name,attr_type,attr_option_values,type_id) value ("内存","可选","4g,16g,32g,64g",1);
insert attribute (attr_name,attr_type,attr_option_values,type_id) value ("颜色","可选","白色,黑色,绿色,蓝色,紫色,粉色",2);
insert attribute (attr_name,attr_type,attr_option_values,type_id) value ("尺码","可选","S,M,X,XL,XXL,XXXL,XXXXL",2);
insert attribute (attr_name,attr_type,attr_option_values,type_id) value ("材质","唯一","",2);



create table goods_attr
(
	id mediumint unsigned not null auto_increment comment 'Id',
	attr_value varchar(150) not null default '' comment '属性值',
	attr_id mediumint unsigned not null comment '属性Id',
	goods_id mediumint unsigned not null comment '商品Id',
	primary key (id),
	key goods_id(goods_id),
	key attr_id(attr_id)
)engine=InnoDB default charset=utf8 comment '商品属性';


create table goods_number
(
	goods_id mediumint unsigned not null comment '商品Id',
	goods_number mediumint unsigned not null default '0' comment '库存量',
	goods_attr_id varchar(150) not null comment '商品属性表的ID,如果有多个，就用程序拼成字符串存到这个字段中',
	key goods_id(goods_id)
)engine=InnoDB default charset=utf8 comment '库存量';


