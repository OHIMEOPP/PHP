<!DOCTYPE html>
<html lang="zh-TW">
	<head>
		<meta charset="utf-8">
		<meta http-equiv="X-UA-Compatible" content="IE=edge,chrome=1">

		<title>第 12 周教材</title>
		<link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.4/css/bootstrap.min.css"/>
		<style>
			body{
				margin:0;
			}
			nav {
				width:400px;
				margin:100px auto;
			}
			nav ul{
				padding-left:0px;
				list-style:none;
			}
			nav ul li
			{
				margin-bottom:10px;
			}
			nav ul li a{
				display:block;				/* 顯示為區塊 */
				width:100%;
				text-align:center;
				padding:20px;
				border:#52c401 solid 1px;	/* 邊線為 #52c401 顏色，為實線 1px的寬度 */
				color:#52c401;				/* 內容文字為 #52c401 顏色 */
				text-decoration: none;		/* 文字底線不顯示 */
				border-radius: 15px;			/* 邊框圓角6px */
			}
			nav ul li a:hover{
				border:#ffffff solid 1px;	/* 邊線為 #52c401 顏色，為實線 1px的寬度 */
				color:#ffffff;				/* 內容文字為 #52c401 顏色 */
				background-color:#027231;
			}
		</style>
	</head>

	<body>
		<nav>
			<ul>
				<li><a href="db.php">資料庫連結</a></li>
				<li><a href="select.php">選擇 SELECT，列出資料表的資料</a></li>
				<li><a href="insert.php">新增資料 INSERT，新增資料到資料表</a></li>
				<li><a href="update.php">更新資料 UPDATE，更新資料表中的資料</a></li>
				<li><a href="del.php">刪除資料 DELETE，刪除資料表中的資料</a></li>
			</ul>
		</nav>
	</body>
</html>
