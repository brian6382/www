<?php 
session_start();
require 'includes/DbOperations.php';
$db = new DbOperations; 

// if (!isset($_SESSION['full_name'])) {
//       header("Location: ../index");
// }

 // $today = date("Y-m-d");




$success_message = '';  
if (isset($_POST['saveAndClose'])) {
    $fullname = $_POST['fullname'];
    $contact = $_POST['contact'];
    $email = $_POST['email'];
    $id_number = $_POST['id_number'];
    $address = $_POST['address'];
    $status = 1;
    $password = $_POST['password'];

    $passport = $_FILES['photo']['name'];
    $target_dir = "Drivers";
    $target_file = $target_dir . basename($_FILES["photo"]["name"]);

     // Select file type
    $imageFileType = strtolower(pathinfo($target_file,PATHINFO_EXTENSION));

     // Valid file extensions
    $extensions_arr = array("jpg","jpeg","png","gif");
    $imageName = $id_number.".".$imageFileType;
    $imagePath = $target_dir."/".$imageName;
    $finalImagePath = "Drivers".$imagePath;

      // Check extension
    if( in_array($imageFileType, $extensions_arr) ){
        // Upload file
        move_uploaded_file($_FILES['photo']['tmp_name'], $imagePath);

   
 
  
    $result = $db->addDrivers($fullname, $contact, $email, $id_number, $address, $passport,$status,$password); 

    if ($result == USER_CREATED) {
         header("Location: addTeacher"); 
    } elseif ($result == USER_FAILURE) {
       $success_message = '<div class="alert alert-primary" role="alert">
                 Something went wrong...please try again later!
                </div>'; 
    }elseif ($result == USER_EXISTS) {
         $success_message = '<div class="alert alert-danger" role="alert">
                      Driver Name already exists
                    </div>'; 
    }

}

}elseif (isset($_POST['saveAndContinue'])) {
  $fullname = $_POST['fullname'];
    $contact = $_POST['contact'];
    $email = $_POST['email'];
    $id_number = $_POST['id_number'];
    $address = $_POST['address'];
    $status = 1;
    $password = $_POST['password'];

    $passport = $_FILES['photo']['name'];
    $target_dir = "Drivers";
    $target_file = $target_dir . basename($_FILES["photo"]["name"]);

     // Select file type
    $imageFileType = strtolower(pathinfo($target_file,PATHINFO_EXTENSION));

     // Valid file extensions
    $extensions_arr = array("jpg","jpeg","png","gif");
    $imageName = $id_number.".".$imageFileType;
    $imagePath = $target_dir."/".$imageName;
    $finalImagePath = "Drivers".$imagePath;

      // Check extension
    if( in_array($imageFileType, $extensions_arr) ){
        // Upload file
        move_uploaded_file($_FILES['photo']['tmp_name'], $imagePath);


    
  
    // $account_number = $db->generateRandomString(6);
  
    $result = $db->addDrivers($fullname, $contact, $email, $id_number, $address, $passport,$status,$password); 
    if ($result == USER_CREATED) {
         $success_message = '<div class="alert alert-success" role="alert">
                 Driver added successfully!
                </div>'; 
    } elseif ($result == USER_FAILURE) {
       $success_message = '<div class="alert alert-primary" role="alert">
                 Something went wrong...please try again later!
                </div>'; 
    }elseif ($result == USER_EXISTS) {
         $success_message = '<div class="alert alert-danger" role="alert">
                      Driver Name already exists
                    </div>'; 
    }

}

}

?>
<!DOCTYPE html>
<html lang="en">

<head>

    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <meta name="description" content="">
    <meta name="author" content="">

    <title>SB Admin 2 - Tables</title>

    <!-- Custom fonts for this template -->
    <link href="vendor/fontawesome-free/css/all.min.css" rel="stylesheet" type="text/css">
    <link
        href="https://fonts.googleapis.com/css?family=Nunito:200,200i,300,300i,400,400i,600,600i,700,700i,800,800i,900,900i"
        rel="stylesheet">

    <!-- Custom styles for this template -->
    <link href="css/sb-admin-2.min.css" rel="stylesheet">

    <!-- Custom styles for this page -->
    <link href="vendor/datatables/dataTables.bootstrap4.min.css" rel="stylesheet">

</head>

<body id="page-top">

    <!-- Page Wrapper -->
    <div id="wrapper">

        <!-- Sidebar -->
        <?php include "includes/aside.php"; ?>
        <!-- End of Sidebar -->

        <!-- Content Wrapper -->
        <div id="content-wrapper" class="d-flex flex-column">

            <!-- Main Content -->
            <div id="content">

                <!-- Topbar -->
                <?php include "includes/header.php"; ?>
                <!-- End of Topbar -->

                <!-- Begin Page Content -->
              

            <div class="container-fluid">
            <div class="card">
                <h5 class="card-header">Add Driver</h5>
                <div class="card-body">
                  <form method="POST" enctype="multipart/form-data">
                    <input type="hidden" name="_token" value="v1gPSd2I0cjCGf0FaSRKNZqtUa2wFXZf0LnXnO4I">

                    <div class="form-group">
                        <label for="inputTitle" class="col-form-label">Full  Name <span class="text-danger">*</span></label>
                        <input id="inputTitle" type="text" name="fullname" placeholder="Add Teacher  Name :" required class="form-control">
                    </div>

                     <div class="form-group">
                        <label for="inputTitle" class="col-form-label">Contact   <span class="text-danger">*</span></label>
                        <input id="inputTitle" type="text" name="contact" placeholder="e.g 0767666" required class="form-control">
                    </div>

                     <div class="form-group">
                        <label for="inputTitle" class="col-form-label">Email  <span class="text-danger">*</span></label>
                        <input id="inputTitle" type="email" name="email" placeholder="school@gmail.com:" required class="form-control">
                    </div>

                     <div class="form-group">
                        <label for="inputTitle" class="col-form-label"> National ID  <span class="text-danger">*</span></label>
                        <input id="inputTitle" type="text" name="id_number" placeholder=" e.g 35467676 :" required class="form-control">
                    </div>

                    <div class="form-group">
                        <label for="inputTitle" class="col-form-label"> Address    <span class="text-danger">*</span></label>
                        <input id="inputTitle" type="text" name="address" placeholder="Eg Karen :" required class="form-control">
                    </div>

                    <div class="form-group">
                        <label for="inputTitle" class="col-form-label"> Password    <span class="text-danger">*</span></label>
                        <input id="inputTitle" type="password" name="password" placeholder="Eg Karen :" required class="form-control">
                    </div>


                    <div class="form-group">
                    <label for="inputPhoto" class="col-form-label">Driver Photo <span class="text-danger">*</span></label>
                    <div class="input-group">
                        <!-- <span class="input-group-btn">
                            <a id="lfm" data-input="thumbnail" data-preview="holder" class="btn btn-primary">
                            <i class="fa fa-picture-o"></i> Choose
                            </a>
                        </span> -->
                    <input id="thumbnail" class="form-control" type="file" name="photo" value="">
                  </div>
                  <div id="holder" style="margin-top:15px;max-height:100px;"></div>
                   </div>



                    <div class="form-group mb-3">
                      <button type="reset" class="btn btn-danger">Reset</button>
                       <button class="btn btn-warning" name="saveAndClose" type="submit">Save & Close</button>
                        <button class="btn btn-success" name="saveAndContinue" type="submit">Save & Continue</button>
                    </div>
                  </form>
                  <?php 
                    if (isset($success_message)) {
                      echo $success_message;
                    }
                  ?>
                </div>
            </div>
        </div>

            <!-- Footer -->
            <footer class="sticky-footer bg-white">
                <div class="container my-auto">
                    <div class="copyright text-center my-auto">
                        <span>Copyright &copy; Your Website 2020</span>
                    </div>
                </div>
            </footer>
            <!-- End of Footer -->

        </div>
        <!-- End of Content Wrapper -->

    </div>
    <!-- End of Page Wrapper -->

    <!-- Scroll to Top Button-->
    <a class="scroll-to-top rounded" href="#page-top">
        <i class="fas fa-angle-up"></i>
    </a>

    <!-- Logout Modal-->
    <div class="modal fade" id="logoutModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel"
        aria-hidden="true">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="exampleModalLabel">Ready to Leave?</h5>
                    <button class="close" type="button" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">×</span>
                    </button>
                </div>
                <div class="modal-body">Select "Logout" below if you are ready to end your current session.</div>
                <div class="modal-footer">
                    <button class="btn btn-secondary" type="button" data-dismiss="modal">Cancel</button>
                    <a class="btn btn-primary" href="login.html">Logout</a>
                </div>
            </div>
        </div>
    </div>

    <!-- Bootstrap core JavaScript-->
    <script src="vendor/jquery/jquery.min.js"></script>
    <script src="vendor/bootstrap/js/bootstrap.bundle.min.js"></script>

    <!-- Core plugin JavaScript-->
    <script src="vendor/jquery-easing/jquery.easing.min.js"></script>

    <!-- Custom scripts for all pages-->
    <script src="js/sb-admin-2.min.js"></script>

    <!-- Page level plugins -->
    <script src="vendor/datatables/jquery.dataTables.min.js"></script>
    <script src="vendor/datatables/dataTables.bootstrap4.min.js"></script>

    <!-- Page level custom scripts -->
    <script src="js/demo/datatables-demo.js"></script>

</body>

</html>