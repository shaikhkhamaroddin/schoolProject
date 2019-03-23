<html>

<head>
    <?php $this->load->view('header/header');?>

</head>
<title>Delete Employee</title>

<body>
    <center>
        <h4 style="color: red">Do you want to delete employee with all cases assigned to him/her?</h4></center>
    <div class='container'>
        <div class='row justify-content-center'>
            <form class='form' method='post' action='<?php echo site_url('stdcontroller/deleteEmp/'.$id)?>'>
                <input type="submit" name="btn_collapse" value="Yes" class='btn btn-warning' />
                <input type="button" id="btnclose" name="btn_expand" value="No" class='btn btn-info' /> &nbsp;&nbsp;

            </form>
        </div>
    </div>
    <?php $this->load->view('footer/footer')?>
        <script type='text/javascript'>
            $("#btnclose").click(function() {

                parent.jQuery.fancybox.close();

            });
        </script>
</body>

</html>