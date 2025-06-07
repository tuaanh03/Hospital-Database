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
                $ret="SELECT  * FROM `examination` E JOIN `outpatient` O ON E.OPCode = O.OPCode JOIN `patient` P ON P.PCode = O.PCode  WHERE ExamCode = '".$pres_id."'";
                $res = executeQuery($ret);
                //$cnt=1;
                while($row=$res->fetch_object())
                {
                    $sql = "SELECT * FROM `doctor` WHERE `ECode` = '".$row->DECode."'";
                    $res1 = executeQuery($sql);
                    $row1 = $res1->fetch_array();

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
                                        <h4 class="page-title">#<?php echo $row->ExamCode;?></h4>
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
                                                    <hr>
                                                    <h4 class="text-primary "><b class="text-dark"> Patient Number : </b><?php echo $row->PCode;?></h4>
                                                    <hr>
                                                    <h4 class="text-primary "><b class="text-dark"> Patient ID : </b><?php echo $row->OPCode;?></h4>
                                                    <hr>
                                                    <h4 class="text-primary"><b class="text-dark">Date Of Birth : </b> <?php echo date("d-m-Y",strtotime($row->DoB));?> </h4>
                                                    <hr>
                                                    <h4 class="text-primary "><b class="text-dark">Patient Category : </b>Outpatient</h4>
                                                    <hr>
                                                    <h4 class="text-primary"> <b class="text-dark">Examination Date :</b><?php echo date("d-m-Y",strtotime($row->ExamDate));?> </h4>
                                                    <hr>

                                                    <h4 class="text-primary "><b class="text-dark">Diagnosis : </b><?php echo $row->Diagnosis;?></h4>
                                                    <hr>
                                                    <h4 class="text-primary"> <b class="text-dark">Date of Re-examination : </b><?php
                                                        if($row->NextExDate == "0000-00-00")
                                                        {
                                                            echo "NO";
                                                        }else
                                                            echo date("d-m-Y",strtotime($row->NextExDate));
                                                        ?> </h4>
                                                    <hr>
                                                    <h4 class="text-primary"> <b class="text-dark">Examination Date :</b><?php echo $row1['Fname'] . " " . $row1['Lname'] . " - ". $row->DECode;?> </h4>
                                                    <hr>

                                                    <h2 class="align-centre">Prescription</h2>


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
                                                $sql = "SELECT * FROM `exam_use` E JOIN `medication` M ON E.MCode = M.MCode WHERE E.ExamCode = '".$pres_id."'";
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
                                                $sql1 = "SELECT * FROM `examination` WHERE `ExamCode` = '".$pres_id."'";
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