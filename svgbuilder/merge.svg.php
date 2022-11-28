<?php
/**
 *
 * Description: Merge the signs passed as arguments into 1 single SVG image
 *
 * Author: Sander H
 *
 * Using:
 * svglib by Eduardo Bonfandini
 *   added setPreserveAspectRatio to svglib.php:
 *     /** Sander H 2014-12-16: added method
 *      * Define the preserveAspectRatio of SVG document
 *      *
 *      * @param string $preserveAspectRatio
 *       /
 *     public function setPreserveAspectRatio( $preserveAspectRatio )
 *     {
 *         $this->setAttribute( 'preserveAspectRatio', $preserveAspectRatio );
 *
 *         return $this;
 *     } 
 *
 * History
 * 2014-12-14: initial tests
 * 2015-01-27: data can include separation characters
 *             adding pole
 * 2016-08-06: adding support for parsing raw traffic_sign by replacing : by _
 * 2018-05-15: allow comma to be used as separator
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
$signstring = preg_replace('/[,;|\s]/', "\n\${1}", $signstring); // without country code as it can be optional on subsequent signs
//var_dump($signstring);print('<br />');
$signstrings = explode("\n", $signstring);

$sign = SVGDocument::getInstance();
$sign->setWidth($defaultwidth);
$sign->setHeight(0);

$rect = SVGRect::getInstance( ($defaultwidth-20)/2, 0, 'myRect', 20, $sign->getHeight(), new SVGStyle( array( 'fill'   => '#f5f5f5', 'stroke' => '#000000' ) ) );
$rect->setAttribute('id', 'pole');
$sign->addShape( $rect ); 

foreach ($signstrings as $signstring)
{
	$signstring = trim($signstring, ',;');  // remove the separator characters from the left
	$signstring = trim($signstring);        // remove any spaces from both ends
	if (!isset($country))
	{
		$country = strtok($signstring, "_");    // country is the (first 2) characters before _, but not needed if an earlier sign already had country code
	}
	$signstring = preg_replace('/([a-zA-Z:]+)(0*)([0-9]+)(.*)/', "$1$3$4", $signstring); // remove leading zero's
	if (strpos($signstring, "_") === false)
	{
		$signstring = $country . "_" . $signstring; // if subsequent signs don't have a country code add it
	}
	//var_dump($signstring);
	//var_dump($country);
	
	if ( !str_ends_with($signstring, ".svg") )
	{
		$signstring .= ".svg"; // append with ".svg" if it's missing
	}

	if ($country && file_exists( "../traffic_signs/{$country}/" . $signstring ))
	{
		$sign_part = SVGDocument::getInstance( "../traffic_signs/{$country}/" . $signstring ); // load resource
	}
	else if (file_exists( "../traffic_signs/" . $signstring )) // don't have anything here yet, but maybe for some future generic signs
	{
		$sign_part = SVGDocument::getInstance( "../traffic_signs/" . $signstring );            // load resource
	}
	else
	{
		if ( preg_match('/OB/', $signstring) ) // catch Dutch underplate
		{
			$sign_part = SVGDocument::getInstance( '../traffic_signs/OB_Q.svg' );  // load `unknown underplate` resource
		}
		else
		{
			$sign_part = SVGDocument::getInstance( '../traffic_signs/Q.svg' );     // load `unknown sign` resource
		}
	}

	if ( preg_match('/OB/', $signstring) )
	{ 
		$offset = 0;                                                               // put underplate directly under 'parent' sign
	}
	else 
	{ 
		$offset = $defaultoffset;                                                  // put space between the 2 plates
	}
	
	$height = $sign_part->getHeight();
	$width = $sign_part->getWidth();
	$new_height = $defaultwidth / $width * $height;                                // calculate new height based in standard width
	$scale = $defaultwidth / $width;                                               // if SVG is smaller/larger, scale accordingly
	
	$sign_part->setHeight($new_height);
	$sign_part->setWidth($defaultwidth);
	$sign_part->setViewBox(0, 0, $defaultwidth, $new_height);
	if ($scale <> 1)
	{
		$sign_part->g->scale($scale);
	}
	//$sign_part->translate(0, $sign->getHeight());
	$sign_part->setY( $sign->getHeight() + $offset );                              // move to position under the sign above this one with small defaultoffset
	$sign_part->setPreserveAspectRatio("xMidYMid meet");

	$sign->addShape( $sign_part );                                                 // add to final image
	$sign->setHeight($new_height + $sign->getHeight() + $defaultoffset );          // set height
}
$sign->setHeight( $sign->getHeight() + $defaultoffset );                           // add a little defaultoffset at the end

$sign->getElementById('pole')->setHeight( $sign->getHeight() );                    // adjust the height of the pole

$sign->setDefaultViewBox();
$sign->output();

?>