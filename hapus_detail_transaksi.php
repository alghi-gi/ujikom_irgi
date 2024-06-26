<script src="bs/vendor/jquery/jquery.min.js"></script>
<script src="bs/vendor/sweetalert2/sweetalert2.all.min.js"></script>
<?php 

	require 'koneksi.php';
	$id_detail_transaksi = $_GET['id_detail_transaksi'];
	$detail_transaksi = mysqli_query($konek, "SELECT * FROM detail_transaksi WHERE id_detail_transaksi = '$id_detail_transaksi'");
	$fetch_detail_transaksi = mysqli_fetch_assoc($detail_transaksi);
	$id_transaksi = $fetch_detail_transaksi['id_transaksi'];
	if (isset($_GET['id_detail_transaksi'])) {
		if (hapus_detail_transaksi($_GET) > 0) {
			echo "
				<script>
					 $(document).ready(function() {
	                    Swal.fire({
	                      type: 'success',
	                      title: 'Detail berhasil dihapus!',
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
	                      title: 'Detail gagal dihapus!',
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

 ?>