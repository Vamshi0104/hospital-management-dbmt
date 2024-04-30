<!DOCTYPE html>
<?php
include('func.php');
include('newfunc.php');

$con=mysqli_connect("localhost","root","","hospitalms");



  $pid = $_SESSION['pid'];
  $username = $_SESSION['username'];
  $email = $_SESSION['email'];
  $fname = $_SESSION['fname'];
  $gender = $_SESSION['gender'];
  $lname = $_SESSION['lname'];
  $contact = $_SESSION['contact'];



if(isset($_POST['app-submit']))
{
  $pid = $_SESSION['pid'];
  $username = $_SESSION['username'];
  $email = $_SESSION['email'];
  $fname = $_SESSION['fname'];
  $lname = $_SESSION['lname'];
  $gender = $_SESSION['gender'];
  $contact = $_SESSION['contact'];
  $doctor=$_POST['doctor'];
  $reason = $_POST["reason"];

  $email=$_SESSION['email'];
  # $fees=$_POST['fees'];
  $docFees=$_POST['docFees'];
  $insurance_id=$_POST['higherText'];
  $appdate=$_POST['appdate'];
  $apptime=$_POST['apptime'];
  $cur_date = date("Y-m-d");
  date_default_timezone_set('Asia/Kolkata');
  $cur_time = date("H:i:s");
  $apptime1 = strtotime($apptime);
  $appdate1 = strtotime($appdate);


  $query2=mysqli_query($con,"select * from INSURANCE_DETAILS where insurance_status = 0 and insurance_id = '$insurance_id';");
  if(mysqli_num_rows($query2)==1)
  {
    echo "<script>alert('Oops!! There is issue with your Insurance Claim Status Limit, Please reach out to Insurance department to proceed further for booking appointment');window.location.href='./admin-panel.php';</script>";
  }

  if(date("Y-m-d",$appdate1)>=$cur_date){
    if((date("Y-m-d",$appdate1)==$cur_date and date("H:i:s",$apptime1)>$cur_time) or date("Y-m-d",$appdate1)>$cur_date) {
      $check_query = mysqli_query($con,"select APPOINTMENT_TIME from APPOINTMENT a inner join DOCTOR d ON a.DOCTOR_ID = d.DOCTOR_ID where DOCTOR_NAME='$doctor' and APPOINTMENT_DATE='$appdate' and APPOINTMENT_TIME='$apptime'");
        $result = mysqli_query($con, "select * from DOCTOR where DOCTOR_NAME='$doctor' or DOCTOR_ID='$doctor'");
        $did='';
        $doc_spec='';
        while ($row = mysqli_fetch_array($result))
        {
            $did = $row['DOCTOR_ID'];
            $doc_spec= $row['DOCTOR_SPEC_ID'];
        }
        if(mysqli_num_rows($check_query)==0){
          $query=mysqli_query($con,"insert into APPOINTMENT(PATIENT_ID,DOCTOR_ID,APPOINTMENT_DATE,APPOINTMENT_TIME,USER_STATUS,DOCTOR_STATUS,DOCTOR_SPEC_ID,REASON_FOR_VISIT) values($pid,'$did','$appdate','$apptime','1','1','$doc_spec','$reason')");
            echo "<script>console.log('okk');</script>";
          $q2=mysqli_query($con,"select APPOINTMENT_ID from APPOINTMENT ORDER BY APPOINTMENT_ID DESC");
          if($q2){
            $row = mysqli_fetch_assoc($q2);
            if($row){
              $id_ap = $row['APPOINTMENT_ID'];
            }
            }
         echo "<script>console.log('okk1');</script>";
          $q4=mysqli_query($con,"select case when INSURANCE_STATUS='1' THEN COVERAGE_PERCENT else '0' end as abc from INSURANCE_DETAILS where PATIENT_ID='$pid'");
          if($q4){
            $row = mysqli_fetch_assoc($q4);
            if($row){
              $per = $row['abc'];
            }
            }
        echo "<script>console.log('okk2');</script>";
          $tot=$docFees-(($docFees*$per)/100);
          echo "<script>console.log($tot);</script>";
          echo "<script>console.log($docFees);</script>";
          echo "<script>console.log($per);</script>";
          $q1=mysqli_query($con,"insert into BILLING(PATIENT_ID,TYPE,ID,AMOUNT,BALANCE_AMOUNT) values ('$pid','Consulting Fees','$id_ap','$docFees','$tot')");
          if($query)
          {
            echo "<script>alert('Your appointment successfully booked');</script>";
          }
          else{
            echo "<script>alert('Unable to process your request. Please try again!');</script>";
          }
      }
      else{
        echo "<script>alert('We are sorry to inform that the doctor is not available in this time or date. Please choose different time or date!');</script>";
      }
   }
   else{
      echo "<script>alert('Select a time or date in the future!');</script>";
    }
}
  else{
      echo "<script>alert('Select a time or date in the future!');</script>";
  }

}

if(isset($_GET['cancel']))
  {
    $query=mysqli_query($con,"update APPOINTMENT set USER_STATUS='0' where APPOINTMENT_ID = '".$_GET['ID']."'");
    if($query)
    {
      echo "<script>alert('Your appointment successfully cancelled');</script>";
    }
  }




//
// function generate_bill(){
//   $con=mysqli_connect("localhost","root","","hospitalms");
//   $pid = $_SESSION['pid'];
//   $output='';
//   $query=mysqli_query($con,"select p.pid,p.ID,p.fname,p.lname,p.doctor,p.appdate,p.apptime,p.disease,p.allergy,p.prescription,a.docFees from PRESCRIPTION p inner join APPOINTMENT a on p.ID=a.ID and p.pid = '$pid' and p.ID = '".$_GET['ID']."'");
//   while($row = mysqli_fetch_array($query)){
//     $output .= '
//     <label> Bill No : </label>HMS_'.$row["pid"].$row["ID"].'<br/><br/>
//     <label> Patient : </label>'.$row["fname"].' '.$row["lname"].'<br/><br/>
//     <label> Doctor : </label>'.$row["doctor"].'<br/><br/>
//     <label> Appointment Date : </label>'.$row["appdate"].'<br/><br/>
//     <label> Appointment Time : </label>'.$row["apptime"].'<br/><br/>
//     <label> Disease : </label>'.$row["disease"].'<br/><br/>
//     <label> Allergies : </label>'.$row["allergy"].'<br/><br/>
//     <label> Prescription : </label>'.$row["prescription"].'<br/><br/>
//     <label> Fees Paid : </label>$'.$row["docFees"].'<br/>
//
//     ';
//
//   }
//
//   return $output;
// }
//
//
// if(isset($_GET["generate_bill"])){
//   require_once("TCPDF/tcpdf.php");
//   $obj_pdf = new TCPDF('P',PDF_UNIT,PDF_PAGE_FORMAT,true,'UTF-8',false);
//   $obj_pdf -> SetCreator(PDF_CREATOR);
//   $obj_pdf -> SetTitle("Generate Bill");
//   $obj_pdf -> SetHeaderData('','',PDF_HEADER_TITLE,PDF_HEADER_STRING);
//   $obj_pdf -> SetHeaderFont(Array(PDF_FONT_NAME_MAIN,'',PDF_FONT_SIZE_MAIN));
//   $obj_pdf -> SetFooterFont(Array(PDF_FONT_NAME_MAIN,'',PDF_FONT_SIZE_MAIN));
//   $obj_pdf -> SetDefaultMonospacedFont('helvetica');
//   $obj_pdf -> SetFooterMargin(PDF_MARGIN_FOOTER);
//   $obj_pdf -> SetMargins(PDF_MARGIN_LEFT,'5',PDF_MARGIN_RIGHT);
//   $obj_pdf -> SetPrintHeader(false);
//   $obj_pdf -> SetPrintFooter(false);
//   $obj_pdf -> SetAutoPageBreak(TRUE, 10);
//   $obj_pdf -> SetFont('helvetica','',12);
//   $obj_pdf -> AddPage();
//
//   $content = '';
//
//   $content .= '
//       <br/>
//       <h2 align ="center"> Hospital Management System</h2></br>
//       <h3 align ="center"> Bill</h3>
//
//
//   ';
//
//   $content .= generate_bill();
//   $obj_pdf -> writeHTML($content);
//   ob_end_clean();
//   $obj_pdf -> Output("hmsbill.pdf",'I');
//
// }

// function get_specs(){
//   $con=mysqli_connect("localhost","root","","hospitalms");
//   $query=mysqli_query($con,"select username,spec from DOCTOR");
//   $docarray = array();
//     while($row =mysqli_fetch_assoc($query))
//     {
//         $docarray[] = $row;
//     }
//     return json_encode($docarray);
// }

?>
<html lang="en">
  <head>


    <!-- Required meta tags -->
    <meta charset="utf-8">
    <link rel="shortcut icon" type="image/x-icon" href="images/favicon.png" />
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">

    <!-- Bootstrap CSS -->

        <link rel="stylesheet" href="vendor/fontawesome/css/font-awesome.min.css">

    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0-beta/css/bootstrap.min.css" integrity="sha384-/Y6pD6FV/Vv2HJnA6t+vslU6fwYXjCFtcEpHbNJ0lyAFsXTsjBbfaDjzALeQsN6M" crossorigin="anonymous">

    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/css/bootstrap.min.css" integrity="sha384-ggOyR0iXCbMQv3Xipma34MD+dH/1fQ784/j6cY/iJTQUOhcWr7x9JvoRxT2MZw1T" crossorigin="anonymous">

    <link href="https://fonts.googleapis.com/css?family=IBM+Plex+Sans&display=swap" rel="stylesheet">
      <nav class="navbar navbar-expand-lg navbar-dark bg-primary fixed-top">
  <a class="navbar-brand" href="#"><i class="fa fa-hospital-o" aria-hidden="true"></i> Hospital Management System</a>
  <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarSupportedContent" aria-controls="navbarSupportedContent" aria-expanded="false" aria-label="Toggle navigation">
    <span class="navbar-toggler-icon"></span>
  </button>

  <style >
    .bg-primary {
    /* background: -webkit-linear-gradient(left, #3931af, #00c6ff); */
    background: #F0F2F0;  /* fallback for old browsers */
    background: -webkit-linear-gradient(to right, #000C40, #F0F2F0);  /* Chrome 10-25, Safari 5.1-6 */
    background: linear-gradient(to right, #000C40, #F0F2F0); /* W3C, IE 10+/ Edge, Firefox 16+, Chrome 26+, Opera 12+, Safari 7+ */

    }
.list-group-item.active {
    z-index: 2;
    color: #fff;
    background: #F0F2F0;
    background: -webkit-linear-gradient(to right, #000C40, #F0F2F0);
    background: linear-gradient(to right, #000C40, #F0F2F0);
    border-color: #c3c3c3;
}
.text-primary {
    color: #342ac1!important;
}

.btn-primary{
  background-color: #3c50c1;
  border-color: #3c50c1;
}
  </style>

  <div class="collapse navbar-collapse" id="navbarSupportedContent">
     <ul class="navbar-nav mr-auto">
       <li class="nav-item">
        <a class="nav-link" href="logout.php"><i class="fa fa-power-off" aria-hidden="true"></i> Logout</a>
      </li>
       <li class="nav-item">
        <a class="nav-link" href="#"></a>
      </li>
    </ul>
  </div>
</nav>
  </head>
  <style type="text/css">
    button:hover{cursor:pointer;}
    #inputbtn:hover{cursor:pointer;}
  </style>
  <body style="padding-top:50px;">

   <div class="container-fluid" style="margin-top:50px;">
    <h3 style = "margin-left: 40%;  padding-bottom: 20px; font-family: 'IBM Plex Sans', sans-serif;"> Welcome &nbsp<?php echo $username ?>
   </h3>
    <div class="row">
  <div class="col-md-4" style="max-width:25%; margin-top: 3%">
    <div class="list-group" id="list-tab" role="tablist">
      <a class="list-group-item list-group-item-action active" id="list-dash-list" data-toggle="list" href="#list-dash" role="tab" aria-controls="home">Dashboard</a>
      <a class="list-group-item list-group-item-action" id="list-home-list" data-toggle="list" href="#list-home" role="tab" aria-controls="home">Book Appointment</a>
      <a class="list-group-item list-group-item-action" href="#app-hist" id="list-pat-list" role="tab" data-toggle="list" aria-controls="home">Appointment History</a>
      <a class="list-group-item list-group-item-action" href="#list-pres" id="list-pres-list" role="tab" data-toggle="list" aria-controls="home">Prescriptions</a>

    </div><br>
  </div>
  <div class="col-md-8" style="margin-top: 3%;">
    <div class="tab-content" id="nav-tabContent" style="width: 950px;">


      <div class="tab-pane fade  show active" id="list-dash" role="tabpanel" aria-labelledby="list-dash-list">
        <div class="container-fluid container-fullw bg-white" >
              <div class="row">
               <div class="col-sm-4" style="left: 5%">
                  <div class="panel panel-white no-radius text-center">
                    <div class="panel-body">
                      <span class="fa-stack fa-2x"> <i class="fa fa-square fa-stack-2x text-primary"></i> <i class="fa fa-bookmark fa-stack-1x fa-inverse"></i> </span>
                      <h4 class="StepTitle" style="margin-top: 5%;"> Book My Appointment</h4>
                      <script>
                        function clickDiv(id) {
                          document.querySelector(id).click();
                        }
                      </script>
                      <p class="links cl-effect-1">
                        <a href="#list-home" onclick="clickDiv('#list-home-list')">
                          Book Appointment
                        </a>
                      </p>
                    </div>
                  </div>
                </div>

                <div class="col-sm-4" style="left: 10%">
                  <div class="panel panel-white no-radius text-center">
                    <div class="panel-body" >
                      <span class="fa-stack fa-2x"> <i class="fa fa-square fa-stack-2x text-primary"></i> <i class="fa fa-paperclip fa-stack-1x fa-inverse"></i> </span>
                      <h4 class="StepTitle" style="margin-top: 5%;">My Appointments</h2>

                      <p class="cl-effect-1">
                        <a href="#app-hist" onclick="clickDiv('#list-pat-list')">
                          View Appointment History
                        </a>
                      </p>
                    </div>
                  </div>
                </div>
                </div>

                <div class="col-sm-4" style="left: 20%;margin-top:5%">
                  <div class="panel panel-white no-radius text-center">
                    <div class="panel-body" >
                      <span class="fa-stack fa-2x"> <i class="fa fa-square fa-stack-2x text-primary"></i> <i class="fa fa-file-powerpoint-o fa-stack-1x fa-inverse"></i> </span>
                      <h4 class="StepTitle" style="margin-top: 5%;">Prescriptions</h2>

                      <p class="cl-effect-1">
                        <a href="#list-pres" onclick="clickDiv('#list-pres-list')">
                          View Prescription List
                        </a>
                      </p>
                    </div>
                  </div>
                </div>


            </div>
          </div>





      <div class="tab-pane fade" id="list-home" role="tabpanel" aria-labelledby="list-home-list">
        <div class="container-fluid">
          <div class="card">
            <div class="card-body">
              <center><h4>Book Appointment</h4></center><br>
              <form class="form-group" method="post" action="admin-panel.php">
                <div class="row">

                    <div class="col-md-4">
                          <label for="spec">Specialization:</label>
                        </div>
                        <div class="col-md-8">
                          <select name="spec" class="form-control" id="spec">
                              <option value="" disabled selected>Select Specialization</option>
                              <?php
                              display_specs();
                              ?>
                          </select>
                        </div>

                        <br><br>

                        <script>
                      document.getElementById('spec').onchange = function foo() {
                        let spec = this.value;
                        console.log(spec)
                        let docs = [...document.getElementById('doctor').options];

                        docs.forEach((el, ind, arr)=>{
                          arr[ind].setAttribute("style","");
                          if (el.getAttribute("data-spec") != spec ) {
                            arr[ind].setAttribute("style","display: none");
                          }
                        });
                      };

                  </script>

              <div class="col-md-4"><label for="doctor">Doctors:</label></div>
                <div class="col-md-8">
                    <select name="doctor" class="form-control" id="doctor" required="required">
                      <option value="" disabled selected>Select Doctor</option>

                      <?php display_docs(); ?>
                    </select>
                  </div><br/><br/>


                        <script>
              document.getElementById('doctor').onchange = function updateFees(e) {
                var selection = document.querySelector(`[value=${this.value}]`).getAttribute('data-value');
                document.getElementById('docFees').value = selection;
              };
            </script>





                        <!-- <div class="col-md-4"><label for="doctor">Doctors:</label></div>
                                <div class="col-md-8">
                                    <select name="doctor" class="form-control" id="doctor1" required="required">
                                      <option value="" disabled selected>Select Doctor</option>

                                    </select>
                                </div>
                                <br><br> -->

                                <!-- <script>
                                  document.getElementById("spec").onchange = function updateSpecs(event) {
                                      var selected = document.querySelector(`[data-value=${this.value}]`).getAttribute("value");
                                      console.log(selected);

                                      var options = document.getElementById("doctor1").querySelectorAll("option");

                                      for (i = 0; i < options.length; i++) {
                                        var currentOption = options[i];
                                        var category = options[i].getAttribute("data-spec");

                                        if (category == selected) {
                                          currentOption.style.display = "block";
                                        } else {
                                          currentOption.style.display = "none";
                                        }
                                      }
                                    }
                                </script> -->


                    <!-- <script>
                    let data =

              document.getElementById('spec').onchange = function updateSpecs(e) {
                let values = data.filter(obj => obj.spec == this.value).map(o => o.username);
                document.getElementById('doctor1').value = document.querySelector(`[value=${values}]`).getAttribute('data-value');
              };
            </script> -->



                  <div class="col-md-4"><label for="consultancyfees">
                                Consultancy Fees
                              </label></div>
                              <div class="col-md-8">
                              <!-- <div id="docFees">Select a doctor</div> -->
                              <input class="form-control" type="text" name="docFees" id="docFees" readonly="readonly"/>
                  </div><br><br>

                  <div class="col-md-4"><label>Appointment Date</label></div>
                  <div class="col-md-8"><input type="date" class="form-control datepicker" name="appdate"></div><br><br>

                  <div class="col-md-4"><label>Appointment Time</label></div>
                  <div class="col-md-8">
                    <!-- <input type="time" class="form-control" name="apptime"> -->
                    <select name="apptime" class="form-control" id="apptime" required="required">
                      <option value="" disabled selected>Select Time</option>
                      <option value="08:00:00">8:00 AM</option>
                      <option value="10:00:00">10:00 AM</option>
                      <option value="12:00:00">12:00 PM</option>
                      <option value="14:00:00">2:00 PM</option>
                      <option value="16:00:00">4:00 PM</option>
                    </select>

                  </div><br><br>
                  <div class="col-md-4"><label for="reason">Reason to Visit:</label></div>
<div class="col-md-8">
    <input type="text" name="reason" class="form-control" id="reason" required>
</div><br><br>

                                     <div class="col-md-4"><label>Do you have Insurance :</label></div>
                                     <div class="col-md-8"><input type="checkbox" class="form-control checkbox"  value="higherText" id="higherCheck" onclick="toggleCheckbox(this)"></input>
                                                                 <br><br><input type="text" id="higherText" name="higherText" class="form-control" title="Enter Insurance ID" placeholder="Enter Insurance ID" class="row" style="text-align:center;font-size:20px;display:none;" /></div><br><br>


<br><br>

                  <div class="col-md-4">
                    <input type="submit" name="app-submit" value="Create new entry" class="btn btn-primary" id="inputbtn">
                  </div>
                  <div class="col-md-8"></div>
                </div>
              </form>
            </div>
          </div>
        </div><br>
      </div>

<div class="tab-pane fade" id="app-hist" role="tabpanel" aria-labelledby="list-pat-list">

              <table class="table table-hover">
                <thead>
                  <tr>
                    <th scope="col">#</th>
                    <th scope="col">Doctor</th>
                    <th scope="col">Fees</th>
                    <th scope="col">Date</th>
                    <th scope="col">Time</th>
                    <th scope="col">Status</th>
                    <th scope="col">Action</th>
                  </tr>
                </thead>
<tbody>
                  <?php

                    $con=mysqli_connect("localhost","root","","hospitalms");
                    global $con;

                    $query = "select * from APPOINTMENT a inner join DOCTOR d ON a.DOCTOR_ID = d.DOCTOR_ID where PATIENT_ID ='$pid';";
                    $result = mysqli_query($con,$query);
                    $cnt=1;
                    while ($row = mysqli_fetch_array($result)){

                      #$fname = $row['fname'];
                      #$lname = $row['lname'];
                      #$email = $row['email'];
                      #$contact = $row['contact'];
                  ?>
                      <tr>
                        <td><?php echo $cnt;?></td>
                        <td><?php echo $row['DOCTOR_NAME'];?></td>
                        <td><?php echo '$'.$row['DOCTOR_FEES'];?></td>
                        <td><?php echo $row['APPOINTMENT_DATE'];?></td>
                        <td><?php echo $row['APPOINTMENT_TIME'];?></td>

                          <td>
                    <?php if(($row['USER_STATUS']==1) && ($row['DOCTOR_STATUS']==1))
                    {
                      echo "Booked";
                    }
                    if(($row['USER_STATUS']==0) && ($row['DOCTOR_STATUS']==1))
                    {
                      echo "Cancelled by You";
                    }

                    if(($row['USER_STATUS']==1) && ($row['DOCTOR_STATUS']==0))
                    {
                      echo "Cancelled by Doctor";
                    }
                        ?></td>

                        <td>
                        <?php if(($row['USER_STATUS']==1) && ($row['DOCTOR_STATUS']==1))
                        { ?>


	                        <a href="admin-panel.php?ID=<?php echo $row['APPOINTMENT_ID']?>&cancel=update"
                              onClick="return confirm('Are you sure you want to cancel this appointment ?')"
                              title="Cancel Appointment" tooltip-placement="top" tooltip="Remove"><button class="btn btn-danger">Cancel</button></a>
	                        <?php } else {

                                echo "Cancelled";
                                } ?>

                        </td>
                      </tr>
                    <?php $cnt++; } ?>
                </tbody>
              </table>
        <br>
      </div>



      <div class="tab-pane fade" id="list-pres" role="tabpanel" aria-labelledby="list-pres-list">

              <table class="table table-hover">
                <thead>
                  <tr>

                    <th scope="col">Doctor</th>
                    <th scope="col">Diseases</th>
                    <th scope="col">Allergies</th>
                    <th scope="col">Prescriptions</th>
                  </tr>
                </thead>
                <tbody>
                  <?php
                    echo "<script>console.log($pid);</script>";
                    $con=mysqli_connect("localhost","root","","hospitalms");
                    global $con;

                    $query = "select * from PRESCRIPTION pr inner join DOCTOR d ON pr.DOCTOR_ID = d.DOCTOR_ID where PATIENT_ID='$pid';";

                    $result = mysqli_query($con,$query);

                    while ($row = mysqli_fetch_array($result)){
                  ?>
                      <tr>
                        <td><?php echo $row['DOCTOR_NAME'];?></td>
                        <td><?php echo $row['DISEASE'];?></td>
                        <td><?php echo $row['ALLERGY'];?></td>
                        <td><?php echo $row['PRESCRIPTION'];?></td>
                      </tr>
                    <?php }
                    ?>
                </tbody>
              </table>
        <br>
      </div>




      <div class="tab-pane fade" id="list-messages" role="tabpanel" aria-labelledby="list-messages-list">...</div>
      <div class="tab-pane fade" id="list-settings" role="tabpanel" aria-labelledby="list-settings-list">
        <form class="form-group" method="post" action="func.php">
          <label>Doctors name: </label>
          <input type="text" name="name" placeholder="Enter doctors name" class="form-control">
          <br>
          <input type="submit" name="doc_sub" value="Add Doctor" class="btn btn-primary">
        </form>
      </div>
       <div class="tab-pane fade" id="list-attend" role="tabpanel" aria-labelledby="list-attend-list">...</div>
    </div>
  </div>
</div>
   </div>
    <!-- Optional JavaScript -->
    <!-- jQuery first, then Popper.js, then Bootstrap JS -->
    <script src="https://code.jquery.com/jquery-3.2.1.slim.min.js" integrity="sha384-KJ3o2DKtIkvYIK3UENzmM7KCkRr/rE9/Qpg6aAZGJwFDMVNA/GpGFF93hXpG5KkN" crossorigin="anonymous"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.11.0/umd/popper.min.js" integrity="sha384-b/U6ypiBEHpOf/4+1nzFpr53nxSS+GLCkfwBdFNTxtclqqenISfwAzpKaMNFNmj4" crossorigin="anonymous"></script>
    <script src="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0-beta/js/bootstrap.min.js" integrity="sha384-h0AbiXch4ZDo7tp9hKZ4TsHbi047NrKGLO3SEJAg45jXxnGIfYzk4Si90RDIqNm1" crossorigin="anonymous"></script>
   <script src="https://cdnjs.cloudflare.com/ajax/libs/limonte-sweetalert2/6.10.1/sweetalert2.all.min.js">
   </script>
    <script>
      function toggleCheckbox(e) {
        document.getElementById(e.value).style.display = e.checked ? "initial" : "none";
       }
    </script>



  </body>
</html>
