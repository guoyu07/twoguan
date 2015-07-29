<?php defined('SYSPATH') or die('No direct script access.');
class Controller_Order extends Stourweb_Controller{


    public static $channelArr = array(
        '1'=>'线路',
        '2'=>'酒店',
        '3'=>'租车',
        '5'=>'门票',
        '8'=>'签证',
        '13'=>'团购'
    );
    /*
     * 订单总控制器
     *
     */
    public function before()
    {
        parent::before();
        $action = $this->request->action();
        $moduleids =array(
            '1'=>'lineorder',
            '2'=>'hotelorder',
            '3'=>'carorder',
            '5'=>'spotorder',
            '8'=>'visaorder',
            '13'=>'tuanorder'
        );
        if($action == 'index')
        {

            $param = $this->params['action'];
            $typeid = $this->params['typeid'];

            $right = array(
                'read'=>'slook',
                'save'=>'smodify',
                'delete'=>'sdelete',
                'update'=>'smodify'
            );
            $user_action = $right[$param];
            $moduleid = $moduleids[$typeid];
            if(!empty($user_action))
                Common::getUserRight($moduleid,$user_action);


        }
        else if($action == 'view')
        {
            $type = $this->params['type'];//订单类型
            $typeid = $this->params['typeid'];

            if(!empty($typeid))
            {
                $moduleid = $moduleids[$typeid];
            }
            else if($type == 'dz')
            {
                $moduleid = 'dzorder';
            }
            else if($type == 'xy')
            {
                $moduleid = 'xyorder';
            }

            Common::getUserRight($moduleid,'slook');

        }

        else if($action == 'ajax_save')
        {
            $type = Arr::get($_POST,'type');//订单类型
            $typeid = Arr::get($_POST,'typeid');
            if(!empty($typeid))
            {
                $moduleid = $moduleids[$typeid];
            }
            else if($type == 'dz')
            {
                $moduleid = 'dzorder';
            }
            else if($type == 'xy')
            {
                $moduleid = 'xyorder';
            }

            Common::getUserRight($moduleid,'smodify');

        }
        else if($action == 'dz')
        {
            $param = $this->params['action'];
            $right = array(
                'read'=>'slook',
                'save'=>'smodify',
                'delete'=>'sdelete',
                'update'=>'smodify'
            );
            $user_action = $right[$param];

            if(!empty($user_action))
                Common::getUserRight('dzorder',$user_action);
        }
        else if($action == 'xy')
        {
            $param = $this->params['action'];
            $right = array(
                'read'=>'slook',
                'save'=>'smodify',
                'delete'=>'sdelete',
                'update'=>'smodify'
            );
            $user_action = $right[$param];

            if(!empty($user_action))
                Common::getUserRight('xyorder',$user_action);
        }

        $this->assign('parentkey',$this->params['parentkey']);
        $this->assign('itemid',$this->params['itemid']);


    }

    /*
     * 订单列表
     * */
    public function action_index()
    {
        $action=$this->params['action'];
        $typeid=$this->params['typeid'];
        $webid=Arr::get($_GET,'webid');
        $this->assign('typeid',$typeid);
        //订单模板
        //$channelname = self::$channelArr[$typeid];
        $channelname = Model_Model::getModuleName($typeid);

        if(empty($action))  //显示列表
        {
            $this->assign('position',$channelname.'订单');
            $this->assign('channelname',$channelname);
            $this->display('stourtravel/order/list');
        }
        else if($action=='read')    //读取列表
        {
            $start=Arr::get($_GET,'start');
            $limit=Arr::get($_GET,'limit');
            $keyword=Arr::get($_GET,'keyword');

            $order='order by a.addtime desc';
            $w = "where a.typeid = $typeid";
            if(!empty($keyword))
            {
                $w .=" and (a.ordersn like '%{$keyword}%' or a.linkman like '%{$keyword}%' or a.linktel like '%{$keyword}%' or a.productname like '%{$keyword}%')";
                $start = 0;
            }
            $w.=empty($webid)?' and a.webid=0':" and a.webid=$webid";

            $sql="select a.*  from sline_member_order as a $w $order limit $start,$limit";
            $totalcount_arr=DB::query(Database::SELECT,"select count(*) as num from sline_member_order a $w ")->execute()->as_array();
            $list=DB::query(Database::SELECT,$sql)->execute()->as_array();
            $new_list=array();
            foreach($list as $k=>$v)
            {
                $v['addtime'] = Common::myDate('Y-m-d H:i:s',$v['addtime']);
                if($v['pid']!=0)
                {
                    $v['productname'] = $v['productname']."[<span style='color:red'>子订单</span>]";
                }

                $new_list[] = $v;
            }
            $result['total']=$totalcount_arr[0]['num'];
            $result['lists']=$new_list;
            $result['success']=true;

            echo json_encode($result);
        }
        else if($action=='save')   //保存字段
        {

        }
        else if($action=='delete') //删除某个记录
        {
            $rawdata=file_get_contents('php://input');
            $data=json_decode($rawdata);
            $id=$data->id;

            if(is_numeric($id)) //
            {
                $model=ORM::factory('order',$id);
                Model_member_Order::refundStorage($id,'plus');
                $model->delete();

            }
        }
        else if($action=='update')//更新某个字段
        {
            $id=Arr::get($_POST,'id');
            $field=Arr::get($_POST,'field');
            $val=Arr::get($_POST,'val');

            if(is_numeric($id))
            {
                $model=ORM::factory('order')->where('id','=',$id)->find();
            }

            if($model->id)
            {
                $oldstatus = $model->status;
                $model->$field=$val;
                $model->update();
                if($model->saved())
                {
                    echo 'ok';

                    if($field=='status' && $val==2)//完成交易
                    {
                        Model_Member_Order::refundJifen($id);
                    }
                    if($field=='status' && $val==3)//取消订单
                    {
                        Model_member_Order::refundStorage($id,'plus');
                    }
                    else if($field=='status' && $oldstatus==3 && $val==1) //由取消变为在处理中
                    {
                        Model_Member_Order::refundStorage($id,'minus');//订单增加,库存减少
                    }


                }

                else
                    echo 'no';
            }
        }
    }


    /*
     * 查看订单信息
     * */
    public function action_view()
    {
        $id = $this->params['id'];//订单id.
        $type = $this->params['type'];//订单类型
        $typeid = $this->params['typeid'];
        if($type == 'dz') //customize订单
        {
            $info = ORM::factory('customize')->where('id','=',$id)->find()->as_array();
            $templet = 'dz_view';
        }

        else if($type == 'xy') //协议订单
        {
            $info = ORM::factory('dzorder')->where('id','=',$id)->find()->as_array();
            $templet = 'xy_view';

        }
        else //普通产品订单
        {
            $info = ORM::factory('order')->where('id','=',$id)->find()->as_array();
            $templet = 'view';
        }

        if($typeid=='1' || $typeid=='8') //线路和签证有游客信息
        {
            $sql = "select * from sline_member_order_tourer where orderid='{$info['id']}'";
            $tourer = DB::query(1,$sql)->execute()->as_array();
            if(!empty($tourer))$this->assign('tourer',$tourer);
        }

        $this->assign('info',$info);
        $this->assign('typeid',$typeid);

        $this->display('stourtravel/order/'.$templet);
    }
    /*
     * 保存
     * */
    public function action_ajax_save()
    {

        $id = Arr::get($_POST,'id');
        $type = Arr::get($_POST,'type');

        $status = false;
        if(empty($type))
        {
            $model = ORM::factory('order',$id);
            $model->price = Arr::get($_POST,'price');
            $oldstatus = $model->status;//原来状态

        }
        else if($type == 'dz')
        {
            $model = ORM::factory('customize',$id);

        }
        else if($type == 'xy')
        {
            $model = ORM::factory('dzorder',$id);
        }
        $model->status = Arr::get($_POST,'status');
        $model->update();

        if($model->saved())
        {
            $current_status = Arr::get($_POST,'status');
            if($oldstatus!=$current_status)
            {
                if($oldstatus!=3 && $current_status==3)
                {
                    Model_Member_Order::refundStorage($id,'plus');//订单取消,增加库存
                }
                else if($oldstatus==3 && $current_status==1) //由取消变为在处理中
                {
                    Model_Member_Order::refundStorage($id,'minus');//订单增加,库存减少
                }

            }
            $status = true;
        }
        echo json_encode(array('status'=>$status));
    }




    /*
     * 定制订单
     * */
    public function action_dz()
    {
        $action=$this->params['action'];
        if(empty($action))  //显示列表
        {

            $this->display('stourtravel/order/dz_list');
        }
        else if($action=='read')    //读取列表
        {
            $start=Arr::get($_GET,'start');
            $limit=Arr::get($_GET,'limit');
            $keyword=Arr::get($_GET,'keyword');

            $order='order by a.addtime desc';

            if(!empty($keyword))
            {
                $w =" where ( a.contactname like '%{$keyword}%' or a.phone like '%{$keyword}%')";
            }




            $sql="select a.*  from sline_customize as a $w $order limit $start,$limit";
            //echo $sql;


            $totalcount_arr=DB::query(Database::SELECT,"select count(*) as num from sline_customize a $w ")->execute()->as_array();
            $list=DB::query(Database::SELECT,$sql)->execute()->as_array();
            $new_list=array();
            foreach($list as $k=>$v)
            {
                $v['addtime'] = Common::myDate('Y-m-d H:i:s',$v['addtime']);
                $v['starttime'] = Common::myDate('Y-m-d',$v['starttime']);
                $new_list[] = $v;
            }
            $result['total']=$totalcount_arr[0]['num'];
            $result['lists']=$new_list;
            $result['success']=true;

            echo json_encode($result);
        }

        else if($action=='delete') //删除某个记录
        {
            $rawdata=file_get_contents('php://input');
            $data=json_decode($rawdata);
            $id=$data->id;

            if(is_numeric($id)) //
            {
                $model=ORM::factory('customize',$id);
                $model->delete();
            }
        }
        else if($action=='update')//更新某个字段
        {
            $id=Arr::get($_POST,'id');
            $field=Arr::get($_POST,'field');
            $val=Arr::get($_POST,'val');

            if(is_numeric($id))
            {
                $model=ORM::factory('customize')->where('id','=',$id)->find();

            }

            if($model->id)
            {
                $model->$field=$val;

                $model->update();
                if($model->saved())
                    echo 'ok';
                else
                    echo 'no';
            }
        }

    }

    /*
     * 协议订单
     * */
    public function action_xy()
    {
        $action=$this->params['action'];
        if(empty($action))  //显示列表
        {

            $this->display('stourtravel/order/xy_list');
        }
        else if($action=='read')    //读取列表
        {
            $start=Arr::get($_GET,'start');
            $limit=Arr::get($_GET,'limit');
            $keyword=Arr::get($_GET,'keyword');

            $order='order by a.addtime desc';

            if(!empty($keyword))
            {
                $w =" where ( a.username like '%{$keyword}%' or a.phone like '%{$keyword}%')";
            }




            $sql="select a.*  from sline_dzorder as a $w $order limit $start,$limit";
            //echo $sql;


            $totalcount_arr=DB::query(Database::SELECT,"select count(*) as num from sline_dzorder a $w ")->execute()->as_array();
            $list=DB::query(Database::SELECT,$sql)->execute()->as_array();
            $new_list=array();
            foreach($list as $k=>$v)
            {

                $v['addtime'] = Common::myDate('Y-m-d H:i:s',$v['addtime']);
                $v['starttime'] = Common::myDate('Y-m-d H:i:s',$v['starttime']);
                $new_list[] = $v;
            }
            $result['total']=$totalcount_arr[0]['num'];
            $result['lists']=$new_list;
            $result['success']=true;

            echo json_encode($result);
        }

        else if($action=='delete') //删除某个记录
        {
            $rawdata=file_get_contents('php://input');
            $data=json_decode($rawdata);
            $id=$data->id;

            if(is_numeric($id)) //
            {
                $model=ORM::factory('dzorder',$id);
                $model->delete();
            }
        }
        else if($action=='update')//更新某个字段
        {
            $id=Arr::get($_POST,'id');
            $field=Arr::get($_POST,'field');
            $val=Arr::get($_POST,'val');

            if(is_numeric($id))
            {
                $model=ORM::factory('dzorder')->where('id','=',$id)->find();

            }

            if($model->id)
            {
                $model->$field=$val;
                $model->update();
                if($model->saved())
                    echo 'ok';
                else
                    echo 'no';
            }
        }

    }


    /*
     * 订单统计数据查看
     * */
    public function action_dataview()
    {
        $year = date('Y');
        $this->assign('thisyear',$year);
        $this->assign('typeid',$this->params['typeid']);
        $this->display('stourtravel/order/data_view');
    }


    /*
     * 异步获取相关统计数据
     * */



    public function action_ajax_sell_info()
    {
        $out = array();
        $typeid = $this->params['typeid'];

        //今日销售
        $time_arr = Common::getTimeRange(1);
        $out['today'] = $this->getOrderPrice($time_arr,$typeid);

        //昨日销售
        $time_arr = Common::getTimeRange(2);
        $out['last'] = $this->getOrderPrice($time_arr,$typeid);

        //本周销售
        $time_arr = Common::getTimeRange(3);
        $out['thisweek'] = $this->getOrderPrice($time_arr,$typeid);

        //本月销售
        $time_arr = Common::getTimeRange(5);
        $out['thismonth'] = $this->getOrderPrice($time_arr,$typeid);

        //全部销售额
        $out['total'] = $this->getOrderPrice(0,$typeid);

        echo json_encode($out);
    }


    public function action_ajax_sell_tj()
    {
        $out = array();
        $typeid = $this->params['typeid'];
        //今日销售
        $time_arr = Common::getTimeRange(1);
        $out['today'] = $this->getOrderDetailPrice($time_arr,$typeid);

        //昨日销售
        $time_arr = Common::getTimeRange(2);
        $out['last'] = $this->getOrderDetailPrice($time_arr,$typeid);

        //本周销售
        $time_arr = Common::getTimeRange(3);
        $out['thisweek'] = $this->getOrderDetailPrice($time_arr,$typeid);

        //本月销售
        $time_arr = Common::getTimeRange(5);
        $out['thismonth'] = $this->getOrderDetailPrice($time_arr,$typeid);

        echo json_encode($out);

    }

    //按年进行统计
    public function action_ajax_year_tj()
    {
        $year = $this->params['year'];
        $typeid = $this->params['typeid'];
        $current_year = date('Y');
        if($current_year<$year) exit('12');
        for($i=1;$i<=12;$i++)
        {
            $starttime =date('Y-m-d',mktime(0,0,0,$i,1,$year));//开始时间

            $endtime = strtotime("$starttime +1 month -1 day");//结束时间
            $timearr = array(strtotime($starttime),$endtime);

            $out[$i]= $this->getOrderDetailPrice($timearr,$typeid);
        }
        echo json_encode($out);

    }

    /*
     * 生成excel页面
     * */
    public function action_excel()
    {
        $this->assign('typeid',$this->params['typeid']);
        $this->display('stourtravel/order/excel');
    }

    public function action_genexcel()
    {

        $typeid = $this->params['typeid'];
        $timetype = $this->params['timetype'];
        $starttime = strtotime(Arr::get($_GET,'starttime'));
        $endtime = strtotime(Arr::get($_GET,'endtime'));
        switch($timetype)
        {
            case 1:
                $time_arr = Common::getTimeRange(1);
                break;
            case 2:
                $time_arr = Common::getTimeRange(2);
                break;
            case 3:
                $time_arr = Common::getTimeRange(3);
                break;
            case 5:
                $time_arr = Common::getTimeRange(5);
                break;
            case 6:
                $time_arr = array($starttime,$endtime);
                break;

        }
        $stime = date('Y-m-d',$time_arr[0]);
        $etime = date('Y-m-d',$time_arr[1]);
        $arr = ORM::factory('member_order')->where("addtime>=$time_arr[0] and addtime<=$time_arr[1] and typeid='$typeid' and pid=0")->get_all();
        $table = "<table><tr>";
        $table.="<td>订单号</td>";
        $table.="<td>产品名称</td>";
        $table.="<td>预订日期</td>";
        $table.="<td>使用日期</td>";
        $table.="<td>成人数量</td>";
        $table.="<td>成人价格</td>";
        if($typeid==1)
        {
            $table.="<td>儿童数量</td>";
            $table.="<td>儿童价格</td>";
            $table.="<td>老人数量</td>";
            $table.="<td>老人价格</td>";
        }
        $table.="</tr>";
        foreach($arr as $row)
        {
            $table.="<tr>";
            $table.="<td>{$row['ordersn']}</td>";
            $table.="<td>{$row['productname']}</td>";
            $table.="<td>".Common::myDate('Y-m-d H:i:s',$row['addtime'])."</td>";
            $table.="<td>{$row['usedate']}</td>";
            $table.="<td>{$row['dingnum']}</td>";
            $table.="<td>{$row['price']}</td>";

            if($typeid==1)
            {
                $table.="<td>{$row['childnum']}</td>";
                $table.="<td>{$row['childprice']}</td>";
                $table.="<td>{$row['oldnum']}</td>";
                $table.="<td>{$row['oldprice']}</td>";
            }
            $table.="</tr>";

        }
        $table.="</table>";



        $filename = date('Ymdhis');
        header ( 'Pragma:public');
        header ( 'Expires:0');
        header ( 'Cache-Control:must-revalidate,post-check=0,pre-check=0');
        header ( 'Content-Type:application/force-download');
        header ( 'Content-Type:application/vnd.ms-excel');
        header ( 'Content-Type:application/octet-stream');
        header ( 'Content-Type:application/download');
        header ( 'Content-Disposition:attachment;filename='.$filename.".xls" );
        header ( 'Content-Transfer-Encoding:binary');

        //define("FILETYPE","xls");
        //header("Content-type:application/vnd.ms-excel");
        //header('Content-type: charset=GBK');
        //header('Pragma: no-cache');
        //header('Expires: 0');
        //header("Content-Disposition:filename=".$info['name'].".xls");
        //$str = iconv("UTF-8//IGNORE","GBK//IGNORE",$str);
        echo $table;
        exit();
    }




    /*
     * 获取已付款,未付款,已取消数量及价格
     * */
    private function getOrderDetailPrice($timearr,$typeid)
    {
        $where = '';
        $out = array();
        if(is_array($timearr))
        {
            $starttime = $timearr[0];
            $endtime = $timearr[1];
            $where = "addtime>=$starttime and addtime<=$endtime and";
        }
        //已付款
        $arr = ORM::factory('member_order')->where("{$where} typeid=$typeid and ispay=1")->get_all();
        $price = 0;
        foreach($arr as $row)
        {
            $price+= intval($row['dingnum'])*$row['price']+intval($row['childnum'])*$row['childprice'];
        }
        $out['pay']=array(
            'num'=>count($arr),
            'price'=>$price
        );
        //未付款
        $arr = ORM::factory('member_order')->where("{$where} typeid=$typeid and ispay=0")->get_all();
        $price = 0;
        foreach($arr as $row)
        {
            $price+= intval($row['dingnum'])*$row['price']+intval($row['childnum'])*$row['childprice'];
        }
        $out['unpay']=array(
            'num'=>count($arr),
            'price'=>$price
        );
        //已取消
        $arr = ORM::factory('member_order')->where("{$where} typeid=$typeid and status=3")->get_all();
        $price = 0;
        foreach($arr as $row)
        {
            $price+= intval($row['dingnum'])*$row['price']+intval($row['childnum'])*$row['childprice'];
        }

        $out['cancel']=array(
            'num'=>count($arr),
            'price'=>$price
        );
        return $out;


    }

    //根据时间范围获取某个产品类型订单数量.
    private function getOrderPrice($timearr,$typeid)
    {
        $where = '';
        if(is_array($timearr))
        {
            $starttime = $timearr[0];
            $endtime = $timearr[1];
            $where = "addtime>=$starttime and addtime<=$endtime and";
        }
        $arr = ORM::factory('member_order')->where("{$where} typeid=$typeid")->get_all();
        $price = 0;
        foreach($arr as $row)
        {
            $price+= intval($row['dingnum'])*$row['price']+intval($row['childnum'])*$row['childprice'];
        }
        return $price;
    }


}