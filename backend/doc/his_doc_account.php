
<?php
  session_start();
  require("../../assets/dataProvider.php");
  include('assets/inc/config.php');
  include('assets/inc/checklogin.php');
  check_login();
  $doc_id = $_SESSION['doc_id'];
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
                $doc_number=$_SESSION['doc_number'];
                $ret="SELECT  * FROM doctor WHERE ECode= '".$doc_id."' ";
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
                                            <li class="breadcrumb-item"><a href="javascript: void(0);">Profile</a></li>
                                            <li class="breadcrumb-item active">View My Profile</li>
                                        </ol>
                                    </div>
                                    <h4 class="page-title"><?php echo $row->Fname;?> <?php echo $row->Lname;?>'s Profile</h4>
                                </div>
                            </div>
                        </div>
                        <!-- end page title -->

                        <div class="row">
                            <div class="col-lg-6 col-xl-6">
                                <div class="card-box text-center">
                                    <img src="../doc/assets/images/users/doc-icon.png" class="rounded-circle avatar-lg img-thumbnail"
                                         alt="profile-image">

                                    
                                    <div class="text-centre mt-3">
                                        
                                        <p class="text-muted mb-2 font-13"><strong>Employee Full Name :</strong> <span class="ml-2"><?php echo $row->Fname;?> <?php echo $row->Lname;?></span></p>
                                       <p class="text-muted mb-2 font-13"><strong>Employee Department :</strong> <span class="ml-2"><?php echo $row->DCode;?></span></p>
                                        <p class="text-muted mb-2 font-13"><strong>Employee Number :</strong> <span class="ml-2"><?php echo $row->Phone;?></span></p>
                                        <p class="text-muted mb-2 font-13"><strong>Employee Email :</strong> <span class="ml-2"><?php echo $row->Address;?></span></p>


                                    </div>

                                </div> <!-- end card-box -->

                            </div> <!-- end col-->
                            <!--Vitals-->

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