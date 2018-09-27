<?php
defined('_JEXEC') or die;
?>
<!DOCTYPE html>
<html xmlns="http://www.w3.org/1999/xhtml" xml:lang="ru-ru" lang="ru-ru" dir="ltr">
<?php var_dump($this->city); ?>
<head>
	<meta http-equiv="content-type" content="text/html; charset=utf-8">
	<style>
		<?php include('locked.css');?>
	</style>
	<meta name="viewport" content="width=device-width, initial-scale=1">
	<title>403 - доступ запрещён</title>
</head>
	<body>
		<div class="heading">
			<div class="wrapper">
				<h1>403 - доступ запрещён</h1>
			</div>
		</div>

		<div class="description">
			<div class="wrapper">
				<p>Доступ к сайту из Черновицкой области запрещён.</p>
				<p>Пожалуйста, обратитесь к администратору или введите пароль доступа:</p>
				<form method="POST">
					<input type="password" name="websitepassword" autofocus/>
					<input type="submit" value="Войти">
				</form>

				<div class="city-info">
					<div><b>IP адрес</b>: <?php echo $this->ip; ?></div>
					<div><b>Название города</b>: <?php echo $this->city['name_ru']; ?></div>
					<div><b>ID города</b>: <?php echo $this->city['id']; ?></div>
				</div>
				
				<pre>

				</pre>
			</div>
		</div>
	</body>
</html>
