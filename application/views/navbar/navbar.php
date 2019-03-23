
    <nav class="navbar navbar-dark bg-dark ">
        <span class="nav item h1 text-uppercase text-light ">	<?php echo $heading ?></span>
<div class="col"></div>
        <?php  $logoutbtn = array(
			      'class'=>"btn btn-danger btn-md",
			      'role'=>"button"
			      );
				   echo "<td>" .anchor(site_url('logincontroller/logout'),'Logout',$logoutbtn)."</td>";
			      ?>

    </nav>