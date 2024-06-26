<script src="bs/vendor/jquery/jquery.min.js"></script>
<script src="bs/vendor/sweetalert2/sweetalert2.all.min.js"></script>
<?php 
	
	require 'koneksi.php';

	//hapus pengguna
	if (isset($_GET['id_user'])) {
		if (hapus_pengguna($_GET) > 0) {
			echo "
				<script>
					$(document).ready(function() {
                    Swal.fire({
                      type: 'success',
                      title: 'Pengguna berhasil dihapus!',
                    }).then((result = true) => {
                      if (result.value) {
                        document.location.href = 'daftar_pengguna.php';
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
                      title: 'Pengguna gagal ditambah!',
                    }).then((result = true) => {
                      if (result.value) {
                        document.location.href = 'daftar_pengguna.php';
                      }
                    });
                  })
				</script>
			";
		}
	}

 ?>