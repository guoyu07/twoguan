<?php
require_once(dirname(__FILE__)."/../include/common.inc.php");
$typeid=10; //问答栏目
require_once SLINEINC."/view.class.php";

$pv = new View($typeid);

$pv->Fields['select'] = GetChannel();

$pv->GetChannelKeywords($typeid);//根据栏目类型获取关键词.介绍,栏目名称
	
$pv->SetTemplet(SLINETEMPLATE ."/".$cfg_df_style ."/" ."questions/" ."index.htm");

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