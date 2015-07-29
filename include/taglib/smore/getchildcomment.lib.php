<?php
if(!defined('SLINEINC'))
{
    exit("Request Error!");
}

/**
 * 属性分类调用标签与attrgrouplist配合使用.
 *
 * @version        $Id: getattrbygroup.lib.php netman
 * @package        Stourweb.Taglib
 * @copyright      Copyright (c) 2007 - 2011, Stourweb, Inc.
 * @link           http://www.stourweb.com
 */
 

function lib_getchildcomment(&$ctag,&$refObj)
{
    global $dsql;
    $attlist="row|8,typeid|,groupname|";
    FillAttsDefault($ctag->CAttribute->Items,$attlist);
    extract($ctag->CAttribute->Items, EXTR_SKIP);
    
    $innertext = trim($ctag->GetInnertext());
    $revalue = '';
	
	$commentid=$refObj->Fields['commentid'];
	$articleid=$refObj->Fields['articleid'];
	if(empty($commentid))
	    return '';  
	 
	 $sql="select * from #@__comment where dockid='$commentid' order by addtime asc";
	 
	  
	
    $dsql->SetQuery($sql);
    $dsql->Execute();
    $ctp = new STTagParse();
    $ctp->SetNameSpace("field","[","]");
    $ctp->LoadSource($innertext);
    $GLOBALS['autoindex'] = 0;
    while($row = $dsql->GetArray())
    {
		 $userinfo=$GLOBALS['User']->getInfoByMid($row['memberid']);
	     $row['litpic']=getUploadFileUrl($userinfo['litpic']);
		 $row['nickname']=empty($userinfo['nick'])?'匿名':$userinfo['nickname'];
		 
		 $replymember=loc_getCommentMemberInfo($row['pid']);
		 $row['replylitpic']=getUploadFileUrl($replymember['litpic']);
		 $row['replynickname']=empty($replymember['nickname'])?'匿名':$replymember['nickname'];
		 $row['replymemberid']=$replymember['id'];
		 $row['articleid']=$articleid;
		 
           
				foreach($ctp->CTags as $tagid=>$ctag)
				{
						if($ctag->GetName()=='array')
						{
								$ctp->Assign($tagid, $row);
						}
						else
						{  
							if( !empty($row[$ctag->GetName()])) $ctp->Assign($tagid,$row[$ctag->GetName()]); 
						}
				}
				$revalue .= $ctp->GetResult();
				$GLOBALS['autoindex']++;
	      
    }
    return $revalue;
}
function loc_getCommentMemberInfo($commentid)
{
	global $dsql;
	$memberid=$dsql->GetOne("select memberid from #@__comment where id='$commentid'");
	$memberinfo=$dsql->GetOne("select * from #@__member where mid='{$memberid['memberid']}'");
	return $memberinfo;
}



