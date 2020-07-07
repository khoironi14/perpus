<?php error_reporting(0); if($_SESSION["cekStatus"] == 0 || $_SESSION["cekStatus"] == 1): ?>

<?php
    // $qBuku = mysqli_query($koneksi, "SELECT * FROM tb_buku b LEFT JOIN tb_lokasi_buku l ON b.id_lokasi_buku = l.id_lokasi_buku");
    $qqBuku = mysqli_query($koneksi, "SELECT * FROM tb_buku");
    $cekBuku = mysqli_fetch_array($qqBuku);
    if($cekBuku == null){
        $setAutoIncrement = mysqli_query($koneksi, "ALTER TABLE tb_buku AUTO_INCREMENT = 1");
    }
?>

   

    <div class="container">
    <div class="content">
        <div class="row mb-2">
            <div class="col-sm-6">
              
            </div><!-- /.col -->
        </div><!-- /.row -->
    </div>

    <div style="margin-bottom: 5px;">
       
    </div>

    <?php

        $page = (isset($_GET['pageBuku']))? $_GET['pageBuku'] : 1; // Cek apakah terdapat data page pada URL
        $limit = 10; // Jumlah data per halamannya
        // Untuk menentukan dari data ke berapa yang akan ditampilkan pada tabel yang ada di database      
        $limit_start = ($page - 1) * $limit;
        // Buat query untuk menampilkan data siswa sesuai limit yang ditentukan          
        $sql = mysqli_query($koneksi, "SELECT * FROM tb_buku b LEFT JOIN tb_lokasi_buku l ON b.id_lokasi_buku = l.id_lokasi_buku LIMIT ".$limit_start.",".$limit);  
        $no = $limit_start + 1; // Untuk penomoran tabel 
    
        $nomor = 0;

    ?>
  <!-- ============================perubahan========================= -->
    <!-- <script src="../jquery.js"></script> -->
  <!-- ============================/perubahan========================= -->

   
   
    <div class="card">
        
        <div class="card-header bg-primary">
        <div class="row">
            <div class="col-md-6">
                <h1 class="m-0 text-white">
                    <strong>Data Buku</strong>
                </h1>
            </div>
            <div class="col-md-6">
                <form action="../../../proses/proses.php" method="post" class="float-right">
                    <a class="btn btn-danger float-right btn-sm" href="index.php?tambahBuku">(+) Tambah Buku</a>
                    <div class="form-group row">
                        <div class="col-md-6">
                            <!-- <input class="form-control" style="float: right" type="text" name="search_buku" id="search_buku" placeholder="Cari Buku" autocomplete="off"> -->
                    </div>
                    <div class="col-md-12">
                        <button class="btn btn-success btn-sm" type="submit" name="bukuReport">Laporan Buku</button>
                    </div>
                    </div>
                </form>
            </div>
        </div>
    </div>
	<div class="card-body">
    <div class="table table-responsive">
        <table id="table_buku" class="table table-striped">
            <thead>
                <tr>
                    <th>No</th>
                    <th>Kode Buku</th>
                    <th>Judul Buku</th>
                    <th>Pengarang</th>
                    <th>Penerbit</th>
                    <th>Tahun Terbit</th>
                    <th>Stok</th>
                    <th>Lokasi Buku</th>
                    <?php if($_SESSION["cekStatus"] == 0 || $_SESSION["cekStatus"] == 1): ?>
                        <th>Aksi</th>
                    <?php endif ?>
                </tr>
            </thead>
            <tbody id="tampil">
                <?php
                    $no = 0;
                    while($rBuku = mysqli_fetch_array($sql)) :
                        $no++;
                ?>
                <tr>
                    <td><?= $no ?></td>
                    <td><?= $rBuku["kd_buku"] ?></td>
                    <td><?= $rBuku["judul_buku"] ?></td>
                    <td><?= $rBuku["pengarang"] ?></td>
                    <td><?= $rBuku["penerbit"] ?></td>
                    <td><?= $rBuku["tahun_terbit"] ?></td>
                    <td><?= $rBuku["stok"] ?></td>
                    <td><?= $rBuku["lokasi_buku"] ?></td>
                    <?php if($_SESSION["cekStatus"] == 0 || $_SESSION["cekStatus"] == 1): ?>
                    <td>
                        <div class="btn-group" role="group">
                        <a onclick="return confirm('Yakin Hapus Buku?')" class="btn btn-danger btn-sm" href="../../../proses/proses.php?hapusBuku=<?= $rBuku["id_buku"] ?>">Hapus</a> | <a class="btn btn-success btn-sm" href="index.php?editBuku=<?= $rBuku["id_buku"] ?>">Edit</a>
                        </div>
                    </td>
                    <?php endif ?>
                </tr>
                <?php endwhile ?>
            </tbody>
        </table>
    </div>
	</div>
    </div>

        <script>
            $(document).ready( function () {
                $('#table_buku').DataTable();
            } );
        </script>
    <!-- </div> -->
 

    <script>
        $(document).ready(function(){
        $('#search_buku').keyup(function(){
            var search = $('#search_buku').val()
            $.ajax({
                type : 'POST',
                url : '../../../proses/ajax_buku.php?search_buku=' + search,
                data : 'search_buku=' + search,
                success : function(data) {
                    $('#tampil').html(data)
                }
            })
        })
        })

    </script>


    <ul class="pagination">
            <?php        
                if($page == 1){ // Jika page adalah page ke 1, maka disable link PREV        
            ?>

                <li class="disabled" style="display: none">
                    <a href="#">First</a>
                </li>      

                <li class="disabled" style="display: none">
                    <a href="#">&laquo;</a></li>        
                    <?php        
                        }else{ // Jika page bukan page ke 1          
                            $link_prev = ($page > 1) ? $page - 1 : 1;        
                    ?>
                <li>
                    <!-- <a class="page-link" href="index.php?pageBuku=1">First</a></li> -->
                        <!-- <li><a class="page-link" href="index.php?pageBuku=<?php echo $link_prev; ?>">&laquo;</a></li>   -->
                    <?php    
                        }        
                    ?>

                <?php        
                    // Buat query untuk menghitung semua jumlah data        
                    $sql2 = mysqli_query($koneksi, "SELECT COUNT(*) AS jumlah FROM tb_buku");   
                    // $get_jumlah = $sql2->fetch();                
                    // $get_jumlah = mysqli_num_rows($sql2);      

                    $sql    ="SELECT * FROM tb_buku";
                    $query    =mysqli_query($koneksi, $sql);
                    $data    =array();
                    while(($row    =mysqli_fetch_array($query)) != null){
                        $data[] =$row;
                    }
                    $count    =count($data);
                    // echo "Jumlah data dari array PHP: $count";

                    $jumlah_page = ceil($count / $limit); // Hitung jumlah halamannya        
                    $jumlah_number = 1; // Tentukan jumlah link number sebelum dan sesudah page yang aktif        
                    $start_number = ($page > $jumlah_number)? $page - $jumlah_number : 1; 
                    // Untuk awal link number        
                    $end_number = ($page < ($jumlah_page - $jumlah_number))? $page + $jumlah_number : $jumlah_page; // Untuk akhir link number                
                    for($i = $start_number; $i <= $end_number; $i++){          
                        // $link_active = ($page == $i)? ' class="page-link active"' : '';        ?>          
                        <!-- <li<?php echo $link_active; ?>><a class="page-link" href="index.php?pageBuku=<?php echo $i; ?>"> -->
                        <!-- <?php echo $i; ?></a></li>         -->
                        <?php        
                            }        
                ?>                
        <!-- LINK NEXT AND LAST -->        
        <?php        
        // Jika page sama dengan jumlah page, maka disable link NEXT nya        
        // Artinya page tersebut adalah page terakhir         
        if($page == $jumlah_page){ // Jika page terakhir        
        ?>          
        <li class="disabled" style="display: none">
            <a href="#">&raquo;</a></li>          
            <li class="disabled" style="display: none"><a href="#">Last</a></li>        
                <?php        
                    }else{ // Jika Bukan page terakhir          
                        $link_next = ($page < $jumlah_page)? $page + 1 : $jumlah_page;        
                    ?>          
                        <li>
                            <!-- <a class="page-link" href="index.php?pageBuku=<?php echo $link_next; ?>">&raquo;</a></li> -->
                                <!-- <li><a class="page-link" href="index.php?pageBuku=<?php echo $jumlah_page; ?>">Last</a></li>         -->
                <?php        
                    }        
                ?>      
            </ul>    

            <div>
        </div>
    
<!-- </div> -->

     
<!-- </div> -->

    
<?php else: ?>
    <?php
        $qPinjamBuku = mysqli_query($koneksi, "SELECT * FROM tb_buku");
        $qqPinjam = mysqli_query($koneksi, "SELECT * FROM tb_pinjam");
        $cekPinjam = mysqli_fetch_array($qqPinjam);
        if($cekPinjam == null){
            $setAutoIncrement = mysqli_query($koneksi, "ALTER TABLE tb_pinjam AUTO_INCREMENT = 1");
        }
    ?>
        <!-- <script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.16.0/umd/popper.min.js"></script>
        <script src="https://maxcdn.bootstrapcdn.com/bootstrap/4.4.1/js/bootstrap.min.js"></script> -->
     
        
        <div class="card-header bg-primary mb-3">
            <div class="row">
                <div class="col-md-6">
                    <h1 class="m-0 text-white">
                        <strong>Data Buku</strong>
                    </h1>
                </div>
            </div><!-- /.row -->
        </div> 

    
<?php

    $sessionNis = $_SESSION["nis"];

?>

            <table id="table_buku" class="table table-striped">
                <thead>
                    <tr>
                        <th>No</th>
                        <th>Judul Buku</th>
                        <th>Pengarang</th>
                        <th>Penerbit</th>
                        <th>Tahun Terbit</th>
                        <th>Stok</th>
                    </tr>
                </thead>
                <tbody>
                    <?php
                        $no = 0;
                        while($rPinjamBuku = mysqli_fetch_array($qPinjamBuku)) :
                            $no++;
                    ?>
                    <tr onclick="buku(<?= $rPinjamBuku['id_buku'] ?>)">
                        <td><?= $no ?></td>
                        <td><?= $rPinjamBuku["judul_buku"] ?></td>
                        <td><?= $rPinjamBuku["pengarang"] ?></td>
                        <td><?= $rPinjamBuku["penerbit"] ?></td>
                        <td><?= $rPinjamBuku["tahun_terbit"] ?></td>
                        <td id="stok">
                            <?php
                                if($rPinjamBuku["stok"] < 0 || $rPinjamBuku["stok"] == 0){
                                    echo "Persediaan Kosong";
                                }else{
                                    echo $rPinjamBuku["stok"];
                                }
                            ?>
                        </td>
                    </tr>

                    <!-- ==================================================modal============================================== -->
                    <!-- <input class="form-control" type="hidden" name="nisku" id="nisku" value="<?= $sessionNis ?>" readonly>
                    <input class="form-control" type="hidden" name="id_buku" id="id_buku<?= $rPinjamBuku["id_buku"] ?>" value="<?= $rPinjamBuku["id_buku"] ?>" readonly>
                    <input class="form-control" type="hidden" name="kd_buku" id="kd_buku<?= $rPinjamBuku["id_buku"] ?>" value="<?= $rPinjamBuku["kd_buku"] ?>" readonly>
                    <input class="form-control" type="hidden" name="judul_buku" id="judul_buku<?= $rPinjamBuku["id_buku"] ?>" value="<?= $rPinjamBuku["judul_buku"] ?>" readonly>
                    <input class="form-control" type="hidden" name="pengarang" id="pengarang<?= $rPinjamBuku["id_buku"] ?>" value="<?= $rPinjamBuku["pengarang"] ?>" readonly>
                    <input class="form-control" type="hidden" name="tahun_terbit" id="tahun_terbit<?= $rPinjamBuku["id_buku"] ?>" value="<?= $rPinjamBuku["tahun_terbit"] ?>" readonly> -->
                    <!-- =================================================================== -->
                    <!-- <input class="form-control" type="hidden" name="stok" id="stok<?= $rPinjamBuku["stok"] ?>" value="<?= $rPinjamBuku["stok"] ?>" readonly> -->

                    <!-- ===============================================disini aja :)================================================= -->



                    <!-- ===============================================disini aja :)================================================= -->

            <?php
                $tglPinjam = date_create(date('Y-m-d')); // waktu sekarang
                // $tanggalPinjam = date('d-F-Y H:i:s');
                $tanggalPinjam = date('d-F-Y');
                $tiga_hari = mktime(0,0,0,date("n"),date("j")+3,date("Y"));
                $tglKembali = date_create(date('Y-m-d', $tiga_hari));
                $tanggalKembali = date('d-F-Y', $tiga_hari);
            ?>

            <div class='modal' id='myModal'>
            <div class='modal-dialog'>
                <div class='modal-content'>
            
                    <!-- Modal Header -->
                    <div class='modal-header'>
                        <h4 class='modal-title'>Pinjam Buku</h4>
                        <button type='button' class='close' data-dismiss='modal'>&times;</button>
                        </div>
                        <div class='row'>
                        
                            <!-- Modal body -->
                            <div class='modal-body'>
                                <input class='form-control' type='hidden' name='id_buku' id='id_buku' value='$pbId' readonly>
                                <div class='row'>
                                    <div class='col-md-6'>
                                        <div class='form-group'>
                                            <label for='nis'>NIS</label>
                                            <input class='form-control' type='text' name='nis' id='nis' value=<?=$_SESSION['nis'] ?> readonly>
                                        </div>
                                    </div>

                                    <div class='col-md-6'>
                                        <div class='form-group'>
                                            <label for='kd_buku'>Kode Buku</label>
                                            <input class='form-control' type='text' name='kd_buku' id='kd_buku' value='' readonly>
                                        </div>
                                    </div>
                                    
                                    <div class='col-md-6'>
                                        <div class='form-group'>
                                            <label for='nama_anggota'>Nama</label>
                                            <input class='form-control' type='text' name='nama_anggota' id='nama_anggota' value='<?=$_SESSION['nama_anggota']?>' readonly>
                                        </div>
                                    </div>

                                    <div class='col-md-6'>
                                        <div class='form-group'>
                                            <label for='judul_buku'>Judul Buku</label>
                                            <input class='form-control' type='text' name='judul_buku' id='judul_buku' value='' readonly>
                                        </div>
                                    </div>

                                    <div class='col-md-6'>
                                        <div class='form-group'>
                                            <label for='pengarang'>Pengarang</label>
                                            <input class='form-control' type='text' name='pengarang' id='pengarang' value='' readonly>
                                        </div>
                                    </div>

                                    <div class='col-md-6'>
                                        <div class='form-group'>
                                            <label for='tahun_terbit'>Tahun Terbit</label>
                                            <input class='form-control' type='text' name='tahun_terbit' id='tahun_terbit' value='' readonly>
                                        </div>
                                    </div>

                                    <div class='col-md-6'>
                                        <div class='form-group'>
                                            <label for='tgl_pinjam'>Tanggal Pinjam</label>
                                            <input class='form-control' type='text' name='tgl_pinjam' id='tgl_pinjam' value='<?= $tanggalPinjam ?>' readonly>
                                        </div>
                                    </div>

                                    <div class='col-md-6'>
                                        <div class='form-group'>
                                            <label for='tgl_kembali'>Tanggal Kembali</label>
                                            <input class='form-control' type='text' name='tgl_kembali' id='tgl_kembali' value='<?= $tanggalKembali ?>' readonly>
                                        </div>
                                    </div>
                                    
                                </div>
                            </div>
                            <div class='col-md-12'>
                                <div class='form-group'>
                                <?php
                                    $nis = $_SESSION["nis"];
                                    $cek_pinjam = mysqli_query($koneksi, "SELECT nis, status FROM tb_kembali WHERE nis = '$nis' AND `status` <= 1");
                                    $rowNis = mysqli_fetch_array($cek_pinjam);
                                    $jml_pinjam = mysqli_num_rows($cek_pinjam);
                                    if($jml_pinjam >= 3):
                                ?>
                                <input class="form-control" type="text"value="Anda Sudah Meminjam Batas Maksimal" readonly>
                                </div>
                                <?php endif ?>
                            </div>
                                    
                            <!-- Modal footer -->
                            <div class='modal-footer'>
                                <button type='button' <?= ($jml_pinjam >= 3) ? "disabled" : "" ?> class='btn btn-danger' id='pinjam' onclick='pinjam()'>Pinjam</button>
                            </div>
                            
                        </div>
                    </div>
                </div>
            
                </div>
                    <div id="tampil-alert"></div>
                    
                    
                    <!-- <script type="text/javascript">
                        $(document).ready(function(){
                            $('#testModal<?= $rPinjamBuku["id_buku"] ?>').on('click', function (event) {
                                event.preventDefault();
                                // var nisku = $("#nisku").attr("value");
                                var nisku = $("#nisku").val();
                                var id = $("#id_buku<?= $rPinjamBuku["id_buku"] ?>").attr("value");
                                var kd_buku = $("#kd_buku<?= $rPinjamBuku["id_buku"] ?>").attr("value");
                                var judul_buku = $("#judul_buku<?= $rPinjamBuku["id_buku"] ?>").attr("value");
                                var pengarang = $("#pengarang<?= $rPinjamBuku["id_buku"] ?>").attr("value");
                                var tahun_terbit = $("#tahun_terbit<?= $rPinjamBuku["id_buku"] ?>").attr("value");
                                var stok = $("#stok<?= $rPinjamBuku["stok"] ?>").attr("value");
                                alert(nisku)
                                $.ajax({
                                    type : 'get',
                                    url : '../../../proses/proses.php?modalPinjamBuku',
                                    data :  {
                                                id : id,
                                                kd_buku : kd_buku,
                                                judul_buku : judul_buku, 
                                                tahun_terbit : tahun_terbit, 
                                                pengarang : pengarang, 
                                                stok : stok
                                            },
                                    success : function(data){
                                        $('#tampil-modal').html(data);//menampilkan data ke dalam modal
                                        $('#myModal').modal();
                                    }
                                });
                            });
                        }); 

                        // function pinjam(){
                        //     var id_buku = $("#id_buku").attr("value");
                        //     var kd_buku = $("#kd_buku<?= $rPinjamBuku["id_buku"] ?>").attr("value");
                        //     var nisku = $("#nisku").attr("value");
                        //     $.ajax({
                        //             type : 'get',
                        //             url : '../../../proses/proses.php?pinjamBuku',
                        //             data :  {
                        //                         id_buku : id_buku,
                        //                         nisku : nisku
                        //                     },
                        //             success : function(data){
                        //                 $("#tampil-alert").html(data);
                        //                 $('#myModal').modal('hide'); //menghilangkan modal
                        //                 // setInterval(function() {
                        //                 //     location.reload();
                        //                 // }, 1500)
                        //             }
                        //         });
                        // }

                    </script>-->
    <!-- =========================================/modal============================================== -->

                    <?php endwhile ?>
                    
                </tbody>
            </table>
        </div>
        <script>
            function buku(id){
                $.ajax({
                    url:"../../../proses/ajax_p_buku.php?id="+id,
                    type:"get",
                    dataType:"JSON",
                    success:function(tampil){
                        document.getElementById('id_buku').value=tampil.id_buku;
                        document.getElementById('kd_buku').value=tampil.kd_buku;
                        document.getElementById('judul_buku').value=tampil.judul_buku;
                        document.getElementById('pengarang').value=tampil.pengarang;
                        document.getElementById('tahun_terbit').value=tampil.tahun_terbit;
                        var stok = tampil.stok;
                        if(stok <= 0){
                            alert('Stok Buku Habis')
                        }else{
                            $('#myModal').modal();
                        }
                    }
                });
            }

            function pinjam(){
                var id_buku = $('#id_buku').val();
                var nisku = $('#nis').val();
                $.ajax({
                    url : '../../../proses/proses.php?pinjamBuku',
                    type : 'POST',
                    data : {
                        id_buku: id_buku,
                        nisku: nisku
                    },
                   // dataType : 'JSON',
                    success : function(data){
                        location.reload();
                        // $("#tampil-alert").html(data.stok);
                        $('#myModal').modal('hide'); //menghilangkan modal
                        // setInterval(function() {
                        //         location.reload();
                        //     }, 1500)
                    }
                })
            }

            $(document).ready( function () {
                $('#table_buku').DataTable();
            } );
        </script>


        <?php
        
            $tglPinjam = date_create(date('Y-m-d')); // waktu sekarang
            $tanggalPinjam = date('Y-m-d H:i:s');
            $tiga_hari = mktime(0,0,0,date("n"),date("j")+3,date("Y"));
            $tglKembali = date_create(date('Y-m-d', $tiga_hari));
            $tanggalKembali = date('Y-m-d', $tiga_hari) . " " . date('H:i:s');
            $diff  = date_diff( $tglPinjam, $tglKembali );
            if($diff->d > 3 ){
                $diff->days;
                $denda = $diff->days . '000';
            }else{
                $diff->d;

                $denda = '0';
                $tglCoba = mysqli_query($koneksi, "SELECT * FROM tb_pinjam p RIGHT JOIN tb_kembali k ON p.id_buku = k.id_buku");
                $row = mysqli_fetch_array($tglCoba);
                 $satu = $row["tgl_kembali"];
                 "<br>";
                 $dua = $tanggalKembali = date('Y-m-d H:i:s', $tiga_hari);
                 "<br>";
                 $jml = (int) $dua - (int) $satu;

            }

// $tgl1 = $row["tgl_kembali"];
// $tanggal1 = new DateTime($tgl1);
// $tgl2 = new DateTime(date("Y-m-d H:i:s"));
// echo $tanggal2 = date_format($tgl2, 'Y-m-d H:i:s');
 
// $perbedaan = $tgl2->diff($tanggal1)->format("%a");
// echo "<br>";
// echo "==";
// echo $tgl1;
// echo "<br>";
// echo $perbedaan;
 
// echo "<br>";

// echo $denda = ($perbedaan-3)*1000;
$qLastIdPinjam = mysqli_query($koneksi, "SELECT *
FROM tb_pinjam
WHERE id_pinjam
IN
(
SELECT MAX(id_pinjam)
 FROM tb_pinjam
)");
$row=mysqli_fetch_array($qLastIdPinjam);
$row["id_pinjam"];

        ?>



<?php endif ?>