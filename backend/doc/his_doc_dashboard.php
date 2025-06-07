<?php
  session_start();
  include('assets/inc/config.php');
  include('assets/inc/checklogin.php');
  check_login();
  $doc_id=$_SESSION['doc_id'];
require ('../../assets/dataProvider.php');

$rowsPerPage = 50;
$pageNum = 1;
$self ="his_doc_dashboard.php";
$root = "his_doc_dashboard.php";


if(isset($_GET["page"])){
    $pageNum = $_GET["page"];

}
$offset = ($pageNum - 1) * $rowsPerPage;

?>
<!DOCTYPE html>
<html lang="en">

    <!--Head Code-->
    <?php include("assets/inc/head.php");?>

    <body>

        <!-- Begin page -->
        <div id="wrapper">

            <!-- Topbar Start -->
            <?php include('assets/inc/nav.php');?>
            <!-- end Topbar -->

            <!-- ========== Left Sidebar Start ========== -->
            <?php include('assets/inc/sidebar.php');?>
            <!-- Left Sidebar End -->

            <!-- ============================================================== -->
            <!-- Start Page Content here -->
            <!-- ============================================================== -->

            <div class="content-page">
                <div class="content">

                    <!-- Start Content-->
                    <div class="container-fluid">
                        
                        <!-- start page title -->
                        <div class="row">
                            <div class="col-12">
                                <div class="page-title-box">
                                    
                                    <h4 class="page-title">Hospital Management Information System Dashboard</h4>
                                </div>
                            </div>
                        </div>     
                        <!-- end page title --> 
                        

                        <div class="row">
                            <!--Start OutPatients-->
                            <div class="col-md-6 col-xl-4">
                                <div class="widget-rounded-circle card-box">
                                    <div class="row">
                                        <div class="col-6">
                                            <div class="avatar-lg rounded-circle bg-soft-danger border-danger border">
                                                <i class="fab fa-accessible-icon  font-22 avatar-title text-danger"></i>
                                            </div>
                                        </div>
                                        <div class="col-6">
                                            <div class="text-right">
                                                <?php
                                                    //code for summing up number of out patients 
                                                    $result ="SELECT count(*) AS 'number' FROM `patient`  ";
                                                    $res = executeQuery($result);
                                                    $row = $res->fetch_array();

                                                ?>
                                                <h3 class="text-dark mt-1"><span data-plugin="counterup"><?php echo $row['number'];?></span></h3>
                                                <p class="text-muted mb-1 text-truncate">Patients</p>
                                            </div>
                                        </div>
                                    </div> <!-- end row-->
                                </div> <!-- end widget-rounded-circle-->
                            </div> <!-- end col-->
                            <!--End Out Patients-->


                            <!--Start InPatients-->
                            <div class="col-md-6 col-xl-4">
                                <div class="widget-rounded-circle card-box">
                                    <div class="row">
                                        <div class="col-6">
                                            <div class="avatar-lg rounded-circle bg-soft-danger border-danger border">
                                                <i class="mdi mdi-flask font-22 avatar-title text-danger"></i>
                                            </div>
                                        </div>
                                        <div class="col-6">
                                            <div class="text-right">
                                                <?php
                                                    /* 
                                                     * code for summing up number of assets,
                                                     */ 
                                                    $result ="SELECT count(*) AS 'number' FROM doctor ";
                                                $res = executeQuery($result);
                                                $row = $res->fetch_array();
                                                ?>

                                                <h3 class="text-dark mt-1"><span data-plugin="counterup"><?php echo $row['number'];?></span></h3>
                                                <p class="text-muted mb-1 text-truncate">Doctors</p>
                                            </div>
                                        </div>
                                    </div> <!-- end row-->
                                </div> <!-- end widget-rounded-circle-->
                            </div>
                            <!--End InPatients-->

                            <!--Start Pharmaceuticals-->
                            <div class="col-md-6 col-xl-4">
                                <div class="widget-rounded-circle card-box">
                                    <div class="row">
                                        <div class="col-6">
                                            <div class="avatar-lg rounded-circle bg-soft-danger border-danger border">
                                                <i class="mdi mdi-pill font-22 avatar-title text-danger"></i>
                                            </div>
                                        </div>
                                        <div class="col-6">
                                            <div class="text-right">
                                                <?php
                                                    /* 
                                                     * code for summing up number of pharmaceuticals,
                                                     */
                                                $result ="SELECT count(*) AS 'number' FROM medication ";
                                                $res = executeQuery($result);
                                                $row = $res->fetch_array();

                                                ?>
                                                <h3 class="text-dark mt-1"><span data-plugin="counterup"><?php echo $row['number'] ;?></span></h3>
                                                <p class="text-muted mb-1 text-truncate">Pharmaceuticals</p>
                                            </div>
                                        </div>
                                    </div> <!-- end row-->
                                </div> <!-- end widget-rounded-circle-->
                            </div> <!-- end col-->
                            <!--End Pharmaceuticals-->
                        
                        </div>


                        

                        
                        <!--Recently Employed Employees-->
                        <div class="row">
                            <div class="col-xl-12">
                                <div class="card-box">
                                    <h4 class="header-title mb-3">Patients</h4>

                                    <div class="table-responsive">
                                        <table class="table table-borderless table-hover table-centered m-0">

                                            <thead class="thead-light">
                                                <tr>
                                                    <th>Name</th>
                                                    <th>Address</th>
                                                    <th>Mobile Phone</th>

                                                    <th>Birthday</th>
                                                    <th>Action</th>
                                                </tr>
                                            </thead>
                                            <?php
                                                $ret="SELECT * FROM `patient`";
                                                $sql1 = $ret;
                                                $ret .= " LIMIT $offset, $rowsPerPage";

                                                //sql code to get to ten docs  randomly
                                                $res = executeQuery($ret);
                                                $cnt=1;
                                                while($row=$res->fetch_object())
                                                {
                                            ?>
                                            <tbody>
                                                <tr>
                                                    
                                                    <td>
                                                        <?php echo $row->Fname;?> <?php echo $row->Lname;?>
                                                    </td>
                                                    <td>
                                                        <?php echo $row->Address;?>
                                                    </td>    
                                                    <td>
                                                        <?php echo $row->Phone;?>
                                                    </td>


                                                    <td>
                                                        <?php echo date("d-m-Y",strtotime($row->DoB));?>
                                                    </td>
                                                    <td>
                                                        <a href="view_single_patient.php?pat_id=<?php echo $row->PCode;?>" class="btn btn-xs btn-success"><i class="mdi mdi-eye"></i> View</a>
                                                    </td>                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                   
                                                </tr>
                                            </tbody>
                                            <?php }?>

                                            <tfoot>
                                            <tr class="active">
                                                <td colspan="5" >
                                                    <div class="text-right">
                                                        <ul style="list-style-type: none" class="pagination-rounded justify-content-c footable-pagination m-t-10 mb-0">
                                                            <?php

                                                            $result1 = ExecuteQuery($sql1);


                                                            $numrows = $result1->num_rows;
                                                            if($numrows > 0){

                                                                $maxPage = ceil($numrows / $rowsPerPage);

                                                                $gap = 5;
                                                                $start = $pageNum - $gap;
                                                                $end = $pageNum + $gap;
                                                                if($start <= 0)
                                                                    $start = 1;
                                                                if($end >= $maxPage)
                                                                    $end = $maxPage;


                                                                $nav = '';

                                                                if($start > 1)
                                                                {
                                                                    $nav = $nav . ' <li class="footable-page"><a href="'.$self.'?page=1">1</a></li>';
                                                                    $nav = $nav . ' <li class="footable-page disable"><span>...</span></li>';
                                                                }

                                                                for($page = $start; $page <= $end; $page++){
                                                                    if($page == $pageNum)
                                                                    {
                                                                        $nav = $nav. '<li class="footable-page active"><a >'.$pageNum.'</a></li>';
                                                                    }
                                                                    else{
                                                                        $nav = $nav . ' <li class="footable-page"><a href="'.$self.'?page='.$page.'">'.$page.'</a></li>';
                                                                    }
                                                                }

                                                                if($end < $maxPage)
                                                                {
                                                                    $nav = $nav . ' <li class="footable-page"><span>...</span></li>';
                                                                    $nav = $nav . ' <li class="footable-page"><a href="'.$self.'?page='.$maxPage.'">'.$maxPage.'</a></li>';
                                                                }



                                                                if($pageNum > 1){
                                                                    $page = $pageNum - 1;
                                                                    $prev = '<li><a href="'.$self.'?page='.$page.'" aria-label="Previous">&lt;</a></li>';
                                                                    $first = '<li><a href="'.$self.'?page=1" aria-label="Previous">&laquo;</a></li>';
                                                                }else
                                                                {
                                                                    $prev = '<li style="display: none"><a href="'.$self.'?page='.$page.'" aria-label="Previous">&lt;</a></li>';
                                                                    $first = '<li style="display: none;"><a href="'.$self.'?page=1" aria-label="Previous">&laquo;</a></li>';
                                                                }

                                                                if($pageNum < $maxPage){
                                                                    $page = $pageNum + 1;
                                                                    $next = '<li><a href="'.$self.'?page='.$page.'" aria-label="Next">&gt;</a></li>';
                                                                    $last = '<li><a href="'.$self.'?page='.$maxPage.'" aria-label="Next">&raquo;</a></li>';
                                                                }else
                                                                {
                                                                    $next = '';
                                                                    $last = '';
                                                                }
                                                                echo $prev . $nav . $next ;
                                                            }



                                                            ?>
                                                        </ul>
                                                    </div>
                                                </td>
                                            </tr>
                                            </tfoot>
                                        </table>
                                    </div>
                                </div>
                            </div> <!-- end col -->                                                                                                                                                                                                                                         
                        </div>
                        <!-- end row -->
                        
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

        <!-- Right Sidebar -->
        <div class="right-bar">
            <div class="rightbar-title">
                <a href="javascript:void(0);" class="right-bar-toggle float-right">
                    <i class="dripicons-cross noti-icon"></i>
                </a>
                <h5 class="m-0 text-white">Settings</h5>
            </div>
            <div class="slimscroll-menu">
                <!-- User box -->
                <div class="user-box">
                    <div class="user-img">
                        <img src="assets/images/users/user-1.jpg" alt="user-img" title="Mat Helme" class="rounded-circle img-fluid">
                        <a href="javascript:void(0);" class="user-edit"><i class="mdi mdi-pencil"></i></a>
                    </div>
            
                    <h5><a href="javascript: void(0);">Geneva Kennedy</a> </h5>
                    <p class="text-muted mb-0"><small>Admin Head</small></p>
                </div>

                <!-- Settings -->
                <hr class="mt-0" />
                <h5 class="pl-3">Basic Settings</h5>
                <hr class="mb-0" />

                <div class="p-3">
                    <div class="checkbox checkbox-primary mb-2">
                        <input id="Rcheckbox1" type="checkbox" checked>
                        <label for="Rcheckbox1">
                            Notifications
                        </label>
                    </div>
                    <div class="checkbox checkbox-primary mb-2">
                        <input id="Rcheckbox2" type="checkbox" checked>
                        <label for="Rcheckbox2">
                            API Access
                        </label>
                    </div>
                    <div class="checkbox checkbox-primary mb-2">
                        <input id="Rcheckbox3" type="checkbox">
                        <label for="Rcheckbox3">
                            Auto Updates
                        </label>
                    </div>
                    <div class="checkbox checkbox-primary mb-2">
                        <input id="Rcheckbox4" type="checkbox" checked>
                        <label for="Rcheckbox4">
                            Online Status
                        </label>
                    </div>
                    <div class="checkbox checkbox-primary mb-0">
                        <input id="Rcheckbox5" type="checkbox" checked>
                        <label for="Rcheckbox5">
                            Auto Payout
                        </label>
                    </div>
                </div>

                <!-- Timeline -->
                <hr class="mt-0" />
                <h5 class="px-3">Messages <span class="float-right badge badge-pill badge-danger">25</span></h5>
                <hr class="mb-0" />
                <div class="p-3">
                    <div class="inbox-widget">
                        <div class="inbox-item">
                            <div class="inbox-item-img"><img src="assets/images/users/user-2.jpg" class="rounded-circle" alt=""></div>
                            <p class="inbox-item-author"><a href="javascript: void(0);" class="text-dark">Tomaslau</a></p>
                            <p class="inbox-item-text">I've finished it! See you so...</p>
                        </div>
                        <div class="inbox-item">
                            <div class="inbox-item-img"><img src="assets/images/users/user-3.jpg" class="rounded-circle" alt=""></div>
                            <p class="inbox-item-author"><a href="javascript: void(0);" class="text-dark">Stillnotdavid</a></p>
                            <p class="inbox-item-text">This theme is awesome!</p>
                        </div>
                        <div class="inbox-item">
                            <div class="inbox-item-img"><img src="assets/images/users/user-4.jpg" class="rounded-circle" alt=""></div>
                            <p class="inbox-item-author"><a href="javascript: void(0);" class="text-dark">Kurafire</a></p>
                            <p class="inbox-item-text">Nice to meet you</p>
                        </div>

                        <div class="inbox-item">
                            <div class="inbox-item-img"><img src="assets/images/users/user-5.jpg" class="rounded-circle" alt=""></div>
                            <p class="inbox-item-author"><a href="javascript: void(0);" class="text-dark">Shahedk</a></p>
                            <p class="inbox-item-text">Hey! there I'm available...</p>
                        </div>
                        <div class="inbox-item">
                            <div class="inbox-item-img"><img src="assets/images/users/user-6.jpg" class="rounded-circle" alt=""></div>
                            <p class="inbox-item-author"><a href="javascript: void(0);" class="text-dark">Adhamdannaway</a></p>
                            <p class="inbox-item-text">This theme is awesome!</p>
                        </div>
                    </div> <!-- end inbox-widget -->
                </div> <!-- end .p-3-->

            </div> <!-- end slimscroll-menu-->
        </div>
        <!-- /Right-bar -->

        <!-- Right bar overlay-->
        <div class="rightbar-overlay"></div>

        <!-- Vendor js -->
        <script src="assets/js/vendor.min.js"></script>

        <!-- Plugins js-->
        <script src="assets/libs/flatpickr/flatpickr.min.js"></script>
        <script src="assets/libs/jquery-knob/jquery.knob.min.js"></script>
        <script src="assets/libs/jquery-sparkline/jquery.sparkline.min.js"></script>
        <script src="assets/libs/flot-charts/jquery.flot.js"></script>
        <script src="assets/libs/flot-charts/jquery.flot.time.js"></script>
        <script src="assets/libs/flot-charts/jquery.flot.tooltip.min.js"></script>
        <script src="assets/libs/flot-charts/jquery.flot.selection.js"></script>
        <script src="assets/libs/flot-charts/jquery.flot.crosshair.js"></script>

        <!-- Dashboar 1 init js-->
        <script src="assets/js/pages/dashboard-1.init.js"></script>

        <!-- App js-->
        <script src="assets/js/app.min.js"></script>
        
    </body>

</html>