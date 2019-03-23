<head>
    <meta charset="utf-8">
    <title>Students Example</title>
    <style>
        body {
            color: #404E67;
            background: #F5F7FA;
            font-family: 'Open Sans', sans-serif;
        }
    </style>
<?php $this->load->view('header/header.php'); ?>
    <link rel="stylesheet" href="<?php echo base_url();?>css/minmize_date_picker.css" />
<link rel="stylesheet" type="text/css" href="<?php echo base_url();?>css/jquery.fancybox.css" >

</head>

<body>
    <?php $this->load->view('header/header.php');
    $datatble = array(
                  'class'=>"btn btn-primary btn-md col-md-2 ",
                  'role'=>"button",
                  'style'=> 'margin-left:20px'

                  );
    $nameinput = array(
            'name'          => 'name',
            'class'=>' col-md-2 form-control',
            'id'            => 'name',
            'placeholder' => 'search',
            'maxlength'     => '20',
            'size'          => '20',
            'value'=> isset($_SESSION["searchstring"])?$_SESSION["searchstring"]:''
            //'required' => TRUE,
            //'pattern' => '[a-zA-Z\s]+'
                );

    $datepickFrom = array(
            'name'          => 'datepickfrom',
            'class'=>' col-md-2 form-control',
            'id'            => 'datepickfrom',
            'placeholder' => 'From',
            'maxlength'     => '20',
            'size'          => '20',
            'style'=> 'margin-left:10px',
            'value'=> isset($_SESSION["datefrom"])?$_SESSION["datefrom"]:''
            //'required' => TRUE,
            //'pattern' => '[a-zA-Z\s]+'
                );

    $datepickTo = array(
            'name'          => 'datepickto',
            'class'=>' col-md-2 form-control',
            'id'            => 'datepickto',
            'placeholder' => 'To',
            'maxlength'     => '20',
            'size'          => '20',
            'style'=> 'margin-left:10px',
            'value'=> isset($_SESSION["dateto"])?$_SESSION["dateto"]:''
            //'required' => TRUE,
            //'pattern' => '[a-zA-Z\s]+'
                );

    ?>
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
                   $asc = base_url().'/css/DataTables-1.10.13/images/sort_asc.png';
                   $desc = base_url().'/css/DataTables-1.10.13/images/sort_desc.png';
                   $image_properties = array(
        'src'   => base_url().'/images/pdfFav.png',
        'alt'   => 'PDF Download',
        'class' => 'post_images',
        'width' => '30px',
        'height'=> '35px'

);
                   $image_zip = array(
        'src'   => base_url().'/images/zipFav.png',
        'alt'   => 'Zip Download',
        'class' => 'post_images',
        'width' => '25px',
        'height'=> '30px'

);

                  ?>

			   </nav>
		   </div>
	   </div>
	   </br>

	   <center>
		   <h2 class='alert-success'>  <?php
	   // Show Add/Edit/Delete : Success message
		   if(!empty($success_message))
		   {
   ?>
			   <span id="success_msg" style="color:green;"><?php echo $success_message; ?></span>
   <?php
		   }

	   // Show Add/Edit : Failed message   
		   if(!empty($failed_message))
		   {
   ?>
			   <span id="fail_msg" style="color:red;"><?php echo $failed_message; ?></span>
   <?php
		   }
   ?></h2></center>

	   </br>
	   <div class="container">
		   <form class='form-inline' method='post' action='<?php echo site_url('/stdcontroller/index/0/nosearch ')?>'>
			   <?php echo form_input($nameinput);  ?>
				   <button type="button" class='btn-warning form-control' onclick="cleardatet('name');" id="btn_received_date" value="received_date" class="pull-center button  button_defoult" style="min-width:30px;padding: 0px;margin-left: 10px">X</button>
				   <?php echo form_input($datepickFrom);   ?>
					   <button type="button" class='btn-warning form-control' onclick="cleardatet('datepickfrom');" id="btn_received_date" value="received_date" class="pull-center button  button_defoult" style="min-width:30px;padding: 0px;margin-left: 10px">X</button>
					   <?php echo form_input($datepickTo); ?>
						   <button type="button" class='btn-warning form-control' onclick="cleardatet('datepickto');" id="btn_received_date" value="received_date" class="pull-center button  button_defoult" style="min-width:30px;padding: 0px;margin-left: 10px">X</button>
						   <?php echo form_submit( 'Submit','Search', $datatble);?>

							   <?php

						//echo anchor(site_url('/stdcontroller/index?flag=nosearch'),' Reset search',$datatble);?>
		   </form>
		   <br>
		   <table id="stdtable" class="table table-bordered table-hover table-light">

			   <tr>
				   <thead class="thead-dark">

					   <th>Roll_No.
						   <br>
						   <?php echo anchor('stdcontroller/sortListPage/0/asc', img(array('src'=>$asc,'border'=>'0','alt'=>'Asc')));?>
							   <?php echo anchor('stdcontroller/sortListPage/0/desc', img(array('src'=>$desc,'border'=>'0','alt'=>'Desc')));?>
					   </th>
					   <th>Name
						   <br>
						   <?php echo anchor('stdcontroller/sortListPage/1/asc', img(array('src'=>$asc,'border'=>'0','alt'=>'Asc')));?>
							   <?php echo anchor('stdcontroller/sortListPage/1/desc', img(array('src'=>$desc,'border'=>'0','alt'=>'Desc')));?>
					   </th>
					   <th>Username
						   <br>
						   <?php echo anchor('stdcontroller/sortListPage/2/asc', img(array('src'=>$asc,'border'=>'0','alt'=>'Asc')));?>
							   <?php echo anchor('stdcontroller/sortListPage/2/desc', img(array('src'=>$desc,'border'=>'0','alt'=>'Desc')));?>
					   </th>

					   <th>Gender</th>
					   <th>Class</th>
					   <th>Hobbies</th>
					   <th>Date&nbspOf&nbspBirth</th>
					   <!--<th>Country</th>
					   <th>State</th>
					   <th>City</th>-->
					   <th >Status</th>
					   <th>CP</th>

					   <th colspan=4 style="text-align:center">Action</th>
				   </thead>
			   </tr>
			   <tbody id="tbody">
				   <?php 
			$i = 1;
			if(isset($records))
			{
			foreach(@$records as $r) {

		  $act_image = array(
	   'src'   => base_url().'images/act.jpg'.'?'.time(),
	   'alt'   => 'Activated',
	   'id'   => 'actImage'.$r['srno'],
	   'onclick'=> 'javascript:toggleStatus('.$r['srno'].',1);',
	   'class' => 'post_images',
	   'width' => '20px',
	   'height'=> '20px',
	   'style'=>'border-radius:50%'

);

		  $deact_image = array(
	   'src'   => base_url().'images/deact.jpg'.'?'.time(),
	   'alt'   => 'deactivated ',
	   'class' => 'post_images',
	   'id'   => 'DeactImage'.$r['srno'],
	   'onclick'=> 'javascript:toggleStatus('.$r['srno'].',0);',
	   'width' => '20px',
	   'height'=> '20px',
	   'style'=>'border-radius:50%'

);
		   $cp_image = array(
	   'src'   => base_url().'images/cp.png',
	   'alt'   => 'change password ',
	   'class' => 'post_images',
	   'id'   => 'cp'.$r['srno'],
	   'onclick'=> 'javascript:changePass('.$r['srno'].');',
	   'width' => '30px',
	   'height'=> '30px',
	   'style'=>'border-radius:50%'

);
		   echo "<tr>"; 

		   //echo "<td><center>".$r['srno']."</center></td>";
		   echo "<td><center>".$i."</center></td>";
				 echo "<td>".$r['name']."</td>";
				 echo "<td>".$r['username']."</td>";

				 echo "<td>".$r['gender']."</td>"; 
				 echo "<td>".$r['class']."</td>";
				echo "<td>".$r['hobbies']."</td>";
				 echo "<td>".$r['dob']."</td>";
				// echo "<td>".$r['country']."</td>";
				// echo "<td>".$r['state']."</td>";
				// echo "<td>".$r['city']."</td>";
				   if($r['status']=='Active'){
			   echo "<td align='center'>".img($act_image)."</td>";
				 }else{
					echo "<td align='center'>".img($deact_image)."</td>";
				 }
				 echo "<td align='center'>" .img($cp_image)."</td>";
	  $editbutton = array(
				 'src'   => base_url().'/images/editFav.png',
	   'alt'   => 'Edit',
	   'class' => 'post_images',
	   'width' => '20px',
	   'height'=> '20px'
				 );
echo "<td>" .anchor(site_url('/stdcontroller/generatepdf/'.$r['srno']),img($image_properties))."</td>";
echo "<td>" .anchor(site_url('/stdcontroller/generatezip/'.$r['srno']),img($image_zip))."</td>";

				 echo "<td>" .anchor(site_url('/add/'.$r['srno']),img($editbutton))."</td>";
				 //$onclick = array('onclick'=>"return confirm('Are you sure?')",
				 $onclick = array('onclick'=>"deleteEmp(".$r['srno'].")",
				 'src'   => base_url().'/images/deleteFav.png',
	   'alt'   => 'Delete',
	   'class' => 'post_images',
	   'width' => '20px',
	   'height'=> '20px'
				 );
				  echo "<td>" . img($onclick)."</td>";
				// echo "<td>" . anchor(site_url('/delete/'.$r['srno']),img($onclick))."</td>";
				 echo "</tr>";
$i++;
			}
			}
			else{
			  echo '<center><h2>records not found</h2></center>';
			}
		 ?>
			   </tbody>
		   </table>
	   </div>

	   <?php echo @$this->pagination->create_links(); ?>

		   <?php

				 $searchbtn = array(
				 'class'=>"btn btn-primary btn-md col-md-2",
				 'role'=>"button",
				 'type'=>'submit'

				 );

				 ?>
			   <div class="container">
				   <div class='raw'>

					   <div class="btn btn-md btn-danger active col-md-2 ">Records :
						   <?php echo $total_rec;?>
					   </div>
					   <?php echo anchor(site_url('/stdcontroller/datatableview'),' ServerSide Datatable',$datatble);?>
						   <?php echo anchor(site_url('/stdcontroller/datatableviewlocal'),' Local Datatable',$datatble);?>
							   <?php echo anchor(site_url('/stdcontroller/generateExcel'),' Generate Excel',$datatble);?>
								   <?php echo anchor(site_url('/stdcontroller/loadAssign'),' Assign Case',$datatble);?>
									   <a class='iframe d-flex justify-content-center'  id="iframe">  </a>
				   </div>
			   </div>

				 <script src="<?php echo base_url();?>js/minmize_date_picker.js"></script>
				 <?php $this->load->view('footer/footer.php'); ?>
				  <script src="<?php echo base_url(); ?>js/jquery.fancybox.js"></script>

	  <script type="text/javascript">
$("a#iframe").fancybox({
       'type': 'image',
       openEffect: 'elastic',
       closeEffect: 'elastic',

   });

   $(function() {
// function to use jquery datepicker 
       $("#datepickfrom").datepicker({
           showButtonPanel: true,
           changeMonth: true,
           changeYear: true,
           dateFormat: 'dd-mm-yy', // Date format
           yearRange: '1940:<?php echo date("Y");?>'
       }).attr('readonly', 'readonly');

       $("#datepickto").datepicker({
           showButtonPanel: true,
           changeMonth: true,
           changeYear: true,
           dateFormat: 'dd-mm-yy', // Date format
           yearRange: '1940:<?php echo date("Y");?>'
       }).attr('readonly', 'readonly');
   });
//function for clearing date field
   function cleardatet(id) {
       // $("#dob_id").val =="";//._clearDate(this);
       document.getElementById(id).value = "";
   }
//function to toggle user status
   function toggleStatus(id, status) {

       var msg;
       $.ajax({
           type: "POST",
           dataType: "json",

           url: "<?php echo site_url('/stdcontroller/changeStatus'); ?>",
           data: {
               id: id,
               status: status
           },
           success: function(data) {
               // jQuery.noConflict();

               if (status != 0) {

                   $('#actImage' + id).attr({
                       'src': '<?php echo base_url().'images/Deact.jpg?'.time();?>',
                       'id' : 'DeactImage' + id,
                       'onclick': 'javascript:toggleStatus(' + id + ',0)'
                   });
                   msg = 'deactivated';

               } else {

                   $('#DeactImage' + id).attr({
                       'src': '<?php echo base_url().'images/act.jpg ? '.time();?>',
                       'id' : 'actImage' + id,
                       'onclick': 'javascript:toggleStatus(' + id + ',1)'
                   });
                   msg = 'activated';

               }

               var abc = '<h3>User ' + msg + ' with name ' + data[0]['name'] + ' & id ' + id + ' successfully!</h3>';
               $.fancybox.open({

                   content: abc, //'<div id="test">Status updated successfully for user '+</div>',
                   'closeBtn': true,
                   'padding': 10,
                   'scrolling': 'no',
                   openEffect: 'fade',
                   closeEffect: 'fade',
                   'type': 'iframe',
                   // href : "<?php echo base_url().'success';?>",

               });

           },
           error: function(data) {
               var abc = 'error function';
               console.log('this is ' + abc);
           }
       });
   }
// function to change password in fancybox
   function changePass(id) {
       //alert(id);
       // jQuery.noConflict();
       $.fancybox.open({

           //content  : '<div id="test">Status updated successfully for user '+'</div>',
           'closeBtn': true,
           'padding': 10,
           'type': 'iframe',
           href: "<?php echo site_url('stdcontroller/changePassword/');?>" + id,
           openEffect: 'elastic',
           closeEffect: 'elastic',
           'width': 600,
           // modal:true,
           keys: {
               close: null
           },

           'height': 420,
           'autoSize': false,
           helpers: {
               overlay: {
                   closeClick: false
               } // prevents closing when clicking OUTSIDE fancybox 
           },
           afterShow: function() {
               this.inner.css({
                   overflow: 'hidden',

               })
           },

       });
   }
// function to check and delete employee if have any case also delete case along with it
   function deleteEmp(id) {
       var msg;
       $.ajax({
           type: "POST",
           dataType: "json",

           url: "<?php echo site_url('/stdcontroller/checkExist/'); ?>" + id,
           data: {
               id: id
           },
           success: function(data) {
               if (data == 'no_record') {

                   var msg = "<?php echo site_url('stdcontroller/deletedSuccess');?>";
                   fancyarea(msg);

               } else {
                   var msg = "<?php echo site_url('stdcontroller/recordExist/');?>" + id;
                   fancyarea(msg);

               }
           },
           error: function(data) {
               console.log('Error! :' + stringify(data))

           }

       });

   }

// function to display msg in fancybox
   function fancyarea(string) {
       k = jQuery.noConflict();
       k.fancybox.open({

           'closeBtn': true,
           'padding': 10,
           'type': 'iframe',

           href: string,
           //content:string,
           openEffect: 'elastic',
           closeEffect: 'elastic',
           'width': 600,
           // modal:true,
           keys: {
               close: null
           },

           'height': 200,
           'autoSize': false,
           helpers: {
               overlay: {
                   closeClick: false
               } // prevents closing when clicking OUTSIDE fancybox 
           },
           afterShow: function() {
               this.inner.css({
                   overflow: 'hidden',

               })
           },
           afterClose: function() {
               parent.location.reload(true);
           },

       });

   }
     </script>
   </body>
</html>