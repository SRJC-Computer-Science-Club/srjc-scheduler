<?php

echo '<!DOCTYPE html><html><head></head><body>'; // webkit hotfix

$con = mysql_connect('localhost', 'srjccs', 'srjccs');
if (!$con) {
    die('Could not connect: ' . mysql_error());
}
echo 'Connected successfully<br>';

mysql_select_db('SRJC');







$url = 'https://portal.santarosa.edu/SRWeb/SR_ScheduleOfClasses.aspx?Mode=text&TermID=20183';


$ch = curl_init();

curl_setopt($ch,CURLOPT_URL, $url);
curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);

//execute post
$result = curl_exec($ch);
echo $result;

//exit();


$http_code = curl_getinfo($ch, CURLINFO_HTTP_CODE);
if (preg_match("/(404|500)/", $http_code) === 1) {
    echo 'Server Error';
}

//close connection



$dom = new DOMDocument;
@$dom->loadHTML($result);

$xpath = new DOMXpath($dom);


$tableQ = $xpath->query("//table[@id='dlstTextSelectionDisciplines']//td/a");

$i = 0;
$links;

foreach($tableQ as $link)
{

    $links[$i] = "https://portal.santarosa.edu/SRWeb/" . $link->getAttribute('href');
    //echo $i . "  https://portal.santarosa.edu/SRWeb/" . $link->getAttribute('href') . "<br>";
    $i += 1;
}

echo "<br><br><br>";


//exit();
for ($i = 0 ; $i < count($links) ; $i++ )
{
    //sleep(2);
    $xpath = getXpath( $links[ $i ] );
    $tableQ = $xpath->query("//table[@id='dlstTextSelectionCourseTitles']//td/a");
    //$j = 0;
    //$links2;
    foreach($tableQ as $link)
    {

        //$links2[$j] = "https://portal.santarosa.edu/SRWeb/" . $link->getAttribute('href');
        //echo "https://portal.santarosa.edu/SRWeb/" . $link->getAttribute('href') . "<br>";
        $li = mysql_real_escape_string('https://portal.santarosa.edu/SRWeb/' . $link->getAttribute('href'));
        echo $link->textContent;
        $na = mysql_real_escape_string($link->textContent);
        $sql = "REPLACE INTO S18 ".
                "VALUES('$na','$li','') ";


        $r = mysql_query( $sql , $con );

        if(! $r )
        {
            die('Could not enter data: ' . mysql_error());
        }

        //echo " - Entered data successfully<br>";

        //$j += 1;
    }
    //$urls[$i] = $links2;
    echo "<br><br><br>";

    flush();
    sleep( 1);
}

echo '</body></html>'; // webkit hotfix


mysql_close($con);

curl_close($ch);

exit();



function getXpath($url) {
    $ch2 = curl_init();
    curl_setopt($ch2,CURLOPT_URL, $url);
    curl_setopt($ch2, CURLOPT_RETURNTRANSFER, true);
    $result = curl_exec($ch2);

    //echo $result;

    $http_code = curl_getinfo($ch2, CURLINFO_HTTP_CODE);
    if (preg_match("/(404|500)/", $http_code) === 1) {
        echo 'Server Error';
    }

    $dom = new DOMDocument;
    @$dom->loadHTML($result);

    $xpath = new DOMXpath($dom);
    return $xpath;
}






exit();
