<head>

    <meta charset="utf-8">
    <title>Students Example</title>
    <style type="text/css">
        body {
            color: #404E67;
            background: #F5F7FA;
            font-family: 'Open Sans', sans-serif;
        }
    </style>

</head>

<body>
    <?php $this->load->view('header/header.php'); ?>
<div class='container-fluid bg-dark' style="border: 1px solid">
   <div class='row justify-content-center'>
        <nav class="navbar navbar-dark bg-dark">
            <span class="nav item h1 text-uppercase text-white">Welcome <?php echo $_SESSION['name']?> !</span>

            <div class="col"></div>
            <?php $addbtn = array(
			      'class'=>"btn btn-primary btn-md  ",
			      'role'=>"button"
			      );
			      echo anchor(site_url('/add/'),'Add Record',$addbtn); ?>
 <div class="col"></div>
                <?php  $logoutbtn = array(
			      'class'=>"btn btn-danger btn-md",
			      'role'=>"button"
			      );
				   echo "<td>" .anchor(site_url('logincontroller/logout'),'Logout',$logoutbtn)."</td>";
			      ?>

        </nav></div></div>
        </br>

        </br>
        <div class="container">
            <table class="table table-bordered table-hover table-light">

                <tr>
                    <thead class="thead-dark">
                        <th>SrNo</th>
                        <th>Roll_No.</th>
                        <th>Name</th>
                        <th>Username</th>
                        <th>Gender</th>
                        <th>Class</th>
                        <th>Hobbies</th>
                        <th>Country</th>
                        <th>City</th>
                        <th>State</th>
                        <th colspan=2 style={text-align:center}>Action</th>
                    </thead>
                </tr>

                <?php 
		     $i = 1; 		 
		     foreach($records as $r) {

			echo "<tr>"; 
			      echo "<td>".$i++."</td>"; 
			      echo "<td><center>".$r->srno."</center></td>"; 
			      echo "<td>".$r->name."</td>";
			      echo "<td>".$r->username."</td>";
			      echo "<td>".$r->gender."</td>"; 
			      echo "<td>".$r->class."</td>";
			      echo "<td>".$r->hobbies."</td>";
			      echo "<td>".$r->country."</td>";
			      echo "<td>".$r->state."</td>";
			      echo "<td>".$r->city."</td>";
	   $editbutton = array(
			      'class'=>"btn btn-primary btn-md ",
			      'role'=>"button"
			      );

			      echo "<td>" .anchor(site_url('/add/'.$r->srno),'Edit',$editbutton)."</td>";
			      $onclick = array('onclick'=>"return confirm('Are you sure?')",
			      'class'=>"btn btn-danger btn-md ",
			      'role'=>"button");
			      echo "<td>" . anchor(site_url('/delete/'.$r->srno),'Delete', $onclick)."</td>";
				  echo "</tr>";

		     } 
		  ?>

            </table>
		</div>
   

        
<br><br>
        <?php echo $this->pagination->create_links(); ?>
		
			   <?php $datatble = array(
			      'class'=>"btn btn-primary btn-md  offset-md-8 col ",
			      'role'=>"button"
				  
			      );
 $searchbtn = array(
			      'class'=>"btn btn-primary btn-md col-md-2",
			      'role'=>"button",
				  'type'=>'submit'
				  
			      );
			      
				  ?>
				   <div class="container">
					 <div class='raw'>
						<?php
		$nameinput = array(
			'name'          => 'name',
			'class'=>' col-md-2',
			'id'            => 'name',
			'placeholder' => '',
			'maxlength'     => '20',
			'size'          => '20'
			
			
			//'required' => TRUE,
			//'pattern' => '[a-zA-Z\s]+'
				);
?>


<div ><form  method='post' action='<?php echo site_url('/stdcontroller/index')?>'>
					<?php echo form_input($nameinput);	?></div>
					<div>	<?php echo form_submit( 'Submit','submit');?></div>
						
				   </div>
					 </form>
				   
	  <div class='row'>
            <span class="btn btn-md btn-primary active col-md-2 ">Records :
			<?php echo $total_rec;?>
			 <?php echo anchor(site_url('/stdcontroller/datatableview'),' ServerSide Datatable',$datatble);?>
			 <?php echo anchor(site_url('/stdcontroller/datatableviewlocal'),' Local Datatable',$datatble);?></span>
         
	  </div>
				   </div>

            <?php $this->load->view('footer/footer.php'); ?>