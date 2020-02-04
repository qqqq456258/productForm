<?php
	session_start();

	header("Content-Type:text/html; charset=utf-8");
	try{	
	    $dsn = "mysql:host=localhost;port=3306;dbname=shop;charset=utf8";
	    $user = "root";
	    $password = "";
	    $options = array (PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION);
	    $pdo = new PDO($dsn, $user,$password,$options);
	}catch(PDOException $e){	
	    echo "資料庫連線失敗！錯誤訊息：",$e->getMessage();	
	    exit;
	}
	$_SESSION['decision']=0;	//設定一個暫存變數，判斷在table.html頁面時，重新整理時資料不重複寫入。

?>
<!DOCTYPE html>
<html lang="en">
<head>
	<meta charset="UTF-8">
	<title>newOnePage</title>
	<style type="">
		p{
			font-size: 20px;
			font-family: "微軟正黑體";
		}
		span{
			font-size: 30px;
			font-family: "微軟正黑體";
			margin: 10px auto;
		}
		form{
			text-align: center;
			margin:20px auto;
		}
		input{
			font-weight: bold;		    
			border-radius: 6px;
		    padding: 10px 15px;
		    text-align: center;
		}
	</style>
</head>
<body>
	<form method="get" action="table.php">
		<span>【新增產品】</span><br><br>
		<p>產品名稱：<input type="text" name="productName"></p><br><br>
		<p>產品價格：<input type="text" placeholder="Enter number 0~9 digits" pattern="[0-9]{0,9}" name="productPrice"></p><br><br>
		<input type="hidden" name="decision" value="<?php echo $_SESSION['decision']; ?>">
		<?php $pdo = null; ?> <!-- 釋放資源 -->
        <input type="submit" value="送出資料" name="maybe"/>
	</form>
</body>
</html>