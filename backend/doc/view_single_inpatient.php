<?php
  session_start();
  include('assets/inc/config.php');
  include('assets/inc/checklogin.php');
  require ('../../assets/dataProvider.php');
  check_login();

  $doc_id=$_SESSION['doc_id'];
  //$doc_number = $_SERVER['doc_number'];
?>

<!DOCTYPE html>
    <html lang="en">

    <?php include('assets/inc/head.php');?>

    <body>

        <!-- Begin page -->
        <div id="wrapper">

            <!-- Topbar Start -->
             <?php include("assets/inc/nav.php");?>
            <!-- end Topbar -->

            <!-- ========== Left Sidebar Start ========== -->
                <?php include("assets/inc/sidebar.php");?>
            <!-- Left Sidebar End -->

            <!-- ============================================================== -->
            <!-- Start Page Content here -->
            <!-- ============================================================== -->

            <!--Get Details Of A Single User And Display Them Here-->
            <?php
                $pat_id=$_GET['pat_id'];
                $ret="SELECT  * FROM inpatient WHERE PCode= '".$pat_id."'";

                $res = executeQuery($ret);
                //$cnt=1;
                while($row=$res->fetch_object())
            {

            ?>
            <div class="content-page">
                <div class="content">

                    <!-- Start Content-->
                    <div class="container-fluid">

                        <!-- start page title -->
                        <div class="row">
                            <div class="col-12">
                                <div class="page-title-box">
                                    <div class="page-title-right">
                                        <ol class="breadcrumb m-0">
                                            <li class="breadcrumb-item"><a href="javascript: void(0);">Dashboard</a></li>
                                            <li class="breadcrumb-item"><a href="javascript: void(0);">Patients</a></li>
                                            <li class="breadcrumb-item active">View Patients</li>
                                        </ol>
                                    </div>
                                    <h4 class="page-title"><?php echo $row->Fname;?> <?php echo $row->Lname;?>'s Profile</h4>
                                </div>
                            </div>
                        </div>
                        <!-- end page title -->

                        <div class="row">
                            <div class="col-lg-4 col-xl-4">
                                <div class="card-box text-center">
                                    <img src="assets/images/users/patient.png" class="rounded-circle avatar-lg img-thumbnail"
                                        alt="profile-image">

                                    
                                    <div class="text-left mt-3">
                                        <p class="text-muted mb-2 font-13"><strong>Number :</strong> <span class="ml-2"><?php echo $row->PCode;?></span></p>
                                        <p class="text-muted mb-2 font-13"><strong>Full Name :</strong> <span class="ml-2"><?php echo $row->Fname;?> <?php echo $row->Lname;?></span></p>
                                        <p class="text-muted mb-2 font-13"><strong>Mobile :</strong><span class="ml-2"><?php echo $row->Phone;?></span></p>
                                        <p class="text-muted mb-2 font-13"><strong>Address :</strong> <span class="ml-2"><?php echo $row->Address;?></span></p>
                                        <p class="text-muted mb-2 font-13"><strong>Date Of Birth :</strong> <span class="ml-2"><?php echo $row->DoB;?></span></p>
                                        <p class="text-muted mb-2 font-13"><strong>Gender :</strong> <span class="ml-2"><?php echo $row->Gender;?></span></p>

                                        <hr>
                                        <hr>




                                    </div>

                                </div> <!-- end card-box -->

                            </div> <!-- end col-->
                            
                            <?php }?>
                            <div class="col-lg-8 col-xl-8">
                                <div class="card-box">
                                    <ul class="nav nav-pills navtab-bg nav-justified">
                                        <li class="nav-item">
                                            <a href="#aboutme" data-toggle="tab" aria-expanded="false" class="nav-link active">
                                                Treatment
                                            </a>
                                        </li>


                                    </ul>
                                    <!--Medical History-->
                                    <div class="tab-content">
                                        <div class="tab-pane show active" id="aboutme">
                                            <ul class="list-unstyled timeline-sm">
                                                <?php
                                                $ret="SELECT  * FROM `treatment` JOIN `doctor` ON DECode = ECode WHERE IPCode ='$pat_id' ORDER BY DateAdmission DESC" ;
                                                $res = executeQuery($ret);
                                                //$cnt=1;

                                                while($row=$res->fetch_object())
                                                {
                                                    $mysqlDateTime = $row->DateAdmission; //trim timestamp to date

                                                    ?>
                                                    <li class="timeline-sm-item">
                                                        <span class="timeline-sm-date">
                                                            <?php echo date("d-m-Y", strtotime($mysqlDateTime));?>
                                                            <br>
                                                            <?php echo $row->TreatCode;?>
                                                        </span>
                                                        <h2 class="mt-0 mb-1"><?php echo $row->Diagnosis;?></h2>
                                                        <hr>
                                                        <h4>
                                                            Treatment
                                                        </h4>

                                                        <p class="text-muted mt-2">
                                                            Admission Date:
                                                            <?php echo  date("d-m-Y", strtotime($mysqlDateTime));?>
                                                        </p>
                                                        <p class="text-muted mt-2">
                                                            Start Date:
                                                            <?php echo  date("d-m-Y", strtotime($row->StartDate));?>
                                                        </p>
                                                        <p class="text-muted mt-2">
                                                            Sick Room:
                                                            <?php echo $row->SickRoom;?>
                                                        </p>
                                                        <p class="text-muted mt-2">
                                                            End Date:
                                                            <?php
                                                            if ($row->EndDate == "0000-00-00")
                                                                echo "Unknown";
                                                            else
                                                                echo  date("d-m-Y", strtotime($row->EndDate));?>
                                                        </p>
                                                        <p class="text-muted mt-2">
                                                            Discharge Date:

                                                            <?php if($row->DateDischarge == "0000-00-00")
                                                                echo "Unknown";
                                                            else
                                                                echo  date("d-m-Y", strtotime($row->DateDischarge));?>
                                                        </p>

                                                        <p class="text-muted mt-2">
                                                            Fee: $<?php echo $row->Fee;?>
                                                        </p>
                                                        <hr>
                                                        <h4>
                                                            Prescription
                                                        </h4>
                                                        <p class="text-muted mt-2">
                                                        <ol>
                                                            <?php
                                                            $sql = "SELECT * FROM `treatment` E JOIN `treat_use` EU ON E.TreatCode = EU.TreatCode JOIN `medication` M ON EU.MCode = M.MCode WHERE E.TreatCode = '".$row->TreatCode."'";
                                                            $result = executeQuery($sql);
                                                            while($row1 = $result->fetch_array())
                                                            {
                                                                ?>
                                                                <li>
                                                                    <?php echo $row1['Name'] ?> - $<?php echo $row1['price'] ?>                  x<?php echo$row1['quantity'] ?>
                                                                </li>
                                                            <?php } ?>

                                                        </ol>
                                                        </p>
                                                        <hr>

                                                        <h4>
                                                            Doctor
                                                        </h4>
                                                        <?php
                                                            $sql2 = "SELECT * FROM `cure` JOIN `doctor` ON DECode = ECode WHERE TreatCode = '".$row->TreatCode."'";
                                                            $res2 = executeQuery($sql2);
                                                            while($row2 = $res2->fetch_array())
                                                        {
                                                        ?>
                                                        <p class="text-muted mt-2">
                                                            <?php echo ($row2['Fname']. " " . $row2['Lname']) . " - " . $row2['ECode']; ?>
                                                        </p>
                                                        <?php
                                                        }
                                                        ?>
                                                        <hr>
                                                        <h4>
                                                            Nurse
                                                        </h4>
                                                        <?php
                                                        $sql3 = "SELECT * FROM `nurse` WHERE ECode = '".$row->NECode."'";
                                                        $res3 = executeQuery($sql3);
                                                        $row3 = $res3->fetch_array();
                                                        ?>
                                                        <p class="text-muted mt-2">
                                                            <?php echo ($row3['Fname']. " " . $row3['Lname']) . " - " . $row3['ECode']; ?>
                                                        </p>
                                                        <hr>

                                                        <h4>
                                                            Treatment Results
                                                        </h4>

                                                        <?php if($row->Result == "Recovered")
                                                        {
                                                            $color = "green";
                                                        }elseif($row->Result == "Have not recovered")
                                                        {
                                                            $color = "red";
                                                        }else
                                                            $color = "orange"

                                                        ?>


                                                        <p class=" mt-2" style="color:<?php echo $color; ?>">
                                                            <b><?php echo $row->Result; ?></b>
                                                        </p>

                                                        <p class="text-muted mt-2">

                                                            Confirmed by <?php echo $row->Fname." ".$row->Lname. "  -  " . $row->DECode ; ?>
                                                        </p>
                                                        <hr>

                                                    </li>
                                                <?php }?>
                                            </ul>
                                        </div> <!-- end tab-pane -->
                                        <!-- end Prescription section content -->
                                        <!-- end vitals content-->
                                        <div class="tab-pane" id="settings">
                                            <ul class="list-unstyled timeline-sm">
                                                <?php
                                                $lab_pat_number =$_GET['pat_number'];
                                                $ret="SELECT  * FROM his_laboratory WHERE  	lab_pat_number  ='$lab_pat_number'";
                                                $stmt= $mysqli->prepare($ret) ;
                                                // $stmt->bind_param('i',$lab_pat_number);
                                                $stmt->execute() ;//ok
                                                $res=$stmt->get_result();
                                                //$cnt=1;

                                                while($row=$res->fetch_object())
                                                {
                                                    $mysqlDateTime = $row->lab_date_rec; //trim timestamp to date

                                                    ?>
                                                    <li class="timeline-sm-item">
                                                        <span class="timeline-sm-date"><?php echo date("Y-m-d", strtotime($mysqlDateTime));?></span>
                                                        <h3 class="mt-0 mb-1"><?php echo $row->lab_pat_ailment;?></h3>
                                                        <hr>
                                                        <h5>
                                                            Laboratory  Tests
                                                        </h5>

                                                        <p class="text-muted mt-2">
                                                            <?php echo $row->lab_pat_tests;?>
                                                        </p>
                                                        <hr>
                                                        <h5>
                                                            Laboratory Results
                                                        </h5>

                                                        <p class="text-muted mt-2">
                                                            <?php echo $row->lab_pat_results;?>
                                                        </p>
                                                        <hr>

                                                    </li>
                                                <?php }?>
                                            </ul>
                                        </div>

                                        <!-- end lab records content-->

                                    </div> <!-- end tab-content -->
                                </div> <!-- end card-box-->

                            </div> <!-- end col -->
                        </div>
                        <!-- end row-->

                    </div> <!-- container -->

                </div> <!-- content -->

                <!-- Footer Start -->
                <?php include('assets/inc/footer.php');?>
                <!-- end Footer -->

            </div>
            

            <!-- ============================================================== -->
            <!-- End Page content -->
            <!-- ============================================================== -->


        </div>
        <!-- END wrapper -->

        <!-- Right bar overlay-->
        <div class="rightbar-overlay"></div>

        <!-- Vendor js -->
        <script src="assets/js/vendor.min.js"></script>

        <!-- App js -->
        <script src="assets/js/app.min.js"></script>

    </body>


</html>