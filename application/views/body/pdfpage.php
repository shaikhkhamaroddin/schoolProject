<!DOCTYPE html>
<html>
<body>
<div style="text-align: center"><h1>USER INFORMATION</h1>
<hr>
</div>
<div width='600px' height='300px'>
<table border="2" cellpadding="5" style="font-size:20px">
  <tbody>
    <tr>
    <td style="font-weight:bold" width="100px">Roll No.</td>
    <td width="300px"><?php echo $records['srno']?></td>
    </tr>
    <tr>
    <td style="font-weight:bold">Name</td>
    <td><?php echo $records['name']?></td>
    </tr>
    <tr>
    <td style="font-weight:bold">E-mail</td>
    <td><?php echo $records['username']?></td>
    </tr>
    <tr>
    <td style="font-weight:bold">Class</td>
    <td><?php echo $records['class']?></td>
    </tr>
    <tr>
    <td style="font-weight:bold">Gender</td>
    <td><?php echo $records['gender']?></td>
    </tr>
     <tr>
    <td style="font-weight:bold">Hobbies</td>
    <td><?php echo $records['hobbies']?></td>
    </tr>
      <tr>
    <td style="font-weight:bold">City</td>
    <td><?php echo $records['city']?></td>
    </tr>
       <tr>
    <td style="font-weight:bold">State</td>
    <td><?php echo $records['state']?></td>
    </tr>
        <tr>
    <td style="font-weight:bold">Country</td>
    <td><?php echo $records['country']?></td>
    </tr>
         <tr>
    <td style="font-weight:bold">DOB</td>
    <td><?php echo $records['dob']?></td>
    </tr>
  </tbody>
</table>
</div>
PDF Generated :<?php echo date('d-m-Y'); ?>
<br>
 
<div style="text-align: center">
    Copyright &copy; Shimbi Computing Labs, <?php echo date('Y'); ?>
    </div>
   
</body>
</html>