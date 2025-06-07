<?php
	session_start();
	include('assets/inc/config.php');
    require('../../assets/dataProvider.php');
    date_default_timezone_set('Asia/Ho_Chi_Minh');

		if(isset($_POST['add_patient_presc']))
		{



			$pres_pat_number = $_POST['pres_pat_number'];
            $pres_pat_type = $_POST['pres_pat_type'];
            $pres_number = $_POST['pres_number'];
            $pres_pat_ailment = $_POST['pres_pat_ailment'];
            $fee = 500;
            $flag = false;
            $nurse = $_POST['nurse'];
            $sickroom = $_POST['sickroom'];
            $start = $_POST['start'];
            //get doctor

            $doctor = $_POST['doctor'];
            $doc = array();
            for($i = 0; $i < count($doctor); $i++)
            {
                if(!in_array($doctor[$i],$doc))
                {
                    $doc[] = $doctor[$i];
                }
            }

            //insert patient

            $sql = "SELECT * FROM `inpatient` WHERE `PCode` = '".$pres_pat_number."'";
            $result = executeQuery($sql);
            if($result->num_rows == 0)
            {
                $sql = "SELECT * FROM `inpatient` ORDER BY IPCode DESC";
                $result = executeQuery($sql);
                if($result->num_rows == 0)
                {
                    $id = "IP000000001";
                }else
                {
                    $row = $result -> fetch_array();
                    $max =  (int)substr($row['IPCode'],2);
                    while($row = $result -> fetch_array())
                    {
                        if($max < (int)substr($row['IPCode'],2) )
                            $max = (int)substr($row['IPCode'],2);
                    }

                    $id = (int)$max + 1;

                    $temp = (9-(strlen((string)$id)));
                    for($i = 0; $i < $temp; $i++)
                    {
                        (string)$id = '0'.$id;

                    }
                    $id = "IP".$id;
                }

                $sql = "insert into inpatient (IPCode,PCode) values ('$id', '".$pres_pat_number."')";
                $result = executeQuery($sql);
                $IPCode = $id;
            }else
            {
                $row = $result->fetch_array();
                $IPCode = $row['IPCode'];

            }

            //get medical

            if(isset($_POST['medical']))
            {
                $flag = true;
                $medication = $_POST['medical'];
                $quantity = $_POST['quantity'];

                $quan = array();
                $med = array();


                for($i = 0; $i < count($medication); $i++)
                {
                    if(!in_array($medication[$i],$med))
                    {
                        $med[] = $medication[$i];
                        $quan[] = 0;
                    }
                }

                for($i = 0; $i < count($med); $i++)
                {
                    for($j = 0; $j < count($medication); $j++)
                    {
                        if($medication[$j] == $med[$i])
                        {
                            $quan[$i] += $quantity[$j];
                        }
                    }

                }


                //total fee

                for($i = 0; $i < count($med); $i++)
                {
                    $sql3 = "SELECT * FROM `medication` WHERE MCODE = '".$med[$i]."'";
                    $result3 = executeQuery($sql3);
                    $row3 = $result3-> fetch_array();
                    $price = $row3['Price'];
                    $fee+= ($price*$quan[$i]);
                }
            }



            //insert treatment medical

            $sql5 = "INSERT INTO `treatment` (`TreatCode`,`Diagnosis`, `DateAdmission`, `StartDate`, `EndDate`,  `DateDischarge`, `Result`,  `Sickroom`, `Fee`,`IPCode`, `DECode`,`NECode` ) VALUES ('".$pres_number."','".$pres_pat_ailment."','".date("Y-m-d H:i:s")."','".date("Y-m-d",strtotime($start))."',NULL,NULL,NULL,'".$sickroom."','".$fee."','".$IPCode."',NULL,'".$nurse."')";
            $result4 = executeQuery($sql5);
            for($i = 0; $i < count($doc); $i++)
            {

                $sql4 = "INSERT INTO `cure` (`TreatCode`, `DECode`) VALUES ('".$pres_number."', '".$doc[$i]."')";
                executeQuery($sql4);
            }

            if($flag)
            {
                for($i = 0; $i < count($med); $i++)
                {
                    $sql3 = "SELECT * FROM `medication` WHERE MCODE = '".$med[$i]."'";
                    $result3 = executeQuery($sql3);
                    $row3 = $result3-> fetch_array();
                    $price = $row3['Price'];
                    $sql4 = "INSERT INTO `treat_use` (`TreatCode`, `MCode`, `quantity`, `price`) VALUES ('".$pres_number."', '".$med[$i]."', '".$quan[$i]."', '".$price."')";
                    executeQuery($sql4);
                }
            }






            //sql to insert captured values

			/*
			*Use Sweet Alerts Instead Of This Fucked Up Javascript Alerts
			*echo"<script>alert('Successfully Created Account Proceed To Log In ');</script>";
			*/ 
			//declare a varible which will be passed to alert function
			if($result4)
			{
				$success = "Patient Treatment Addded";
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
                $pat_number = $_GET['pat_number'];
                $ret="SELECT  * FROM patient WHERE PCode =" . "'" . $pat_number . "'" ;

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
                                                <li class="breadcrumb-item active">Add Prescription</li>
                                            </ol>
                                        </div>
                                        <h4 class="page-title">Add Patient Prescription</h4>
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
                                            <form method="post" >
                                                <div class="form-row">

                                                    <div class="form-group col-md-6">
                                                        <label for="inputEmail4" class="col-form-label">Patient Name</label>
                                                        <input type="text" required="required" readonly name="pres_pat_name" value="<?php echo $row->Fname;?> <?php echo $row->Lname;?>" class="form-control" id="inputEmail4" placeholder="Patient's First Name">
                                                    </div>

                                                    <div class="form-group col-md-6">
                                                        <label for="inputPassword4" class="col-form-label">Patient Date of birth</label>
                                                        <input required="required" type="text" readonly name="pres_pat_age" value="<?php echo date('d-m-Y', strtotime($row->DoB)) ;?>" class="form-control"  id="inputPassword4" placeholder="Patient`s Last Name">
                                                    </div>

                                                </div>

                                                <div class="form-row">

                                                    <div class="form-group col-md-4">
                                                        <label for="inputEmail4" class="col-form-label">Patient Number</label>
                                                        <input type="text" required="required" readonly name="pres_pat_number" value="<?php echo $row->PCode;?>" class="form-control" id="inputEmail4" placeholder="DD/MM/YYYY">
                                                    </div>

                                                    <div class="form-group col-md-4">
                                                        <label for="inputPassword4" class="col-form-label">Patient Address</label>
                                                        <input required="required" type="text" readonly name="pres_pat_addr" value="<?php echo $row->Address;?>" class="form-control"  id="inputPassword4" placeholder="Patient`s Age">
                                                    </div>

                                                    <div class="form-group col-md-4">
                                                        <label for="inputPassword4" class="col-form-label">Patient Type</label>
                                                        <input required="required" readonly type="text" name="pres_pat_type" value="Outpatient" class="form-control"  id="inputPassword4" placeholder="Patient`s Age">
                                                    </div>

                                                </div>
                                                <div class="form-row">
                                                    <div class="form-group col-md-6 ">
                                                        <label for="inputCity" class="col-form-label">Phone Number</label>
                                                        <input required="required" readonly type="text" value="<?php echo $row->Phone;?>" name="pres_pat_ailment" class="form-control" id="inputCity">
                                                    </div>

                                                    <div class="form-group col-md-6 ">
                                                        <label for="inputCity" class="col-form-label">Gender</label>
                                                        <input required="required" readonly type="text" value="<?php echo $row->Gender;?>" name="pres_pat_ailment" class="form-control" id="inputCity">
                                                    </div>


                                                </div>

                                                <div class="form-row">
                                                    <div class="form-group col-md-4 ">
                                                        <label for="inputCity" class="col-form-label">Patient's Diagnosis</label>
                                                        <input required="required" type="text" value="" name="pres_pat_ailment" class="form-control" id="inputCity" placeholder="Diagnosis">
                                                    </div>
                                                    <div class="form-group col-md-4">
                                                        <label for="inputPassword4" class="col-form-label">Sickroom
                                                        </label>
                                                        <input type="text"  name="sickroom" value="" class="form-control"  id="inputPassword4" placeholder="Sickroom">
                                                    </div>
                                                    <div class="form-group col-md-4">
                                                        <label for="inputPassword4" class="col-form-label">Start Date
                                                        </label>
                                                        <input type="date"  name="start" value="" class="form-control"  id="inputPassword4" placeholder="Start Date">
                                                    </div>
                                                </div>


                                                <hr>
                                                <div class="form-row">
                                                    
                                            
                                                    <div class="form-group col-md-2" style="display:none">

                                                        <label for="inputZip" class="col-form-label">Prescription Number</label>
                                                        <input type="text" name="pres_number" value="<?php
                                                        $sql2 = "SELECT * FROM `treatment` ORDER BY TreatCode DESC";
                                                        $result2 = executeQuery($sql2);
                                                        $pres_no = "T000000001";
                                                        if($result2->num_rows > 0)
                                                        {
                                                            $row2 = $result2 -> fetch_array();
                                                            $max = (int)substr($row2['TreatCode'],1);
                                                            while($row2 = $result2 -> fetch_array())
                                                            {
                                                                if($max <= (int)substr($row2['TreatCode'],2))
                                                                    $max = (int)substr($row2['TreatCode'],2);
                                                            }

                                                            $id = (int)$max + 1;
                                                            $temp = (9-(strlen((string)$id)));
                                                            for($i = 0; $i < $temp; $i++)
                                                            {
                                                                (string)$id = '0'.$id;
                                                            }
                                                            $pres_no = "T" . $id;
                                                        }

                                                        echo $pres_no;?>" class="form-control" id="inputZip">
                                                    </div>
                                                </div>

                                                <div class="form-group">
                                                    <label for="inputAddress" class="col-form-label"><h3>Doctor</h3></label>
                                                    <br>
                                                    <input id="adddoc" type="button" value="Add Doctor" name="addMed" class="ladda-button btn btn-primary" data-style="expand-right" onclick="addMed()">
                                                    <hr>

                                                    <div>
                                                        <table id="doctor" width="100%">
                                                            <tr>
                                                                <th style="width: 70%">
                                                                    Doctor
                                                                </th>
                                                            </tr>
                                                            <tr>
                                                                <td style="width: 100%">
                                                                    <select  style="width: 65%" id="inputGender" required="required" name="doctor[]" class="form-control">
                                                                        <?php
                                                                        $sql1 = "SELECT * FROM `doctor`";
                                                                        $res1 = executeQuery($sql1);
                                                                        while($row1 = $res1 -> fetch_array())
                                                                        {
                                                                            echo '<option value="'.$row1['ECode'].'">'.$row1['Fname']." ". $row1['Lname'].' - '. $row1['ECode'] .'</option>';
                                                                        }
                                                                        ?>
                                                                    </select>
                                                                </td>
                                                            </tr>
                                                        </table>


                                                    </div>
                                                </div>

                                                <div class="form-group">
                                                    <label for="inputAddress" class="col-form-label"><h3>Nurse</h3></label>


                                                    <div>
                                                        <table id="nurse" width="100%">
                                                            <tr>
                                                                <th style="width: 70%">
                                                                    Nurse
                                                                </th>
                                                            </tr>
                                                            <tr>
                                                                <td style="width: 100%">
                                                                    <select  style="width: 65%" id="inputGender" required="required" name="nurse" class="form-control">
                                                                        <?php
                                                                        $sql1 = "SELECT * FROM `nurse`";
                                                                        $res1 = executeQuery($sql1);
                                                                        while($row1 = $res1 -> fetch_array())
                                                                        {
                                                                            echo '<option value="'.$row1['ECode'].'">'.$row1['Fname']." ". $row1['Lname'].' - '. $row1['ECode'] .'</option>';
                                                                        }
                                                                        ?>
                                                                    </select>
                                                                </td>
                                                            </tr>
                                                        </table>


                                                    </div>
                                                </div>

                                                <div class="form-group">
                                                    <label for="inputAddress" class="col-form-label"><h3>Prescription</h3></label>
                                                    <br>
                                                    <input id="addmed" type="button" value="Add Medication" name="addMed" class="ladda-button btn btn-primary" data-style="expand-right"">


                                                    <div>
                                                        <table id="medication">
                                                            <tr>
                                                                <th style="width: 70%">
                                                                    Medication
                                                                </th>
                                                                <th>
                                                                    Quantity
                                                                </th>
                                                            </tr>


                                                            <tr>
                                                                <td style="width: 70%">
                                                                    <select  style="width: 65%" id="inputGender" required="required" name="medical[]" class="form-control">
                                                                        <?php
                                                                        $sql1 = "SELECT * FROM `medication`";
                                                                        $res1 = executeQuery($sql1);
                                                                        while($row1 = $res1 -> fetch_array())
                                                                        {
                                                                            echo '<option value="'.$row1['MCode'].'">'.$row1['Name'].' - $'. $row1['Price'] .'</option>';
                                                                        }
                                                                        ?>

                                                                    </select>
                                                                </td>
                                                                <td>
                                                                    <input required="required" type="number" value=""  name="quantity[]" class="form-control">

                                                                </td>
                                                                <td>
                                                                    <input type="button" name="delMed" value="remove" class="remove ladda-button btn btn-danger" data-style="expand-right" >
                                                                </td>
                                                            </tr>
                                                        </table>

                                                        <div class="form-row">

                                                            <div class="form-group col-md-12" id="total">
                                                               <h3>Total: </h3>
                                                            </div>

                                                        </div>
                                                    </div>
                                                </div>

                                                <button type="submit" name="add_patient_presc" class="ladda-button btn btn-primary" data-style="expand-right">Add Patient Prescription</button>

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
        <script>
            $(document).ready(function (){
                $("#addmed").click(function (e){
                    e.preventDefault();
                    $("#medication").append(`  <tr>
                                                                    <td style="width: 70%">
                                                                        <select  style="width: 65%" id="inputGender" required="required" name="medical[]" class="form-control">
                                                                        <?php
                    $sql1 = "SELECT * FROM medication";
                    $res1 = executeQuery($sql1);
                    while($row1 = $res1 -> fetch_array())
                    {
                        echo '<option value="'.$row1['MCode'].'">'.$row1['Name'].' - $'. $row1['Price'] .'</option>';
                    }
                    ?>

                                                                    </select>
                                                                    </td>
                                                                    <td>
                                                                        <input required="required" type="number" value=""  name="quantity[]" class="form-control">
                                                                    </td>
                                                                    <td>
                                                                    <input type="button" name="delMed" value="remove" class="remove ladda-button btn btn-danger" data-style="expand-right" >
                                                                    </td>
                                                                </tr>`,);
                })
            })

            $(document).on('click', '.remove', function (e) {
                e.preventDefault();
                let row_item = $(this).parent().parent();
                row_item.remove();
            })

            $(document).ready(function (){
                $("#adddoc").click(function (e){
                    e.preventDefault();
                    $("#doctor").append(` <hr><tr>
                                                                <td style="width: 100%">
                                                                    <select  style="width: 65%" id="inputGender" required="required" name="doctor[]" class="form-control">
                                                                        <?php
                    $sql1 = "SELECT * FROM doctor";
                    $res1 = executeQuery($sql1);
                    while($row1 = $res1 -> fetch_array())
                    {
                        echo '<option value="'.$row1['ECode'].'">'.$row1['Fname']." ". $row1['Lname'].' - '. $row1['ECode'] .'</option>';
                    }
                    ?>
                                                                    </select>
                                                                </td>
                                                            </tr> `,);
                })
            })

            $(document).on('click', '.remove', function (e) {
                e.preventDefault();
                let row_item = $(this).parent().parent();
                row_item.remove();
            })
        </script>

        
    </body>



</html>