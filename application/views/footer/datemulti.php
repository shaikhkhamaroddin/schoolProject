<script type="text/javascript">
          $(function() {
            $("#dob_id").datepicker({
                showButtonPanel: true,
                changeMonth: true,
                changeYear: true,
                dateFormat: 'dd-mm-yy', // Date format
                yearRange: '1940:<?php echo date("Y");?>'
            }).attr('readonly', 'readonly');
        });

        function cleardatet() {
            // $("#dob_id").val =="";//._clearDate(this);
            document.getElementById("dob_id").value = "";
        }
    
        $('#otherhob').ready(function() {

            $('#otherhob').multiselect({
                columns: 1,
                placeholder: 'select Subjects',
                search: true,
                selectAll: true
            });
        });

        function getAlert() {
            confirm('Reset all fields');
        }
        if ("<?php echo $flag;?>" == 'add') {
            // initialize country
            $("#country").ready(function() {
                    $("#country").prepend($("<option></option>").text("Select Country").attr("selected", 'selected'));
                })
                //initialize state
            $("#state").ready(function() {
                $("#state").empty();
                $("#state").prepend($("<option></option>").text("Select State").attr("selected", 'selected'));
            })

            // initialize city
            $("#city").ready(function() {
                $("#city").empty();
                $("#city").prepend($("<option></option>").text("Select City").attr("selected", 'selected'));
            })
        }

        // function for getting states according to country
        function getStates() {
            $("#country").change(function(e) {
                var id = this.options[e.target.selectedIndex].value;

                $.ajax({
                    type: "POST",
                    dataType: "json",
                    //url: "getValues/"+id,
                    url: "<?php echo site_url('/stdcontroller/loadStates/'); ?>" + id,
                    data: id,
                    success: function(data) {
                        $("#city").empty();
                        $("#city").prepend($("<option></option>").text("Select City").attr("selected", 'selected'));
                        $("#state").empty();
                        $('#state').append($("<option></option>").attr("value", '').text('Select State'));
                        $.each(data, function(id, val) {
                            $("#state").append($("<option></option>").attr("value", id).text(val));

                        });

                    }
                });
            });
        }
        // function for getting cities according to state
        function getCity() {
            $("#state").change(function(e) {
                var id = this.options[e.target.selectedIndex].value;

                $.ajax({
                    type: "POST",
                    dataType: "json",
                    //url: "getCity/"+id,
                    url: "<?php echo site_url('/stdcontroller/loadCities/'); ?>" + id,
                    data: id,
                    success: function(data) {

                        $("#city").empty();
                        $('#city').append($("<option></option>").attr("value", '').text('Select City'));
                        $.each(data, function(id, val) {
                            $("#city").append($("<option></option>").attr("value", id).text(val));
                            console.log(id + '' + val);

                        });

                    }
                });
            });
        }
        // back button
        function back_function() {
                // var e = $('submit').text();
               // alert(e);
               <?php unset($_SESSION['pdfupload']);
               unset($_SESSION['excelupload']);?>
            window.location.href = "<?php  echo site_url('stdcontroller/index/0/af'); ?>";
        }

        
    </script>