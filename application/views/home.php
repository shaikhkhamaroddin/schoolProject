 <!DOCTYPE html>
<html lang="en">
  <head>
    <title>
      Welcome User
    </title>
  </head>
  <body>
  <?php
  $this->load->view(isset($viewFile)?$viewFile:'body/stdinfo');
  ?>
  </body>
</html>