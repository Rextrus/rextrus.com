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
	<?php 
	if(isSet($_GET['map'])) {
		$map = $_GET['map'];


	    $mappath = WEB_SV_PATH . "content/cod4/usermaps/$map/";
	    $file = WEB_SV_PATH . "temp/$map.zip";

	    if(!file_exists($file)) {
	        $zip = new ZipArchive();
	        $res = $zip->open($file, ZipArchive::CREATE | ZIPARCHIVE::OVERWRITE);
	        if($res === FALSE){
	            return false;
	        }

	        $zip->addFile($mappath . $map . ".ff", $map . ".ff");
	        $zip->addFile($mappath . $map . "_load.ff", $map . "_load.ff");
	        $zip->addFile($mappath . $map . ".iwd", $map . ".iwd");

	        $zip->close();
	    }

	    header("Content-Type: application/zip");
	    header("Content-Length: " . filesize($file));
	    header("Content-Disposition: attachment; filename=" . basename($file));
	    ob_clean();

	    printLog("$map was downloaded");     
	    $statement = $pdo->prepare("UPDATE usermaps SET download = download + 1  WHERE name = :name");
        $statement->execute(array('name' => $map));

	    readfile($file);
	    unlink($file);
	}

	function mapScanBot() {
	    $mappath = WEB_SV_PATH . "content/cod4/usermaps";
	    $usermaps = scandir($mappath);
	    $msg = '';

	    $dbhost = SQL_HOST;
	    $pdo = new PDO("mysql:host=$dbhost;dbname=web", SQL_USER, SQL_PASSWORD);


	    if($pdo) {
		    for($i = 2; $i < sizeof($usermaps); $i++) {
		    	if(substr($usermaps[$i], 0, 3) == "mp_") {
			        $statement = $pdo->prepare("SELECT ID_usermaps FROM usermaps WHERE name = '$usermaps[$i]'");
			        $result = $statement->execute();
			        $user = $statement->fetch();
			        if (!$user) {
			            $statement = $pdo->prepare("INSERT INTO `usermaps` (`name`) VALUES ('$usermaps[$i]')");
			            $result = $statement->execute();
			            if($result)
			            	$msg .= "<p>[Map Scan] Added " . $usermaps[$i] . "</p>";
			            else echo "$usermaps[$i] could not be added";
			        }
			    } 
		    }
			return $msg;
		}
	}
	?>

	<?php include_once(WEB_SV_PATH . "components/navbar.php"); ?>


	<section id="downloads">
		<div class="container">
			<p>available downloads</p>

			<?php
			if(isset($_POST['action'])) {
			    switch ($_POST['action']) {
			        case 'scan':
			            echo mapScanBot();
			            break;
			    }
			}
			?>

			<form action="downloads.php" method="post" enctype="multipart/form-data">
                <button class="btn" name="action" value="scan" style="border: 2px solid;">scan for new maps</button>
			</form>

			<div class="row justify-content-md-center hidden" style="margin-top: 20px;">
				<div class="col-sm">
					<div class="hovereffect"> 
						<?php $nRows = $pdo->query('SELECT count(*) FROM usermaps')->fetchColumn();	?>
						<p>total maps: <?php echo $nRows;?></p>
					</div>
				</div>
				<div class="col-sm">
					<?php $totalDownloads = $pdo->query('SELECT SUM(download) AS totalDownloads FROM usermaps;')->fetchColumn(); ?>
					<div class="hovereffect">
						<p>total downloads: <?php echo $totalDownloads;?></p>
					</div>
				</div>
				<div class="col-sm">
					<div class="hovereffect">
						<?php $latestEntry = $pdo->query('SELECT name FROM usermaps ORDER BY date DESC LIMIT 1;')->fetchColumn(); ?>
						<p>latest map: <?php echo $latestEntry;?></p>
					</div>
				</div>
			</div>

			<?php $results = "SELECT * FROM usermaps ORDER BY name"; ?>

			<input id='searchEngine' type='text' placeholder='search..'><br>
			<form action="downloads.php" method="get">
				<table class="table sortable">
					<thead>
						<tr>
							<th>name</th>
							<th>downloads</th>
							<th>date added</th>
							<th>download link</th>
						</tr>
					</thead>
					<tbody id='search'>
					<?php foreach ($pdo->query($results) as $row) : ?>
						<tr>
							<td><?=$row['name']?></td>
							<td><?=$row['download']?></td>
							<td><?=$row['date']?></td>
							<td><input type="submit" name="map" style='cursor:pointer;' value="<?=$row['name']?>"></td>
						</tr>
					<?php endforeach; ?>
					</tbody>
				</table>
			</form>
		</div>
		<script type="text/javascript">
			$(document).ready(function(){
			  $("#searchEngine").on("keyup", function() {
			    var value = $(this).val().toLowerCase();
			    $("#search tr").filter(function() {
			      $(this).toggle($(this).text().toLowerCase().indexOf(value) > -1)
			    });
			  });
			});
		</script>
	</section>

<!-- 	<section id="footer">
		<div class="container">
			<p>© Rextrus.com 2020. All Rights Reserved.</p>
		</div>
	</section> -->
</body>