<?php 
session_start();

$currentSide = basename(__FILE__, '.php');
include_once("config.php");
include_once(WEB_SV_PATH . "components/_fnctn.php");

$dbhost = SQL_HOST;
$pdo = new PDO("mysql:host=$dbhost;dbname=web", SQL_USER, SQL_PASSWORD);

require_once('components/GameQ/Autoloader.php');

$GameQ = new \GameQ\GameQ();

?>
<!DOCTYPE HTML>

<html>
	<?php include_once(WEB_SV_PATH . "components/header.php"); ?>
<body>

	<?php include_once(WEB_SV_PATH . "components/navbar.php"); ?>

	<section id="servers">
		<div class="container">
			<p>servers</p>
			<?php $results = "SELECT * FROM servers"; ?>

			<table class="table sortable">
				<thead>
					<tr>
						<th>type</th>
						<th>ip address</th>
						<th>port</th>
						<th>information</th>
						<th>status</th>
					</tr>
				</thead>
				<tbody id='search'>
				<?php foreach ($pdo->query($results) as $row) : ?>
					<tr>
						<?php 
							$ip = $row['ip'];
							$port = $row['port'];
							$type = $row['type'];
							if($row['ip'] == "rextrus.com")
								$ip = "localhost";
						
							if($port == 9987)
								$port = 10011;

							$fp = @fsockopen($ip, $row['port'], $errno, $errstr, .1);
						?>
						<td><?=$row['type']?></td>
						<td><?=$row['ip']?></td>
						<td><?=$row['port']?></td>
						<td>
							<?php
								if($fp) {
									if($row['owner'] != "rextrus")
										$id = $row['type'] . "_" . $row['owner'] . "_" . $row['port'];
									else 
										$id = $row['type'] . "_" . $row['port'];

									if($type == "minecraft" || $type == "cod4") {
										$GameQ->addServer(['type' => $type, 'host' => "$ip:$port", 'id' => $id]);
										$infoResults = $GameQ->process();
									}
									
									switch($row['type']) {
										case "cod4":
											if(isSet($infoResults[$id]['gq_mapname']) && isSet($infoResults[$id]['clients'])  && isSet($infoResults[$id]['gq_hostname'])) {
												$infoResults[$id]['gq_hostname'] = str_replace("^5", "", $infoResults[$id]['gq_hostname']);
												$infoResults[$id]['gq_hostname'] = str_replace("^7", "", $infoResults[$id]['gq_hostname']);
												echo "<p>name: " . $infoResults[$id]['gq_hostname'] . "</p>";
												echo "<p>map: " . $infoResults[$id]['gq_mapname'] . "</p>";
												echo "<a style='cursor:pointer;' onClick='togglePlayers(";
												echo '"'.$id.'"';
												echo ")'>players: " . $infoResults[$id]['clients'] . "/" .  $infoResults[$id]['sv_maxclients'] . " (click)</a>";
												echo "
												<table id='$id' class='table sortable hidden' style='background-color: unset !important;'>
													<thead>
														<tr>
															<th>player</th>
															<th>score</th>
															<th>ping</th>
														</tr>
													</thead>
												<tbody>
												";
												foreach($infoResults[$id]["players"] as $player) {
													echo "<tr>";
													echo "<td>" . $player["name"] . "</td>";
													echo "<td>" . $player["frags"] . "</td>";
													echo "<td>" . $player["ping"] . "</td>";
													echo "</tr>";
												}
												echo "</tbody></table>";
											} else {
												echo "<p>server is still booting</p>";
											}
											break;
										case "minecraft":
											if(isSet($infoResults[$id]['version']) && isSet($infoResults[$id]['gq_numplayers'])) {
												echo "<p>version: " . $infoResults[$id]['version'] . "</p>";
												echo "<p>players: " . $infoResults[$id]['gq_numplayers'] . "/" .  $infoResults[$id]['gq_maxplayers'] . "</p>";
											} else {
												echo "<p>server is still booting</p>";
											}
											break;
										case "teamspeak3":
											// echo $id;
											break;
										default:
											break;
									}
								}
							
							?>
						</td>
						<td>
							<?php
								if(!$fp) 
									echo "<img src='img/offline.png' alt='offline' width='100px' height='42px;''>";
								else 
									echo "<img src='img/online.png' alt='online' width='100px' height='42px;'>";
							?>
						</td>
					</tr>
				<?php endforeach; ?>
				</tbody>
			</table>
		</div>

		<script type="text/javascript">
			function togglePlayers(which) {
				var element = document.getElementById(which);
				if (element.classList.contains('hidden')) {
					element.classList.remove("hidden");
				} else {
					element.classList.add("hidden");
				}
			} 
		</script>
	</section>

</body>

</html>