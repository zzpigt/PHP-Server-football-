<?php
include_once("extoxml/extoxml.php");

$dir = @opendir("xlsx/")or die('Ŀ¼�޷���');

while($file = readdir($dir))
{
	if(substr($file,strripos($file,".")+1) == 'xlsx')
	{
		$limit = null;
		
		if($file === "cards.xlsx")
		{
			$limit = array(0,8,23,24,25,26,27,28,29,30,31,32,33,34);
		}
		else if($file == "clubs.xlsx")
		{
			$limit = array(0,1,2,3,4,5);
		}
		else if($file == "formation.xlsx")
		{
			$limit = array(0,1,2,3,4,5);
		}
		$content = myextoxml($file, $limit);
		$filearr = explode('.', $file);
		
	
		if(!$handle = fopen('server/'.$filearr[0].'.xml','w+'))
		{
			echo "���ܴ�!";
			exit;
		}
	
		if(!fwrite($handle,$content))
		{
			echo "д��ʧ�ܣ�";
			exit;
		}
		echo "д��".$filearr[0].".xml�ɹ�\n";
	}
}