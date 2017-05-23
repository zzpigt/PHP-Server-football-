<?php

	require_once("PHPEXCEL.php");
	
	function myextotxt($file, $limit, &$cscontent)
	{
		date_default_timezone_set('UTC');
	
		$filename = explode('.', $file);
		$content = "{\"".$filename[0]."\":\r\n	[";

		$filePath  = getcwd().'/xlsx/'.$file;

		$PHPReader = new PHPExcel_Reader_Excel2007 ();
		if (! $PHPReader->canRead ( $filePath )) {
			$PHPReader = new PHPExcel_Reader_Excel5 ();
			if (! $PHPReader->canRead ( $filePath )) {
				exit('no Excel');
				return;
			}
		}
		
		
		$PHPExcel = $PHPReader->load ( $filePath );
		/**
		 * 读取excel文件中的第一个工作表
		 */
		$currentSheet = $PHPExcel->getSheet ( 0 );
		/**
		 * 取得最大的列号
		 */
		$allColumn = $currentSheet->getHighestColumn ();
		/**
		 * 取得一共有多少行
		 */
		$allRow = $currentSheet->getHighestRow ();
		/**
		 * 从第二行开始输出，因为excel表中第一行为列名
		 */

		$column = $limit;//26,27,28,29,30
		$card = '';

		if($allColumn{1})
		{
			$allColumn = (ord($allColumn{0})-65)*26 + ord($allColumn{1})-65+1+26;
		}
		else
		{
			$allColumn = ord($allColumn);
		}

		$once = false;
		$datanull = false;
		$cscontent .= "\r\n	class ".$filename[0]."config\r\n	{";
						

		for($currentRow = 3; $currentRow <= $allRow; $currentRow ++)
		{
			for($currentColumn = 0; $currentColumn < $allColumn; $currentColumn++ ) 
			{
				$name = $currentSheet->getCellByColumnAndRow ($currentColumn , 2 )->getValue ();
				if(!$column || in_array($currentColumn,$column))
				{
					$val = $currentSheet->getCellByColumnAndRow ($currentColumn , $currentRow )->getValue();
					//echo $val;
					
					$type = "int";
					$init = " = 0;";
					if($name != "")
					{
						if($currentColumn == 0 && $name != "")
						{
							if($val == ""&&!is_numeric($val))//判断是否为空行 
								break 2;
							$card .= "\r\n		{";
							if(is_numeric($val))
							{
								if(ceil($val)!=$val)
								{//判断是否为float类型  json只能读取双精度的 所以修改double
									$type = "double";
								}
								$card .= "\r\n			\"".$name.'":'.$val;					
							}
							else
							{
								$card .= "\r\n			\"".$name.'":"'.$val.'"';
								$type = "string";
								$init = " = \"\";";
							}
						}
						else if(is_numeric($val))
						{
							if(ceil($val)!=$val)
							{
								$type = "double";
							}
							$card .= ",\r\n			\"".$name.'":'.$val;					
						}
						else
						{
							$card .= ",\r\n			\"".$name.'":"'.$val.'"';
							$type = "string";
							$init = " = \"\";";
						}
					}
					if(!$once && $name != "")
					{
						$cscontent .= "\r\n		public ".$type." ".$name." ".$init;
						
					}
				}
				
			}
			if(!$once)
			{
				$cscontent .="\r\n	}";
				
				$once = true;
			}
			$card .= "\r\n		},";
		
		
		}
		
		$content .= $card."\r\n	]\r\n}";
		return $content;
	}
	
	function myExFirstColumn($file, $limit)
	{
	    date_default_timezone_set('UTC');
	
	    $filename = explode('.', $file);
	    $content = "{\"".$filename[0]."\":\r\n	[";
	
	    $filePath  = getcwd().'/xlsx/'.$file;
	
	    $PHPReader = new PHPExcel_Reader_Excel2007 ();
	    if (! $PHPReader->canRead ( $filePath )) {
	        $PHPReader = new PHPExcel_Reader_Excel5 ();
	        if (! $PHPReader->canRead ( $filePath )) {
	            exit('no Excel');
	            return;
	        }
	    }
	
	
	    $PHPExcel = $PHPReader->load ( $filePath );
	    /**
	     * 读取excel文件中的第一个工作表
	    */
	    $currentSheet = $PHPExcel->getSheet ( 0 );
	    /**
	     * 取得最大的列号
	    */
	    $allColumn = $currentSheet->getHighestColumn ();
	    /**
	     * 取得一共有多少行
	    */
	    $allRow = $currentSheet->getHighestRow ();
	    /**
	     * 从第二行开始输出，因为excel表中第一行为列名
	    */
	
	    $column = $limit;//26,27,28,29,30
	    $card = '';
	
	    if($allColumn{1})
	    {
	        $allColumn = (ord($allColumn{0})-65)*26 + ord($allColumn{1})-65+1+26;
	    }
	    else
	    {
	        $allColumn = ord($allColumn);
	    }
	
	    $once = false;
	
	  //  $cscontent .= "\r\n	class ".$filename[0]."config\r\n	{";
	
	
	    for($currentRow = 3; $currentRow <= $allRow; $currentRow ++)
	    {
	        for($currentColumn = 0; $currentColumn < $allColumn; $currentColumn++ )
	        {
	            $name = $currentSheet->getCellByColumnAndRow ($currentColumn , 2 )->getValue ();
	            if(!$column || in_array($currentColumn,$column))
	            {
	                $val = $currentSheet->getCellByColumnAndRow ($currentColumn , $currentRow )->getValue();
					//echo $val;
					
					$type = "int";
					if($name != "")
					{
						if(ceil($val)!=$val){  
							$type = "double";
						}
						if(!is_numeric($val))
							$type = "string";
							
					}
					return Array("name"=>$name, "type"=>$type);
	            }
	
	        }
	       
	    }
	    return Array("name"=>"", "type"=>"");
	}
	
	/*$dir = @opendir(".")or die('目录无法打开');
	

	while($file = readdir($dir))
	{
		if(substr($file,strripos($file,".")+1) == 'xlsx')
		{
			$filePath  = getcwd().'/'.$file;

			$PHPReader = new PHPExcel_Reader_Excel2007 ();
			if (! $PHPReader->canRead ( $filePath )) {
				$PHPReader = new PHPExcel_Reader_Excel5 ();
				if (! $PHPReader->canRead ( $filePath )) {
					echo 'no Excel';
					return;
				}
			}
			//echo "1111";
			$PHPExcel = $PHPReader->load ( $filePath );
			/**
			 * 读取excel文件中的第一个工作表
			 */
			//$currentSheet = $PHPExcel->getSheet ( 0 );
			/**
			 * 取得最大的列号
			 */
			//$allColumn = $currentSheet->getHighestColumn ();
			/**
			 * 取得一共有多少行
			 */
			//$allRow = $currentSheet->getHighestRow ();
			/**
			 * 从第二行开始输出，因为excel表中第一行为列名
			 */
		
			/*$column = array(0,8,23,24,25,26,27,28,29,30,31,32,33,34);//26,27,28,29,30
			$card = '';
			
			if($allColumn{1})
			{
				$allColumn = ord($allColumn{0})+ ord($allColumn{1})-65+1+26;
			}
			else
			{
				$allColumn = ord($allColumn);
			}
			
			for($currentRow = 3; $currentRow <= $allRow; $currentRow ++)
			{
				$id  = 0;
				for($currentColumn = 0; $currentColumn < $allColumn-65; $currentColumn++ ) 
				{
					$name = $currentSheet->getCellByColumnAndRow ($currentColumn , 2 )->getValue ();
					if(in_array($currentColumn,$column))
					{
						$val = $currentSheet->getCellByColumnAndRow ($currentColumn , $currentRow )->getValue();
						echo $val;
						
						if($currentColumn == 0)
						{
							$card .= '    <'.$val.'> '."\r\n";
							$id = $val;
						}
						else
						{
							$card .= '        <'.$name.'>'.$val.'</'.$name.'> '."\r\n";
						}
					}
				}
				$card .= '    </'.$id.'> '."\r\n";
			}
			
			
			/*$extends = '        <extends>'."\r\n";
			for($currentRow = 3; $currentRow <= $allRow; $currentRow ++) {
				$va = $currentSheet->getCellByColumnAndRow ( 26, $currentRow )->getValue ();
				$val = $currentSheet->getCellByColumnAndRow ( 27, $currentRow )->getValue ();
				$vall = $currentSheet->getCellByColumnAndRow ( 28, $currentRow )->getValue ();
				$valll = $currentSheet->getCellByColumnAndRow ( 29, $currentRow )->getValue ();
				$vallll = $currentSheet->getCellByColumnAndRow ( 30, $currentRow )->getValue ();
				if($va)
				{
					$extends .= '            <extend id="'.iconv('utf-8','gbk',$va).'" name="'.iconv('utf-8','gbk',$val).'" ids="'.iconv('utf-8','gbk',$vall).'" effect="'.iconv('utf-8','gbk',$valll).'" proh="'.iconv('utf-8','gbk',$vallll).'"/>'."\r\n";
				}
				else
				{
					break;
				}
			}
			$extends .= '        </extends>'."\r\n";
			
			for($currentRow = 3; $currentRow <= $allRow; $currentRow ++) {
				$va = $currentSheet->getCellByColumnAndRow ( ord ( 'F' ) - 65, $currentRow )->getValue ();
				$val = $currentSheet->getCellByColumnAndRow ( ord ( 'H' ) - 65, $currentRow )->getValue ();
				$vall = $currentSheet->getCellByColumnAndRow ( ord ( 'I' ) - 65, $currentRow )->getValue ();
				if($val)
				{
					$lv .= '            <level  lv="'.iconv('utf-8','gbk',$va).'" atk="'.iconv('utf-8','gbk',$val).'" hp="'.iconv('utf-8','gbk',$vall)."\"/>\r\n";
				}
			}
			
			$content .= $card.$lv.'        </levels>'."\r\n".'    </card>'."\r\n";*/
			
		/*}
		
	}
	$content .= $card.'</root>';
	echo $content;
	if(!$handle = fopen('cards.xml','w+'))
	{
		echo "不能打开!";
		exit;
	}
	
	if(!fwrite($handle,$content))
	{
		echo "写入失败！";
		exit;
	}
	echo "写入成功!";
	echo "<br/>-------------<br/>";
	fclose($handle);*/
	
?>
