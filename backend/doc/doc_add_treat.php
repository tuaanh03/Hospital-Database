<?php
  session_start();
  include('assets/inc/config.php');
  include('assets/inc/checklogin.php');
  check_login();
  $doc_id = $_SESSION['doc_id'];
  require('../../assets/dataProvider.php');

$rowsPerPage = 50;
$pageNum = 1;
$self ="manage_patient.php";
$root = "manage_patient.php";


if(isset($_GET["page"])){
    $pageNum = $_GET["page"];

}
$offset = ($pageNum - 1) * $rowsPerPage;
$flag = false;
if(isset($_GET['key']))
{
    $key = trim($_GET['key']);

    $self .= "?key=".$key;
    if($key != "")
        $flag = true;
}
?>

<!DOCTYPE html>
<html lang="en">
    
<?php include('assets/inc/head.php');?>

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
                                            <li class="breadcrumb-item"><a href="javascript: void(0);">Pharmacy</a></li>
                                            <li class="breadcrumb-item active">Give Prescription</li>
                                        </ol>
                                    </div>
                                    <h4 class="page-title">Add Prescriptions</h4>
                                </div>
                            </div>
                        </div>     
                        <!-- end page title --> 

                        <div class="row">
                            <div class="col-12">
                                <div class="card-box">
                                    <h4 class="header-title"></h4>
                                    <div class="mb-2">
                                        <div class="row">
                                            <div class="col-12 text-sm-center form-inline" >
                                                <div class="form-group mr-2" style="display:none">
                                                    <select id="demo-foo-filter-status" class="custom-select custom-select-sm">
                                                        <option value="">Show all</option>
                                                        <option value="Discharged">Discharged</option>
                                                        <option value="OutPatients">OutPatients</option>
                                                        <option value="InPatients">InPatients</option>
                                                    </select>
                                                </div>
                                                <div class="form-group">
                                                    <form method="get" action="">
                                                        <input id="" name="key" type="text" placeholder="Search" class="form-control form-control-sm" autocomplete="on">
                                                        <button type="submit" class="ladda-button btn btn-primary" data-style="expand-right">Search</button>
                                                    </form>

                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                    
                                    <div class="table-responsive">
                                        <table id="" class="table table-bordered toggle-circle mb-0" data-page-size="7">
                                            <thead>
                                            <tr>
                                                <th>#</th>
                                                <th data-toggle="true">Patient Name</th>
                                                <th data-hide="phone">Patient Number</th>
                                                <th data-hide="phone">Patient Address</th>
                                                <th data-hide="phone">Patient Date of birth</th>
                                                <th data-hide="phone">Action</th>
                                            </tr>
                                            </thead>
                                            <?php
                                            /*
                                                *get details of allpatients
                                                *
                                            */
                                            if($flag)
                                            {
                                                $sql="SELECT * FROM `patient` WHERE PCode = '".$key."' OR Fname LIKE '%".$key."%' OR Lname LIKE '%".$key."%' OR CONCAT(Fname,' ',Lname) LIKE '%".$key."%'";
                                                $sql1 = $sql;
                                                $sql.= " LIMIT $offset, $rowsPerPage";

                                            }else
                                            {
                                                $sql="SELECT * FROM patient";
                                                $sql1 = $sql;
                                                $sql.= " LIMIT $offset, $rowsPerPage";
                                            }


                                            //sql code to get to ten docs  randomly
                                            echo $sql;
                                                $res = executeQuery($sql);
                                                $cnt=1;
                                                while($row=$res->fetch_object())
                                                {
                                            ?>

                                                <tbody>
                                                <tr>
                                                    <td><?php echo $cnt;?></td>
                                                    <td><?php echo $row->Fname;?> <?php echo $row->Lname;?></td>
                                                    <td><?php echo $row->PCode;?></td>
                                                    <td><?php echo $row->Address;?></td>
                                                    <td><?php echo date("d-m-Y",strtotime($row->DoB)) ;?> </td>

                                                    <td><a href="addtreatment.php?pat_number=<?php echo $row->PCode;?>" class="badge badge-success"><i class="fas fa-highlighter "></i> Get Treatment</a></td>
                                                </tr>
                                                </tbody>
                                            <?php  $cnt = $cnt +1 ; }?>
                                            <tfoot>
                                            <tr class="active">
                                                <td colspan="8">
                                                    <div class="text-right">
                                                        <ul style="list-style-type: none" class="pagination-rounded justify-content-end footable-pagination m-t-10 mb-0">
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

                                                                if($self != $root){
                                                                    $self .= "&&";
                                                                }
                                                                else
                                                                    $self .= '?';
                                                                $nav = '';


                                                                if($start > 1)
                                                                {
                                                                    $nav = $nav . ' <li class="footable-page"><a href="'.$self.'page=1">1</a></li>';
                                                                    $nav = $nav . ' <li class="footable-page disable"><span>...</span></li>';
                                                                }

                                                                for($page = $start; $page <= $end; $page++){
                                                                    if($page == $pageNum)
                                                                    {
                                                                        $nav = $nav. '<li class="footable-page active"><a >'.$pageNum.'</a></li>';
                                                                    }
                                                                    else{
                                                                        $nav = $nav . ' <li class="footable-page"><a href="'.$self.'page='.$page.'">'.$page.'</a></li>';
                                                                    }
                                                                }

                                                                if($end < $maxPage)
                                                                {
                                                                    $nav = $nav . ' <li class="footable-page"><span>...</span></li>';
                                                                    $nav = $nav . ' <li class="footable-page"><a href="'.$self.'page='.$maxPage.'">'.$maxPage.'</a></li>';
                                                                }



                                                                if($pageNum > 1){
                                                                    $page = $pageNum - 1;
                                                                    $prev = '<li><a href="'.$self.'page='.$page.'" aria-label="Previous">&lt;</a></li>';
                                                                    $first = '<li><a href="'.$self.'page=1" aria-label="Previous">&laquo;</a></li>';
                                                                }else
                                                                {
                                                                    $prev = '<li style="display: none"><a href="'.$self.'page='.$page.'" aria-label="Previous">&lt;</a></li>';
                                                                    $first = '<li style="display: none;"><a href="'.$self.'page=1" aria-label="Previous">&laquo;</a></li>';
                                                                }

                                                                if($pageNum < $maxPage){
                                                                    $page = $pageNum + 1;
                                                                    $next = '<li><a href="'.$self.'page='.$page.'" aria-label="Next">&gt;</a></li>';
                                                                    $last = '<li><a href="'.$self.'page='.$maxPage.'" aria-label="Next">&raquo;</a></li>';
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
                                    </div> <!-- end .table-responsive-->
                                </div> <!-- end card-box -->
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


        <!-- Right bar overlay-->
        <div class="rightbar-overlay"></div>

        <!-- Vendor js -->
        <script src="assets/js/vendor.min.js"></script>

        <!-- Footable js -->
        <script src="assets/libs/footable/footable.all.min.js"></script>

        <!-- Init js -->
        <script src="assets/js/pages/foo-tables.init.js"></script>

        <!-- App js -->
        <script src="assets/js/app.min.js"></script>
        
    </body>

</html>