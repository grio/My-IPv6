<?php require 'config.inc'; ?>
<?php

function db_open (){
global $db;
global $_DB_NAME;
	try //open the database
	{
		$db = new PDO("sqlite:$_DB_NAME");
		$db->setAttribute( PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION );  
	}
	catch (PDOException $e)
	{
		print 'Exception : '.$e->getMessage();
		file_put_contents('PDOErrors.txt', $e->getMessage(), FILE_APPEND);  
	}
}
function add_user ($Email, $Password){
global $db;
    $ISODate = date (DATE_ATOM);
    $tmp = $db->prepare ("INSERT INTO users VALUES (NULL, '$Email', '$Password', '$ISODate', '$_SERVER[REMOTE_ADDR]', 0)");
    $tmp->execute();
    $tmp = null;
}
function add_computer ($Name, $Email, $Private = 0, $IPv6 = "unknown"){
global $db;
    $ISODate = date (DATE_ATOM);
    $tmp = $db->prepare ("REPLACE INTO computers VALUES ((SELECT ID FROM computers WHERE Name = '$Name' AND UserID = (SELECT ID FROM users WHERE Email = '$Email')), (SELECT ID FROM users WHERE Email = '$Email'), '$Name', '$IPv6', '$ISODate', '$_SERVER[REMOTE_ADDR]', '$Private')");
    $tmp->execute();
    $tmp = null;
}
function change_ip ($Name, $Email, $IPv6 = "unknown"){
global $db;
    $ISODate = date (DATE_ATOM);
    $tmp = $db->prepare ("UPDATE computers SET IPv6 = '$IPv6', RecDate = '$ISODate', IP = '$_SERVER[REMOTE_ADDR]' WHERE Name = '$Name' AND UserID = (SELECT ID FROM users WHERE Email = '$Email')");
    $tmp->execute();
    $tmp = null;
}
function check_pass ($Email, $Password){
global $db;
    $tmp = $db->prepare ("SELECT 1 FROM users WHERE Email = '$Email' AND Password = '$Password'");
    $tmp->execute();
    $result = $tmp->fetch();    
    $tmp = null;
    return $result[1];
}
function check_user ($Email){
global $db;
    $tmp = $db->prepare ("SELECT 1 FROM users WHERE Email = '$Email'");
    $tmp->execute();
    $result = $tmp->fetch();    
    $tmp = null;
    return $result[1];
}
function check_computer ($Name, $Email){
global $db;
    $tmp = $db->prepare ("SELECT 1 FROM computers WHERE Name = '$Name' AND UserID = (SELECT ID FROM users WHERE Email = '$Email')");
    $tmp->execute();
    $result = $tmp->fetch();    
    $tmp = null;
    return $result[1];
}
function get_ip ($Name, $Email, $Pass){
global $db;
    $tmp = $db->prepare ("SELECT IPv6 FROM computers WHERE Name = '$Name' AND UserID = (SELECT ID FROM users WHERE Email = '$Email' AND Password = '$Pass')");
    $tmp->execute();
    $result = $tmp->fetch();    
    $tmp = null;
    return $result['IPv6'];
}
function hide_email ( $email ){
      list($name, $server) = split("@", $email);
      $newname = $name[0]." [***] ".$name[strlen($name)-1];
      return $newname."@".$server;
}
function antispam ( $email ){
	$html = "";
	for ($i=0; $i<strlen($email); $i++) {
		$html .= '&amp;#'.ord($email[$i]).";";
	}
	return $html;
}
function isValidEmail ($email){
return preg_match("/^[_\.0-9a-zA-Z-]+@([0-9a-zA-Z][0-9a-zA-Z-]+\.)+[a-zA-Z]{2,6}$/i", $email);
}

function str_numbers_only ($str){
	return preg_replace ("/[^\d]/", "", $str);
}

function db_close (){
global $db;
	// close the database connection
	$db = NULL;
}

function generateRndCode($_Length, $_Symbols = 'QWERTYUiLPASDFGHJKZXCVBNM123456789'){
	
	$l_name='';
	$top = strlen($_Symbols)-1;
	srand((double) microtime()*1000000);
	for($j=0; $j<$_Length; $j++)$l_name .= $_Symbols{rand(0,$top)};
	return $l_name;
}

function validateIPv4($IP)
{
    return $IP == long2ip(ip2long($IP));
}

function validateIPv6($IP)
{
    // fast exit for localhost
    if (strlen($IP) < 3)
        return $IP == '::';

    // Check if part is in IPv4 format
    if (strpos($IP, '.'))
    {
        $lastcolon = strrpos($IP, ':');
        if (!($lastcolon && validateIPv4(substr($IP, $lastcolon + 1))))
            return false;

        // replace IPv4 part with dummy
        $IP = substr($IP, 0, $lastcolon) . ':0:0';
    }

    // check uncompressed
    if (strpos($IP, '::') === false)
    {
        return preg_match('/^(?:[a-f0-9]{1,4}:){7}[a-f0-9]{1,4}$/i', $IP);
    }

    // check colon-count for compressed format
    if (substr_count($IP, ':') < 8)
    {
        return preg_match('/^(?::|(?:[a-f0-9]{1,4}:)+):(?:(?:[a-f0-9]{1,4}:)*[a-f0-9]{1,4})?$/i', $IP);
    }

    return false;
} 
?>