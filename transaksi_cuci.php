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

   $panggil_table = mysqli_query($konek, "SELECT * FROM transaksi as tr INNER JOIN outlet as ot ON tr.id_outlet = ot.id_outlet INNER JOIN member as mb ON tr.id_member = mb.id_member INNER JOIN user as us ON tr.id_user = us.id_user ORDER BY tr.kode_invoice ASC LIMIT $mulai, $tampil_hal ");

   $sql_no_limit = mysqli_query($konek, "SELECT * FROM transaksi as tr INNER JOIN outlet as ot ON tr.id_outlet = ot.id_outlet INNER JOIN member as mb ON tr.id_member = mb.id_member INNER JOIN user as us ON tr.id_user = us.id_user ORDER BY tr.kode_invoice ASC");

   $total_hal = mysqli_num_rows($sql_no_limit);

   $semua = ceil($total_hal/$tampil_hal); 

   //echo "$semua";


  //cari data
  if (isset($_POST['cari'])) {
    $keyword = $_POST['cari_data'];
    $panggil_table = mysqli_query($konek, "SELECT * FROM transaksi as tr INNER JOIN outlet as ot ON tr.id_outlet = ot.id_outlet INNER JOIN member as mb ON tr.id_member = mb.id_member INNER JOIN user as us ON tr.id_user = us.id_user WHERE mb.nama_member LIKE '%$keyword%'");
  }

  //cari status cuci
  if (isset($_POST['cari_status'])) {
    $keyword2 = $_POST['status'];
    $panggil_table = mysqli_query($konek, "SELECT * FROM transaksi as tr INNER JOIN outlet as ot ON tr.id_outlet = ot.id_outlet INNER JOIN member as mb ON tr.id_member = mb.id_member INNER JOIN user as us ON tr.id_user = us.id_user WHERE tr.status LIKE '%$keyword2%'");
  }

  //cari tanggal & batas waktu
  if (isset($_POST['cari_tgl'])) {
    $tgl_awal = $_POST['tgl_awal'];
    $tgl_akhir = $_POST['tgl_akhir'];
    $panggil_table = mysqli_query($konek, "SELECT * FROM transaksi as tr INNER JOIN outlet as ot ON tr.id_outlet = ot.id_outlet INNER JOIN member as mb ON tr.id_member = mb.id_member INNER JOIN user as us ON tr.id_user = us.id_user  WHERE tgl BETWEEN '$tgl_awal' AND '$tgl_akhir'");
  }

  //jika button tambah di tekan
  if (isset($_POST['tambah'])) {
    if (tambah_transaksi($_POST) > 0) {
      echo "
        <script>
          $(document).ready(function() {
                    Swal.fire({
                      type: 'success',
                      title: 'Transaksi berhasil ditambah!',
                    }).then((result = true) => {
                      if (result.value) {
                        document.location.href = 'transaksi_cuci.php';
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
                      title: 'Transaksi berhasil ditambah!',
                    }).then((result = true) => {
                      if (result.value) {
                        document.location.href = 'transaksi_cuci.php';
                      }
                    });
                  })
        </script>
      ";
    }
  }

  //panggil nama user dari table user
  $panggil_user = mysqli_query($konek, "SELECT * FROM user");

  //panggil outlet dari table outlet
  $panggil_outlet = mysqli_query($konek, "SELECT * FROM outlet");
  $panggil = mysqli_fetch_assoc($panggil_outlet);

  //panggil member dari table member
  $panggil_member = mysqli_query($konek, "SELECT * FROM member");

  
 ?>
<!DOCTYPE html>
<html lang="en">

<head>

  <meta charset="utf-8">
  <meta http-equiv="X-UA-Compatible" content="IE=edge">
  <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
  <meta name="description" content="">
  <meta name="author" content="">

  <title>SlowClean | Transaksi</title>

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
                        <a class="dropdown-item" href="paket.php">Paket Cuci</a>
                        <a class="dropdown-item active" href="transaksi_cuci.php">Transaksi</a>
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
          <h4><i class="fas fa-table"></i> | Data Transaksi</h4>
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
            <div class="col-lg-6 mt-1">
              <form action="" method="POST" class="form-inline mr-1 col-9">
                <select name="status" id="" class="form-control mr-1">
                  <option value="">-- Status Cuci--</option>
                  <option value="baru">Baru</option>
                  <option value="proses">Proses</option>
                  <option value="selesai">Selesai</option>
                  <option value="diambil">Diambil</option>
                </select>
                <div class="form-group">
                  <button type="submit" class="btn btn-primary" name="cari_status"><i class="fas fa-search" aria-hidden="true"></i></button>
                </div>
              </form>
            </div>
            <div class="col-lg-3 text-right">
              <!-- Button trigger modal -->
            <button type="button" class="btn btn-primary mt-1" data-toggle="modal" data-target="#staticBackdrop">
              <i class="far fa-plus-square"></i> Tambah Transaksi
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
                    <?php $no=$mulai+1; ?>
                    <?php foreach ($panggil_table as $data): 
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
                           <a class="btn btn-success" title="Ubah Data Transaksi" data-toggle="popover" data-placement="bottom" href="ubah_transaksi.php?id_transaksi=<?php echo $data['id_transaksi']; ?>"><i class="fas fa-pen"></i></a>
                         <?php endif ?>
                         <?php if ($_SESSION['role'] == 'admin' OR $_SESSION['role'] == 'kasir'): ?>
                            <a data-toggle="popover" data-placement="bottom" title="Tambah Detail Transaksi" class="btn btn-info mt-1 mb-1" href="detail_transaksi.php?id_transaksi=<?php echo $data['id_transaksi']; ?>"><i class="fas fa-info-circle"></i></a> 
                         <?php endif ?>
                          <?php if ($_SESSION['role'] == 'admin'): ?>
                            <a onclick="return confirm('Apakah data ini ingin hapus??!')" data-placement="bottom" data-toggle="popover" title="Hapus Transaksi" class="btn btn-danger mb-1 swalDefaulthapus" href="hapus_transaksi.php?id_transaksi=<?php echo $data['id_transaksi']; ?>"><i class="fas fa-trash-alt"></i></a>
                          <?php endif ?>
                            <?php if ($_SESSION['role'] == 'admin' OR $_SESSION['role'] == 'kasir'): ?>
                              <a data-toggle="popover" data-placement="bottom" title="Invoice Transaksi" class="btn btn-warning" href="lembaran_invoice.php?id_transaksi=<?php echo $data['id_transaksi']; ?>"><i class="fas fa-file-invoice"></i></a>
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
                <h5 class="modal-title text-white" id="staticBackdropLabel"><i class="fas fa-align-justify"></i> <i class="fas fa-plus"></i> | Tambah Transaksi</h5>
                <button type="button" class="close text-white" data-dismiss="modal" aria-label="Close">
                  <span aria-hidden="true">&times;</span>
                </button>
              </div>
              <div class="modal-body text-white">
                <form action="" method="POST">
                  <input type="hidden" name="id_user" value="<?php echo $_SESSION['id_user']; ?>">
                  <input type="hidden" name="id_outlet" value="<?php echo $panggil['id_outlet']; ?>">
                  <div class="form-row">
                    <div class="col-lg-8">
                      <label for="">Nama Pelanggan</label>
                      <div class="input-group">
                            <div class="input-group-prepend">
                              <span class="input-group-text"><i class="fas fa-user"></i></i></span>
                            </div>
                           <select name="id_member" class="form-control" id="">
                             <?php foreach ($panggil_member as $data): ?>
                              <option value="<?php echo $data['id_member']; ?>"><?php echo $data['nama_member']; ?></option>
                             <?php endforeach ?>
                           </select>
                          </div>
                    </div>
                    <div class="col-lg-4">
                      <label for="">Kode Invoice</label>
                      <input type="number" name="kode_invoice" required class="form-control" placeholder="Contoh : 001">
                    </div>
                  </div>
                  <div class="form-row mt-2">
                    <div class="col-lg-6">
                      <label for="">Tanggal Masuk</label>
                       <div class="input-group">
                          <div class="input-group-prepend">
                            <span class="input-group-text"><i class="far fa-calendar-alt"></i></span>
                          </div>
                          <input type="date" class="form-control" name="tgl" value="<?php echo date('Y-m-d'); ?>">
                        </div>
                    </div>
                    <div class="col-lg-6">
                      <label for="">Tanggal Keluar</label>
                        <div class="input-group">
                            <div class="input-group-prepend">
                              <span class="input-group-text"><i class="far fa-clock"></i></i></span>
                            </div>
                            <input type="date" class="form-control" name="batas_waktu" value="<?php echo date('Y-m-d'); ?>">
                          </div>
                    </div>
                  </div>
                  <div class="form-row mt-2">
                    <div class="col-lg-6">
                      <label for="">Status Cuci</label>
                      <select name="status" class="form-control"id="">
                        <option value="baru">Baru</option>
                      </select>
                    </div>
                    <div class="col-lg-6">
                      <label for="">Status Pembayaran</label>
                      <select name="dibayar" class="form-control"id="">
                        <option value="belum dibayar">Belum dibayar</option>
                      </select>
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
  <script>
    $(document).ready(function (){
      $('[data-toggel="popover"]').popover();
    });
  </script>

</body>

</html>
