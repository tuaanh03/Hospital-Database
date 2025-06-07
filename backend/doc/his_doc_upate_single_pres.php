<!--Server side code to handle  Patient Registration-->
<?php
	session_start();
require ('../../assets/dataProvider.php');
$doc_id = $_SESSION['doc_id'];

include('assets/inc/config.php');
		if(isset($_POST['update_patient_presc']))
		{

			//$pres_pat_number = $_POST['pres_pat_number'];
            $pres_number = $_GET['pres_id'];
            $discharge = $_POST['discharge'];
            $resultTreat = $_POST['result'];
            //sql to insert captured values
			$query="UPDATE   treatment  SET Result = '".$resultTreat."', DateDischarge = '".date("Y-m-d",strtotime($discharge)  )."', EndDate = '".date("Y-m-d")."', DECode = '".$doc_id."' WHERE TreatCode = '".$pres_number."'";
			$stmt = executeQuery($query);
			/*
			*Use Sweet Alerts Instead Of This Fucked Up Javascript Alerts
			*echo"<script>alert('Successfully Created Account Proceed To Log In ');</script>";
			*/ 
			//declare a varible which will be passed to alert function
			if($stmt)
			{
				$success = "Patient Treatment Updated";
			}
			else {
				$err = "Please Try Again Or Try Later";
			}
			
			
		}
?>
<!--End Server Side-->
<!--End Patient Registration-->
<!DOCTYPE html>
<html lang="en">
    
    <!--Head-->
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
            <?php
                $pres_number = $_GET['pres_id'];
                $ret="SELECT  * FROM treatment T JOIN inpatient I ON I.IPCode = T.IPCode JOIN patient P ON I.PCode = P.PCode WHERE T.TreatCode = '".$pres_number."'";
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
                                                <li class="breadcrumb-item"><a href="his_doc_dashboard.php">Dashboard</a></li>
                                                <li class="breadcrumb-item"><a href="javascript: void(0);">Pharmacy</a></li>
                                                <li class="breadcrumb-item active">Manage Prescriptions</li>
                                            </ol>
                                        </div>
                                        <h4 class="page-title">Update Patient Prescription</h4>
                                    </div>
                                </div>
                            </div>     
                            <!-- end page title --> 
                            <!-- Form row -->
                            <div class="row">
                                <div class="col-12">
                                    <div class="card">
                                        <div class="card-body">
                                            <h4 class="header-title">Fill all fields</h4>
                                            <!--Add Patient Form-->
                                            <form method="post">
                                                <div class="form-row">

                                                    <div class="form-group col-md-6">
                                                        <label for="inputEmail4" class="col-form-label">Patient Name</label>
                                                        <input type="text" required="required" readonly name="pres_pat_name" value="<?php echo $row->Fname . " " . $row->Lname;?>" class="form-control" id="inputEmail4" placeholder="Patient's First Name">
                                                    </div>

                                                    <div class="form-group col-md-6">
                                                        <label for="inputPassword4" class="col-form-label">Patient Birthday</label>
                                                        <input required="required" type="text" readonly name="pres_pat_age" value="<?php echo date("d-m-Y",strtotime($row->DoB)) ;?>" class="form-control"  id="inputPassword4" placeholder="Patient`s Last Name">
                                                    </div>

                                                </div>

                                                <div class="form-row">
                                                    <div class="form-group col-md-6">
                                                        <label for="inputPassword4" class="col-form-label">Patient Address</label>
                                                        <input required="required" type="text" readonly name="pres_pat_addr" value="<?php echo $row->Address;?>" class="form-control"  id="inputPassword4" placeholder="Patient`s Age">
                                                    </div>

                                                    <div class="form-group col-md-6">
                                                        <label for="inputPassword4" class="col-form-label">Patient Type</label>
                                                        <input required="required" readonly type="text" name="pres_pat_type" value="Inpatient" class="form-control"  id="inputPassword4" placeholder="Patient`s Age">
                                                    </div>

                                                </div>

                                                <div class="form-row">
                                                    <div class="form-group col-md-4 ">
                                                        <label for="inputCity" class="col-form-label">Patient Ailment</label>
                                                        <input required="required" readonly type="text" value="<?php echo $row->Diagnosis;?>" name="pres_pat_ailment" class="form-control" id="inputCity">
                                                    </div>
                                                    <hr>

                                                    <div class="form-group col-md-4">
                                                        <label for="inputPassword4" class="col-form-label">Sickroom</label>
                                                        <input required="required" readonly type="text" value="<?php echo $row->SickRoom;?>" name="pres_pat_ailment" class="form-control" id="inputCity">
                                                    </div>

                                                    <div class="form-group col-md-4">
                                                        <label for="inputPassword4" class="col-form-label">Start Date</label>
                                                        <input required="required" readonly type="text" value="<?php echo date("d-m-Y",strtotime($row->StartDate)) ;?>" name="pres_pat_ailment" class="form-control" id="inputCity">
                                                    </div>

                                                </div>

                                                <div class="form-row">
                                                    <div class="form-group col-md-6">
                                                        <label for="inputCity" class="col-form-label">Result</label>
                                                        <select required="required"  type="text"  name="result" class="form-control" id="inputCity">
                                                            <option value="">Result</option>
                                                            <option value="Recovered">Recovered</option>
                                                            <option value="Have not recovered">Have not recovered</option>
                                                        </select>
                                                    </div>
                                                    <hr>

                                                    <div class="form-group col-md-6">
                                                        <label for="inputPassword4" class="col-form-label">Date Discharge</label>
                                                        <input required="required"  type="date" value="" name="discharge" class="form-control" id="inputCity">
                                                    </div>

                                                </div>


                                                



                                                <button type="submit" name="update_patient_presc" class="ladda-button btn btn-primary" data-style="expand-right">Update Patient Prescription</button>

                                            </form>
                                            <!--End Patient Form-->
                                        </div> <!-- end card-body -->
                                    </div> <!-- end card-->
                                </div> <!-- end col -->
                            </div>
                            <!-- end row -->

                        </div> <!-- container -->

                    </div> <!-- content -->

                    <!-- Footer Start -->
                    <?php include('assets/inc/footer.php');?>
                    <!-- end Footer -->

                </div>
            <?php }?>

            <!-- ============================================================== -->
            <!-- End Page content -->
            <!-- ============================================================== -->


        </div>
        <!-- END wrapper -->

       
        <!-- Right bar overlay-->
        <div class="rightbar-overlay"></div>
        <script src="//cdn.ckeditor.com/4.6.2/basic/ckeditor.js"></script>
        <script type="text/javascript">
        CKEDITOR.replace('editor')
        </script>

        <!-- Vendor js -->
        <script src="assets/js/vendor.min.js"></script>

        <!-- App js-->
        <script src="assets/js/app.min.js"></script>

        <!-- Loading buttons js -->
        <script src="assets/libs/ladda/spin.js"></script>
        <script src="assets/libs/ladda/ladda.js"></script>

        <!-- Buttons init js-->
        <script src="assets/js/pages/loading-btn.init.js"></script>
        
    </body>

</html>