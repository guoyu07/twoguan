<?php defined('SYSPATH') or die('No direct script access.');
class Controller_Theme extends Stourweb_Controller{

    private $product_arr=array(1=>'line',2=>'hotel',3=>'car',4=>'article',5=>'spot',6=>'photo',8=>'visa',13=>'tuan');
    /*
	   以json方式返回主题列表
	*/
	public function action_ajax_themelist()
	{
		$model=ORM::factory('theme');
		$list=$model->where('isopen=1')->get_all();
		echo json_encode($list);	 
	}
	/*
	  设置产品专题
	*/
	public function action_ajax_settheme()
	{
	     $typeid=Arr::get($_POST,'typeid');
		 $productid=Arr::get($_POST,'productid');
		 $themes=Arr::get($_POST,'themes');
         $table = $typeid>13 ? 'model_archive' : $this->product_arr[$typeid];
		 $model=ORM::factory($table,$productid);
	
		  
		$is_success='ok';
		$productid_arr=explode('_',$productid);
		foreach($productid_arr as $k=>$v)
		{
			$model=ORM::factory($table,$v);
			if($model->id)
			{
				$model->themelist=$themes;
				$model->save();
				if(!$model->saved())
				   $is_success='no';
			}
		}
		echo $is_success;
	}
	
}