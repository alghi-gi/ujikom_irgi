<script src="bs/vendor/jquery/jquery.min.js"></script>
<script src="bs/vendor/sweetalert2/sweetalert2.all.min.js"></script>
<?php 
  
  require 'koneksi.php';

  //login
  if (!isset($_SESSION['status_login'])) {
    if ($_SESSION['status_login'] !==1) {
      header('location:login.php');
      exit;
    }
  }

   //pagging
    if (empty($_GET['hal'])) {
      $hal = 1;
    }else{
      $hal = $_GET['hal'];
    }

    $tampil_hal = 5;

    $mulai = ($hal*$tampil_hal)-$tampil_hal;

    $sql_pagging = mysqli_query($konek, "SELECT * FROM member LIMIT $mulai, $tampil_hal");

    $sql_no_limit = mysqli_query($konek, "SELECT * FROM member");

    $total_hal = mysqli_num_rows($sql_no_limit);

    $semua = ceil($total_hal/$tampil_hal);

    //echo "$semua";

  //jika tombol cari di tekan
  if (isset($_POST['cari'])) {
    $keyword = $_POST['cari_data'];
    $sql_pagging = mysqli_query($konek, "SELECT * FROM member WHERE nama_member LIKE '%$keyword%' OR alamat LIKE '%$keyword%' OR jenis_kelamin LIKE '%$keyword%'");
  }

    if (isset($_POST['tambah'])) {
      if (tambah_pelanggan_cuci($_POST) > 0) {
        echo "
          <script>
             $(document).ready(function() {
                Swal.fire({
                  type: 'success',
                  title: 'Pelanggan berhasil ditambah!',
                }).then((result = true) => {
                  if (result.value) {
                    document.location.href = 'pelanggan.php';
                  }
                });
              })
          </script>
        ";
      }else{
        echo "
          <script>
             $(document).ready(function() {
                Swal.fire({
                  type: 'error',
                  title: 'Pelanggan gagal ditambah!',
                }).then((result = true) => {
                  if (result.value) {
                    document.location.href = 'pelanggan.php';
                  }
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

  <title>SlowClean | Pelanggan</title>

  <!-- Custom fonts for this template-->
  <link href="bs/vendor/fontawesome-free/css/all.min.css" rel="stylesheet" type="text/css">
  <link href="bs/https://fonts.googleapis.com/css?family=Nunito:200,200i,300,300i,400,400i,600,600i,700,700i,800,800i,900,900i" rel="stylesheet">

  <!-- Custom styles for this template-->
  <link href="bs/css/sb-admin-2.min.css" rel="stylesheet">
  <link rel="stylesheet" href="bs/sweetalert2-theme-bootstrap-4/bootstrap-4.min.css">

</head>

<body id="page-top">

   <!-- navbar logo -->
      <nav class="navbar navbar-expand-lg navbar-light bg-primary" style="background-image: url('img/bg-logn5.png'); height: 65px;"></nav>
      <!-- akhir navbar logo -->

      <!-- navbar link -->
     <nav class="navbar navbar-expand-lg navbar-light bg-dark shadow p-3 bg-white rounded">
      <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarNav" aria-controls="navbarNav" aria-expanded="false" aria-label="Toggle navigation">
        <span class="navbar-toggler-icon"></span>
      </button>
      <div class="container-fluid">
        <img src="img/logonavbar.png" alt="" style="width: 250px;">
        <div class="collapse navbar-collapse" id="navbarNav">
        <ul class="navbar-nav text-uppercase">
          <li class="nav-item">
            <a class="nav-link collapsed" href="home.php">
              <i class="fas fa-home"></i>
              <span>dasbor</span>
            </a>
          </li>
        <?php if ($_SESSION['role'] == 'admin' OR $_SESSION['role'] == 'kasir'): ?>
          <p class="mt-2">|</p>
           <li class="nav-item dropdown active">
                  <a class="nav-link dropdown-toggle" href="#" id="navbarDropdownMenuLink" role="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                    <i class="fas fa-tasks"></i>
                    manajemen
                  </a>
                  <div class="dropdown-menu" aria-labelledby="navbarDropdownMenuLink">
                      <h6 class="dropdown-header">Komponen : </h6>
                       <?php if ($_SESSION['role'] == 'admin'): ?>
                          <a class="dropdown-item" href="daftar_pengguna.php">Pengguna</a>
                       <?php endif ?>
                        <a class="dropdown-item active" href="pelanggan.php">Pelanggan</a>
                        <a class="dropdown-item" href="paket.php">Paket Cuci</a>
                        <a class="dropdown-item" href="transaksi_cuci.php">Transaksi</a>
                  </div>
                </li>
        <?php endif ?>
            <?php if ($_SESSION['role'] == 'admin' OR $_SESSION['role'] == 'owmer'): ?>
              <p class="mt-2">|</p>
              <li class="nav-item">
                <a class="nav-link collapsed" href="laporan.php">
                  <i class="fas fa-file-signature"></i>
                  <span>laporan</span>
                </a>
              </li>
            <p class="mt-2">|</p>
              <li class="nav-item">
                <a class="nav-link collapsed" href="riwayat.php">
                  <i class="fas fa-history"></i>
                  <span>riwayat</span>
                </a>
              </li>
            <?php endif ?>
            </ul>
           </div>
             <form class="form-inline my-2 my-lg-0">
                  <a onclick="return confirm('Apakah ingin keluar dari sistem?')" class="nav-link btn btn-sm btn-outline-danger rounded-lg collapsed text-uppercase" href="logout.php">
                    <i class="fas fa-sign-out-alt"></i>
                    <span>Keluar</span>
                </a>
            </form>
          </div>
        </nav>
      <!-- akhir navbar link -->

  <!-- Page Wrapper -->
  <div id="wrapper">

    <!-- Content Wrapper -->
    <div id="content-wrapper" class="d-flex flex-column">
        
      <div id="content" class="p-4 p-md-5 pt-5 text-dark mt-1">
          <h4><i class="fas fa-table"></i> | Data Pelanggan</h4>
          <hr>
           <!-- Search form -->
          <div class="container rounded-lg shadow p-3 mb-3 bg-white rounded">
            <div class="row mt-3">
            <div class="col-lg-9 mb-3">
              <form class="form-inline md-form form-sm" method="POST">
               <div class="form-group">
                  <input class="form-control mr-1 col-8" type="text" name="cari_data" placeholder="Cari Data">
                  <button class="btn btn-primary" name="cari"><i class="fas fa-search" aria-hidden="true"></i></button>
               </div>
              </form>
            </div>
            <div class="col-lg-3 text-right">
              <!-- Button trigger modal -->
           <?php if ($_SESSION['role'] == 'admin' OR $_SESSION['role'] == 'kasir'): ?>
              <button type="button" class="btn btn-primary" data-toggle="modal" data-target="#staticBackdrop">
              <i class="far fa-plus-square"></i> Tambah Pelanggan
            </button>
           <?php endif ?>
            </div>
          </div>
        </div>

           <div class="container rounded-lg mt-3 shadow-lg p-3 mb-5 bg-white rounded">
             <div class="table-responsive mt-3">
                <table class="table table-bordered table-striped text-dark">
                  <thead class="text-center" style="background-color: skyblue;">
                    <tr>
                      <th>No</th>
                      <th>Nama Pelanggan</th>
                      <th>Alamat</th>
                      <th>Jenis Kelamin</th>
                      <th>Nomer Telepon</th>
                      <th>Opsi</th>
                    </tr>
                  </thead>
                  <tbody class="text-center">
                    <?php $no=$mulai+1; ?>
                    <?php foreach($sql_pagging as $data): ?>
                      <tr>
                        <td><?php echo $no++; ?>.</td>
                        <td><?php echo $data['nama_member']; ?></td>
                        <td><?php echo $data['alamat']; ?></td>
                        <td><?php echo ucwords($data['jenis_kelamin']); ?></td>
                        <td><?php echo $data['no_telepon']; ?></td>
                        <td>
                          <a data-toggel="popover" data-placement="buttom" title="Ubah Pelanggan" class="btn btn-sm btn-success" href="ubah_pelanggan.php?id_member=<?php echo $data['id_member']; ?>"><i class="fas fa-pen"></i></a> 
                          <?php if ($_SESSION['role'] == 'admin'): ?>
                            <a data-toggel="popover" data-placement="buttom" title="Hapus Pelanggan" onclick="return confirm('Apakah data ini dengan nama <?php echo $data['nama_member']; ?> ingin di hapus?')" class="btn btn-sm btn-danger swalDefaulthapus" href="hapus_pelanggan.php?id_member=<?php echo $data['id_member']; ?>"><i class="fas fa-trash-alt"></i></a>
                          <?php endif ?>
                        </td>
                      </tr>
                    <?php endforeach ?>
                  </tbody>
                </table>
                <nav aria-label="Page navigation example" class="text-dark">
                  <ul class="pagination justify-content-center">
                    <li class="page-item disabled">
                      <a class="page-link" href="#" tabindex="-1" aria-disabled="true">Previous</a>
                    </li>
                    <?php for ($a=1; $a <=$semua ; $a++) { ?>
                      <li class='page-item'><a class='page-link' href='?hal=<?php echo $a; ?>'><?php echo $a; ?></a></li>
                    <?php } ?>
                    <li class="page-item">
                      <a class="page-link" href="#">Next</a>
                    </li>
                  </ul>
                </nav>
            </div>
            <hr>
             <footer class="main-footer mt-3">
                 <strong>Copyright &copy;<script>document.write(new Date().getFullYear());</script></strong> SlowClean Laundry
                <div class="float-right d-none d-sm-inline-block">
              <b>Versi</b> 0.0.0
            </div>
            </footer>
           </div>
          </div>
         </div>

       <!-- Modal -->
        <div class="modal fade" id="staticBackdrop" data-backdrop="static" tabindex="-1" role="dialog" aria-labelledby="staticBackdropLabel" aria-hidden="true">
          <div class="modal-dialog" role="document">
            <div class="modal-content bg-dark">
              <div class="modal-header">
                <h5 class="modal-title text-white" id="staticBackdropLabel"><i class="fas fa-align-justify"></i> <i class="fas fa-plus"></i> | Tambah Pelanggan</h5>
                <button type="button" class="close text-white" data-dismiss="modal" aria-label="Close">
                  <span aria-hidden="true">&times;</span>
                </button>
              </div>
              <div class="modal-body">
                <form action="" method="POST">
                  <div class="form-group mt-2">
                    <label for="" class="text-white">Nama Pelanggan</label>
                    <div class="input-group">
                            <div class="input-group-prepend">
                              <span class="input-group-text"><i class="fas fa-user"></i></i></span>
                            </div>
                            <input type="text" class="form-control" required name="nama_member" placeholder="Masukan Nama pelanggan">
                          </div>
                  </div>
                  <div class="form-group">
                    <label for="" class="text-white">Alamat</label>
                     <div class="input-group">
                            <div class="input-group-prepend">
                              <span class="input-group-text"><i class="fas fa-map-marker-alt"></i></i></span>
                            </div>
                            <input type="text" class="form-control" required name="alamat" placeholder="Masukan Alamat lengkap">
                          </div>
                  </div>
                 <div class="form-row">
                    <div class="form-group col-md-6">
                      <label for="" class="text-white">Jenis Kelamin</label>
                       <div class="input-group">
                            <div class="input-group-prepend">
                              <span class="input-group-text"><i class="fas fa-venus-mars"></i></i></span>
                            </div>
                            <select name="jenis_kelamin" class="form-control" id="">
                              <option value="laki-laki">Laki-laki</option>
                              <option value="perempuan">Perempuan</option>
                            </select>
                          </div>
                    </div>
                    <div class="form-group col-md-6">
                      <label for="" class="text-white">Nomer Telepon</label>
                       <div class="input-group">
                            <div class="input-group-prepend">
                              <span class="input-group-text"><i class="fas fa-phone"></i></i></span>
                            </div>
                            <input type="number" class="form-control" required name="no_telepon">
                          </div>
                      <p class="text-warning">*Nomer aktif saat ini</p>
                    </div>
                  </div>
              </div>
              <div class="modal-footer">
                <button type="button" class="btn btn-danger btn-lg btn-block" data-dismiss="modal">Tutup</button>
                <button type="submit" class="btn btn-primary btn-lg btn-block mb-2" name="tambah">Tambahkan</button>
              </div>
            </form>
            </div>
          </div>
        </div>


    </div>
    <!-- End of Content Wrapper -->

  </div>
  <!-- End of Page Wrapper -->

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
  <script>
    $(document).ready(function (){
      $('[data-toggle="popover"]').popover();
    });
  </script>

  

</body>

</html>
