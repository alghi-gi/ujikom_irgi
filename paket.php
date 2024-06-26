<script src="bs/vendor/jquery/jquery.min.js"></script>
<script src="bs/vendor/sweetalert2/sweetalert2.all.min.js"></script>
<?php 
  
  require 'koneksi.php';

  //login
  if (!isset($_SESSION['status_login'])) {
    if ($_SESSION['status_login'] !== 1) {
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

    $sql_panggil = mysqli_query($konek, "SELECT * FROM paket as pk INNER JOIN outlet as ot ON pk.id_outlet = ot.id_outlet LIMIT $mulai, $tampil_hal");

    $sql_no_limit = mysqli_query($konek, "SELECT * FROM paket as pk INNER JOIN outlet as ot ON pk.id_outlet = ot.id_outlet");

    $total_hal = mysqli_num_rows($sql_no_limit);

    $semua = ceil($total_hal/$tampil_hal);

    //echo "$semua";

  //panggil outlet
  $outlet = mysqli_query($konek, "SELECT * FROM outlet");

  //cari data paket
  if (isset($_POST['cari'])) {
    $keyword = $_POST['cari_data'];
    $sql_panggil = mysqli_query($konek, "SELECT * FROM paket as pk INNER JOIN outlet as ot ON pk.id_outlet = ot.id_outlet WHERE pk.nama_paket LIKE '%$keyword%'OR ot.nama_outlet LIKE '%$keyword%'");
  }

  //cari jenis paket
  if (isset($_POST['cari_paket'])) {
    $keyword2 = $_POST['jenis'];
    $sql_panggil = mysqli_query($konek, "SELECT * FROM paket as pk INNER JOIN outlet as ot ON pk.id_outlet = ot.id_outlet WHERE pk.jenis LIKE '%$keyword2%'");
  }


  //tambah paket

    if (isset($_POST['tambah'])) {
      if (tambah_paket($_POST) > 0) {
        echo "
          <script>
            $(document).ready(function() {
                Swal.fire({
                  type: 'success',
                  title: 'Paket berhasil ditambah!',
                }).then((result = true) => {
                  if (result.value) {
                    document.location.href = 'paket.php';
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
                  type: 'success',
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

  <title>SlowClean | Paket Cuci</title>

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
                        <a class="dropdown-item" href="pelanggan.php">Pelanggan</a>
                        <a class="dropdown-item active" href="paket.php">Paket Cuci</a>
                        <a class="dropdown-item" href="transaksi_cuci.php">Transaksi</a>
                  </div>
                </li>
        <?php endif ?>
           <?php if ($_SESSION['role'] == 'admin' OR $_SESSION['role'] == 'onwer'): ?>
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
          <h4><i class="fas fa-table"></i> | Data Paket Cuci</h4>
          <hr>
           <!-- Search form -->
          <div class="container rounded-lg shadow p-3 mb-3 bg-white rounded">
            <div class="row mt-3">
            <div class="col-lg-3 mb-3">
              <form class="form-inline md-form form-sm" method="POST">
               <div class="form-group">
                  <input class="form-control mr-1 col-9" type="text" name="cari_data" placeholder="Cari Data">
                  <button class="btn btn-primary" name="cari"><i class="fas fa-search" aria-hidden="true"></i></button>
               </div>
             </form>
            </div>
            <div class="col-lg-3">
              <form action="" method="POST" class="form-inline md-form form-sm">
                <select name="jenis" id="" class="form-control mr-1 col-9">
                  <option value="">--Cari Jenis Paket--</option>
                  <option value="kiloan">Kiloan</option>
                  <option value="selimut">Selimut</option>
                  <option value="bed cover">Bed Cover</option>
                  <option value="kaos">Kaos</option>
                  <option value="hemat">Hemat</option>
                </select>
                <button type="submit" class="btn btn-primary" name="cari_paket"><i class="fas fa-search" aria-hidden="true"></i></button>
              </form>   
            </div>
            <div class="col-lg-6 text-right">
             <!-- Button trigger modal -->
              <button type="button" class="btn btn-primary" data-toggle="modal" data-target="#staticBackdrop">
                <i class="far fa-plus-square"></i> Tambah Paket
              </button>
            </div>
          </div>
        </div>

          <div class="container rounded-lg mt-3 shadow-lg p-3 mb-5 bg-white rounded">
             <div class="table-responsive mt-3">
                <table class="table table-bordered table-striped text-dark">
                  <thead class="text-center" style="background-color: skyblue;">
                    <tr>
                      <th>No</th>
                      <th>Outlet</th>
                      <th>Nama Paket</th>
                      <th>Jenis Paket</th>
                      <th>Harga</th>
                      <th>Opsi</th>
                    </tr>
                  </thead>
                  <tbody class="text-center">
                    <?php $no=$mulai+1; ?>
                    <?php foreach ($sql_panggil as $data): ?>
                      <tr>
                        <td><?php echo $no++; ?>.</td>
                        <td><?php echo $data['nama_outlet']; ?></td>
                        <td><?php echo $data['nama_paket']; ?></td>
                        <td><?php echo ucwords($data['jenis']); ?></td>
                        <td>Rp. <?php echo number_format($data['harga']); ?></td>
                        <td>
                          <a data-toggel="popover" data-placement="buttom" title="Ubah Paket Cuci" class="btn btn-sm btn-success" href="ubah_paket.php?id_paket=<?php echo $data['id_paket']; ?>"><i class="fas fa-pen"></i></a>
                         <?php if ($_SESSION['role'] == 'admin'): ?>
                            <a data-toggel="popover" data-placement="buttom" title="Hapus Paket Cuci" onclick="return confirm('Apakah data ini ingin di hapus?')" class="btn btn-sm btn-danger swalDefaulthapus" href="hapus_paket.php?id_paket=<?php echo $data['id_paket']; ?>"><i class="fas fa-trash-alt"></i></a>
                         <?php endif ?>
                        </td>
                      </tr>
                    <?php endforeach ?>
                  </tbody>
                </table>
                <h6># Khusus Paket Hemat, Jika Pelanggan menyerahkan pakaian lebih dari 4 jenis paket dan jumlah di hitung dari berapa banyak pakaian kotor yang dibawa. </h6>
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
                <h5 class="modal-title text-white" id="staticBackdropLabel"><i class="fas fa-align-justify"></i> <i class="fas fa-plus"></i> | Tambah Paket</h5>
                <button type="button" class="close text-white" data-dismiss="modal" aria-label="Close">
                  <span aria-hidden="true">&times;</span>
                </button>
              </div>
              <div class="modal-body">
                <form action="" method="POST">
                  <input type="hidden" name="id_outlet" value="<?php echo $_SESSION['id_outlet']; ?>">
                  <div class="form-group">
                    <label for="" class="text-white">Nama Paket</label>
                    <div class="input-group">
                            <div class="input-group-prepend">
                              <span class="input-group-text"><i class="fas fa-box"></i></i></span>
                            </div>
                            <input type="text" class="form-control" name="nama_paket" placeholder="Masukan Nama paket">
                          </div>
                  </div>
                  <div class="form-row">
                    <div class="form-group col-md-6">
                      <label for="" class="text-white" >Jenis Paket</label>
                        <div class="input-group">
                            <div class="input-group-prepend">
                              <span class="input-group-text"><i class="fas fa-boxes"></i></i></span>
                            </div>
                            <select name="jenis" class="form-control" id="">
                              <option value="kiloan">Kiloan</option>
                              <option value="selimut">Selimut</option>
                              <option value="bed_cover">Bed Cover</option>
                              <option value="kaos">Kaos</option>
                              <option value="sepatu">Sepatu</option>
                              <option value="hemat">Hemat</option>
                            </select>
                          </div>
                      </div>
                    <div class="form-group col-md-6">
                     <label for="" class="text-white">Harga / Rp</label>
                         <div class="input-group">
                            <div class="input-group-prepend">
                              <span class="input-group-text"><i class="fas fa-tags"></i></i></span>
                            </div>
                            <input type="number" class="form-control" name="harga" placeholder="Masukan harga paket">
                          </div>
                    </div>
                  </div>
              </div>
              <div class="modal-footer">
                <button type="button" class="btn btn-danger btn-lg btn-block" data-dismiss="modal">Tutup</button>
                <button type="submit" class="btn btn-primary btn-lg btn-block mb-2 swalDefaultSuccess" name="tambah">Tambahkan</button>
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
