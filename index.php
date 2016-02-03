<?php require 'functions.php'; ?>
<?php db_open (); ?>
<?php 
//проверяем валидность поста
$Err_email = false;
$Err_pass = false; 
$Err_name = false; 
$Err_code = false; 
$Err_search = false;
$Err_db = false;
$Flag_post = false;
$Flag_success = false;
$Flag_search = false;
	if (isset ($_REQUEST["email"]) || isset ($_REQUEST["search"]))
	{ 
		if ( isset($_REQUEST["search"]) )
		{
			$_REQUEST["search"] = substr(trim($_REQUEST["search"]), 0, 30);
			if (strlen(trim($_REQUEST["search"])) < 1) $Err_search = true;
				else $Flag_search = true;
		} else {
			$Flag_post = true;
			if (isset ($_REQUEST["pass"])) $_REQUEST["pass"] = substr(trim($_REQUEST["pass"]), 0, 20);
			if (isset ($_REQUEST["computer"])) $_REQUEST["computer"] = substr(trim($_REQUEST["computer"]), 0, 20);
			if (isset ($_REQUEST["email"])) $_REQUEST["email"] = substr(trim($_REQUEST["email"]), 0, 30);
			$Err_email = !isValidEmail($_REQUEST["email"]);
			(strlen($_REQUEST["pass"]) < 1) ? $Err_pass = true : $Err_pass = false;
			(strlen($_REQUEST["computer"]) < 1) ? $Err_name = true : $Err_name = false;
			if ( trim($_REQUEST["RND_User"]) == "" or strtoupper($_REQUEST["RND_User"])<>strtoupper($_REQUEST["RND_Original"]) )
			{
				$Err_code = true;
			}
			if (!$Err_email && !$Err_pass && !$Err_name && !$Err_code) {
				if (!isset($_REQUEST["private"]) || $_REQUEST["private"] != "1") $_REQUEST["private"] = "0";
				if (check_user ($_REQUEST["email"]) < 1) 
				{
					add_user ($_REQUEST["email"], $_REQUEST["pass"]);
					add_computer ($_REQUEST["computer"], $_REQUEST["email"], $_REQUEST["private"]);
					if (check_pass ($_REQUEST["email"], $_REQUEST["pass"]) < 1) {
							$Err_db = true;
						} else {
							$Flag_success = true;
						}
				} else if (check_pass ($_REQUEST["email"], $_REQUEST["pass"]) < 1) 
				{
					$Err_pass = true;
				} else {
					add_computer ($_REQUEST["computer"], $_REQUEST["email"], $_REQUEST["private"]);
					$Flag_success = true;
					}
				if ($Flag_success) 
				{
				$Flag_search = true;
				$_REQUEST["search"] = $_REQUEST["computer"];
				}
			}
		}
	}
?>

<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta content="text/html; charset=utf-8" http-equiv="Content-Type">
<meta name="description" content="Ваш приватный DNS для динамических IPv6 адресов" /> 
<meta name="keywords" content="IPv6, DNS, Teredo, Miredo, Dynamic IP, SSH, NAT, Firewall, Router, Linux, MacOS, Windows, open source, GPL" />
<meta name="author" content="GRiO" />
 
<title>My-IPv6 :: Ваш приватный DNS для динамических IPv6 адресов</title>
<link rel="stylesheet" href="main.css" type="text/css">
</head>
<body>

<div id="block">
<div class="header">
<logo><a href="index.php"><img src="logo.jpg"/></a></logo>
<htitle>My-IPv6</htitle><br>
<subhtitle>Ваш приватный DNS для динамических IPv6 адресов.</subhtitle>
<div class="menu">
<a href="index.php">[Домашняя]</a> <a href="http://version6.ru/ways" target=_blank>[Как настроть IPv6]</a> <a href="https://gitorious.org/my-ipv6/my-ipv6/blobs/master/ipv6save.sh" target=_blank>[Bash скрипт]</a> <a href="https://gitorious.org/my-ipv6" target=_blank>[Сорцы проекта]</a> <a href="/ipv6/punbb/viewtopic.php?id=5">[FAQ]</a> <a href="/ipv6/punbb/">[Форум]</a>
</div> <!-- меню -->
</div> <!-- header -->

<div class="left_col">
<form	enctype="multipart/form-data" 
		action="index.php" 
		method="post" 
		name="UserForm" >
<h2>Добавить новый компьютер:</h2>
<?php if ($Flag_success) echo '<span class="formSuccess">Комьютер под именем <b>'.$_REQUEST["computer"].'</b> успешно добавлен в базу!</span>'; ?>
<?php if ($Err_db) echo '<span class="formErrorMess">Возникла техническая проблема с базой данных. Попробуйте снова через минуту. Если ошибка повторится, пожалуйста напишите в <a href="&#109;&#97;&#105;&#108;&#116;&#111;&#58;&#103;&#114;&#105;&#103;&#111;&#114;&#105;&#121;&#50;&#48;&#49;&#49;&#64;&#103;&#109;&#97;&#105;&#108;&#46;&#99;&#111;&#109;"><img src="mail.gif" alt="" width="14" height="10" border="0"/>&nbsp;тех.поддержку</a>!</span>'; ?>
	    <div>
	        <label for="email">Е-Mail:<span>*</span><br><i>(на один email можно регистрировать сколько угодно компьютеров)</i></label>
	        <input type="text" id="email" name="email" <?php if ($Err_email) echo 'class="formError"'; ?> value="<?php if ($Flag_post && !$Flag_success) echo $_REQUEST["email"]; ?>"/>
		<?php if ($Err_email) echo '<span class="formErrorMess">Введите действительный email!</span>'; ?>
	    </div>
	    <div>
	        <label>Пароль:<span>*</span></label>
	        <input type="text" id="pass" name="pass" <?php if ($Err_pass) echo 'class="formError"'; ?> value="<?php if ($Flag_post && !$Flag_success) echo $_REQUEST["pass"]; ?>"/>
		<?php if ($Err_pass) echo '<span class="formErrorMess">Введите корректный пароль!</span>'; ?>
	    </div>
	    <div>
	        <label for="computer">Имя компьютера:<span>*</span></label>
	        <input type="text" id="computer" name="computer" <?php if ($Err_pass) echo 'class="formError"'; ?> value="<?php if ($Flag_post && !$Flag_success) echo $_REQUEST["computer"]; ?>"/>
		<?php if ($Err_name) echo '<span class="formErrorMess">Введите корректное имя компьютера!</span>'; ?>
	    </div>
	    <div>
		<input type="checkbox" id="private" name="private" value="1" <?php if ($Flag_post && !$Flag_success && $_REQUEST["private"]=="1") echo "checked"; ?>/> не доступен для общего поиска
	    </div>
	    <div><br>
		<label>Код подтверждения:<span>*</span></label>
<?php 
if (!isset ($_REQUEST['RND_Original']) or $Flag_post) $Rnd_Code=generateRndCode(4); else $Rnd_Code = $_REQUEST['RND_Original'];
echo '<input type="hidden" name="RND_Original" value='.$Rnd_Code.'><rndcode>'.$Rnd_Code.'</rndcode>';
?>
		<input type="text" name="RND_User" id="RND_User" class="rndcode" value="" maxlength=6 <?php if ($Err_code) echo 'class="formError"'; ?>/>
		<input type="submit" value="Добавить" />
		<?php if ($Err_code) echo '<span class="formErrorMess">Введите правильный код!</span>'; ?>
	    </div>
	</form>
</div> <!-- left_col -->
<?php if ($Flag_success) require 'success.inc';?>
<div class="right_col">
	<form	enctype="multipart/form-data" 
			action="index.php" 
			method="get" 
			name="SearchForm" >
<h2>Поиск в базе IPv6:</h2>
Введите имя компьютера или адрес электронной почты.
		<div>
			<input type="text" name="search" id="search" value="<?php if ($Flag_search) echo $_REQUEST["search"]; ?>" maxlength=30 />
			<input type="hidden" name="nc" value="<?php echo generateRndCode(6); ?>"/>
			<input type="submit" value="Найти"/>
			<?php if ($Err_search) echo '<span class="formErrorMess">Может еще пару буковок?</span>'; ?>
<?php if ($Flag_search && !$Err_search) {

$result = $db->query("SELECT Name, IPv6, RecDate, (SELECT Email FROM users WHERE ID = UserID) FROM computers WHERE (Name = '".$_REQUEST["search"]."' OR UserID = (SELECT ID FROM users WHERE Email = '".$_REQUEST["search"]."')) AND Protected != '1' GROUP BY Name ORDER BY RecDate DESC");
$Flag_found = false;
    foreach($result as $row)
   {
$Flag_found = true;
echo "<div id='search'>";
echo "<div>
<label>Регистратор:</label>
".hide_email($row[3])."
</div>";
echo "<div>
<label>Имя компьютера:</label>
".$row['Name']."
</div>";
echo "<div>
<label>IPv6 адрес:</label>
".$row['IPv6']."
</div>";
echo "<div>
<label>Дата обновления:</label>
".$row['RecDate']."
</div>";
echo "</div>";
   }
if (!$Flag_found) echo "<div><br><b>Совпадений c ".$_REQUEST["search"]." не найдено.</b><br>Или информация по компьютеру отмечена, как приватная.</div>";
}?>
		</div>

		<div>
			  
		</div>
	</form>
</div><!-- right_col -->
<?php if (!$Flag_search) require 'intro.inc';?>

<div class="footer">grio.ru &#174; 2011-2016<br>
<a class="small" href="xmpp:grio@jabber.ru?message"><img src="../images/jabber.gif" align="absmiddle" width="" height="" alt="Jabber: grio@jabber.ru" border="0">&nbsp;Тех.поддержка</a>
</div>
</div><!-- footer -->
</body>
</html>
<?php db_close ();?>