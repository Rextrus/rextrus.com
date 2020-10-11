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

	<section id="main-bg">
		<div class="container">
			<div class="row">
				<div class="col-sm" onMouseOver="showContent('dcContent')" onMouseOut="hideContent('dcContent')">
					<div class="hovereffect">
						<a href="https://discord.gg/t5jRGbj" target="_blank"><img class="img-responsive" src="img/dc.png" alt="Discord"></a>
					</div>
				</div>
				<div class="col-sm" onMouseOver="showContent('tsContent')" onMouseOut="hideContent('tsContent')">
					<div class="hovereffect">
						<a href="ts3server://rextrus.com?port=9987" target="_blank"><img src="img/ts.png" alt="Teamspeak"></a>
					</div>
				</div>
				<div class="col-sm" onMouseOver="showContent('svContent')" onMouseOut="hideContent('svContent')">
					<div class="hovereffect">
						<a href="servers" target="_blank"><img src="img/sv.png" alt="Servers"></a>
					</div>
				</div>
			</div>
			<div class="row">
				<div class="col-sm" onMouseOver="showContent('steamContent')" onMouseOut="hideContent('steamContent')">
					<div class="hovereffect">
						<a href="https://steamcommunity.com/id/rextrus" target="_blank"><img src="img/steam.png" alt="Steam"></a>
					</div>
				</div>
				<div class="col-sm" onMouseOver="showContent('codContent')" onMouseOut="hideContent('codContent')">
					<div class="hovereffect">
						<a href="timers"><img src="img/cod4.png" alt="CoD4"></a>
					</div>
				</div>
				<div class="col-sm" onMouseOver="showContent('dlContent')" onMouseOut="hideContent('dlContent')">
					<div class="hovereffect">
						<a href="downloads" target="_blank"><img src="img/download-icon.png" alt="Download"></a>
					</div>
				</div>
			</div>
		</div>
	</section>

	<section id="desc-text">
		<div class="container">
			<div id="dcContent"><p>Link to xoxor4ds Discord - You can find me there</p></div>
			<div id="tsContent"><p>Link to my Teamspeak 3 Server</p></div>
			<div id="svContent"><p>Click to see an overview from my servers</p></div>
			<div id="steamContent"><p>Link to my Steam profile</p></div>
			<div id="codContent"><p>Click to see my Call of Duty 4 references</p></div>
			<div id="dlContent"><p>Click to get to the download section</p></div>
		</div>
		<script>
		  function showContent(id) {
		    document.getElementById(id).style.display = "block";
		    document.getElementById(id).style.opacity = 1;
		  }
		  function hideContent(id) {
		    document.getElementById(id).style.opacity = 0;
		    setTimeout(() => {document.getElementById(id).style.display = "none";
			}, 3000);
		  }

		</script>
	</section>
</body>