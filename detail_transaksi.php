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


    //panggil data detail transaksi
    $id_transaksi = $_GET['id_transaksi'];
    $detail_transaksi = mysqli_query($konek, "SELECT * FROM detail_transaksi as dt INNER JOIN transaksi as tr ON dt.id_transaksi = tr.id_transaksi INNER JOIN paket as pk ON dt.id_paket = pk.id_paket WHERE dt.id_transaksi = '$id_transaksi'");
    $dt_panggil = mysqli_fetch_assoc($detail_transaksi);

    //panggil data dari table paket
    $panggil_paket = mysqli_query($konek, "SELECT * FROM paket");

    //panggil data nama dari table member
    $panggil_member = mysqli_query($konek, "SELECT * FROM member");
    $asli_member = mysqli_fetch_assoc($panggil_member);

    //panggil id transaksi untuk mewakili satu
    $panggil_transaksi = mysqli_query($konek, "SELECT * FROM transaksi as tr INNER JOIN outlet as ot ON tr.id_outlet = ot.id_outlet INNER JOIN member as mb ON tr.id_member = mb.id_member INNER JOIN user as us ON tr.id_user = us.id_user WHERE tr.id_transaksi = '$id_transaksi'");
    $tr_panggil = mysqli_fetch_assoc($panggil_transaksi);

    //jika tombol tambah ditekan
    if (isset($_POST['tambah'])) {
      if (tambah_detail_transaksi($_POST) > 0) {
        echo "
          <script>
           $(document).ready(function() {
                    Swal.fire({
                      type: 'success',
                      title: 'Detail berhasil ditambah!',
                    }).then((result = true) => {
                      if (result.value) {
                        document.location.href = 'detail_transaksi.php?id_transaksi=$id_transaksi';
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
                      title: 'Detail gagal ditambah!',
                    }).then((result = true) => {
                      if (result.value) {
                        document.location.href = 'detail_transaksi.php?id_transaksi=$id_transaksi';
                      }
                    });
                  })
          </script>
        ";
      }
    }

    //menentukan harga total, pajak, dan diskon
    $no = 1;
    $harga_total = 0;
    $pajak = 0;
    $diskon = 0;

  

 ?>

<!DOCTYPE html>
<html lang="en">

<head>

  <meta charset="utf-8">
  <meta http-equiv="X-UA-Compatible" content="IE=edge">
  <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
  <meta name="description" content="">
  <meta name="author" content="">

  <title>SlowClean | Detail Transaksi "<?php echo $tr_panggil['nama_member']; ?>"</title>

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
           <li class="nav-item dropdown">
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
                        <a class="dropdown-item" href="paket.php">Paket Cuci</a>
                        <a class="dropdown-item" href="transaksi_cuci.php">Transaksi</a>
                  </div>
                </li>
        <?php endif ?>
            <?php if ($_SESSION['role'] == 'admin' OR $_SESSION['role'] == 'owner'): ?>
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
          <h4><i class="fas fa-table"></i> | Data Detail Transaksi "<?php echo $tr_panggil['nama_member']; ?> | Invoice - <?php echo $tr_panggil['kode_invoice']; ?>"</h4>
          <hr>
           <!-- Search form -->
         <div class="container rounded-lg shadow p-3 mb-3 bg-white rounded">
            <div class="row mt-3">
            <div class="col-lg-3 mb-3">
            </div>
            <div class="col-lg-9 mb-3 text-right">
             <!-- Button trigger modal -->
              <button type="button" class="btn btn-primary mt-1" data-toggle="modal" data-target="#staticBackdrop">
                <i class="far fa-plus-square"></i> Tambah Detail Transaksi
              </button>
            </div>
          </div>
        </div>

           <div class="container rounded-lg mt-3 shadow-lg p-3 mb-5 bg-white rounded">
             <div class="table-responsive mt-3">
            <table class="table table-bordered table-striped text-dark text-center">
              <thead class="text-center" style="background-color: skyblue;">
                <tr>
                  <th>No</th>
                  <th>Jenis Paket</th>
                  <th>Nama Paket</th>
                  <th>Harga Satuan</th>
                  <th>Jumlah Barang</th>
                  <th>Jumlah Harga</th>
                  <th>Opsi</th>
                </tr>
              </thead>
              <tbody>
                <?php $n=1; ?>
                <?php foreach ($detail_transaksi as $data): 
                    $jumlah_harga = $data['harga'] * $data['qty'];
                  ?>
                  <tr>
                    <td><?php echo $n++; ?>.</td>
                    <td><?php echo ucwords($data['jenis']); ?></td>
                    <td><?php echo $data['nama_paket']; ?></td>
                    <td>Rp.<?php echo number_format($data['harga']); ?></td>
                    <td><?php echo $data['qty']; ?></td>
                    <td>Rp.<?php echo number_format($jumlah_harga); ?></td>
                    <td>
                      <?php if ($_SESSION['role'] == 'admin'): ?>
                        <a data-toggel="popover" data-placement="buttom" title="Hapus Detail Transaksi" onclick="return confirm('Apakah ingin menghapus data ini?')" class="btn btn-danger swalDefaulthapus" href="hapus_detail_transaksi.php?id_detail_transaksi=<?php echo $data['id_detail_transaksi']; ?>"><i class="fas fa-trash-alt"></i></a>
                      <?php endif ?>
                    </td>
                  </tr>
                  <?php 
                    $harga_total += $jumlah_harga; 

                    //perhitungan pajak
                            
                      $pajak = 0.1 * $harga_total;
                      $sql_pajak = mysqli_query($konek, "UPDATE transaksi SET pajak = '$pajak' WHERE transaksi.id_transaksi = '$id_transaksi'");
                      

                    //perhitungan diskon
                    if ($harga_total>90000) {
                      $diskon = 0.10 * $harga_total;
                    }
                      $sql_diskon = mysqli_query($konek, "UPDATE transaksi SET diskon = '$diskon' WHERE transaksi.id_transaksi = '$id_transaksi'");
                  ?>
              </tbody>
            <?php endforeach ?>
            </table>
              <h4>Keterangan Administrasi : </h4>      
              <h5>Total Harga : Rp.<?php echo number_format($harga_total); ?></h5>
              <h5>Pajak : <?php echo number_format($pajak); ?>%</h5>
              <h5>Diskon 10% (Jika lebih dari Rp.90.000) : <?php echo number_format($diskon); ?>%</h5>
            </div>
            <hr>
             <footer class="main-footer">
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
                <h5 class="modal-title text-white" id="staticBackdropLabel"><i class="fas fa-align-justify"></i> <i class="fas fa-plus"></i> | Tambah Detail Transaksi</h5>
                <button type="button" class="close text-white" data-dismiss="modal" aria-label="Close">
                  <span aria-hidden="true">&times;</span>
                </button>
              </div>
              <div class="modal-body">
               <form action="" method="POST">
                <input type="hidden" name="id_transaksi" value="<?php echo $id_transaksi; ?>">
                 <div class="form-group">
                   <label for="" class="text-white">Paket Cuci</label>
                    <div class="input-group">
                            <div class="input-group-prepend">
                              <span class="input-group-text"><i class="fas fa-boxes"></i></i></span>
                            </div>
                              <select name="id_paket" class="form-control" id="">
                               <?php foreach ($panggil_paket as $data): ?>
                                  <option value="<?php echo $data['id_paket']; ?>"><?php echo $data['nama_paket']; ?> | Rp.<?php echo number_format($data['harga']); ?> per Kg/Satuan</option>
                               <?php endforeach ?>
                             </select>
                            </div>
                    </div>
                 <div class="form-row">
                  <div class="col-lg-4">
                     <label for="" class="text-white">Jumlah</label>
                     <input type="number" name="qty" required class="form-control">
                  </div>
                  <div class="col-lg-8">
                    <label for="" class="text-white">Keterangan</label>
                    <div class="input-group">
                            <div class="input-group-prepend">
                              <span class="input-group-text"><i class="fas fa-info"></i></i></span>
                            </div>
                            <input type="text" class="form-control" name="keterangan">
                          </div>
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
    $(document).ready(function(){
      $('[data-toggle="popover"]').popover();
    });
  </script>


</body>

</html>
