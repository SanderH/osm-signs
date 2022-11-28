<!doctype html>
<html>
    <head>
        <meta http-equiv="content-type" content="text/html; charset=UTF-8"/>
        <title>Listing of SVG files used for NL_traffic_sign paint style</title>
		<style>
		/*
		body
		{
			background-color: #202020;
			color: #e0e0e0;
		}
		*/
		th {
			color: #e0e0e0;
			background-color: blue;
		}
		td  {
			width: 100px;
			border-top: solid 1px #e0e0e0;
		}
		img {
			width: 100px;
		}
		</style>
    </head>
    <body>
        <h1>
            Listing of SVG files used for NL_traffic_sign paint style
        </h1>
        <p>
            This is a dynamic listing of all the SVG files available within the NL_traffic_sign paint style. All signs are shown individually and stacked with another sign.
			<br />
			If you want additional signs to be available, create SVG based images and provide them to me to have them added.
        </p>
        <p>If you have some questions, contact me at:
            <a href="https://www.openstreetmap.org/message/new/Sander%20H">Sander H</a>
        </p>

        <table>
		<tr>
			<th>Sign</th>
			<th>Image</th>
			<th>Height</th>
			<th>Width</th>
			<th>Stacked</th>
		</tr>
        <?php
		require_once "svglib/svglib.php";
/*  turn off when done debugging */
//error_reporting(E_ALL);
//ini_set('display_errors', 'On');
/* ******************* */

		$country = 'NL';
		if (isset($_GET[ 'country' ]))
		{
			$country = $_GET[ 'country' ];
		}
		//var_dump("country: {$country}");
		
        if ( is_array( $examples = glob( "../traffic_signs/{$country}/*.svg" ) ) )
        {
            foreach ( $examples as $info )
            {
				$sign = SVGDocument::getInstance( $info );
				$height = $sign->getHeight();
				$width = $sign->getWidth();
				
                $name = basename( $info );
				echo "<tr>";
				if (strpos($name, '_OB') !== false)
				{
					echo "<td>{$name}</td><td><img src='$info'/></td><td>$height</td><td>$width</td><td><img src='merge.svg.php?signs=NL:Q.svg;$name'/></td>";
				}
				else
				{
					echo "<td>{$name}</td><td><img src='$info'/></td><td>$height</td><td>$width</td><td><img src='merge.svg.php?signs=$name;NL:OB_Q.svg'/></td>";
				}
				echo "</tr>\n";
            }
        }
        ?>
		</table>
		
    </body>
</html>