<?php 
  require_once(dirname(__FILE__)."/../include/common.inc.php");
  require_once(dirname(__FILE__)."/../data/webinfo.php");
  require_once(dirname(__FILE__)."/../include/email.class.php");
  require_once SLINEINC."/view.class.php";

  $typeid=1; //线路栏目
  $typename=GetTypeName($typeid);//获取栏目名称
  $pv = new View($typeid);
  $lineid = Helper_Archive::pregReplace($lineid,2);
 if(empty($dopost))
 {

  $lineinfo=getLineInfo($lineid);
  $suitinfo=getLineSuitInfo($suitid);
  $priceinfo = getDayPrice($usedate,$suitid);
  if(!isset($lineinfo))
  {
     head404();
 
  }

  $lineinfo['lineseries']=getSeries($lineinfo['id'],'01');//线路编号
  $lineinfo['usedate']=$usedate;//出团日期
  $lineinfo['title'] = $lineinfo['linename']."({$suitinfo['suitname']})";
  $lineinfo['suitname'] = $suitinfo['suitname'];

  $lineinfo['price'] = $priceinfo['adultprice']; //成人价格
  $lineinfo['childprice'] =  $priceinfo['childprice']; //小孩价格
  $lineinfo['oldprice'] =  $priceinfo['oldprice']; //老人价格

  $lineinfo['dingnum'] = intval($adultnum) ? intval($adultnum) : 1;//数量
  $lineinfo['childnum'] = intval($childnum) ? intval($childnum) : 0;
  $lineinfo['oldnum'] = intval($oldnum) ? intval($oldnum) : 0;
  $group = explode(',',$suitinfo['propgroup']);//人群

  $lineinfo['suitid'] = $suitid;
  $lineinfo['totalprice'] = $priceinfo['price'] * $adultnum + $priceinfo['childprice'] * $childnum + $priceinfo['oldprice']* $oldnum;//总价格
  if(!empty($suitinfo['dingjin']))$GLOBALS['condition']['_djsupport']=1;//是否支持定金
  if(!empty($suitinfo['jifentprice']))$GLOBALS['condition']['_has_jifentprice']=1;
  if(!empty($suitinfo['jifencomment']))$GLOBALS['condition']['_has_jifencomment']=1;
  if(!empty($suitinfo['jifenbook']))$GLOBALS['condition']['_has_jifenbook']=1;
  if(in_array(1,$group))$lineinfo['haschild']=1;
  if(in_array(2,$group))$lineinfo['hasadult']=1;
  if(in_array(3,$group))$lineinfo['hasold']=1;


     $lineinfo['dingjin'] = $suitinfo['dingjin'];
     $lineinfo['jifentprice'] = $suitinfo['jifentprice'];
     $lineinfo['jifencomment'] = $suitinfo['jifencomment'];
     $lineinfo['jifenbook'] = $suitinfo['jifenbook'];

     //如果用户是登陆状态,获取用户信息
  if($User->uid)
  {
	 $userinfo = $User->getInfoByMid($User->uid);//获取用户信息 
	 $lineinfo['linkman'] = $userinfo['truename'];
	 $lineinfo['linktel'] = $userinfo['mobile'];
	 $lineinfo['linkemail'] = $userinfo['linkemail'];

  }

     if($suitinfo['jifentprice'])
     {
         $needjifen = $cfg_exchange_jifen * $suitinfo['jifentprice']; //所需积分
         if($User->uid)
         {
             if($userinfo['jifen']>=$needjifen)
             {
                 $exopen = 1;
             }
             else
             {
                 $exopen = 0;
             }


             $userstatus = "(<span style='color:red'>当前积分:{$userinfo['jifen']}</span>)";
             $islogin=1;
         }
         else
         {
             $userstatus = "(<span style='color:red'><a style=\"color:red\" href=\"{$GLOBALS['cfg_cmsurl']}/member/login.php\">立即登陆</a></span>)";
             $exopen = 0;
             $islogin = 0;
         }

         $jifenpricemsg = " <span style='color:orange'>使用{$needjifen}积分抵现{$suitinfo['jifentprice']}元</span> ".$userstatus;
         $lineinfo['jifenpricemsg'] = $jifenpricemsg;
         $lineinfo['needjifen'] = $needjifen;
         $lineinfo['exopen'] = $exopen ;//优惠是否开启.
         $lineinfo['islogin'] = $islogin;
         $lineinfo['myjifen'] = $userinfo['jifen'];
     }

  
  
  foreach($lineinfo as $k=>$v) //线路基本信息
  {
	  $pv->Fields[$k] = $v;
  }
 $pkname = get_par_value($lineinfo['kindlist'],$typeid);//上一级
 //获取上级开启了导航的目的地
  getTopNavDest($lineinfo['kindlist']);

  $pv->SetTemplet(SLINETEMPLATE ."/".$cfg_df_style ."/" ."lines/" ."line_booking.htm");

  $pv->Display();
  exit();
 }
//保存订单
else if($dopost=="savebooking")
{

    $tourer = Helper_Archive::getTourer($_POST);
    $needjifen = $usejifen ? Helper_Archive::getNeedJifen($jifentprice) : 0;
    $userinfo = $User->getInfoByMid($User->uid);//获取用户信息
       //这里再次判断用户积分是否满足条件.
       if($userinfo['jifen']<$needjifen)
       {
           $usejifen = 0;
           $needjifen = 0;

       }
   $ordersn=get_order_sn('01');//订单号
   $memberid = $User->uid ? $User->uid : 0;

   $suitinfo=getLineSuitInfo($suitid);
   $priceinfo = getDayPrice($usedate,$suitid);
   $status = $suitinfo['paytype']==1 ? 1 : 0;

   $adultnum = Helper_Archive::pregReplace($adultnum,2);
   $childnum = Helper_Archive::pregReplace($childnum,2);
   $oldnum = Helper_Archive::pregReplace($oldnum,2);
   $total_dingnum = $adultnum+$childnum+$oldnum;
   if(intval($priceinfo['number'])!=-1 && intval($priceinfo['number']) < $total_dingnum)
   {
      echo 'nonumber';
      exit;
   }

   $linktel=Helper_Archive::pregReplace($linktel,2);

   $arr = array(
           'ordersn'=>$ordersn,
		   'webid'=>$webid,
		   'typeid'=>$typeid,
		   'productautoid'=>$productautoid,
		   'productaid'=>$productaid,
		   'productname'=>$productname,
		   'price'=>$priceinfo['adultprice'],
		   'childprice'=>$priceinfo['childprice'],
           'oldprice'=>$priceinfo['oldprice'],
           'usedate'=>$usedate,
		   'dingnum'=>Helper_Archive::pregReplace($adultnum,2),
		   'childnum'=>Helper_Archive::pregReplace($childnum,2),
           'oldnum'=>Helper_Archive::pregReplace($oldnum,2),
		   'linkman'=>Helper_Archive::pregReplace($linkman,5),
		   'linktel'=>Helper_Archive::pregReplace($linktel,2),
		   'linkemail'=>Helper_Archive::pregReplace($linkemail,5),
		   'jifentprice'=>Helper_Archive::pregReplace($jifentprice,2),
		   'jifenbook'=>Helper_Archive::pregReplace($jifenbook,2),
		   'jifencomment'=>Helper_Archive::pregReplace($jifencomment,2),
		   'addtime'=>time(),
		   'memberid'=>$memberid,
		   'dingjin'=>Helper_Archive::pregReplace($dingjin,2),
           'paytype'=>$suitinfo['paytype'],
           'suitid'=>$suitid,
           'usejifen'=>$usejifen,
           'needjifen'=>$needjifen,
           'status'=>$status,
           'remark'=>Helper_Archive::pregReplace($remarkinfo,5),
           'tourer'=>$tourer
   );

   $price    =  $arr['price'];
   $remark   = $arr['remark'];
   $dingnum  = $arr['dingnum'];
   $childnum = $arr['childnum'];
  
   if(Helper_Archive::addOrder($arr))
   {
       $model = new CommonModule('#@__member_order');
       $orderid = $model->getField('id',"ordersn='$ordersn'");
       //判断是否开启在线支付且不是二次确认付款

       if(!empty($choosepay) && $suitinfo['paytype']!='3' && $choosepay!='6')
       {
           $url = $GLOBALS['cfg_basehost'].'/lines/booking.php?dopost=payonline&id='.$orderid.'&paytype='.$choosepay;
       }
       else
       {
           //$url = "{$GLOBALS['cfg_basehost']}/lines/show_{$arr['productaid']}.html";
		   $url = "{$GLOBALS['cfg_basehost']}/member/query.php?dopost=search&mobile=$linktel";

       }


	   if($cfg_lineEmail != '')
		 {
		     $mailto = $cfg_lineEmail;
		 }
		 else
		 {
		     $mailto = $cfg_Email139;
		 }
		 $title   = $linename . "线路订单";
		 
		 $content = $linkman . "预定" . $usedate  . $productname . "(成团报价:".$price.")"."旅游线路,成人数:" . $dingnum . "人" . ";儿童数:" . $childnum . "人;联系电话:".$linktel."-----".$GLOBALS['cfg_webname'];
         if(!empty($mailto))ordermaill($mailto,$title,$content);

        //扣除积分
        if(!empty($usejifen))
        {
            $sql = "update sline_member set jifen=jifen-{$needjifen} where mid='{$memberid}'";
            $dsql->ExecuteNoneQuery($sql);
            Helper_Archive::addJifenLog($memberid,"预订线路{$productname}消费积分{$needjifen}分",$needjifen,1);
        }

		 echo $url;



        //预订送积分(改为支付成功后才实现)
      /*  $jifen = $jifenbook ? $jifenbook : 0 ;
        $sql = "update #@__member set jifen=jifen+".$jifen." where mid='$memberid'";
        $dsql->ExecNoneQuery($sql);
		exit();*/
   }
   else
   {
	   echo 'no';
	  //Helper_Archieve::showMsg('订单提交失败!',-1,0,3);
   }

   
 
	    
		
	

}
//在线支付
if($dopost == 'payonline')
{
    $order = Helper_Archive::getOrderInfo($id);

    if(empty($order['dingjin'])) //非订金支付
    {
        $price = intval($order['dingnum']) * $order['price'] +intval($order['childnum']) * $order['childprice'] + intval($order['oldnum']) * $order['oldprice'];
        if(!empty($order['usejifen']) && !empty($order['jifentprice']))
        {
            $price = $price-intval($order['jifentprice']);//减去积分抵现的价格.
        }
    }
    else //订金支付
    {
        $price = (intval($order['dingnum'])+intval($order['childnum'])+intval($order['oldnum'])) * $order['dingjin'];
        if(!empty($order['usejifen']) && !empty($order['jifentprice']))
        {
            $price = $price-intval($order['jifentprice']);//减去积分抵现的价格.
        }
    }
    if(empty($price))
    {
        $url = "{$GLOBALS['cfg_basehost']}/lines/show_{$order['productaid']}.html";
        header("location:$url");
        exit;
    }
    else
    {
        echo Helper_Archive::payOnline($order['ordersn'],$order['productname'],$price,$paytype);
    }


}

    /**
     *  获得预订线路的基本信息
     *
     * @access    private
     * @return    array
     */
function getLineInfo($id)
{
   global $dsql;
   $sql="select a.* from #@__line a where a.id=$id";
   $row=$dsql->GetOne($sql);
   return $row;
}

/**
 *  获得预订线路套餐基本信息
 *
 * @access    private
 * @return    array
 */
function getLineSuitInfo($suitid)
{
    global $dsql;
    $sql="select * from #@__line_suit where id=$suitid";
    $row=$dsql->GetOne($sql);
    return $row;
}

function getDayPrice($usedate,$suitid)
{
    global $dsql;
    $day = strtotime($usedate);
    $sql = "select adultprice,childprice,oldprice,number from #@__line_suit_price where day='$day' and suitid='$suitid'";
    $row = $dsql->GetOne($sql);
    return $row;
}






?>
