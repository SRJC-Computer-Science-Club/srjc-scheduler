<?php
$spreadsheet_url="https://docs.google.com/spreadsheets/d/1bI3gCleBzYX7Euz7Wvu5nJ_gNlVGjWKuuqKc2D7Rg3Q/pub?output=csv";

if(!ini_set('default_socket_timeout', 15)) echo "<!-- unable to change socket timeout -->";

$selected_course = "GtC Government";

if (($handle = fopen($spreadsheet_url, "r")) !== FALSE) {
	while (($data = fgetcsv($handle, 1000, ",")) !== FALSE) {

		$t = "\t";
		$b = " "; //blank information for missing attributes from the spreadsheet_url
		//TODO parse into correct format >>section, days, time, instructor, campus, room, units, status, total seats, used seats, remaining seats, date begin ends, date final

		//TODO DONE remove any slashes (want MWTTh)
		$days = preg_replace("/\//", "", $data[2]);

		$course_title = "c";
		if ($data[0] == "")
			$course_title = "";
		$course = $t . $course_title . $t . $data[1] . $t . $days . $t . $data[3] . $t . $data[4] . $t . $data[5] . $t . $data[6] . $t . $data[7] . $t . $t . $t . $t . $t . $data[8] . $t . $data[9] . "\t\n\t \t" . $data[10];
		// echo $course;
		//save into an array of gtc courses_temp
		$courses_temp[] = $course;

		// echo "<br><br>";
	}

	// echo "<hr>";

	$courses_temp;
	$courses;
	$index = 0;

	foreach ($courses_temp as $course) {
		if( $course[1] /*course title*/ == "c")
		{ // the course is fine as is
			$courses[$index] = substr( $course, 2);
			$index += 1;
		}
		else
		{ // it is part of a larger course and needs to be concatenated with the previous course
			$courses[$index -1] .= "\n\t" . $course;
		}
	}

	echo $courses[4];
	// echo $course . "<br><br>";
	fclose($handle);
}
else
	die("Problem reading csv");
?>
