<?php
  session_start();
  include('assets/inc/config.php');
  include('assets/inc/checklogin.php');
  require ('../../assets/dataProvider.php');
  check_login();
  $doc_id = $_SESSION['doc_id'];
?>
<!DOCTYPE html>
<html lang="en">
    
<?php include ('assets/inc/head.php');?>

    <body>

        <!-- Begin page -->
        <div id="wrapper">

            <!-- Topbar Start -->
            <?php include('assets/inc/nav.php');?>
            <!-- end Topbar -->

            <!-- ========== Left Sidebar Start ========== -->
                <?php include("assets/inc/sidebar.php");?>
            <!-- Left Sidebar End -->

            <!-- ============================================================== -->
            <!-- Start Page Content here -->
            <!-- ============================================================== -->
            <?php
                $pres_id = $_GET['pres_id'];
                $ret="SELECT  * FROM `treatment` T JOIN `inpatient` I ON I.IPCode = T.IPCode JOIN `patient` P ON P.PCode = I.PCode WHERE TreatCode = '".$pres_id."'";
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
                                                <li class="breadcrumb-item"><a href="javascript: void(0);">Pharmaceuticals</a></li>
                                                <li class="breadcrumb-item active">View Prescriptions</li>
                                            </ol>
                                        </div>
                                        <h4 class="page-title">#<?php echo $row->TreatCode;?></h4>
                                    </div>
                                </div>
                            </div>     
                            <!-- end page title --> 

                            <div class="row">
                                <div class="col-12">
                                    <div class="card-box">
                                        <div class="row">
                                            <div class="col-xl-5">

                                                <div class="tab-content pt-0">

                                                    <div class="tab-pane active show" id="product-1-item">
                                                        <img src="assets/images/users/patient.png" alt="" class="img-fluid mx-auto d-block rounded">
                                                    </div>
                            
                                                </div>
                                            </div> <!-- end col -->
                                            <div class="col-xl-7">
                                                <div class="pl-xl-3 mt-3 mt-xl-0">

                                                    <h2 class="mb-3">Name : <?php echo $row->Fname . " " . $row->Lname;?></h2>
                                                    <h4 class="text-primary "><b class="text-dark"> Patient Number : </b><?php echo $row->PCode;?></h4>
                                                    <hr>
                                                    <h4 class="text-primary"><b class="text-dark">Date Of Birth : </b> <?php echo date("d-m-Y",strtotime($row->DoB));?> </h4>
                                                    <hr>
                                                    <h4 class="text-primary "><b class="text-dark">Patient Category : </b>Inpatient</h4>
                                                    <hr>
                                                    <h4 class="text-primary"> <b class="text-dark">Admission Date : </b><?php echo date("d-m-Y",strtotime($row->DateAdmission));?> </h4>
                                                    <hr>
                                                    <h4 class="text-primary"> <b class="text-dark">Start Date : </b><?php echo date("d-m-Y",strtotime($row->StartDate));?> </h4>
                                                    <hr>
                                                    <h4 class="text-primary "><b class="text-dark">Diagnosis : </b><?php echo $row->Diagnosis;?></h4>
                                                    <hr>

                                                    <h4 class="text-primary "> <b class="text-dark">End Date: </b><?php
                                                        if($row->EndDate == "0000-00-00" || $row->EndDate == NULL)
                                                        {
                                                            echo "Unknown";
                                                        }else
                                                            echo date("d-m-Y",strtotime($row->EndDate));
                                                        ?></h4>
                                                    <hr>
                                                    <h4 class="text-primary "> <b class="text-dark">Discharge Date: </b><?php
                                                        if($row->DateDischarge == "0000-00-00" || $row->DateDischarge == NULL )
                                                        {
                                                            echo "Unknown";
                                                        }else
                                                            echo date("d-m-Y",strtotime($row->DateDischarge));
                                                        ?></h4>
                                                    <hr>
                                                    <?php if($row->Result == "Recovered")
                                                    {
                                                        $color = "green";
                                                    }elseif($row->Result == "Have not recovered")
                                                    {
                                                        $color = "red";
                                                    }else
                                                        $color = "orange"

                                                    ?>
                                                    <h4 class="" style="color:<?php echo $color;?>"><b class="text-dark"> Treatment Results : </b><?php
                                                        if( $row->Result == NULL)
                                                            echo "IS BEING TREATED";
                                                        else
                                                        {
                                                            $sql4 = "SELECT * FROM doctor WHERE ECode = '".$row->DECode."'";
                                                            $res4 = executeQuery($sql4);
                                                            $row4 = $res4->fetch_array();
                                                            echo $row->Result; ?></h4>

                                                    <p class="text-muted mt-2">
                                                        Confirmed by <?php echo $row4['Fname']." ".$row4['Lname']. "  -  " . $row->DECode ; ?>
                                                    </p>
                                                    <?php } ?>
                                                    <hr>

                                                    <h4 class="align-centre">Doctor</h4>

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

                                                    <h4 class="align-centre">Nurse</h4>
                                                    <?php
                                                    $sql3 = "SELECT * FROM `nurse` WHERE ECode = '".$row->NECode."'";
                                                    $res3 = executeQuery($sql3);
                                                    $row3 = $res3->fetch_array();
                                                    ?>
                                                    <p class="text-muted mt-2">
                                                        <?php echo ($row3['Fname']. " " . $row3['Lname']) . " - " . $row3['ECode']; ?>
                                                    </p>
                                                    <hr>

                                                    <h4 class="align-centre">Prescription</h4>

                                                   <!--
                                                    <form class="form-inline mb-4">
                                                        <label class="my-1 mr-2" for="quantityinput">Quantity</label>
                                                        <select class="custom-select my-1 mr-sm-3" id="quantityinput">
                                                            <option value="1">1</option>
                                                            <option value="2">2</option>
                                                            <option value="3">3</option>
                                                            <option value="4">4</option>
                                                            <option value="5">5</option>
                                                            <option value="6">6</option>
                                                            <option value="7">7</option>
                                                        </select>

                                                        <label class="my-1 mr-2" for="sizeinput">Size</label>
                                                        <select class="custom-select my-1 mr-sm-3" id="sizeinput">
                                                            <option selected>Small</option>
                                                            <option value="1">Medium</option>
                                                            <option value="2">Large</option>
                                                            <option value="3">X-large</option>
                                                        </select>
                                                    </form>

                                                    <div>
                                                        <button type="button" class="btn btn-danger mr-2"><i class="mdi mdi-heart-outline"></i></button>
                                                        <button type="button" class="btn btn-success waves-effect waves-light">
                                                            <span class="btn-label"><i class="mdi mdi-cart"></i></span>Add to cart
                                                        </button>
                                                    </div> -->
                                                </div>
                                            </div> <!-- end col -->
                                        </div>
                                        <!-- end row -->


                                        <div class="table-responsive mt-4">
                                            <table class="table table-bordered table-centered mb-0">
                                                <thead class="thead-light">
                                                    <tr>
                                                        <th>Medication</th>
                                                        <th>Price</th>
                                                        <th>Quantity</th>
                                                        <th>Total</th>
                                                    </tr>
                                                </thead>
                                                <tbody>
                                                <?php
                                                $sql = "SELECT * FROM `treat_use` T JOIN `medication` M ON T.MCode = M.MCode WHERE T.TreatCode = '".$pres_id."'";
                                                $result = executeQuery($sql);
                                                while($row1 = $result-> fetch_array())
                                                {
                                                ?>

                                                    <tr>
                                                        <td><?php echo $row1['Name'] ?></td>
                                                        <td><?php echo $row1['price'] ?></td>
                                                        <td>
                                                            <?php echo $row1['quantity'] ?>
                                                        </td>
                                                        <td> $<?php echo ($row1['quantity']*$row1['price']) ?></td>
                                                    </tr>
                                                <?php }
                                                $sql1 = "SELECT * FROM `treatment` WHERE `TreatCode` = '".$pres_id."'";
                                                $res1 = executeQuery($sql1);
                                                $row2 = $res1->fetch_array();

                                                ?>

                                                    <tr>
                                                        <td colspan="3"><h2>Total: </h2></td>

                                                        <td><h2>$<?php echo $row2['Fee'] ?></h2></td>
                                                    </tr>
                                                </tbody>
                                            </table>
                                        </div>

                                    </div> <!-- end card-->
                                </div> <!-- end col-->
                            </div>
                            <!-- end row-->
                            
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

        <!-- Vendor js -->
        <script src="assets/js/vendor.min.js"></script>

        <!-- App js -->
        <script src="assets/js/app.min.js"></script>
        
    </body>

</html>