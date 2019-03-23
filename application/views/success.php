<html>
  <head>
    <?php $this->load->view('header/header')?>
  </head>
  <body>
    
    <div class="jumbotron text-xs-center">
  <h1 class="display-3">Thank You!</h1>
  <p class="lead"><strong>Password changed successfully!</p>
  <hr>
  
 <button type="button" class="btn btn-grey" id='btnclose'>Close</button>
</div>
     <?php $this->load->view('footer/footer')?>
          <script type='text/javascript'>
      $("#btnclose").click(function() {
       
       parent.jQuery.fancybox.close();
       
      });
    </script>
  </body>
</html>