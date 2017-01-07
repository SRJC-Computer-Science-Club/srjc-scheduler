<?php
$spreadsheet_url="https://docs.google.com/spreadsheets/d/1bI3gCleBzYX7Euz7Wvu5nJ_gNlVGjWKuuqKc2D7Rg3Q/pub?output=csv";

if(!ini_set('default_socket_timeout', 15)) echo "<!-- unable to change socket timeout -->";

if (($handle = fopen($spreadsheet_url, "r")) !== FALSE) {
	while (($data = fgetcsv($handle, 1000, ",")) !== FALSE) {
		$spreadsheet_data[] = $data;
		print_r($data);
		echo "<br><br>";
	}
	echo "<br><br>";
	print_r($spreadsheet_data);
	fclose($handle);
}
else
	die("Problem reading csv");
?>