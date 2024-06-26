<script src="bs/vendor/jquery/jquery.min.js"></script>

<script src="bs/vendor/sweetalert2/sweetalert2.all.min.js"></script>


<?php 
  
 require 'koneksi.php';


  //cek user login

  if (isset($_SESSION['status_login'])) {
    if ($_SESSION['status_login'] == 1) {
      header('location: home.php');
      exit;
    }
  }

  //jika login di tekan
    if (isset($_POST['login'])) {
      $username = htmlspecialchars($_POST['username']);
      $password = htmlspecialchars($_POST['password']);

      $sql_login = mysqli_query($konek, "SELECT * FROM user WHERE username = '$username'");
      $panggil = mysqli_fetch_assoc($sql_login);

       if ($panggil) {
         if (password_verify($password, $panggil['password'])) {
           $_SESSION['id_user'] = $panggil['id_user'];
           $_SESSION['id_outlet'] = $panggil['id_outlet'];
           $_SESSION['role'] = $panggil['role'];
           $_SESSION['nama_user'] = $panggil['nama_user'];
           $_SESSION['status_login'] = 1;
           echo "
            <script> 
              $(document).ready(function() {
                Swal.fire({
                  type: 'success',
                  title: 'Berhasil Masuk!',
                }).then((result = true) => {
                  if (result.value) {
                    document.location.href = 'home.php';
                  }
                });
              })
            </script>
          ";
          exit;
         }else{
          echo "
            <script> 
              $(document).ready(function() {
                Swal.fire({
                  type: 'error',
                  title: 'Gagal Masuk!',
                  text: 'Password yang anda masukkan salah!'
                });
              })
            </script>
          ";
         }
       }else{
        echo "
          <script>
            $(document).ready(function() {
              Swal.fire({
                type: 'error',
                title: 'Gagal Masuk!',
                text: 'Username yang anda masukkan salah!'
              });
            })
          </script>
        ";
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

  <title>SlowClean | Login</title>

  <!-- Custom fonts for this template-->
  <link href="bs/vendor/fontawesome-free/css/all.min.css" rel="stylesheet" type="text/css">
  <link href="bs/https://fonts.googleapis.com/css?family=Nunito:200,200i,300,300i,400,400i,600,600i,700,700i,800,800i,900,900i" rel="stylesheet">

  <!-- Custom styles for this template-->
  <link href="bs/css/sb-admin-2.min.css" rel="stylesheet">

  <!-- <link rel="stylesheet" href="bs/sweetalert2-theme-bootstrap-4/bootstrap-4.min.css"> -->

</head>

<body id="page-top" style="background-image: url(img/bg-loin-13.png); background-repeat: no-repeat;">

  <div class="wrapper d-flex align-items-stretch mt-5">
      <div class="container mt-5">
        <br>
           <div class="row justify-content-center mt-5">
             <div class="col-lg-5 p-5 text-dark bg-light rounded-lg shadow-lg p-3 mb-5 bg-white rounded">
               <h3 class="text-dark text-uppercase text-center">Login</h3>
               <form method="POST">
                <div class="form-group">
                  <label class="text-dark mt-3">Pengguna</label>
                  <div class="input-group">
                            <div class="input-group-prepend">
                              <span class="input-group-text"><i class="fas fa-user"></i></i></span>
                            </div>
                              <input type="text" class="form-control" name="username" placeholder="Masukan Nama Pengguna">
                            </div>
                 </div>
                 <div class="form-group">
                   <label class="text-dark mt-3">Kata sandi</label>
                   <div class="input-group">
                            <div class="input-group-prepend">
                              <span class="input-group-text"><i class="fas fa-key"></i></i></span>
                            </div>
                            <input type="password" class="form-control" name="password" placeholder="Masukan Kata Sandi">
                          </div>
                 </div>
                 <div class="form-group mt-3">
                  <!-- swalDefaultSuccess -->
                   <button type="submit" name="login" class="btn btn-primary btn-block mt-5" ><i class="fas fa-sign-in-alt"></i> MASUK</button>
                 </div>
               </form>
                <footer class="main-footer mt-5 text-center">
                  <hr>
                 <strong>Copyright &copy;<script>document.write(new Date().getFullYear());</script></strong> SlowClean Laundry
            </footer>
             </div>
           </div>
         </div> 
        </div>
    </div>
  </div>

  <!-- Bootstrap core JavaScript-->
  <script src="bs/vendor/bootstrap/js/bootstrap.bundle.min.js"></script>

  <!-- Core plugin JavaScript-->
  <script src="bs/vendor/jquery-easing/jquery.easing.min.js"></script>

  <!-- Custom scripts for all pages-->
  <script src="bs/js/sb-admin-2.min.js"></script>

  <!-- Page level plugins -->
  <script src="bs/vendor/chart.js/Chart.min.js"></script>

  <!-- Page level custom scripts -->
  <script src="bs/js/demo/chart-area-demo.js"></script>
  <script src="bs/js/demo/chart-pie-demo.js"></script>

 

</body>

</html>
