<?php
  session_start();
  include('assets/inc/config.php');
  include('assets/inc/checklogin.php');
  require ('../../assets/dataProvider.php');
  check_login();
  //$aid=$_SESSION['ad_id'];
  $doc_id = $_SESSION['doc_id'];
  /*
  Doctor has no previledges to delete a patient record
  if(isset($_GET['delete']))
  {
        $id=intval($_GET['delete']);
        $adn="delete from his_patients where pat_id=?";
        $stmt= $mysqli->prepare($adn);
        $stmt->bind_param('i',$id);
        $stmt->execute();
        $stmt->close();	 
  
          if($stmt)
          {
            $success = "Patients Records Deleted";
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
                                            <li class="breadcrumb-item"><a href="javascript: void(0);">Patients</a></li>
                                            <li class="breadcrumb-item active">Manage Patients</li>
                                        </ol>
                                    </div>
                                    <h4 class="page-title">Manage Outpatient Details</h4>
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
                                                    <form method="get" action="manage_my_outpatient.php">
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
                                                <th >Patient Name</th>
                                                <th >Patient Number</th>
                                                <th >Patient ID</th>

                                                <th >Patient Address</th>
                                                <th >Patient Phone</th>
                                                <th >Action</th>
                                            </tr>
                                            </thead>
                                            <?php
                                            /*
                                                *get details of allpatients
                                                *
                                            */
                                            if($flag)
                                            {
                                                $sql="SELECT * FROM `examination` E JOIN `outpatient` O ON E.OPCode = O.OPCode JOIN `patient` P ON P.PCode = O.PCode WHERE (O.OPCode = '".$key."' OR P.Fname LIKE '%".$key."%' OR P.Lname LIKE '%".$key."%') AND E.DECode = '".$doc_id."' GROUP BY O.OPCode";
                                            }else
                                                $sql="SELECT * FROM `examination` E JOIN `outpatient` O ON E.OPCode = O.OPCode JOIN `patient` P ON P.PCode = O.PCode WHERE E.DECode = '".$doc_id."' GROUP BY O.OPCode";
                                            $result = executeQuery($sql);
                                            //sql code to get to ten docs  randomly

                                            $cnt=1;
                                            while($row = $result->fetch_array())
                                            {
                                                ?>

                                                <tbody>
                                                <tr>
                                                    <td><?php echo $cnt;?></td>
                                                    <td><?php echo $row['Fname'];?> <?php echo $row['Lname'];?></td>
                                                    <td><?php echo $row['PCode'];?></td>
                                                    <td><?php echo $row['OPCode'];?></td>

                                                    <td><?php echo $row['Address'];?></td>
                                                    <td><?php echo $row['Phone'];?></td>


                                                    <td>
                                                        <a href="view_single_patient.php?pat_id=<?php echo $row['PCode'];?>&&pat_number=<?php echo $row['PCode'];?>&&pat_name=<?php echo $row['Fname'];?>_<?php echo $row['Lname'];?>" class="badge badge-success"><i class="mdi mdi-eye"></i> View</a>
                                                        <a href="#" class="badge badge-primary"><i class="mdi mdi-check-box-outline "></i> Update</a>
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