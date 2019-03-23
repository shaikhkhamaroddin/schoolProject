<!DOCTYPE html>
<html>
    <head>
		<title>Login</title>
		<script src="<?php echo site_url('js/jquery.js')?>"></script>
		<link href="<?php echo site_url('css/bootstrap.min.css')?>" rel="stylesheet">
		<script src=""<?php echo site_url('js/bootstrap.min.js')?>"></script>
    </head>
<body>
<?php echo validation_errors();?>

<br><br><br><br><br>
<div class="container">
	<div class="row">
        <div class="col-md-4 col-md-offset-4 bg-light">
            <div class="panel panel-default">
                <div class="panel-heading">
                    <h3 class="panel-title">Welcome User</h3>
                </div>
                <div class="panel-body">
                    <form role="form" method="POST" action="<?php echo site_url('logincontroller/login');?>" >
                        <fieldset>
                            <div class="form-group">
                                <input class="form-control" placeholder="E-mail" name="email" type="email" autofocus>
                            </div>
                            <div class="form-group">
                                <input class="form-control" placeholder="Password" name="password" type="password" value="">
                            </div>
							<div class='text-danger '><?php echo (isset($_SESSION['error']))?$_SESSION['error']:'';unset($_SESSION['error']);?></div>
                            <!-- Change this to a button or input when using this as a form -->
                            <?php
								$button= array(
								'class' => 'btn btn-primary btn-md col-md-3');
								echo form_submit('submit', 'Login',$button); // submit button?>
                            
                        </fieldset>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>
</body>
</html>