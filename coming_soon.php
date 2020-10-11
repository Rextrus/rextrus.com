<?php 
session_start();

$currentSide = basename(__FILE__, '.php');
include_once("config.php");
include_once(WEB_SV_PATH . "components/_fnctn.php");

$dbhost = SQL_HOST;
$pdo = new PDO("mysql:host=$dbhost;dbname=web", SQL_USER, SQL_PASSWORD);
?>
<!DOCTYPE HTML>

<html>
	<?php include_once(WEB_SV_PATH . "components/header.php"); ?>
<body>

	<?php include_once(WEB_SV_PATH . "components/navbar.php"); ?>

	<section id="desc-text" style="color: #fff; text-align: center; margin-top: 100px; font-size: 30px; text-transform: none;">
		<p>coming soon..</p>
	</section>

</body>

</html>