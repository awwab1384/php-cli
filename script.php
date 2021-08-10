<?php 
require_once('vendor/autoload.php');
use Spatie\ArrayToXml\ArrayToXml;

echo "\nWelcome to Sacoor Brothers\n\nPHP is running\n\n";
$values = array('f:','opt::');
$values = getopt(null, $values);
if(!isset($values['f']) || !$values['f'])return 'Need a CSV file to process a task';
$row = 1;
if (($handle = fopen($values['f'], "r")) !== FALSE) {
    while (($data = fgetcsv($handle, 1000, ",")) !== FALSE) {
       $content[] = $data;
    }
    fclose($handle);
}
$title = $content[0];
$data = array();
$count = 0;
foreach ($content as $key => $value) {
	if($key==0)continue;//Remove headers
	foreach ($title as $subkey => $subvalue) {
		$data['product'][$count][preg_replace('/[\x00-\x1F\x80-\xFF]/',"",trim($subvalue))] = trim($value[$subkey]);
	}
	$count++;
}
if(!isset($values['opt']))$values['opt'] = 'both';
switch ($values['opt']) {
	case 'json':
		echo json_encode($data);
		break;
	case 'xml':
		echo ArrayToXml::convert($data);
		break;
	case 'both':
		echo json_encode($data);
		echo ArrayToXml::convert($data);
		break;
	
	default:
		# code...
		break;
}

$file_name = "products.json";

$fh = fopen($file_name, "w");
fwrite($fh, json_encode($data));
fclose($fh);
echo "\n\nData store on local json file(products.js) for REST API calls";
?>