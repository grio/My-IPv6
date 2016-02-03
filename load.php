<?php require 'functions.php'; ?>
<?php db_open (); ?>
<?php 
//проверяем валидность поста
$Err_email = false;
$Err_pass = false; 
$Err_name = false; 
if (isset ($_REQUEST) && count ($_REQUEST) > 2)
{ 
	if (isset ($_REQUEST["pass"])) $_REQUEST["pass"] = substr(trim($_REQUEST["pass"]), 0, 20);
	if (isset ($_REQUEST["name"])) $_REQUEST["name"] = substr(trim($_REQUEST["name"]), 0, 20);
	if (isset ($_REQUEST["email"])) $_REQUEST["email"] = substr(trim($_REQUEST["email"]), 0, 30);
	if ( isset ($_REQUEST["email"]) )
	{
		  if (isValidEmail($_REQUEST["email"]) && (check_user ($_REQUEST["email"])))
			$Err_email = false;
		  else
			$Err_email = true;
	} else $Err_email = true;
	if ( isset ($_REQUEST["pass"]) )
	{
		if (check_pass ($_REQUEST["email"], $_REQUEST["pass"])) {
						$Err_pass = false;
					} else {
						$Err_pass = true;
					}
	} else $Err_pass = true;
	if ( isset ($_REQUEST["name"]) )
	{
		if (check_computer ($_REQUEST["name"], $_REQUEST["email"])) {
						$Err_name = false;
					} else {
						$Err_name = true;
					}
	} else $Err_name = true;
	if ($Err_email || $Err_pass || $Err_name) 
	{
		     if ($Err_email) echo "Email incorrect";
		else if ($Err_pass) echo "Auth incorrect";
		else if ($Err_name) echo "Computer name incorrect";
	} else {
		echo get_ip ($_REQUEST["name"], $_REQUEST["email"], $_REQUEST["pass"]);
	}
} else {
	echo "USAGE: load.php?email=[e@mail]&pass=[password]&name=[computer_name]";
}
echo "\n";
?>
<?php db_close ();?>