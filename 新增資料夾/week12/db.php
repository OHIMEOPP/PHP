<?php
	//先設定資料庫資訊，主機通常都用本機
	$host = 'localhost';
	//以root管理者帳號進入資料庫
	$dbuser = 'root';
	//root的資料庫密碼
	$dbpw = 'stust';
	//登入後要使用的資料庫
	$dbname = 'my_db';
	
	
	//宣告一個 link 變數，並執行連結資料庫函式，連結結果會帶入 link 當中
	$link = mysql_connect($host, $dbuser, $dbpw);
	
	if ($link)
	{
		//若傳回正值，就代表已經連線
		
		//設定連線編碼為UTF-8
		mysql_query("SET NAMES utf8");
		
		//取得我要的資料庫，並帶入$db變數中
		$db = mysql_select_db($dbname, $link);
	
		if ($db)
		{
			//傳回正值代表已經指定此次連線的資料表為 my_db
			echo '已正確連接資料庫： ' . $dbname;
		}
		else
		{
			//否則就代表連線失敗，並印出錯誤訊息
			echo "未能連接資料庫 {$dbname}，錯誤訊息 :<br/>" . mysql_error();
		}
	}
	else
	{
		//否則就代表連線失敗
		echo '無法連線mysql資料庫 :<br/>' . mysql_error();
	}
?>