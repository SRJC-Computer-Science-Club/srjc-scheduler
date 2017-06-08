<?php

$con = mysql_connect('localhost', 'srjccs', 'srjccs');
if (!$con) {
	echo "A Server Error Occured";
	exit();
}
//echo 'Connected successfully<br>';

mysql_select_db('SRJC');

$search = mysql_real_escape_string($_GET["cls"]);
//echo $search;

$result = mysql_query("SELECT DISTINCT  `URL` FROM  `F17` WHERE Courses =  '$search'");

if (!$result ) {
	echo "A Server Error Occured";
	exit();
}

if ( mysql_num_rows($result)==0 ) {
	echo "Course Not Found";
	exit();
}

$url = mysql_result($result, 0);

$ch = curl_init();

curl_setopt($ch,CURLOPT_URL, $url);
curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);

$result = curl_exec($ch);

$http_code = curl_getinfo($ch, CURLINFO_HTTP_CODE);
if (preg_match("/(404|500)/", $http_code) === 1) {

	$result = mysql_query("SELECT DISTINCT  `INFO` FROM  `F17` WHERE Courses =  '$search'");

	if (!$result ) {
		echo "A Server Error Occured";
		exit();
	}

	if ( mysql_num_rows($result)==0 ) {
		echo "Course Not Found";
		exit();
	}

	echo mysql_result($result, 0);
	exit();
}


//close connection
curl_close($ch);


$dom = new DOMDocument;
@$dom->loadHTML($result);

$elements = $dom->getElementsByTagName("br");

for ($i = $elements->length - 1; $i >= 0; $i --)
{
	$nodePre = $elements->item($i);
	$nodeDiv = $dom->createTextNode("&");
	$nodePre->parentNode->replaceChild($nodeDiv, $nodePre);
}
/*
$elements = $dom->getElementsByTagName("img");

for ($i = $elements->length - 1; $i >= 0; $i --)
{
	$nodePre = $elements->item($i);
	$nodeDiv = $dom->createTextNode("");
	$nodePre->parentNode->replaceChild($nodeDiv, $nodePre);
}
*/

$xpath = new DOMXpath($dom);


$tableQ = $xpath->evaluate("//tr[@class='DataRow']/td");

$class = "";


foreach($tableQ as $link)
{
	$class = $class . $link->textContent . "\t";
}

echo $class;

$class = mysql_real_escape_string( $class );

$sql = "REPLACE INTO F17 ".
		"VALUES('$search','$url','$class') ";

mysql_query( $sql , $con );

mysql_close($con);


exit();

?>
