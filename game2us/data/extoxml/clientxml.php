<?php

include_once("extoxml/jsonextoxml.php");

$dir = @opendir("xlsx/")or die('目录无法打开');

$cscontentall ="
using LitJson;
using System.Collections.Generic;
using Proto;
using System.IO;
using System.Text;
using UnityEngine;
namespace Proto
{
	class ConfigMgr
	{
		private static ConfigMgr m_instance = new ConfigMgr();
		public static ConfigMgr Instance()
		{
			return m_instance;
		}";
$cscontent = "";
$cscontentmgr = "";
$csfunction = "\r\n		public void load()\r\n		{";
$csfunction .= "\r\n		  string path = null ;		";
$csfunction .= "\r\n		  path += WindowName.Data;\r\n		";

$index = 0;
while($file = readdir($dir))
{
	if(substr($file,strripos($file,".")+1) == 'xlsx')
	{
		
		$content = myextotxt($file, null, $cscontent);
		$filearr = explode('.', $file);
		
		$firstColumn = myExFirstColumn($file, null);
		
		$cscontentall .= "\r\n		public ".$filearr[0]."mgr m_".$filearr[0]."=new ".$filearr[0]."mgr();";
		$cscontentmgr .= "\r\n	class ".$filearr[0]."mgr";
		$cscontentmgr .= "\r\n	{";
		$cscontentmgr .= "\r\n		public Dictionary<".$firstColumn["type"].",".$filearr[0]."config> ".$filearr[0]."=new Dictionary<".$firstColumn["type"].",".$filearr[0]."config>() ;";
		$cscontentmgr .= "\r\n	}";
		
		$cscontentmgr .= "\r\n	class ".$filearr[0]."mgrtemp";
		$cscontentmgr .= "\r\n	{";
		$cscontentmgr .= "\r\n		public ".$filearr[0]."config[] ".$filearr[0].";";
		$cscontentmgr .= "\r\n	}";
		
		$csfunction .= "\r\n			string json{$index} = AssetBundleLoad.LoadFileTxt(path +\"".$filearr[0]."\",\"".$filearr[0]."\");";
		$csfunction .= "\r\n			JsonData jd{$index} = JsonMapper.ToObject(json{$index});";
		$csfunction .= "\r\n			".$filearr[0]."mgrtemp temp{$index} = JsonMapper.ToObject<".$filearr[0]."mgrtemp>(jd{$index});";
		
		
		$csfunction .= "\r\n			for(int i = 0; i < "."temp{$index}.".$filearr[0].".Length; i++)";
		$csfunction .= "\r\n            {";
		$csfunction .= "\r\n               m_".$filearr[0].".".$filearr[0].".Add(temp{$index}.".$filearr[0]."[i].".$firstColumn["name"].", temp{$index}.".$filearr[0]."[i]);";
		$csfunction .= "\r\n			}";
		//$csfunction .= "\r\n			m_".$filearr[0]." = JsonMapper.ToObject<".$filearr[0]."mgr>(jd{$index});";
		$csfunction .= "\r\n";
		$index++;
		if(!$handle = fopen('client/'.$filearr[0].'.txt','w+'))
		{
			echo "不能打开!";
			exit;
		}
	
		iconv('GB2312', 'UTF-8', $content);
		if(!fwrite($handle,$content))
		{
			echo "写入失败！";
			exit;
		}
		echo "写入".$filearr[0].".txt成功\n";
	}
}

$csfunction .= "\r\n		}";
$csfunction .= "\r\n	}";
$cscontentall .= $csfunction.$cscontentmgr.$cscontent."\r\n}";

file_put_contents("client/xmlconfigmgr.cs", $cscontentall);
