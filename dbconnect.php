<?php

error_reporting(E_ALL);
    ini_set('display_errors', 1);

define('DB_SERVER', 'mysql');
define('DB_USERNAME', 'trifonov');
define('DB_PASSWORD', 'trifonov');
define('DB_NAME', 'trifonov_app');
 

$conn = new PDO("mysql:host=".DB_SERVER.";dbname=".DB_NAME.";charset=UTF8", DB_USERNAME, DB_PASSWORD);

$res = $conn->query( 'SHOW DATABASES;' );

if(($db = $res->fetchColumn( 0 ) ) !== false) {
  while( ( $db = $res->fetchColumn( 0 ) ) !== false )
  {
      if($db=='trifonov_app') echo '<i>Connecting to DB trifonov_app...</i><br><br>';
  }
} else {
    echo 'DB trifonov_app not found';
}

echo '<b>TABLES in DB trifonov_app:</b><br>';

$res = $conn->query( 'SHOW TABLES;' );
$tables = $res->fetchAll(PDO::FETCH_COLUMN);

if($tables) {
  foreach ($tables as $table) {
    echo $table.'<br>';
  }
} else {
   echo 'Not found';
}

?>