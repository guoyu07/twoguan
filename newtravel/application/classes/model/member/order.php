<?php defined('SYSPATH') or die('No direct access allowed.');

class Model_Member_Order extends ORM {


    /*
     * 返积分操作
     * */
    public static function refundJifen($orderid)
    {
        $row = ORM::factory('member_order')->where('id='.$orderid)->find()->as_array();
        if(isset($row))
        {
            $memberid = $row['memberid'];
            $jifenbook = intval($row['jifenbook']);
            $member = ORM::factory('member')->where("mid=$memberid");
            $member->jifen = intval($member->jifen) + $jifenbook;
            $member->save();
            if($member->saved())
            {
                $memberid = $member->mid;
                $content = "预订{$row['productname']}获得{$jifenbook}积分";
                self::addJifenLog($memberid,$content,$jifenbook,2);
            }

        }

    }

    public static function addJifenLog($memberid,$content,$jifen,$type)
    {
        $addtime = time();
        $sql = "insert into sline_member_jifen_log(memberid,content,jifen,`type`,addtime) values ('$memberid','$content','$jifen','$type','$addtime')";
        DB::query(Database::INSERT,$sql)->execute();

    }

    /*
     * 返库存操作
     * */
    public static function refundStorage($orderid,$op)
    {
        $row = ORM::factory('member_order')->where('id='.$orderid)->find()->as_array();
        if(isset($row))
        {
            $dingnum = intval($row['dingnum'])+intval($row['childnum']);
            $suitid = $row['suitid'];
            $productid = $row['productautoid'];
            $typeid = $row['typeid'];
            $usedate = strtotime($row['usedate']);


            $storage_table=array(
                    '1'=>'sline_line_suit_price',
                    '2'=>'sline_hotel_room_price',
                    '3'=>'sline_car_suit_price',
                    '5'=>'sline_spot_ticket',
                    '8'=>'sline_visa',
                    '13'=>'sline_tuan'
            );
            $table = $storage_table[$typeid];
            //加库存
            if($op=='plus')
            {
                if($typeid==1||$typeid==2||$typeid==3)
                 $sql = "update {$table} set number=number+$dingnum where day='$usedate' and suitid='$suitid'";
                else
                 $sql = "update {$table} set number=number+$dingnum where id=$productid";
            }
            else if($op=='minus')
            {
                if($typeid==1||$typeid==2||$typeid==3)
                    $sql = "update {$table} set number=number-$dingnum where day='$usedate' and suitid='$suitid'";
                else
                    $sql = "update {$table} set number=number-$dingnum where id=$productid";
            }
            DB::query(2,$sql)->execute();
        }
    }



}