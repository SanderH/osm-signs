<?php
	require $_SERVER['DOCUMENT_ROOT'].'/lib/config.php';

	if (!isLoggedIn())
	{
		Header("Location: /");
	}
?>
<!DOCTYPE html>
<html>
<head>
	<title>Profile - Traffic signs for OSM</title>
	<meta charset="UTF-8">
	<meta http-equiv="X-UA-Compatible" content="IE=Edge">
	<meta name="viewport" content="initial-scale=1.0, user-scalable=no, width=device-width">

	<link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.4.1/css/bootstrap.min.css" integrity="sha384-Vkoo8x4CGsO3+Hhxv8T/Q5PaXtkKtu6ug5TOeNV6gBiFeWPGFN9MuhOf23Q9Ifjh" crossorigin="anonymous">
	<link rel="stylesheet" href="/css/layout.css" type="text/css">

	<script type="text/javascript" src="https://code.jquery.com/jquery-3.3.1.min.js" integrity="sha256-FgpCb/KJQlLNfOu91ta32o/NMZxltwRo8QtmkMRdAu8=" crossorigin="anonymous"></script>

	<script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.14.3/umd/popper.min.js" integrity="sha384-ZMP7rVo3mIykV+2+9J3UJ46jBk0WLaUAdn689aCwoqbBJiSnjAK/l8WvCWPIPm49" crossorigin="anonymous"></script>
	<script src="https://stackpath.bootstrapcdn.com/bootstrap/4.4.1/js/bootstrap.bundle.min.js" integrity="sha384-6khuMg9gaYr5AxOqhkVIODVIvm9ynTT5J4V1cfthmT+emCG6yVmEZsRHdxlotUnm" crossorigin="anonymous"></script>
	
</head>
<body>

<nav class="navbar sticky-top navbar-light bg-light" role="navigation">
    <div class="navbar-header">
		<a href="#"><img src="/images/hamburger_icon.svg" alt="" width="30" height="30" class="navbar-toggle collapsed" data-toggle="collapse" data-target="#bs-navbar-collapse-1"></a>
		<!--<img src="images/OSM_Netherlands_Logo.svg" alt="" width="30" height="30">-->
		<span class="navbar-brand">&nbsp;Profile - Traffic signs for OSM</span>
    </div>

<?php
	require $_SERVER['DOCUMENT_ROOT'].'/lib/menu.php';
?>

	<div class="collapse navbar-collapse list-group" id="bs-navbar-collapse-1">
	  <a href="/" class="list-group-item list-group-item-action">Algemene informatie</a>
	  <a href="/progress/progress.php" class="list-group-item list-group-item-action">Kaart Nederland</a>
	  <a href="/progress/table.php" class="list-group-item list-group-item-action">Lijst woonplaatsen</a>
	  <a href="/progress/info.php" class="list-group-item list-group-item-action">BAG Informatie</a>
	</div>
</nav>

<div>
<hr />
<h4>Profile information</h4>
<table class="table table-nonfluid">
  <tbody>
    <tr>
      <th scope="row">OSM id</th>
      <td><?php echo $osm_id; ?></td>
    </tr>
    <tr>
      <th scope="row">OSM display name</th>
      <td><?php echo $osm_user; ?></td>
    </tr>
    <tr>
      <th scope="row">Traffic sign uploader *</th>
      <td><?php echo (isSignsUser()) ? "ja" : "nee"; ?></td>
    </tr>
  </tbody>
</table>
*) Traffic sign uploaders can upload new traffic sign images
</div>

</body>
