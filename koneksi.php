<?php 

	session_start();
	$konek = mysqli_connect("localhost", "root", "", "laundri_v2");

	if ($konek) {
		//echo "Data ke sambung";
	}

	function tambah_pelanggan_cuci($data){

		global $konek;

		$nama_member = $data['nama_member'];
		$alamat = $data['alamat'];
		$jenis_kelamin = $data['jenis_kelamin'];
		$no_telepon = $data['no_telepon'];

		mysqli_query($konek, "INSERT INTO member (nama_member, alamat, jenis_kelamin, no_telepon) VALUES ('$nama_member', '$alamat', '$jenis_kelamin', '$no_telepon')");
		
		$id_user_riwayat = $_SESSION['id_user'];
		$message = "menambahkan Pelanggan cuci";
		riwayat($id_user_riwayat, $message);

		return mysqli_affected_rows($konek);
	}

	function hapus_pelanggan($data){

		global $konek;

		$id_member = $data['id_member'];

		mysqli_query($konek, "DELETE FROM member WHERE id_member = '$id_member'");

		$hapus_pelanggan_cuci = $_SESSION['id_user'];
		$message = "meng-hapus pelanggan";
		riwayat($hapus_pelanggan_cuci, $message); 

		return mysqli_affected_rows($konek);
	}

	function ubah_pelanggan($data){

		global $konek;

		$id_member = $data['id_member'];
		$nama_member = $data['nama_member'];
		$alamat = $data['alamat'];
		$jenis_kelamin = $data['jenis_kelamin'];
		$no_telepon = $data['no_telepon'];

		$query = mysqli_query($konek, "UPDATE member SET nama_member = '$nama_member', alamat = '$alamat', jenis_kelamin = '$jenis_kelamin', no_telepon = '$no_telepon' WHERE id_member = '$id_member'");

		$ubah_pelanggan = $_SESSION['id_user'];
		$message = "meng-ubah pelanggan";
		riwayat($ubah_pelanggan, $message);

		return mysqli_affected_rows($konek);
	}

	
	function hapus_paket($data){

		global $konek;

		$id_paket = $data['id_paket'];

		mysqli_query($konek, "DELETE FROM paket WHERE id_paket = '$id_paket'");

		$hapus_paket_1 = $_SESSION['id_user'];
		$message = "meng-hapus paket";
		riwayat($hapus_paket_1, $message);

		return mysqli_affected_rows($konek);
	}

	function tambah_paket($data){

		global $konek;

		$id_outlet = $data['id_outlet'];
		$nama_paket = $data['nama_paket'];
		$jenis = $data['jenis'];
		$harga = $data['harga'];

		mysqli_query($konek, "INSERT INTO paket (id_outlet, nama_paket, jenis, harga) VALUES ('$id_outlet', '$nama_paket', '$jenis', '$harga')");

		$riwayat_tambah_paket = $_SESSION['id_user'];
		$message = "menambahkan paket";
		riwayat($riwayat_tambah_paket, $message);

		return mysqli_affected_rows($konek);
	}

	function ubah_paket($data){

		global $konek;

		$id_paket = $data['id_paket'];
		$id_outlet = $data['id_outlet'];
		$nama_paket = $data['nama_paket'];
		$jenis = $data['jenis'];
		$harga = $data['harga'];

		mysqli_query($konek, "UPDATE paket SET id_outlet = '$id_outlet', nama_paket = '$nama_paket', jenis = '$jenis', harga = '$harga' WHERE id_paket = '$id_paket'");

		$ubah_paket = $_SESSION['id_user'];
		$message = "meng-update paket";
		riwayat($ubah_paket, $message);

		return mysqli_affected_rows($konek);
	}

	function hapus_pengguna($data){

		global $konek;

		$id_user = $data['id_user'];

		mysqli_query($konek, "DELETE FROM user WHERE id_user = '$id_user'");

		$hapus_riwayat = $_SESSION['id_user'];
		$message = "meng-hapus user";
		riwayat($hapus_riwayat, $message);

		return mysqli_affected_rows($konek);
	}

	function ubah_pengguna($data){

		global $konek;

		$id_user = $data['id_user'];
		$id_outlet = $data['id_outlet'];
		$nama_user = $data['nama_user'];
		$username = $data['username'];
		$role = $data['role'];

		mysqli_query($konek, "UPDATE user SET id_outlet = '$id_outlet', nama_user = '$nama_user', username = '$username', role = '$role' WHERE id_user = '$id_user'");

		$id_user_riwayat = $_SESSION['id_user'];
		$message = "meng-update user";
		riwayat($id_user_riwayat, $message);

		return mysqli_affected_rows($konek);
	}

	function riwayat($id_user, $message) {
		global $konek;
		return mysqli_query($konek, "INSERT INTO riwayat VALUES (NULL, '$id_user', '$message', NOW())");
	}

	function tambah_transaksi($data){

		global $konek;

		$id_outlet = $data['id_outlet'];
		$kode_invoice = $data['kode_invoice'];
		$id_member = $data['id_member'];
		$id_user = $data['id_user'];	
		$tgl = $data['tgl'];
		$batas_waktu = $data['batas_waktu'];
		$status = $data['status'];
		$dibayar = $data['dibayar'];

		 mysqli_query($konek, "INSERT INTO transaksi (id_outlet, kode_invoice, id_member, id_user, tgl, batas_waktu, biaya_tambahan, diskon, pajak, status, dibayar) VALUES ('$id_outlet', '$kode_invoice', '$id_member', '$id_user', '$tgl', '$batas_waktu', NULL, NULL, NULL, '$status', '$dibayar')");


		$nambah_transaksi = $_SESSION['id_user'];
		$message = 'menambahkan transaksi';
		riwayat($nambah_transaksi, $message);

		return mysqli_affected_rows($konek);
	}

	function hapus_transaksi($data){

		global $konek;

		$id_transaksi = $data['id_transaksi'];

		mysqli_query($konek, "DELETE FROM transaksi WHERE id_transaksi = '$id_transaksi'");

		$hapus_transaksi = $_SESSION['role'];
		$message = 'meng-hapus transaksi';
		riwayat($hapus_transaksi, $message);

		return mysqli_affected_rows($konek);
	}


	function transaksi_ubah($data){

		global $konek;

		$id_transaksi = $data['id_transaksi'];
		$id_outlet = $data['id_outlet'];
		$kode_invoice = $data['kode_invoice'];
		$id_member = $data['id_member'];
		$id_user = $data['id_user'];
		$tgl = $data['tgl'];
		$batas_waktu = $data['batas_waktu'];
		$status = $data['status'];
		$dibayar = $data['dibayar'];
		
		 mysqli_query($konek, "UPDATE transaksi SET id_outlet = '$id_outlet', kode_invoice = '$kode_invoice', id_member = '$id_member', id_user = '$id_user', tgl = '$tgl', batas_waktu = '$batas_waktu', status = '$status', dibayar = '$dibayar' WHERE id_transaksi = '$id_transaksi'");


		$ubah_transaksi = $_SESSION['id_user'];
		$message = 'meng-ubah transaksi';
		riwayat($ubah_transaksi, $message);

		return mysqli_affected_rows($konek);
	}

	function hapus_detail_transaksi($data){

		global $konek;

		$id_detail_transaksi = $data['id_detail_transaksi'];

		mysqli_query($konek, "DELETE FROM detail_transaksi WHERE id_detail_transaksi = '$id_detail_transaksi'");

		$menghapus_detail = $_SESSION['id_user'];
		$message = 'meng-hapus Detail transaksi';
		riwayat($menghapus_detail, $message);

		return mysqli_affected_rows($konek);
	}

	function tambah_detail_transaksi($data){

		global $konek;

		$id_transaksi = $data['id_transaksi'];
		$id_paket = $data['id_paket'];
		$qty = $data['qty'];
		$keterangan = $data['keterangan'];

		 mysqli_query($konek, "INSERT INTO detail_transaksi (id_detail_transaksi, id_transaksi, id_paket, qty, keterangan) VALUES (NULL, '$id_transaksi', '$id_paket', '$qty', '$keterangan')");

		$nambah_detail = $_SESSION['id_user'];
		$message = 'menambahkan detail transaksi';
		riwayat($nambah_detail, $message);

		return mysqli_affected_rows($konek);
	}


 ?>