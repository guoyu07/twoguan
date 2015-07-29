<?php 

require_once(dirname(__FILE__)."/../include/common.inc.php");

$typeid=10; //问答栏目
require_once SLINEINC."/view.class.php";

$pv = new View($typeid);

//$pv->GetChannelKeywords($typeid);
if(!isset($aid)) exit('Wrong Id');
$aid=RemoveXSS($aid);//防止跨站攻击

$sql="select * from #@__leave where aid=$aid and webid='0'";
$row=$dsql->GetOne($sql);
if(empty($row['id']))
{
	header("HTTP/1.1 404 Not Found");
    header("Status: 404 Not Found");
    //header("Location: ".$GLOBALS['cfg_basehost']."/404.php");
    echo "<script>window.location.href='".$GLOBALS['cfg_basehost']."/404.php'</script>";
    exit; 
}

if(is_array($row))
{
    $row['subname']=$row['title'];
    foreach($row as $k=>$v)
    {
	   $pv->Fields[$k] = $v;
    }
}
$pv->Fields['typeid']=$typeid;

$typename=GetTypeName($typeid);//获取栏目名称.
$pv->Fields['typename'] = $typename;
$pv->Fields['select'] = GetChannel();

//$pv->GetChannelKeywords($typeid);//根据栏目类型获取关键词.介绍,栏目名称
	
$pv->SetTemplet(SLINETEMPLATE ."/".$cfg_df_style ."/" ."questions/" ."show.htm");

$pv->Display();

function GetChannel()
{
	global $dsql;
	$str = "分类：<select name=\"typeid\"><option value=''>--请选择--</option>";
	$sql = "select * from #@__nav where pid='0' and isopen='1' and webid='0' and typeid != '10'";
	$row = $dsql->getAll($sql);
	foreach($row AS $res)
	{
		$str .= "<option value='" . $res['typeid'] . "'>" . $res['shortname'] . "</option>";
	}
	$str .= "</select>";
	return $str;
}
?>
