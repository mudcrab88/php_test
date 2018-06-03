<?php
	/*проверка капчи*/
	function captcha($recaptcha, $secret) {		
		//Формируем utl адрес для запроса на сервер гугла
		$url = "https://www.google.com/recaptcha/api/siteverify?secret=".$secret."&response=".$recaptcha."&remoteip=".$_SERVER['REMOTE_ADDR'];	 
		//Инициализация и настройка запроса
		$curl = curl_init();
		curl_setopt($curl, CURLOPT_URL, $url);
		curl_setopt($curl, CURLOPT_RETURNTRANSFER, 1);
		curl_setopt($curl, CURLOPT_TIMEOUT, 10);
		curl_setopt($curl, CURLOPT_USERAGENT, "Mozilla/5.0 (Windows; U; Windows NT 6.1; en-US; rv:1.9.2.16) Gecko/20110319 Firefox/3.6.16");
		//Выполнение запроса к серверу google
		$curlData = curl_exec($curl); 
		curl_close($curl);  
		//Ответ приходит в виде json строки, декодируем ее
		$curlData = json_decode($curlData, true);
		return $curlData;
	}
	/*проверка является ли фото изображением*/
	function is_photo($photo) {
		if (mime_content_type($photo['tmp_name'])=="image/png" or mime_content_type($photo['tmp_name'])=="image/jpeg") {
			return true;
		} else {
			return false;
		}
	}
	/*загрузка фото*/
	function upload_photo($photo,$path) {
		$ext = array_pop(explode('.',$photo['name'])); // расширение
		$new_name = "img".time().'.'.$ext; // новое имя с расширением
		$full_path = $path.$new_name; //путь с новым именем и расширением
		if($photo['error'] == 0){
			if(move_uploaded_file($photo['tmp_name'], $full_path)){
				return $full_path;
			} else return;
		} else return;
	}
	
	/*загрузка файлов*/
	function upload_files($files,$path,$user_id,$mysqli) {
		$count=0;
		foreach ($files['name'] as $filename) {			
			$ext = array_pop(explode('.',$filename));
			$new_name = "file".time()."_".$count.".".$ext; // новое имя с расширением			
			$full_path = $path.$new_name; 
			$tmp=$files['tmp_name'][$count];
             $count=$count + 1;
			if(move_uploaded_file($tmp, $full_path)){
				$mysqli->query("INSERT into files (name,user_id) VALUES ('$full_path','$user_id')");
			} 
		} 
	}
?>