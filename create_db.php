<?php
	try //open the database
	{
		$db = new PDO('sqlite:ipv6.base.sqlite');
		$query = $db->query('SELECT 1 FROM sqlite_master WHERE tbl_name = "users"');
		$result = $query->fetch();
		if ($result[2] != 1) {
			//create the database
			$db->exec("CREATE TABLE users (ID INTEGER PRIMARY KEY, Email TEXT, Password TEXT, RecDate TEXT, IP TEXT, Aproved INTEGER)");
			$db->exec("CREATE TABLE computers (ID INTEGER PRIMARY KEY, UserID INTEGER, Name TEXT, IPv6 TEXT, RecDate TEXT, IP TEXT, Protected INTEGER)");
			echo 'Table created';
		} else echo 'Table exist';
	}
	catch(PDOException $e)
	  {
	    print 'Exception : '.$e->getMessage();
	  }
	$db = NULL;
?>