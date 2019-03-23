<!DOCTYPE html>
<html lang="en">

<head>
    <meta name="viewport" content="width=1024">
    <meta http-equiv="X-UA-Compatible" content="IE=EmulateIE7, IE=9" />
    <meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
    <title>Assign employee to City</title>
    <link href='<?php echo base_url(); ?>css/minified-login.css' rel='stylesheet' type='text/css' />
	<link rel="stylesheet" type="text/css" href="<?php echo base_url();?>css/ui.fancytree.css" >
    <link href="<?php echo site_url('css/bootstrap.min.css')?>" rel="stylesheet">
    <!--[if IE]>
   <!-- <link rel="stylesheet" type="text/css" href="http://localhost/css/ie_only.css" />-->
    <![endif]-->
    <!-- Le HTML5 shim, for IE6-8 support of HTML5 elements -->
   
	<style>
	tr {
   line-height: 25px;
   min-height: 25px;
   height: 25px;
   text-align: center;
}
	  ul.fancytree-container {
		  height: 200px;
		  width: 100%;
		}
	  </style>
</head>

<body>
  	<?php $this->load->view('header/header.php'); ?>
		<div class='container-fluid bg-dark'>
				<div class='row justify-content-center'>
		<?php $this->load->view('navbar/navbar.php'); ?>
			  </div>
		</div>
    <div id="MainContainer">
	  
    </div>

    <script src="<?php echo base_url(); ?>js/minified_js_layout.js"></script>
        <script src="<?php echo base_url(); ?>js/minified-header.js"></script>
    <script src="<?php echo base_url();?>js/jquery.fancytree.js" type="text/javascript"></script>
	<script src="<?php echo base_url(); ?>js/bootstrap.min.js"></script>
    <script type="text/javascript">
        jQuery.browser={};(function(){jQuery.browser.msie=false;
		jQuery.browser.version=0;if(navigator.userAgent.match(/MSIE ([0-9]+)\./)){
		jQuery.browser.msie=true;jQuery.browser.version=RegExp.$1;}})();
        //set date format yy-mm-dd
    </script>

    <br/>
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
    ?></h2>
	 </center>
	<br/>
    <div class='container'>
      <div class='row'>
		<div class="col-xs-4">
		<?php $url= ($flag=='edit')? 'stdcontroller/editUpdate':'stdcontroller/saveCase';?>
        <form id="cluster_form" name="form2" method="post" action="<?php echo site_url($url);?>" enctype="multipart/form-data" autocomplete="off">
          <input name="flag" id="flag" value="save" type="hidden">
		  <div >
			  Select Employee:
			  <?php 
			  echo form_dropdown('empList',$empList,$selected,array('class'=>'form-control '));?>
		  </div>
		  <br/>
			  <div class="clear"></div>
			<div>
				<input type="button" name="btn_expand" value="Expand All" onclick="expand_all()" class='btn btn-light' /> &nbsp;&nbsp;
				<input type="button" name="btn_collapse" value="Collapse All" onclick="collapse_all()" class='btn btn-light' />
	  
				<br/>

				  <div id="tree" name="selNodes[]" style="margin-top: 10px"></div>
				  <br/>
				  <span class="col-xs-2 col-sm-2 col-md-2">
					  <button type="submit" id="AddCluster" value="Add Cluster" class="btn btn-primary" >
						<?php echo ($flag=='edit')? 'Update':'Save';?>
					  </button>
		
							<?php
							if($flag=='edit'){
							   $caption ="Cancel";
							}else{
							  $caption ="Back";
							}
							$back= array(
						   'class' => 'btn btn-info offset-md-1 ',
						   'onclick' => 'back_function()',
						   'id'=>'back'
						   );
				echo form_button('back',$caption, $back); // reset button
				?>
			</span>
		</form>
		</div>
			</div>
			
		  
		<div id='table' class='col' style="margin-top: -38px">
	<?php if($flag!='edit'){?>
	<p class='text-danger' style="font-weight: bold;font-size: 30px ;text-align: center;text-decoration: underline;">Case Information</p>
	  <table name='caseTable' id='caseTable' class="table table-bordered table-hover table-light" width="300px">
		
		<tr>
                    <thead class="thead-dark">

                        <th>Sr.No.</th>
                        <th>Employee Name</th>
						<th>E-Mail</th>
                        <!--<th>City</th>
						<th>State</th>
						<th>Country</th>-->

                        <th>Date&nbspAssigned</th>
						<th colspan='2' >Operation</th>
		
                    </thead>
					</tr>
                </tr>
                <tbody id="tbody">
                    <?php 
		     $i = 1;
			 if(isset($records))
			 {
		     foreach(@$records as $r) {
			  echo "<tr>"; 

			//echo "<td><center>".$r['srno']."</center></td>";
			echo "<td><center>".$i."</center></td>";
			      echo "<td>".$r['name']."</td>";
			//	   echo "<td>";
			//	  echo ($r['city'])?$r['city']:'All cities';
			//	  echo "</td>";
			//      echo "<td>";
			//	  echo ($r['state'])?$r['state']:'All states';
			//	  echo "</td>";
			//      echo "<td>".$r['country']."</td>";
				  echo "<td>".$r['username']."</td>";
				 echo "<td>".$r['created_at']."</td>";
				 $editbutton = array(
			      'src'   => base_url().'/images/editFav.png',
        'alt'   => 'Edit',
        'class' => 'post_images',
        'width' => '20px',
        'height'=> '20px'
			      );

			      echo "<td>" .anchor(site_url('/stdcontroller/assignEdit/'.$r['empid']),img($editbutton))."</td>";
			      $onclick = array('onclick'=>"return confirm('Are you sure?')",
			      'src'   => base_url().'/images/deleteFav.png',
        'alt'   => 'Delete',
        'class' => 'post_images',
        'width' => '20px',
        'height'=> '20px'
			      );
			      echo "<td>" . anchor(site_url('/stdcontroller/assignDelete/'.$r['id']),img($onclick))."</td>";
				   echo "</tr>";
				 $i++;
			 }
			 }
			  ?>
				</tbody>
	  </table>
	  </div>
	</div>
		  </div>
<?php } ?>

    <script type='text/javascript'>

        //alert('<?php echo @$var_json; ?>');
	<?php
	  if (!empty($countrylist))
	  {
	?>
		$(function() {
            $("#tree").fancytree({
                checkbox: true,
                selectMode: 3,
                icons: false,
                source: <?php echo @$countrylist; ?>,

            });
            $("#cluster_form").submit(function() {
                // Render hidden <input> elements for active and selected nodes
                $("#tree").fancytree("getTree").generateFormElements();
              //  alert(jQuery.param($(this).serializeArray()));
               //return false;

            });
        });

        function expand_all() {
            $("#tree").fancytree("getRootNode").visit(function(node) {
                node.setExpanded(true);
            });
        }

        function collapse_all() {
            $("#tree").fancytree("getRootNode").visit(function(node) {
                node.setExpanded(false);
            });
        }
<?php } ?>

function back_function() {
			flag = "<?php echo $flag;?>";
			if (flag=='edit') {
			 window.location.href = "<?php  echo site_url('stdcontroller/loadAssign/0'); ?>";
			}else{
			  window.location.href = "<?php  echo site_url('stdcontroller/index/0'); ?>";
			}
            
        }
    </script>

</body>
</html>