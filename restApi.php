<?php 
require_once('vendor/autoload.php');
use Spatie\ArrayToXml\ArrayToXml;

$file_name = "products.json";
if(!file_exists($file_name))return;
$string = file_get_contents($file_name);
$fData = $data = json_decode($string, true);

$filter_by_name = $filter_by_pvp = false;

$values = array('f_name:','f_pvp:');
$values = getopt(null, $values);

if(isset($values['f_name']))$filter_by_name = explode(",", strtolower($values['f_name']));
if(isset($values['f_pvp']))$filter_by_pvp = explode(",", $values['f_pvp']);

if(isset($_GET['filter_by_name']))$filter_by_name = explode(",", strtolower($_GET['filter_by_name']));
if(isset($_GET['filter_by_pvp']))$filter_by_pvp = explode(",", $_GET['filter_by_pvp']);

if($filter_by_name || $filter_by_pvp)$fData = array();

if($filter_by_name || $filter_by_pvp):
	$fData = array();
	$count = 0;
	foreach ($data['product'] as $key => $value) {
		if($filter_by_name && !in_array(strtolower($value['name']),$filter_by_name))continue;
		if($filter_by_pvp && $value['pvp']<$filter_by_pvp[0])continue;
		if($filter_by_pvp && $value['pvp']>$filter_by_pvp[1])continue;
		$fData['product'][$count] = $value;
		$count++;
	}
endif;

// headers for not caching the results
header('Cache-Control: no-cache, must-revalidate');

// headers to tell that result is JSON
header('Content-type: application/xml');
// send the result now
// exit(json_encode($fData));
exit(ArrayToXml::convert($fData));
?>