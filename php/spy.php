<?php
	foreach ( $_POST as $key=>$value )	
	{
		echo "'" . $key  . "' => urlencode('" . $value . "'),<br>";
	}
?>