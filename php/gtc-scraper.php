<?php
$spreadsheet_url="https://docs.google.com/spreadsheets/d/1bI3gCleBzYX7Euz7Wvu5nJ_gNlVGjWKuuqKc2D7Rg3Q/pub?gid=234805686&single=true&output=csv";

if(!ini_set('default_socket_timeout', 15)) echo "<!-- unable to change socket timeout -->";

$selected_course = $_GET["cls"];

if (($handle = fopen($spreadsheet_url, "r")) !== FALSE) {
  $skip = true;

	while (($data = fgetcsv($handle, 1000, ",")) !== FALSE) {
		if ($skip)
		{ //Skip header line
		    $skip = false;
		    continue;
		}
		//save into an array of gtc courses_temp
    if ($data[0] != "")
  		$courses .= $data[0] . ",";

	}

	fclose($handle);
}
else
	die("Problem reading csv");

  echo substr( $courses, 0, -1);
?>
