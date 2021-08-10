<?php 
require_once('vendor/autoload.php');
use Spatie\ArrayToXml\ArrayToXml;
session_start();
$file_name = "products.json";
if(!file_exists($file_name))return;
$string = file_get_contents($file_name);
$data = json_decode($string, true);

if(isset($_POST['get-api-data'])):
	$actual_link = 'http://'.$_SERVER['HTTP_HOST'].$_SERVER['REQUEST_URI'];
	$filter = $actual_link.'restApi.php?';
	if(isset($_POST['filter-name'])):
		$filter .= 'filter_by_name='.implode(",",$_POST['filter-name']);
	endif;
	if(isset($_POST['pvp-low']) && isset($_POST['pvp-high'])):
		if(isset($_POST['filter-name']))$filter .= '&';
		$filter .= 'filter_by_pvp='.$_POST['pvp-low'].','.$_POST['pvp-high'];
	endif;
	$curl_handle=curl_init();
	curl_setopt($curl_handle,CURLOPT_URL,$filter);
	curl_setopt($curl_handle,CURLOPT_CONNECTTIMEOUT,2);
	curl_setopt($curl_handle,CURLOPT_RETURNTRANSFER,1);
	$buffer = curl_exec($curl_handle);
	curl_close($curl_handle);

	$_SESSION['data'] = $buffer;
	header("Location: ".$actual_link);
	exit;
endif;
?>
<!DOCTYPE html>
<html>
	<head>
		<title>Sacoor Brother</title>
		<!-- CSS only -->
		<link href="https://cdn.jsdelivr.net/npm/bootstrap@5.1.0/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-KyZXEAg3QhqLMpG8r+8fhAXLRk2vvoC2f3B09zVXn8CA5QIVfZOJ3BCsw2P0p/We" crossorigin="anonymous">
	</head>
	<body>
		<main>
			<div class="container">
				<div class="parent-div mt-5">
					<form action="" method="post">
						<div class="row">
							<div class="col-12 col-md-3">
								<p>Filter by name</p>
								<?php foreach ($data['product']  as $key => $value) {
									?>
									<div class="form-check">
									  <input class="form-check-input" type="checkbox" value="<?php echo $value['name'] ?>" id="flexCheckDefault<?php echo $key ?>" name="filter-name[]">
									  <label class="form-check-label" for="flexCheckDefault<?php echo $key ?>">
									    <?php echo $value['name'] ?>
									  </label>
									</div>
									<?php
								} ?>
							</div>
							<div class="col-12 col-md-3">
								<p>Filter by pvp</p>
								<section class="range-slider">
								  <p><span class="rangeValues"></span></p>
								  <input name="pvp-low" value="0" min="0" max="50000" step="500" type="range">
								  <input  name="pvp-high"value="3000" min="500" max="50000" step="500" type="range">
								</section>
							</div>
							<div class="col-12">
								<input class="mt-4 btn btn-success w-50" type="submit" name="get-api-data" value="Get data">
							</div>
						</div>
					</form>
					<div class="mt-5">
						<?php 
						if(isset($_SESSION['data'])):
							echo '<p>Response</p>';
							var_dump($_SESSION['data']);
						endif;
						?>
					</div>
				</div>
			</div>
		</main>
		<script type="text/javascript">
			function getVals(){
			  // Get slider values
			  var parent = this.parentNode;
			  var slides = parent.getElementsByTagName("input");
			    var slide1 = parseFloat( slides[0].value );
			    var slide2 = parseFloat( slides[1].value );
			  // Neither slider will clip the other, so make sure we determine which is larger
			  if( slide1 > slide2 ){ var tmp = slide2; slide2 = slide1; slide1 = tmp; }
			  
			  var displayElement = parent.getElementsByClassName("rangeValues")[0];
			      displayElement.innerHTML = slide1 + " - " + slide2;
			}

			window.onload = function(){
			  // Initialize Sliders
			  var sliderSections = document.getElementsByClassName("range-slider");
			      for( var x = 0; x < sliderSections.length; x++ ){
			        var sliders = sliderSections[x].getElementsByTagName("input");
			        for( var y = 0; y < sliders.length; y++ ){
			          if( sliders[y].type ==="range" ){
			            sliders[y].oninput = getVals;
			            // Manually trigger event first time to display values
			            sliders[y].oninput();
			          }
			        }
			      }
			}
		</script>
	</body>
</html>