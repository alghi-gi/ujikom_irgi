<script src="bs/vendor/jquery/jquery.min.js"></script>
<script src="bs/vendor/sweetalert2/sweetalert2.all.min.js"></script>
<?php 

	require 'koneksi.php';

	if (isset($_GET['id_transaksi'])) {
		if (hapus_transaksi($_GET) > 0) {
			echo "
				<script>
					$(document).ready(function() {
		                Swal.fire({
		                  type: 'success',
		                  title: 'Transaksi berhasil dihapus!',
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
		                  title: 'Transaksi gagal dihapus!',
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


 ?>