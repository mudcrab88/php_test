<?php 
	session_start();
	require_once "functions.php";
	$host = "localhost";
	$user = "test";
	$password = "masterkey";
	$db = "test_db";
	$photo_dir = "img/";
	$files_dir = "files/";
	$mysqli = new mysqli($host, $user, $password, $db);
	/* проверка соединения */
	if ($mysqli->connect_errno) {
		exit("Не удалось подключиться к базе данных");
	}	
	/*проверка полей формы*/
	$recaptcha = $_POST['g-recaptcha-response']; 
	//Если капча введена
	if(!empty($recaptcha)) {
		//Получаем HTTP от recaptcha
		$recaptcha = $_REQUEST['g-recaptcha-response'];
		$secret = '6LciZVwUAAAAAGJDHHQzLsBjZmhEnZQJNwfEtnYV'; 
		$curlData = captcha($recaptcha, $secret);
		//Если капча прошла проверку
		if($curlData['success']) {
			if ($_POST['password']=="test") {
				$pass = true;
				$_SESSION["name"] = "";
				$_SESSION["surname"] = ""; 
				$_SESSION["age"] = "";
			}
			else {
				$pass = false;
				$_SESSION["name"] = $_POST['name'];
				$_SESSION["surname"] = $_POST['surname']; 
				$_SESSION["age"] = $_POST['age'];
			}	
			$photo = $_FILES['photo'];
			$files = $_FILES['files'];			
			if ($pass==true and is_photo($photo)==true and is_empty($_POST['name'],$_POST['surname'],$_POST['age'])) {
				$name = $mysqli->escape_string($_POST['name']);
				$surname = $mysqli->escape_string($_POST['surname']); 
				$age = $mysqli->escape_string($_POST['age']);				
				$photo = $mysqli->escape_string(upload_photo($photo,$photo_dir));
				if ($mysqli->query("INSERT into users (name,surname,age, photo) VALUES ('$name','$surname','$age','$photo')")) {
					$msg = "$mysqli->affected_rows новых строк вставлено.\n";
					$user_id = $mysqli->insert_id;
					upload_files($files,$files_dir,$user_id,$mysqli);
				} 
			}
			else if ($pass==false){			
				$msg = "Неверный пароль";
			} 
			else if (is_photo($photo)==false){			
				$msg = "Загруженная фотография не является изображением";
			}	
			else  {			
				$msg = "Не заполнены необходимые поля";
			} 
	 
		} else if (isset($_POST['send'])){
			$msg = "Капча не прошла проверку";
		}
	}
	else if ($_SERVER['REQUEST_METHOD'] == 'POST') {
		$msg = "Капча не введена";
		$_SESSION["name"] = $_POST['name'];
		$_SESSION["surname"] = $_POST['surname']; 
		$_SESSION["age"] = $_POST['age'];
	}
		
	/*вывод таблицы с результатами*/
	$result = $mysqli->query("SELECT * FROM users");	
	ob_start();
	require 'template.php';
	$content = ob_get_clean();
	if ($result) $result->close();		
	else $msg = "Ошибка при запросе к базе данных";		
	echo $content;
?>