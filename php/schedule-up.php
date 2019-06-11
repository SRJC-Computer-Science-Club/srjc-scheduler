<?php

$url = 'https://portal.santarosa.edu/SRWeb/SR_ScheduleOfClasses.aspx?Mode=text&TermID=20157';


$ch = curl_init();

curl_setopt($ch,CURLOPT_URL, $url);
curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);

//execute post
$result = curl_exec($ch);


//exit();


$http_code = curl_getinfo($ch, CURLINFO_HTTP_CODE);


//close connection



$dom = new DOMDocument;
@$dom->loadHTML($result);

$xpath = new DOMXpath($dom);


$tableQ = $xpath->query("//select[@id='ddlTerm']");

$i = 0;
$links;

foreach($tableQ as $link)
{

    if( preg_match('/2016/' , $link->textContent) == 1 )
    {

    $email_to = "benhuff322@gmail.com";
 
    $email_subject = "SRJC Scheduler";
   
     
 
     
 
     
 
// create email headers
 
$headers = "Spring Schedule";
@mail($email_to, $email_subject, $email_message, $headers);  
exit();
    }
}

?>
