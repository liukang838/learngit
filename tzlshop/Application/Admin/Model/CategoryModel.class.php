<?php
namespace Admin\Model;
use Think\Model;
class CategoryModel extends Model
{
	protected $_validate=[
	['cat_name','require','分类名称不能为空',1],
	['cat_name','','分类名称已经存在，不能重复添加！',1,'unique']
	];
	public function tree()
	{
		//取出所有的数据
		$data=$this->select();
		//var_dump($data);die;
		//根据parent_id 排序
		return $this->_sort($data);
	}
	private function _sort($data,$parentId=0,$level=0)
	{
		//排序之后的数组
		static $_result=[];
		//循坏寻找子分类
		foreach($data as $k => $v)
		{
			if($v['parent_id']==$parentId)
			{
				$v['level']=$level;
				$_result[]=$v;
				$this->_sort($data,$v['id'],$level+1);
			}
		}
		return $_result;
	}
	public function children($catId)
	{
		//取出所有的数据
		$data=$this->select();
		//从所有数据中递归寻找所有数据的子ID
		//true 参数在递归之前先清空数据
		return $this->_children($data,$catId,true);
	}
	private function _children($data,$parentId,$isReset=false)
	{
		static $_id=[];
		if($isReset)
			$_id=[];
		//var_dump($parentId);die;
		foreach ($data as $k => $v) {
			if($v['parent_id']==$parentId)
			{
				$_id=$v['id'];
				$this->_children($data,$v['id']);
			}
		}
		return $_id;
	}
	//在模型中添加一个删除一个分类以及其的子分类
	public function deleteCatAndChildren($catId)
	{
		$children=$this->children($catId);
		//把这个分类和子分类放在一起
		$children[]=$catId;
		$children=implode(',', $children);
		//调用父类的函数删除
		$this->delete($children);
	}
}