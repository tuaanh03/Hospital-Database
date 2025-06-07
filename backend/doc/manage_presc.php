<?php
  session_start();
  require('../../assets/dataProvider.php');
  include('assets/inc/config.php');
  include('assets/inc/checklogin.php');
  check_login();
  $doc_id = $_SESSION['doc_id'];
  /*
  Doc cant delete a prescription
  Uncomment the code to enable
  if(isset($_GET['delete_pres_number']))
  {
        $id=intval($_GET['delete_pres_number']);
        $adn="DELETE FROM his_prescriptions WHERE pres_number=?";
        $stmt= $mysqli->prepare($adn);
        $stmt->bind_param('i',$id);
        $stmt->execute();
        $stmt->close();	 
  
          if($stmt)
          {
            $success = "Prescription Records Deleted";
          }
            else
            {
                $err = "Try Again Later";
            }
    }
    */

$flag = false;
if(isset($_GET['key']))
{
    $key = trim($_GET['key']);
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
                                            <li class="breadcrumb-item active">Manage Prescriptions</li>
                                        </ol>
                                    </div>
                                    <h4 class="page-title">Manage Prescriptions</h4>
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
                                        <table id="" class="table table-bordered toggle-circle mb-0" data-page-size="8">
                                            <thead>
                                            <tr>
                                                <th>#</th>
                                                <th data-hide="phone">Examination Number</th>
                                                <th data-hide="phone">Patient Number</th>
                                                <th data-toggle="true">Patient Name</th>
                                                <th data-hide="phone">Address</th>
                                                <th data-hide="phone">Date</th>
                                                <th data-hide="phone">Diagnosis</th>
                                                <th data-hide="phone">Action</th>
                                            </tr>
                                            </thead>
                                            <?php
                                            /*
                                                *get details of allpatients
                                                *
                                            */ if($flag)
                                            {
                                                $sql="SELECT * FROM `patient` WHERE PCode = '".$key."' OR Fname LIKE '%".$key."%' OR Lname LIKE '%".$key."%' OR CONCAT(Fname,' ',Lname) LIKE '%".$key."%'";

                                                $ret="SELECT * FROM `examination` E JOIN `outpatient` O ON E.OPCode= O.OPCode JOIN `patient` P ON P.PCode = O.PCode WHERE E.DECode = '".$doc_id."' AND (O.OPCode = '".$key."' OR P.Fname LIKE '%".$key."%' OR P.Lname LIKE '%".$key."%' OR CONCAT(P.Fname,' ',P.Lname) LIKE '%".$key."%' OR E.ExamCode = '".$key."')";

                                            }else
                                                $ret="SELECT * FROM `examination` E JOIN `outpatient` O ON E.OPCode= O.OPCode JOIN `patient` P ON P.PCode = O.PCode WHERE E.DECode = '".$doc_id."'";


                                                $res = executeQuery($ret);
                                                //sql code to get to ten docs  randomly

                                                $cnt=1;
                                                while($row=$res->fetch_object())
                                                {
                                            ?>

                                                <tbody>
                                                <tr>
                                                    <td><?php echo $cnt;?></td>
                                                    <td><?php echo $row->ExamCode;?></td>
                                                    <td><?php echo $row->OPCode;?></td>
                                                    <td><?php echo $row->Fname . " " . $row->Lname;?></td>
                                                    <td><?php echo $row->Address;?></td>
                                                    <td><?php echo date("d/m/y H:i",strtotime($row->ExamDate));?></td>
                                                    <td><?php echo $row->Diagnosis;?></td>

                                                    <td>
                                                        <a href="view_single_pres.php?pres_id=<?php echo $row->ExamCode;?>" class="badge badge-success"><i class="fas fa-eye"></i> View</a>
                                                        <a href="#" class="badge badge-warning"><i class="fas fa-eye-dropper "></i> Update</a>

                                                    </td>
                                                </tr>
                                                </tbody>
                                            <?php  $cnt = $cnt +1 ; }?>
                                            <tfoot>
                                            <tr class="active">
                                                <td colspan="8">
                                                    <div class="text-right">
                                                        <ul class="pagination pagination-rounded justify-content-end footable-pagination m-t-10 mb-0"></ul>
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