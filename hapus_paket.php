<script src="bs/vendor/jquery/jquery.min.js"></script>
<script src="bs/vendor/sweetalert2/sweetalert2.all.min.js"></script>
<?php 

	require 'koneksi.php';

	if (isset($_GET['id_paket'])) {
		if (hapus_paket($_GET) > 0) {
			echo "
				<script>
					$(document).ready(function() {
		                Swal.fire({
		                  type: 'success',
		                  title: 'Paket berhasil dihapus!',
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
		                  type: 'error',
		                  title: 'Paket gagal ditambah!',
		                }).then((result = true) => {
		                  if (result.value) {
		                    document.location.href = 'paket.php';
		                  }
		                });
		              })
				</script>
			";
		}
	}

 ?>