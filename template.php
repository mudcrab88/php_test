<html lang='ru'>
	<head>
	<title>Пример</title>
	<meta charset='utf-8'>
	<script src='https://www.google.com/recaptcha/api.js'></script>
	<script src="js/script.js"></script>
	<link rel="stylesheet" href="css/style.css">
	</head>
	<body>
	<div id="user_data">
		<form id="user_register_form" action="" method="POST" enctype="multipart/form-data">
			<p><b>Введите данные нового пользователя:</b></p>
			<p><label for="name">Имя:</label>
			<input type="text" id="name" name="name" value="<?=$_SESSION['name']?>" required></p> 
			<p><label for="surname">Фамилия:</label> 
			<input type="text" id="surname" name="surname" value="<?=$_SESSION['surname']?>" required></p>
			<p><label for="age">Возраст:</label> 
			<input type="text" id="age" name="age" value="<?=$_SESSION['age']?>" required></p>
			<p><label for="password">Пароль:</label>
			<input type="text" id="password" name="password" required></p>
			<p><label for="image">Фото:</label>
			<input type="file" id="photo" name="photo" accept="image/jpeg,image/png" required></p>
			<p><label for="files">Файлы:</label>
			<input type="file" id="files" name="files[]" accept="application/msword" multiple="multiple" required></p>
			<p><input type="submit" value="Отправить"></p>
			<div class="g-recaptcha" data-sitekey="6LciZVwUAAAAAMNqu8Tx5TPoZIxvmI60_1-uXGgg"></div>
		</form>
	</div>
	<div id="users_table">
		<p id ="error"><?php echo $msg;?></p>
		<table border='1'><tr><td>id</td><td>Имя</td><td>Фамилия</td><td>Возраст</td><td>Фото</td></tr>
		<?php if ($result) {while ($row = $result->fetch_row()) { ?>
			<tr> 
			<?php for ($i=0;$i<$result->field_count;$i++) { ?>				
				<td><?php echo $row[$i];?></td>				
			<?php } ?>
			</tr>
		<?php }} ?>		
		</table>
	</div>
	</body>
</html>