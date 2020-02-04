<?php
	session_start();  //�q�������HSESSION�Ȧs��ơC

	header("Content-Type:text/html; charset=utf-8"); //PHP �e Header �i�D�s�����o���O UTF-8 �s�X�A�קK�ýX�C
	try{
	    $dsn = "mysql:host=localhost;port=3306;dbname=shop;charset=utf8"; // �s��mysql������T�Ghost:localhost/port=3306/dbname
	    $user = "root"; // mysql�ϥΪ̦W��
	    $password = ""; // mysql�ϥΪ̱K�X
	    $options = array (PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION);
	    /*
			 ATTR_EERMODE�G�O�ӭn��PDO�ɪ��@�w�n���򥻳]�w�C
			 ERRMODE_EXCEPTION. ���|�۰ʧi�DPDO�C���d�ߥ��ѮɩߥX���`�C
	    */
	    $pdo = new PDO($dsn, $user,$password,$options); //�s�WPDO�����Jpdo�ܼơC
	}catch(PDOException $e){	
	    echo "��Ʈw�s�u���ѡI���~�T���G",$e->getMessage();	
	    exit;
	}

	if(!isset($_SESSION['decision'])){ // �קK�]���s��z�ɭP��ƭ��ƿ�J�C
		$_SESSION['decision']=0;
	}
	if(isset($_GET["maybe"]) && !empty($_GET["productName"]) && !empty($_GET["productPrice"]) && $_SESSION['decision']==$_GET['decision']){
		$_SESSION['decision']+=1;  // �קK���s��z�ɭP��ƭ��ƿ�J�C
		$sql ="INSERT INTO shop.product(product_name, price) VALUES ('".$_GET["productName"]."','".$_GET["productPrice"]."')";   
		//SQL���g�J��ƫ��O�C 
		$pdo->query($sql);	//�HPDO�q�D����SQL�C
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
				�ϥ�PDO::prepare()��k�ӷǳƥ��C������ǳƤ@�ӥy�l�A�æ^�ǡC
				�S���D�N�^�Ǥ@��pdo����A�ӿ��~�N�^��false.
			*/
			$stmt->execute() or exit("Ū��test.member�o�Ϳ��~"); //����pdo����F�Ϥ��X���C

			while( $row = $stmt->fetch( PDO::FETCH_ASSOC ) ){	//�H fetch �@�����X�@����ơC
				echo "<tr>";
				echo "<td>".$row['product_id']."</td>";
				echo "<td>".$row['product_name']."</td>";
				echo "<td>".$row['price']."</td>";
				echo "</tr>";
			}
		?>
	</table>
		<form method="get" action="addOneData.php">
			<?php $pdo = null; ?> 	<!-- ���U���s�P������pdo�q�D�A����귽�C  -->
			<button type="submit">CreateData</button>
		</form>
</body>
</html>