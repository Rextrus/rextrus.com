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

	<section id="timers">

		<div class="container">
			<p>speedruns of my maps</p>
			<form action="timers" method="get" name="selector">
				<div class="input-group mb-3">
					<select class="custom-select" id="map" name="map">
						<option value="">select a map</option>
						<option value="mp_glados" <?php if(isSet($_GET['map']) && $_GET['map'] == "mp_glados") echo " selected";?>>mp_glados</option>
						<option value="mp_ruins" <?php if(isSet($_GET['map']) && $_GET['map'] == "mp_ruins") echo " selected";?>>mp_ruins</option>
						<option value="mp_the_extreme_v2" <?php if(isSet($_GET['map']) && $_GET['map'] == "mp_the_extreme_v2") echo " selected";?>>mp_the_extreme_v2</option>
						<option value="mp_astral" <?php if(isSet($_GET['map']) && $_GET['map'] == "mp_astral") echo " selected";?>>mp_astral</option>
					</select>
					<div class="input-group-prepend">
						<button class="btn btn-outline-secondary" onclick="window.location.href='timers'" type="button">reset</button>
					</div>
					<div class="input-group-prepend">
						<button class="btn btn-outline-secondary" name="route" value="random" type="submit">random</button>
					</div>
				</div>

				<div class="row justify-content-md-center hidden" id="astral">
					<div class="col col-lg-2">
						<div class="hovereffect">
							<input type="submit" name="route" value="training">
						</div>
					</div>
					<div class="col col-lg-2">
						<div class="hovereffect">
							<input type="submit" name="route" value="easy">
						</div>
					</div>
					<div class="col col-lg-2">
						<div class="hovereffect">
							<input type="submit" name="route" value="inter">
						</div>
					</div>
					<div class="col col-lg-2">
						<div class="hovereffect">
							<input type="submit" name="route" value="hard">
						</div>
					</div>
					<div class="col col-lg-2">
						<div class="hovereffect">
							<input type="submit" name="route" value="secret">
						</div>
					</div>
				</div>
				<div class="row justify-content-md-center hidden" id="glados">
					<div class="col col-lg-2">
						<div class="hovereffect">
							<input type="submit" name="route" value="easy">
						</div>
					</div>
					<div class="col col-lg-2">
						<div class="hovereffect">
							<input type="submit" name="route" value="inter">
						</div>
					</div>
					<div class="col col-lg-2">
						<div class="hovereffect">
							<input type="submit" name="route" value="hard">
						</div>
					</div>
					<div class="col col-lg-2">
						<div class="hovereffect">
							<input type="submit" name="route" value="advanced">
						</div>
					</div>
					<div class="col col-lg-2">
						<div class="hovereffect">
							<input type="submit" name="route" value="beach">
						</div>
					</div>
					<div class="col col-lg-2">
						<div class="hovereffect">
							<input type="submit" name="route" value="challenge">
						</div>
					</div>
				</div>			
				<div class="row justify-content-md-center hidden" id="the_extreme_v2">
					<div class="col col-lg-2">
						<div class="hovereffect">
							<input type="submit" name="route" value="easy">
						</div>
					</div>
					<div class="col col-lg-2">
						<div class="hovereffect">
							<input type="submit" name="route" value="inter">
						</div>
					</div>
					<div class="col col-lg-2">
						<div class="hovereffect">
							<input type="submit" name="route" value="inter plus">
						</div>
					</div>
					<div class="col col-lg-2">
						<div class="hovereffect">
							<input type="submit" name="route" value="elevator">
						</div>
					</div>
					<div class="col col-lg-2">
						<div class="hovereffect">
							<input type="submit" name="route" value="extreme">
						</div>
					</div>
				</div>
				<div class="row justify-content-md-center hidden" id="notOut">
					<p>this map is not out yet..</p>
				</div>

				<script type="text/javascript">
					$(document).ready(function(){
					  $("#searchEngine").on("keyup", function() {
					    var value = $(this).val().toLowerCase();
					    $("#runTable tr").filter(function() {
					      $(this).toggle($(this).text().toLowerCase().indexOf(value) > -1)
					    });
					  });
					});

				    $('#map').change(function(){
				        var selected_item = $(this).val()

						$('#astral').val(selected_item).addClass('hidden');
						$('#glados').val(selected_item).addClass('hidden');
						$('#the_extreme_v2').val(selected_item).addClass('hidden');
						$('#notOut').val(selected_item).addClass('hidden');

						switch(selected_item) {
							case "mp_glados":
								$('#glados').val("").removeClass('hidden');
								break;
							case "mp_the_extreme_v2":
								$('#the_extreme_v2').val("").removeClass('hidden');
								break;
							case "mp_ruins":
								$('#notOut').val("").removeClass('hidden');
								break;
							case "mp_astral":
								$('#astral').val("").removeClass('hidden');
								break;
							default:
								break;
						}
				    });

				</script>

				<?php

					if(isSet($_GET['map']))
						$map = $_GET['map'];
					if(isSet($_GET['route']))
						$route = $_GET['route'];


					if(isSet($map) && isSet($route)) {
						if($route == "random") {
							randomTable();
						} else {
							echo "<p>$map $route</p>";

							$map = substr($map, 3);

							echo "<script>$('#$map').val('').removeClass('hidden');</script>";

							echo printTable($map, $route);
						}
			        }

			        function randomTable() {
						$random = array (
							array("mp_astral","training","easy","inter","hard","secret"),
							array("mp_the_extreme_v2","easy","inter","interplus","extreme","elevator"),
							array("mp_glados","easy","inter","hard","beach","challenge","advanced")
						);

						$rndmMap = rand(0, 2);
						$rndmMapString = $random[$rndmMap][0];
						$countMapRoutes = count($random[$rndmMap]) - 1;						  
						$rndmRoutes = rand(1, $countMapRoutes);						  
						$rndmRouteString = $random[$rndmMap][$rndmRoutes];
						
						echo "<p>$rndmMapString - $rndmRouteString</p>";

						$rndmMapString = substr($rndmMapString, 3);

						$_GET['route'] = $rndmRouteString;

						echo printTable($rndmMapString, $rndmRouteString);
			        }

			        function printTable($map, $route) {
						$table = "content/timers/$map"."_"."$route";
						
						if (!file_exists($table)) {
						    echo "<p>error 404 - that map and route does not match</p>";
						} else {
							$timer = file_get_contents("content/timers/$map"."_"."$route", true);
							$thead = file_get_contents("content/timers/thead", true);
						    $table = "$thead $timer";
						    return $table;
						}
			        }
				?>
			</form>
		</div>
	</section>

<!-- 	<section id="footer">
		<div class="container">
			<p>© Rextrus.com 2020. All Rights Reserved.</p>
		</div>
	</section> -->
</body>