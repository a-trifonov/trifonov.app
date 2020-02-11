<?php

define('DB_SERVER', 'mysql');
define('DB_USERNAME', 'root');
define('DB_PASSWORD', '123321');
define('DB_NAME', 'trifonov_app');
 

$conn = new PDO("mysql:host=".DB_SERVER.";dbname=".DB_NAME.";charset=UTF8", DB_USERNAME, DB_PASSWORD);

$dbs = $conn->query( 'SELECT * FROM statuses' );

var_dump($dbs);

while( ( $db = $dbs->fetchColumn( 0 ) ) !== false )
{
    var_dump($db);
	echo $db.'<br>';
}

?>