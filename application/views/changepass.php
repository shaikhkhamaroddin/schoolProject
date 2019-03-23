<html>
  <head>
    
    <title>
      Change User password
      </title>
    
  </head>
  <?php $this->load->view('header/header');
  $path =file_exists(UPLOAD_IMAGE_PATH.'/'.$id.'.jpg')?base_url().UPLOAD_IMAGE_PATH.'/'.$id.'.jpg':base_url().'images/no-image.jpg';
  ?>
  <body>
    
      <form  class='form' method='post' action='<?php echo site_url('/stdcontroller/change/'.$id)?>'>
      <div class="container bootstrap snippet">
    <div class="row">
        <div class="col-xs-12 col-sm-12 col-md-6 col-md-offset-2">
            <div class="panel panel-info">
                <div class="panel-heading">
                    <h3 class="panel-title">
                        <span class="glyphicon glyphicon-th"></span>
                        Change password   
                    </h3>
                </div>
                <div class="panel-body">
                    <div class="row">
                        <div class="col-xs-6 col-sm-6 col-md-6 separator social-login-box"> <br>
                           <img alt="No Image" class="img-thumbnail" src="<?php echo $path.'?'.time();?>">                        
                        </div>
                        <div style="margin-top:80px;" class="col-xs-6 col-sm-6 col-md-6 login-box">
                         <div class="form-group">
                            <div class="input-group">
                              <div class="input-group-addon"><span class="glyphicon glyphicon-lock"></span></div>
                              <input class="form-control" type="password" placeholder="New Password" name='newpass'>
                                 
                            </div>
                            <?php echo form_error('newpass')?>
                          </div>
                          <div class="form-group">
                            <div class="input-group">
                              <div class="input-group-addon"><span class="glyphicon glyphicon-log-in"></span></div>
                              <input class="form-control" type="password" placeholder="Re-enter Password" name='checkpass'>
                                
                            </div>
                             <?php echo form_error('checkpass')?>
                          </div>
                        </div>
                    </div>
                </div>
                <div class="panel-footer">
                    <div class="row">
                        <div class="col-xs-6 col-sm-6 col-md-6"></div>
                        <div class="col-xs-2 col-sm-2 col-md-2">
                            <button class="btn icon-btn-save btn-success col-xs-4" type="submit">
                            <span class="btn-save-label"><i class="glyphicon glyphicon-floppy-disk"></i></span>Save</button>
                        </div>
                        <div class="col-xs-3 col-sm-3 col-md-3">
                            <button type="button" class="btn btn-grey" id='btnclose'>
                            <span class="btn-save-label"><i class="glyphicon glyphicon-floppy-disk"></i></span>Close</button>
                        </div>
                    

                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
    </form>
    
   
    <?php $this->load->view('footer/footer')?>
   
   
          <script type='text/javascript'>
      $("#btnclose").click(function() {
       
       parent.jQuery.fancybox.close();
       
      });
    </script>
  
  </body>
</html>