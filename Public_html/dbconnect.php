<?php
	ob_start();
	if(!isset($_SESSION)) { 
             session_start(); 
        } 
	
	// this will avoid mysql_connect() deprecation error.
	error_reporting( ~E_DEPRECATED & ~E_NOTICE );
	// but I strongly suggest you to use PDO or MySQLi.
	
	define('DBHOST', 'localhost');
	define('DBUSER', 'id2017236_leonidagarth');
	define('DBPASS', '123456789');
	define('DBNAME', 'id2017236_dbtest');
	
	$_SESSION['conn'] = mysqli_connect(DBHOST,DBUSER,DBPASS);
	$dbcon = mysqli_select_db($_SESSION['conn'], DBNAME);
	
	if ( !$_SESSION['conn'] ) {
		die("Connection failed : " . mysqli_error($_SESSION['conn']));
	}
	
	if ( !$dbcon ) {
		die("Database Connection failed : " . mysqli_error($_SESSION['conn']));
	}
?>
<?php ob_end_flush(); ?>