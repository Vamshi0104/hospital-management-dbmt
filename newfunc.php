<?php
// session_start();
$con=mysqli_connect("localhost","root","","hospitalms");
// if(isset($_POST['submit'])){
//  $username=$_POST['username'];
//  $password=$_POST['password'];
//  $query="select * from logintb where username='$username' and password='$password';";
//  $result=mysqli_query($con,$query);
//  if(mysqli_num_rows($result)==1)
//  {
//   $_SESSION['username']=$username;
//   $_SESSION['pid']=
//   header("Location:admin-panel.php");
//  }
//  else
//   header("Location:error.php");
// }
if(isset($_POST['update_data']))
{
 $contact=$_POST['contact'];
 $status=$_POST['status'];
 $query="update APPOINTMENT set payment='$status' where contact='$contact';";
 $result=mysqli_query($con,$query);
 if($result)
  header("Location:updated.php");
}



function display_specs() {
  global $con;
  $query="select distinct(DOCTOR_SPEC) from DOCTOR";
  $result=mysqli_query($con,$query);
  while($row=mysqli_fetch_array($result))
  {
    $spec=$row['DOCTOR_SPEC'];
    echo '<option data-value="'.$spec.'">'.$spec.'</option>';
  }
}

function display_docs()
{
 global $con;
 $query = "select * from DOCTOR";
 $result = mysqli_query($con,$query);
 while( $row = mysqli_fetch_array($result) )
 {
  $username = $row['DOCTOR_NAME'];
  $price = $row['DOCTOR_FEES'];
  $spec = $row['DOCTOR_SPEC'];
  echo '<option value="' .$username. '" data-value="'.$price.'" data-spec="'.$spec.'">'.$username.'</option>';
 }
}



if(isset($_POST['doc_sub']))
{
 $username=$_POST['username'];
 $query="insert into DOCTOR(DOCTOR_ID)values('$username')";
 $result=mysqli_query($con,$query);
 if($result)
  header("Location:adddoc.php");
}

?>