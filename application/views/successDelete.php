<html>

<head>
    <?php $this->load->view('header/header')?>
        <style>
            #jumbo {
                margin-top: 2px;
                padding-top: 33px;
                padding-bottom: 8px;
            }
        </style>
</head>

<body>

    <div id="jumbo" class="jumbotron text-xs-center">

        <p class="lead"><strong>Record deleted successfully!</p>
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