<?php
	session_start();  //通知網頁以SESSION暫存資料。

	header("Content-Type:text/html; charset=utf-8"); //PHP 送 Header 告訴瀏覽器這頁是 UTF-8 編碼，避免亂碼。
	try{
	    $dsn = "mysql:host=localhost;port=3306;dbname=shop;charset=utf8"; // 連接mysql相關資訊：host:localhost/port=3306/dbname
	    $user = "root"; // mysql使用者名稱
	    $password = ""; // mysql使用者密碼
	    $options = array (PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION);
	    /*
			 ATTR_EERMODE：是個要用PDO時的一定要的基本設定。
			 ERRMODE_EXCEPTION. 它會自動告訴PDO每次查詢失敗時拋出異常。
	    */
	    $pdo = new PDO($dsn, $user,$password,$options); //新增PDO物件放入pdo變數。
	}catch(PDOException $e){	
	    echo "資料庫連線失敗！錯誤訊息：",$e->getMessage();	
	    exit;
	}

	if(!isset($_SESSION['decision'])){ // 避免因重新整理導致資料重複輸入。
		$_SESSION['decision']=0;
	}
	if(isset($_GET["maybe"]) && !empty($_GET["productName"]) && !empty($_GET["productPrice"]) && $_SESSION['decision']==$_GET['decision']){
		$_SESSION['decision']+=1;  // 避免重新整理導致資料重複輸入。
		$sql ="INSERT INTO shop.product(product_name, price) VALUES ('".$_GET["productName"]."','".$_GET["productPrice"]."')";   
		//SQL的寫入資料指令。 
		$pdo->query($sql);	//以PDO通道執行SQL。
	}
?> 

<!DOCTYPE html>
<html lang="en">
<head>
	<meta charset="UTF-8">
	<title>Product</title>
	<style type="text/css">
		table {
			margin:auto;
			border: 2px dashed #111;
			font-size: 23px;
			text-align: center;
		}
		th,td{
			margin:0px;
			border: 2px solid #111;
		}
		form{
			text-align: center;
			margin:20px auto;
		}
		button{
		    background-color: #4CAF50;
		    border: none;
		    color: white;
		    padding: 15px 25px;
		    text-align: center;
		}
	</style>
</head>
<body>
	<table>
		<?php
			echo "<tr>";
			echo "<th>id</th>";
			echo "<th>name</th>";
			echo "<th>price</th>";
			echo "</tr>";

			$stmt = $pdo->prepare("SELECT product_id, product_name, price FROM shop.product");
			/*
				使用PDO::prepare()方法來準備它。為執行準備一個句子，並回傳。
				沒問題就回傳一個pdo物件，而錯誤就回傳false.
			*/
			$stmt->execute() or exit("讀取test.member發生錯誤"); //執行pdo物件；反之出錯。

			while( $row = $stmt->fetch( PDO::FETCH_ASSOC ) ){	//以 fetch 一次取出一筆資料。
				echo "<tr>";
				echo "<td>".$row['product_id']."</td>";
				echo "<td>".$row['product_name']."</td>";
				echo "<td>".$row['price']."</td>";
				echo "</tr>";
			}
		?>
	</table>
		<form method="get" action="addOneData.php">
			<?php $pdo = null; ?> 	<!-- 按下按鈕同時關閉pdo通道，釋放資源。  -->
			<button type="submit">CreateData</button>
		</form>
</body>
</html>