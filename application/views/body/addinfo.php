 <!DOCTYPE html>
<html lang="en">
<head>
		<?php $this->load->view('header/header.php'); ?>
		 <link href="<?php echo base_url(); ?>css/jquery.multiselect.css" rel="stylesheet">
		 <link rel="stylesheet" href="<?php echo base_url();?>css/minmize_date_picker.css" />
		</head>
		<div class='container-fluid bg-dark'>
				<div class='row justify-content-center'>
		<?php $this->load->view('navbar/navbar.php'); ?>
    </div></div>

<body>


    <div class="h1 text-center text-underlined">Student Information</div>
    <hr width="50%">

    <?php if ($flag =='add')
		{
			$action= site_url('/addstd');
			$reset ='Reset';
			$country='';
			$state ='';
			$city ='';
			$city_selected ='';
			$state_selected="";
			$citieslist="";
			$statelist="";
			$country_selected="";
			$password = "";
			$gender = "";
			$passconf="";

		}
		if($flag == 'upd')
		{
			$action = site_url('/updatestd/'.$id);
			$reset = 'Cancel';

		}?>

        <?php
					// variable declaration
$setpdf = (isset($usrpdf)|| $usrpdf!='')?'display:none':'';				// if pdf available hide
$setexcel = (isset($usrexcel)|| $usrexcel!='')?'display:none':'';		// if excel available hide
$setimg = (isset($usrimage) || $usrimage!='')?'display:none':'';	//if image available hide

$displayImage = (!isset($usrimage)|| $usrimage=='')?'display:none':'';				// if image available show


$hidePdfDel = (!isset($usrpdf)|| $usrpdf=='')?'display:none':'';					// if pdf not available hide
$hideExlDel = (!isset($usrexcel) || $usrexcel=='')?'display:none':'';					// if excel not available hide

$showFileImg = (!isset($usrimage)|| $usrimage=='')?'':'display:none';
$showFilePdf = (!isset($usrpdf)|| $usrpdf=='')?'':'display:none';					// if pdf not available hide
$showFileExcel = (!isset($usrexcel) || $usrexcel=='')?'':'display:none';					// if excel not available hide


		$attributes = array('class' => 'form-horizontal', 'id' => 'stdform','role' =>'form', 'action'=>$action, 'method'=>'post');
		echo form_open_multipart($action, $attributes);	// form
		echo "<div class='form-group'>";
		//echo form_fieldset('Student Information','class='text-da',''style="text-align:center,margin:0,padding:0 0 20px,font-size:22px"');
		?>

            <div class='container' style="padding-top: 30px;">
                <div class='row'>
				<div class='offset-md-1'>
						<?php if(isset($usrimage) && $usrimage!='')?>
                    <img  style="<?php echo $displayImage?>" id='usrImage' src="<?php echo  base_url() . UPLOAD_IMAGE_PATH .$usrimage.'?'.time(); ?>" width="200px" height="200px" alt=' No-Image'>
					
				</div>
		</div>
				<br>
				<br>
                    <?php // upload file

		$image_properties = array(
        'src'   => base_url().'/images/pdf_download.jpg',
        'alt'   => 'PDF Download',
        'class' => 'post_images',
        'width' => '200',
        'height'=> '100',
		'id'=>'pdfuploadImg',
		'style'=> 'margin-top:-18px;'.$hidePdfDel
      
);
		
		$excel_img = array(
        'src'   => base_url().'/images/excel_download.png',
        'alt'   => 'Excel Download',
        'class' => 'post_images',
        'width' => '200',
        'height'=> '100',
		'id'=>'exceluploadImg',
		'style'=> 'margin-top:-18px;'.$hideExlDel
      
);
		$delImgImg = array(
        'src'   => base_url().'/images/del.jpg',
		'id'=>'removeimage',
        'alt'   => 'Remove Image',
        'class' => 'post_images',
		'style'=> 'margin-top:17px;',
        'width' => '50',
        'height'=> '50',
		'style'=>'margin-left:150px;'.$displayImage
      
);
		$delImgPdf = array(
        'src'   => base_url().'/images/del.jpg',
		'id'=>'removepdf',
        'alt'   => 'Delete PDF File',
        'class' => 'post_images',
		'style'=> 'margin-top:17px;',
        'width' => '50',
        'height'=> '50',
		'style'=> $hidePdfDel
      
);
		$delImgExl = array(
        'src'   => base_url().'/images/del.jpg',
		'id'=>'removeexcel',
        'alt'   => 'Delete Excel File',
        'class' => 'post_images',
		'style'=> 'margin-top:17px',
        'width' => '50',
        'height'=> '50',
		'style'=> $hideExlDel
				);
		

		$hiddenInput = array(
        'flagExcel'  => 1,
		'flagPdf'  => 1,
		'flagImg'  => 1
);	
	
echo form_hidden($hiddenInput);


		$pdfupload = array(
				    'name'=>'myfile[]',
				    'id'=>'pdfupload',
					'type'=>'file',
					'class'=>'form-control col-xs-4',
					'style'=>'margin-left:10px;'.$showFilePdf
				    );
		$excelupload = array(
				    'name'=>'myfile[]',
				    'id'=>'excelupload',
					'type'=>'file',
					'class'=>'form-control col-xs-4',
					'style'=>'margin-left:10px;'.$showFileExcel
				    );
				?>
				<div class='row'>
						<div class='col-md-4 '>
					<div class="input-group ">
                        <div class="input-group-prepend">
                            <span class="input-group" id="basic-addon1" for="myfileid" style="<?php echo $showFileImg?>">Upload Image File :</span>
                            <br>
                        </div>
                    
				
                    <?php // upload file

		$imageUpload = array(
				    'name'=>'myfile[]',
				    'id'=>'imageupload',
					'type'=>'file',
					'class'=>'form-control col-xs-4',
					'style'=>'margin-left:10px;'.$showFileImg
				    );
				echo form_upload($imageUpload);	
				echo img($delImgImg); ?>
				
				</div>
			</div>
						<div class='col-md-4 '>
					<div class="input-group">
				
				<?php echo anchor(base_url() . UPLOAD_PDF_EXCEL_PATH . $usrpdf,img($image_properties));	// download pdf file
				
				echo img($delImgPdf);	// remove pdf file
			?>
                        <div class="input-group-prepend" style>
                            <span class="input-group" id="basic-addon1" for="pdfupload" style="<?php echo $showFilePdf;?>" >Upload PDF File :</span>
                            <br>
                        </div>
						
				<?php echo form_upload($pdfupload);
			
				?>
				
				</div></div>
					<div class='col-md-4 '>
					<div class="input-group">
                <?php // upload file
				echo anchor(base_url() .UPLOAD_PDF_EXCEL_PATH . $usrexcel,img($excel_img));	//download excel file
				echo img($delImgExl);	// remove excel file
				?>
				<div class="input-group-prepend">
                            <span class="input-group" id="basic-addon1" for="exelupload" style="<?php echo $showFileExcel;?>">Upload Excel File :</span>
                            <br>
                        </div>
				<?php echo form_upload($excelupload);
		
				?>
				</div>
				</div>
				</div>
                
                <div class="text-danger" style="margin-left: 350px">
                    <?php echo $imgerror;?>
                </div>

                <br>
                <br>
                <div class='row'>
                    <div class="input-group col">

                        <div class="input-group-prepend">
                            <span class="input-group-text" id="basic-addon1" style=" padding-left: 23px;padding-right: 24px;">Name </span>
                        </div>

                        <?php
		$nameinput = array(
			'name'          => 'name',
			'class'=>'form-control',
			'id'            => 'name',
			'placeholder' => 'Enter name here',
			'maxlength'     => '20',
			'size'          => '20',
			'style'         => 'width:40%',
			'value'=>	$name
			//'required' => TRUE,
			//'pattern' => '[a-zA-Z\s]+'
				);

					echo form_input($nameinput);	?>
                    </div>

                    <div class="input-group col">
                        <div class="input-group-prepend">
                            <span class="input-group-text" id="basic-addon1" style="padding-left: 41px;padding-right: 41px;">Username</span>
                        </div>

                        <?php
		$usernameinput = array(
			'name'          => 'username',
			'id'            => 'username',
			'class'=>'form-control',
			'placeholder' => 'Enter email address',
			'maxlength'     => '50',
			'size'          => '20',
			'style'         => 'width:40%',
			'value'=>$username
				);

			echo form_input($usernameinput);	//username input ?>
                    </div>
                </div>
                <div class='row'>
                    <div class='col text-danger' style="margin-left: 95px;">
                        <?php echo form_error('name')?>
                    </div>
                    <div class='col text-danger' style="margin-left: 95px;">
                        <?php echo form_error('username')?>
                    </div>
                </div>
                <br>
                <div class='row'>
                    <div class="input-group col">
                        <div class="input-group-prepend">
                            <span class="input-group-text" id="basic-addon1">Password</span>
                        </div>

                        <?php
			$passwordinput = array(
			       'name'          => 'password',
			       'id'            => 'password',
			       'placeholder' => 'Enter password here',
			       'maxlength'     => '20',
				   'class'=>'form-control',
			       'size'          => '20',
			       'style'         => 'width:40%',
			       'value' => ($flag =='add')? set_value($password):''

				       );

		       echo form_password($passwordinput,'',($flag =='add')? '':'disabled');		// password input?>
                    </div>

                    <div class="input-group col">
                        <div class="input-group-prepend">
                            <span class="input-group-text" id="basic-addon1">Re-Enter Password</span>
                        </div>
                        <?php  $passconfinput = array(
			       'name'          => 'passconf',
			       'id'            => 'passconf',
				   'class'=>'form-control',
			       'placeholder' => 'Re-Enter password here',
			       'maxlength'     => '20',
			       'size'          => '20',
			       'style'         => 'width:40%',
			       'value'=>($flag =='add')? set_value($passconf):'',

				       );
		       echo form_password($passconfinput,'',($flag =='add')? '':'disabled');	// password confirmation?>
                    </div>
                </div>
                <div class='row'>
                    <div class='col text-danger' style="margin-left: 95px;">
                        <?php echo form_error('password')?>
                    </div>
                    <div class='col text-danger' style="margin-left: 95px;">
                        <?php echo form_error('passconf')?>
                    </div>
                </div>

                <br></br>
                <div class='row'>

                    <div class="input-group col-md-2">

                        <span class="input-group " id="basic-addon1">Country :  </span>

                        <?php
                $cs = array('onClick' => 'getStates()',
						  'id'=>'country',
						  'value'=>$country,
						  'class'=>'custom-select'
						 // 'style'=>'margin-left:10px'
						  );	// country dropdown
				echo form_dropdown('country', $countrylist,$country_selected,$cs); 
               ?>

                    </div>

                    <div class="input-group col-md-2">

                        <span class="input-group " id="basic-addon1">State :  </span>

                        <?php $ss = array('onClick' => 'getCity()',
				    'id'=>'state',
				    'value'=>$state,
				    'class'=>'custom-select',
				//	'style'=>'margin-left:10px'
					);	// states dropdown
			echo form_dropdown('state', $statelist,$state_selected,$ss); 
                               ?>
                    </div>
                    <div class="input-group col-md-2">

                        <span class="input-group " id="basic-addon1">City :  </span>

                        <?php
                                $es = array('id'=>'city',
								'value'=> $city,
								'class'=>'custom-select col'
								//'style'=>'margin-left:10px'
								);
			echo form_dropdown('city',$citieslist,$city_selected,$es);			//city dropdown?>

                    </div>
                    <div class="input-group col-md-1">
                        <span class="input-group " id="basic-addon1">Class : </span>

                        <?php
			$options = array(  //dropdown class
				'I'         => 'I',
				'II'           => 'II',
				'III'         => 'III',
				'IV'        => 'IV',
				'V'        => 'V'
			);

				$dropat = array(
					'class'=>"custom-select"
					//'style'=>'margin-left:10px'
					);
				echo form_dropdown('class', $options,$class,$dropat);
                ?>
                    </div>
                    <div class='col col-md-2'>Other hobbies:
                        <?php  $list= array(
										'1'=> '	&nbspFishing',
										'2'=> '	&nbspPlaying',
										'3' => '	&nbspSwimming',
										'4'=>'	&nbspGardening');
								$multi_att =array(
												  'id'=>'otherhob',
												 'multiple'=>'multiple',
												 'class'=>'custom-select col-md-1'
												);

						echo form_multiselect('otherhob[]', $list,($a)?$a:'',$multi_att);	// other hobbies multicheckbox?>
                    </div>
                </div>
                <div class='row'>
                    <div class='col  text-danger' style="margin-left: 380px">
                        <?php echo form_error('city')?>
                    </div>
                </div>
                <br>
                <div class='row'>

                    <div class='col col-md-3'>
                        Date of Birth :
                        <input type="text" id="dob_id" name="dob_id" value="<?php echo ($dob!=" ")?$dob:'';?>" required>
                        <button type="button" onclick="cleardatet();" id="btn_received_date" value="received_date" class="pull-center button  button_defoult" style="min-width:30px;padding: 0px;margin-left: 10px">X</button>
                    </div>
                    <div class='col col-md-9 text-danger' style="margin-left: 1px">
                        <?php echo form_error('dob_id')?>
                    </div>
                </div>

            </div>

            <div class='row' style="margin: auto; max-width: 300px;">
                <div class="col">

                    <?php echo form_label('Gender  :', 'gender_label'); 

								$mrad= array(
									'value'=>'male',
									'class'=>'form-check-input',
									'type' =>'radio'
								);
								$frad= array(
									'value'=>'female',
									'class'=>'form-check-input',
									'type' =>'radio'
								);?>

                        <!--Radio group-->
                        <div class="form-check">

                            <?php echo form_radio('gender','male',($gender=='male')?'checked':false,$mrad);?>
                                <label class="form-check-label " for="radio100">Male</label>
                        </div>

                        <div class="form-check ">
                            <?php echo form_radio('gender','female',($gender=='female')?'checked':false,$frad); ?>
                                <label class="form-check-label" for="female">Female</label>
                        </div>

                </div>
                <div class="col">
                    <?php echo form_label('Hobbies : ', 'hobbies_label'); ?>
                        <div class="form-check ">
                            <?php  echo form_checkbox('hobbies[]','cricket',(isset($hobbies['cricket']))?TRUE:FALSE); ?>
                                <label class="form-check-label" for="cricket">Cricket</label>
                        </div>
                        <div class="form-check ">
                            <?php  echo form_checkbox('hobbies[]','football',(isset($hobbies["football"]))?TRUE:FALSE);?>
                                <label class="form-check-label" for="football">Football</label>
                        </div>
                </div>

            </div>

            <div class='row'>

                <div class='col text-danger' style="margin-left: 590px">
                    <?php echo form_error('gender')?>
                </div>
                <div class='col'></div>
            </div>
            <br>
            <br>
				
				<div class='container'>
						<div class='row justify-content-center'>
						<div class='col offset-md-3'>Student Summary :
		<?php $areaattrib = array(
								  'id' => 'std_details',
								  'class' => 'ckeditor',
								 );
		echo form_textarea('std_details',(isset($stdDetails))?$stdDetails:'',$areaattrib)?>
						</div>
						</div>
				</div>            
				<br>
            <div class='row justify-content-center'>
                <div class="" style="margin-left: <?php echo ($flag=='add')?'93px':'143px'?>"></div>
                <?php
		$button= array(
			       'class' => 'btn btn-primary col-md-1');
		echo form_submit('submit', 'Save',$button); // submit button?>
                    <div class="col col-md-1">
                    </div>
                    <?php $resetbtn= array(
			       'class' => 'btn btn-danger col-md-1',
			       'onclick' => ($flag=='add')?'getAlert()':'back_function()',
				   'id'=>'resetbtn'
			       );
		echo form_reset($reset, $reset,$resetbtn); // reset button?>
                        <div class="col col-md-1">
                        </div>

                        <?php if($flag=='add'){
		$backbtn= array(
			       'class' => 'btn btn-dark col-md-1',
			       'onclick' => 'back_function()',
				   'id'=>'backbtn'
			       );
		echo form_reset('backbtn', 'Back',$backbtn); // back button for add page
		}
		?>
            </div>
            </div>

            <?php
		echo form_fieldset_close();

		echo form_close();
		?>
  <script src="<?php echo base_url();?>js/minmize_date_picker.js"></script>
<?php $this->load->view('footer/footer.php'); ?>
    <script src="<?php echo base_url(); ?>js/jquery.multiselect.js"></script>
	
<script type="text/javascript" src="<?php echo base_url();?>ckeditor/ckeditor.js"></script>
<script type="text/javascript" src="<?php echo base_url();?>ckfinder/ckfinder.js"></script>


<script type="text/javascript">

                   CKEDITOR.replace('std_details',
                   {
                           toolbar : 'MyToolbar',
                           width:'600',
                           height:'200',
                           filebrowserBrowseUrl : '/ckfinder/ckfinder.html',
                           filebrowserImageBrowseUrl : '/ckfinder/ckfinder.html?type=Images',
                           filebrowserFlashBrowseUrl : '/ckfinder/ckfinder.html?type=Flash',
                           filebrowserUploadUrl : '/ckfinder/core/connector/php/connector.php?command=QuickUpload&type=Files',
                           filebrowserImageUploadUrl : '/ckfinder/core/connector/php/connector.php?command=QuickUpload&type=Images',
                           filebrowserFlashUploadUrl : '/ckfinder/core/connector/php/connector.php?command=QuickUpload&type=Flash'
                   });
		
				$(document).ready(function () {					
						 $('#removeimage').click(function(){
								$(this).hide();
                       $('#usrImage').hide();
					    $('input[name=flagImg]').val(0);
						$('#imageupload').show();
					  			   
				   });
				   $('#removepdf').click(function(){
                       $(this).hide();
					   $('#pdfuploadImg').hide();
					    $('input[name=flagPdf]').val(0);
						$('#pdfupload').show();
					  			   
				   });
				   
				    $('#removeexcel').click(function(){
                       $(this).hide();
					   $('#exceluploadImg').hide();
					   $('#excelupload').show();
					   $('input[name=flagExcel]').val(0)
	
						});
				 
				   });
				     
           </script>

<?php $this->load->view('footer/datemulti.php'); ?>
</body>
</html>