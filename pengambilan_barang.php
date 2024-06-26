<?php 
  
  require 'koneksi.php';

  //login
  if (!isset($_SESSION['status_login'])) {
    if ($_SESSION['status_login'] !== 1) {
      header('location:login.php');
      exit;
    }
  }

  //panngil kode invoice dari table transaksi
  $panggil_invoice_2 = mysqli_query($konek, "SELECT * FROM transaksi as tr INNER JOIN outlet as ot ON tr.id_outlet = ot.id_outlet INNER JOIN member as mb ON tr.id_member = mb.id_member INNER JOIN user as us ON tr.id_user = us.id_user");

  //jika tombol cari di tekan
  if (isset($_POST['cari_bedasarkan_kode_invoice'])) {
    $keyword = $_POST['kode_invoice'];
    $panggil_invoice = mysqli_query($konek, "SELECT * FROM transaksi as tr INNER JOIN outlet as ot ON tr.id_outlet = ot.id_outlet INNER JOIN member as mb ON tr.id_member = mb.id_member INNER JOIN user as us ON tr.id_user = us.id_user WHERE tr.kode_invoice LIKE '%$keyword%'");
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

  <title>SlowClean | Pengambilan Barang </title>

  <!-- Custom fonts for this template-->
  <link href="bs/vendor/fontawesome-free/css/all.min.css" rel="stylesheet" type="text/css">
  <link href="bs/https://fonts.googleapis.com/css?family=Nunito:200,200i,300,300i,400,400i,600,600i,700,700i,800,800i,900,900i" rel="stylesheet">
  <link rel="stylesheet" href="bs/css/sweetalert2.css">

  <!-- Custom styles for this template-->
  <link href="bs/css/sb-admin-2.min.css" rel="stylesheet">

</head>

<body id="page-top">

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
    <div id="content-wrapper" class="d-flex flex-column text-dark mt-1">
       <div class="jumbotron jumbotron-fluid" style="background-image: url(img/bg-logn5.png); background-repeat: no-repeat; height: 370px;">
          <center>
            <h1 class="display-7 text-white mt-4">PENGAMBILAN BARANG</h1>
             <form action="" method="POST">
              <div class="row justify-content-center mt-5">
                <div class="col-lg-3">
                  <button type="submit" class="btn btn-outline-light btn-lg btn-block text-dark" name="mulai_cari">Cari Pelanggan</button>
                </div>
              </div>
          <?php if (isset($_POST['mulai_cari'])): ?>
              <div class="row justify-content-center mt-4">
                <div class="col-lg-2">
                  <h5 class="text-white">Kode Invoice</h5>
                </div>
                <div class="col-lg-1">
                  <input type="text" name="kode_invoice" class="form-control">
                </div>
              </div> 
              <div class="row justify-content-center mt-3 mb-2">
                <div class="col-lg-2">
                  <button type="submit" class="btn btn-success btn-lg btn-block" name="cari_bedasarkan_kode_invoice"><i class="fas fa-search"></i></button>
                </div>
              </div>
            <?php endif ?>
             </form> 
          </center>
      </div>
      
      <div id="content" class="p-4 p-md-5 pt-5">
         <?php if (isset($_POST['cari_bedasarkan_kode_invoice'])): ?>
             <div class="container rounded-lg mt-3 shadow-lg p-3 mb-5 bg-white rounded">
             <div class="table-responsive mt-3">
                <table class="table table-bordered table-striped text-dark">
                  <thead class="text-center" style="background-color: skyblue;">
                   <tr>
                    <th>No</th>
                    <th>Kode Invoice</th>
                    <th>Nama Pelanggan</th>
                    <th>Outlet</th>
                    <th>Tanggal Masuk</th>
                    <th>Tanggal Keluar</th>
                    <th>Biaya Cuci</th>
                    <th>Pajak</th>
                    <th>Biaya Tambahan</th>
                    <th>Diskon</th>
                    <th>Total Harga</th>
                    <th>Status Cuci</th>
                    <th>Status Pembayaran</th>
                    <th>Penginput</th>
                    <th>Opsi</th>
                   </tr>
                  </thead>
                  <tbody>
                    <?php $no=1; ?>
                    <?php foreach ($panggil_invoice as $data): 
                        $id_transaksi = $data['id_transaksi'];
                        $harga_total = 0;

                        //mencari total harga dari table detail
                        $sql_panggil_detail = "SELECT * FROM detail_transaksi as dt INNER JOIN transaksi as tr ON dt.id_transaksi = tr.id_transaksi INNER JOIN paket as pk ON dt.id_paket = pk.id_paket WHERE dt.id_transaksi = '$id_transaksi'";
                        $panggil_detail_transaksi = mysqli_query($konek, $sql_panggil_detail);
                        while ($data_total = mysqli_fetch_array($panggil_detail_transaksi)) {
                          $jumlah_harga = $data_total['harga'] * $data_total['qty'];
                          $harga_total += $jumlah_harga;
                        }

                        $total_bayar = ($harga_total + $data['pajak'] + $data['biaya_tambahan']) - $data['diskon'];

                      ?>
                      
                      <tr>
                        <td><?php echo $no++; ?>.</td>
                        <td><?php echo $data['kode_invoice']; ?></td>
                        <td><a class="btn btn-info" href="info_transaksi_pelanggan.php?id_transaksi=<?php echo $data['id_transaksi']; ?>"><?php echo $data['nama_member']; ?></a></td>
                        <td><?php echo $data['nama_outlet']; ?></td>
                        <td><?php echo date_format(date_create($data['tgl']), "d-M-Y"); ?></td>
                        <td><?php echo date_format(date_create($data['batas_waktu']), "d-M-Y"); ?></td>
                        <td>Rp.<?php echo number_format($harga_total); ?></td>
                        <td><?php echo number_format($data['pajak']); ?>%</td>
                        <td>Rp.<?php echo number_format($data['biaya_tambahan']); ?></td>
                        <td><?php echo number_format($data['diskon']); ?>%</td>
                        <td>Rp.<?php echo number_format($total_bayar); ?></td>
                        <td class="text-center">
                          <?php 
                            $id_transaksi = $data['id_transaksi'];
                            $status_detail = mysqli_query($konek, "SELECT * FROM detail_transaksi as dt INNER JOIN transaksi as tr ON dt.id_transaksi = tr.id_transaksi INNER JOIN paket as pk ON dt.id_paket = pk.id_paket WHERE tr.id_transaksi = '$id_transaksi'");
                           ?>
                           <?php if (mysqli_fetch_assoc($status_detail) == NULL): ?>
                             <a class="btn btn-secondary" href="detail_transaksi.php?id_transaksi=<?php echo $data['id_transaksi']; ?>">
                               Kosong
                             </a>
                           <?php else: ?>
                          <?php if ($data['status'] == 'baru'): ?>
                            <span class="btn btn-sm btn-info"><?php echo $data['status']; ?></span>
                          <?php elseif ($data['status'] == 'proses'):?>
                            <span class="btn btn-sm btn-danger"><?php echo $data['status']; ?></span>
                          <?php elseif ($data['status'] == 'selesai'):?>
                            <span class="btn btn-sm btn-success"><?php echo $data['status']; ?></span>
                          <?php elseif ($data['status'] == 'diambil'):?>
                            <span class="btn btn-sm btn-dark"><?php echo $data['status']; ?></span>
                          <?php endif ?>
                         <?php endif ?>
                        </td>
                        <td>
                            <?php if ($data['dibayar'] == 'belum dibayar'): ?>
                              <a href="bayar.php?id_transaksi=<?php echo $data['id_transaksi'] ?>">
                                <span class="btn btn-sm btn-danger"><?php echo $data['dibayar']; ?></span>
                              </a>
                            <?php elseif ($data['dibayar'] == 'sudah dibayar'):?>
                              <span class="btn btn-sm btn-success"><?php echo $data['dibayar']; ?></span>
                            <?php endif ?>
                        </td>
                        <td><?php echo ucwords($data['nama_user']); ?></td>
                        <td>
                            <?php if ($_SESSION['role'] == 'admin' OR $_SESSION['role'] == 'kasir'): ?>
                              <a data-toggle="popover" data-placement="bottom" title="Invoice Transaksi" class="btn btn-warning" href="lembaran_invoice.php?id_transaksi=<?php echo $data['id_transaksi']; ?>"><i class="fas fa-file-invoice"></i></a>
                            <?php endif ?>
                        </td>
                      </tr>
                    <?php endforeach ?>
                  </tbody>
                </table>
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
          <?php endif ?>
      </div>
    </div>
    <!-- End of Content Wrapper -->
  </div>
  <!-- End of Page Wrapper -->

  <!-- Bootstrap core JavaScript-->
  <script src="bs/vendor/jquery/jquery.min.js"></script>
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

  <script src="bs/js/sweetalert2-config.js"></script>



</body>

</html>
