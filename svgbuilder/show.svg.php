<?php
/**
 *
 * Description: Show the sign passed as argument
 *
 * Author: Sander H
 *
 * Using:
 * svglib by Eduardo Bonfandini
 *
 * History
 * 2016-08-07: initial tests
 *
 */
 
/*  turn off when done debugging */
//error_reporting(E_ALL);
//ini_set('display_errors', 'On');
/* ******************* */

require_once "svglib/svglib.php";

$defaultwidth = 300; // standardize all SVG to 300 width to compensate for image size differences (sign must be within group for the scale transform to work OK)
$defaultoffset = 10; // small defaultoffset to separate signs

$signstring = $_GET[ 'signs' ];

$signstring = str_replace(':', '_', $signstring);  // replace : by _ to match filenames
//$signstrings = explode(',', $signstring);
//var_dump($signstring);print('<br />');
//$signstring = preg_replace('/[,|;|\s]([A-Z]{2})/', "\n\${1}", $signstring); // replace the separation characters followed by at least the country code by newlines for easier splitting
//var_dump($signstring);print('<br />');
//$signstrings = explode("\n", $signstring);

	$signstring = trim($signstring, ',;');  // remove the separator characters from the left
	$signstring = trim($signstring);        // remove any spaces from both ends
	$country = strtok($signstring, "_");    // country is the (first 2) characters before _
    $signstring = preg_replace('/([a-zA-Z:]+)(0*)([0-9]+)(.*)/', "$1$3$4", $signstring); // remove leading zero's
	//var_dump($signstring);
	//var_dump($country);
	
	if ( !str_ends_with($signstring, ".svg") )
	{
		$signstring .= ".svg"; // append with ".svg" if it's missing
	}

	if ($country && file_exists( "../traffic_signs/{$country}/" . $signstring ))
	{
		$sign = SVGDocument::getInstance( "../traffic_signs/{$country}/" . $signstring ); // load resource
	}
	else if (file_exists( "../traffic_signs/" . $signstring )) // don't have anything here yet, but maybe for some future generic signs
	{
		$sign = SVGDocument::getInstance( "../traffic_signs/" . $signstring );            // load resource
	}
	else
	{
		if ( str_starts_with($signstring, "OB") ) // catch Dutch underplate
		{
			$sign = SVGDocument::getInstance( '../traffic_signs/OB_Q.svg' );  // load `unknown underplate` resource
		}
		else
		{
			$sign = SVGDocument::getInstance( '../traffic_signs/Q.svg' );     // load `unknown sign` resource
		}
	}

$sign->output();

?>