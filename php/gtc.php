<?php
$spreadsheet_url="https://docs.google.com/spreadsheets/d/1bI3gCleBzYX7Euz7Wvu5nJ_gNlVGjWKuuqKc2D7Rg3Q/pub?gid=234805686&single=true&output=csv";

if(!ini_set('default_socket_timeout', 15)) echo "<!-- unable to change socket timeout -->";

$selected_course = $_GET["cls"];

if (($handle = fopen($spreadsheet_url, "r")) !== FALSE) {
  $skip = true;

	$courses_temp;
	$courses;
	$index = 0;

	while (($data = fgetcsv($handle, 1000, ",")) !== FALSE) {
		if ($skip)
		{ //Skip header line
		    $skip = false;
		    continue;
		}

		$t = "\t";
		$b = " "; //blank information for missing attributes from the spreadsheet_url

        //format >>section, days, time, instructor, campus, room, units, status, total seats, used seats, remaining seats, date begin ends, date final

		$days = preg_replace("/\n/", "&", preg_replace("/\//", "", $data[2]));
    $times = preg_replace("/\n/", "&", $data[3]);
    $instructors = preg_replace("/\n/", "&", $data[4]);
    $locations = preg_replace("/\n/", "&", $data[5]);
    $classrooms = preg_replace("/\n/", "&", $data[6]);
    $dates = preg_replace("/\n/", "&", $data[8]);

		$course = array(
      $data[0],
      $data[1] . $t . $days . $t . $times . $t . $instructors . $t . $locations . $t . $classrooms . $t . $data[7] . $t . $t . $t . $t . $t . $dates . $t . $data[9] . "\t\n\t \t" . $data[10]
    );

		//save into an array of gtc courses_temp
		$courses_temp[] = $course;

	}

  //$courses_temp now has all entries in the csv as ([0]: course title, [1]: course info as a large string)


  // add or contactanate classes with multiple sections to the courses array
	foreach ($courses_temp as $course) {
		if( $course[0] /*course title*/ != "")
		{ // the course is fine as is
			$courses[$index] = $course;
			$index += 1;
		}
		else
		{ // it is part of a larger course and needs to be concatenated with the previous course
			$courses[$index -1][1] .= "$^$" . $course[1];
		}
	}

	$return;

	foreach ($courses as $course) {
		if ($selected_course == $course[0])
			$return = $course[1];

	}

	echo $return;

	fclose($handle);
}
else
	die("Problem reading csv");
?>
