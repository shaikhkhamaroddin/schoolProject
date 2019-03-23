<!DOCTYPE html>
  <html><head>
        <title>Datatable Example</title>
        <link rel="stylesheet" type="text/css" href="<?php echo base_url(); ?>css/datatables.min.css"/>
         <?php $this->load->view('header/header.php'); ?>
        
      
    </head>
    <body>
      <div class='container justify-content-center'>
        <h1> DataTable example  <?php echo $heading?></h1>
      <table id="stdtable" class="table table-bordered table-striped table-hover">
        <thead>
        <tr>
          <th>RollNo</th>
           <th>Name</th>
           <th>Username</th>
           <th>Class</th>
           <th>Country</th>
           <th>State</th>
           <th>City</th>
           <th>DOB</th>
        </tr>
        
        </thead>
        <tbody>
        <?php 
		      		 if ($flag !='ajax'){
		     foreach($records as $r) {

			echo "<tr>"; 
			      
			      echo "<td><center>".$r['srno']."</center></td>"; 
			      echo "<td>".$r['name']."</td>";
                  echo "<td>".$r['username']."</td>";
                  echo "<td>".$r['class']."</td>";
                  echo "<td>".$r['country']."</td>";
                  echo "<td>".$r['state']."</td>";
                  echo "<td>".$r['city']."</td>";
			      echo "<td>".$r['dob']."</td>";
                  
                  echo "</tr>";
             }
                     }?>
        </tbody>
      </table>
      </div>
      
      <?php $this->load->view('footer/footer.php'); ?>
       <script type="text/javascript" src="<?php echo base_url(); ?>js/datatables.min.js"></script>
      <script type="text/javascript">
        var flag = '<?php echo $flag;?>';
        var records ='';
 //////////// simple and ajax datatable view and search
 //$k = jQuery.noConflict();
$(document).ready(function() {
  
  if (flag=='ajax') {
    $('#stdtable').DataTable({
      serverSide: true,
      processing: true,
      
        "ajax": {
            url : "<?php echo site_url("stdcontroller/getDataTable") ?>",
            dataSrc: 'records'
          
        },
        "pagingType": "full_numbers",
   "paging": true,
  
       
         columns: [
        { data: 'srno' },
        { data: 'name' },
        { data: 'username'},
        { data: 'class' },
        { data: 'country'},
        { data: 'state'},
        { data: 'city'},
        { data: 'dob' }
        ]

    });
  }
  else{
    
      $('#stdtable').DataTable( {
            
    } );
  }
  //////////////// sorting in datatable for ajax
  $('#stdtable thead th').on('click', function () {
  var index = $('#stdtable').DataTable().column(this).index();
  $('#stdtable').DataTable().empty();
 $('#stdtable').DataTable({
      serverSide: true,
      processing: true,
      
        "ajax": {
            url : "<?php echo site_url("stdcontroller/sortTable") ?>",
            dataSrc: 'records'
          
        },
        "pagingType": "full_numbers",
   "paging": true,
   "pageLength": 5,
       
         columns: [
        { data: 'srno' },
        { data: 'name' },
        { data: 'username'},
        { data: 'class' },
        { data: 'country'},
        { data: 'state'},
        { data: 'city'},
        { data: 'dob' }
        ]

    });
 });
  
}

);
 
</script>
     
    </body>
  </html>