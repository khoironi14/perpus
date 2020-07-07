<?php
	include "koneksi/koneksi.php";
	session_start();
		if(isset($_SESSION["username"])){
			header("location: template/external/adminlte/index.php");
		}
	$qAdmin = mysqli_query($koneksi, "SELECT * FROM tb_user");
	$cekAdmin = mysqli_fetch_array($qAdmin);
?>

<!DOCTYPE html>
<html lang="en">
<head>
	<title>PERPUSTAKAAN | GRISA</title>
	<meta charset="UTF-8">
	<meta name="viewport" content="width=device-width, initial-scale=1">
<!--===============================================================================================-->	
	<link rel="icon" type="image/png" href="template/external/images/icons/favicon.ico"/>
<!--===============================================================================================-->
	<link rel="stylesheet" type="text/css" href="template/external/vendor/bootstrap/css/bootstrap.min.css">
<!--===============================================================================================-->
	<link rel="stylesheet" type="text/css" href="template/external/fonts/font-awesome-4.7.0/css/font-awesome.min.css">
<!--===============================================================================================-->
	<link rel="stylesheet" type="text/css" href="template/external/vendor/animate/animate.css">
<!--===============================================================================================-->	
	<link rel="stylesheet" type="text/css" href="template/external/vendor/css-hamburgers/hamburgers.min.css">
<!--===============================================================================================-->
	<link rel="stylesheet" type="text/css" href="template/external/vendor/select2/select2.min.css">
<!--===============================================================================================-->
	<link rel="stylesheet" type="text/css" href="template/external/css/util.css">
	<link rel="stylesheet" type="text/css" href="template/external/css/main.css">
<!--================== =============================================================================-->
	<script src="template/external/jquery.js"></script>

</head>
<body>
	
<a href="index.php"><div style="position: fixed; z-index: 999; width: 100%" id="tampil_sedia"></div></a>
<div style="position: absolute;" class="limiter">
	<div class="container-login100">
		<div class="wrap-login100">
			<img width="100px" class="login00-pic js-tilt" data-tilt style="margin-left: 45%; margin-bottom: 50px;" src="template/external/images/grisa.png" alt="gambar">
			<input id="search_sedia" style="display: block; margin-left: 0%; width: 122em; margin-bottom: 22%; color: red; outline-style: double;" type="text" placeholder="Cek Buku">
			<div class="login100-pic js-tilt" data-tilt>
				FATKHUL UMAR | 16112307
			</div>
            <a href="index.php">Login</a>
		</div>
		</div>
    </div>

  <!-- ============================perubahan========================= -->

	<script>
    $(document).ready(function(){
      $('#search_sedia').keyup(function(){
        var search = $('#search_sedia').val()
        $.ajax({
          type : 'POST',
          url : 'proses/ajax_sedia.php?search_sedia=' + search,
          data : 'search=' + search,
          success : function(data){
            $('#tampil_sedia').html(data)
          }
        })
      })
    })
</script>
	
<!-- ============================perubahan========================= -->

	

	
<!--===============================================================================================-->	
	<script src="template/external/vendor/jquery/jquery-3.2.1.min.js"></script>
<!--===============================================================================================-->
	<script src="template/external/vendor/bootstrap/js/popper.js"></script>
	<script src="template/external/vendor/bootstrap/js/bootstrap.min.js"></script>
<!--===============================================================================================-->
	<script src="template/external/vendor/select2/select2.min.js"></script>
<!--===============================================================================================-->
	<script src="template/external/vendor/tilt/tilt.jquery.min.js"></script>
	<script >
		$('.js-tilt').tilt({
			scale: 1.1
		})
	</script>
<!--===============================================================================================-->
	<script src="template/external/js/main.js"></script>

</body>
</html>