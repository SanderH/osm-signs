	<ul class="nav nav-pills justify-content-end">
<?php
	if (!isLoggedIn())
	{
?>
	  <li class="nav-item">
		<a class="nav-link active" href="/authenticate.php?action=login">Login</a>
	  </li>
<?php
	} else {
?>
	  <li class="nav-item">
		<a class="nav-link dropdown-toggle active" data-toggle="dropdown" href="#" role="button" aria-haspopup="true" aria-expanded="false"><?php echo $osm_user; ?></a>
		<div class="dropdown-menu dropdown-menu-right">
		<a class="dropdown-item" href="/profile.php">Profile</a>
		<div class="dropdown-divider"></div>
			<a class="dropdown-item" href="/authenticate.php?action=logout">Logout</a>
		</div>
		
	  </li>
<?php
	}
?>
	</ul>

