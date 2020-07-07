<?php if($_SESSION["cekStatus"] == 0 || $_SESSION["cekStatus"] == 1): ?>

<?php
    $qPinjam = mysqli_query($koneksi, "SELECT * FROM tb_pinjam p JOIN tb_buku b ON p.id_buku = b.id_buku");
    $qqPinjam = mysqli_query($koneksi, "SELECT * FROM tb_pinjam");
    $cekPinjam = mysqli_fetch_array($qqPinjam);
    if($cekPinjam == null){
        $setAutoIncrementPinjam = mysqli_query($koneksi, "ALTER TABLE tb_pinjam AUTO_INCREMENT = 1");
    }

    $qqKembali = mysqli_query($koneksi, "SELECT * FROM tb_kembali");
    $cekKembali = mysqli_fetch_array($qqKembali);
    if($cekKembali == null){
        $setAutoIncrementKembali = mysqli_query($koneksi, "ALTER TABLE tb_kembali AUTO_INCREMENT = 1");
    }
?>
    <!-- <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.4.1/jquery.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.16.0/umd/popper.min.js"></script>
    <script src="https://maxcdn.bootstrapcdn.com/bootstrap/4.4.1/js/bootstrap.min.js"></script> -->
   
    <div class="card">   
    <div class="card-header bg-primary mb-3">
        <div class="row">
            <div class="col-md-6">
                <h4 class="m-0 text-white">
                    Data Peminjaman & Pengembalian Buku
                </h4>
            </div>
            <div class="col-md-6">
                <form action="../../../proses/proses.php" method="post" class="float-right">
                    <!-- <a class="btn btn-danger float-right btn-sm" href="index.php?tambahUsers">(+) Tambah User</a> -->
                    <div class="form-group row">
                        <div class="col-md-6">
                        <input style="float: right" type="text" name="search" class="" id="search" placeholder="Cari Peminjaman" autocomplete="off"></div>
                    <div class="col-md-6">
                        <button class="btn btn-success btn-sm mr-1" type="submit" name="pinjamReport">Laporan</button>
                    </div>
                </form>
            </div>
        </div>
    <!-- </div> -->

    <!-- <div class="card-header mb-3 bg-primary">
        <div style="position: relative;">
            <h3 class="m-0 text-white">
                <strong>Data Peminjaman & Pengembalian Buku</strong>
            </h3> -->
        </div>
    </div>
    
    <div style="margin-bottom: 10px">
        <?php
            $sql = mysqli_query($koneksi, "SELECT * FROM tb_kembali p JOIN tb_buku b ON p.id_buku = b.id_buku JOIN tb_anggota a ON a.nis = p.nis"); 
        
            $nomor = 0;
            ?>
            <table id="myTable" style="text-align: center" class='table table-striped'>
                    <thead>
                        <tr>
                            <th>No</th>
                            <th>NIS</th>
                            <th>Nama Anggota</th>
                            <th>Buku</th>
                            <th>Pengarang</th>
                            <th>Penerbit</th>
                            <th>Tanggal Pinjam</th>
                            <th>Tanggal Kembali</th>
                            <th>Denda</th>
                            <th style="width: 200px">Aksi</th>
                            <!-- <th><input id="pilihsemua" onchange="checkAll(this)" name="chk[]" type="checkbox"></th> -->
                        </tr>
                    <thead>
                <tbody id="tampil">
                    <?php
                        while($data = mysqli_fetch_array($sql)) : 
                            $nomor++;
                        ?>
                        <tr>
                            <td><?= $nomor ?></td>
                            <td><?= $data["nis"] ?></td>
                            <td><?= $data["nama_anggota"] ?></td>
                            <td><?= $data["judul_buku"] ?></td>
                            <td><?= $data["pengarang"] ?></td>
                            <td><?= $data["penerbit"] ?></td>
                            <td><?= $data["tgl_pinjam"] ?></td>
                            <td><?= $data["tgl_kembali"] ?></td>
                            <td style="width: 160px"><?= $data["denda"] ?></td>
                            <!-- <td style="width: 170px"> -->
                            <td>
                                <?php
                                    if($data["status"] == 0):
                                ?>

                                    <div class="btn-group" role="group" aria-label="Basic example">
                                        <a onclick="return confirm('<?= $data['nama_anggota']; echo ' NIS '; echo $data['nis']?> Apakah Tidak Jadi Pinjam Buku?')" class="btn btn-danger btn-sm" href="../../../proses/proses.php?cancelPinjam=<?= $data["id_pinjam"] ?>">Cancel</a> 
                                   
                                        <form action="../../../proses/proses.php" method="GET">
                                            <input type="hidden" name="id_buku" id="" value="<?= $data["id_buku"] ?>">
                                            <input type="hidden" name="setujui" value="<?= $data['id_pinjam'] ?>">
                                            <button onclick="return confirm('<?= $data['nama_anggota']; echo ' NIS '; echo $data['nis']?> Apakah Setuju Peminjaman Buku?')" class="btn btn-success btn-sm" type="submit" name="setujuiPinjam">Setujui</button>
                                        </form>
                                    </div>

                                <?php
                                    elseif($data["status"] == 1):
                                ?>
                                    <form action="../../../proses/proses.php" method="GET">
                                        <input type="hidden" name="id_buku" id="" value="<?= $data["id_buku"] ?>">
                                        <input type="hidden" name="dikembalikan" value="<?= $data['id_pinjam'] ?>" >
                                        <button onclick="return confirm('<?= $data['nama_anggota']; echo ' NIS '; echo $data['nis']?> Apakah Mau Mengembalikan?')" class="btn btn-warning btn-sm" type="submit" name="dikembalikanPinjam">Belum Kembali</button>
                                    </form>
                                <?php
                                    elseif($data["status"] == 2):
                                ?>
                                    <button class="btn btn-primary btn-sm" disabled>Sudah Kembali</button>

                                <?php
                                    elseif($data["status"] == 3):
                                ?>
                                    <button class="btn btn-danger btn-sm" disabled>Cancel Peminjaman</button>
                                <?php
                                    endif
                                ?>
                            </td>
                            <!-- <td>
                                <input class="pilih" type="checkbox" name="chkbox[]" value="<?= $data["id_kembali"] ?>">
                            </td> -->
                        </tr>
                        <?php endwhile ?> 
                    </tbody>
                </table>
                </div>
                <script>
            $(document).ready( function () {
                $('#myTable').DataTable();
            } );
        </script>
        
    </script>
               
        <!-- <form style="float: right; margin-right: 15px" action="../../../proses/proses.php" method="POST">
            <input style="float: right" type="text" name="search" id="search" placeholder="Cari Peminjaman" autocomplete="off">
            <button class="btn btn-primary btn-sm mr-1" type="submit" name="pinjamReport">Laporan</button>
        </form> -->

    </div>
</div>

    <script>
        $(document).ready(function(){
            $('#search').keyup(function(){
                var search = $('#search').val()
                $.ajax({
                    type : 'POST',
                    url : '../../../proses/ajax_pinjam.php?search=' + search,
                    data : 'search=' + search,
                    success : function(data) {
                        $('#tampil').html(data)
                    }
                })
            })
        })

        function checkAll(ele) {
        var checkboxes = document.getElementsByTagName('input');
        if (ele.checked) {
            for (var i = 0; i < checkboxes.length; i++) {
                if (checkboxes[i].type == 'checkbox' ) {
                    checkboxes[i].checked = true;
                    }
                }
            }else{
            for (var i = 0; i < checkboxes.length; i++) {
                if (checkboxes[i].type == 'checkbox') {
                    checkboxes[i].checked = false;
                }
                }
            }
        }

    </script>

    

<?php else: ?>

    <?php
        $qqPinjam = mysqli_query($koneksi, "SELECT * FROM tb_pinjam");
        $cekPinjam = mysqli_fetch_array($qqPinjam);
        if($cekPinjam == null){
            $setAutoIncrement = mysqli_query($koneksi, "ALTER TABLE tb_pinjam AUTO_INCREMENT = 1");
        }
    ?>
        <!-- <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.4.1/jquery.min.js"></script> -->
        <!-- <script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.16.0/umd/popper.min.js"></script>
        <script src="https://maxcdn.bootstrapcdn.com/bootstrap/4.4.1/js/bootstrap.min.js"></script> -->

        <!-- <script src="../jquery.js"></script> -->
    <script src="../datatables/media/js/dataTables.bootstrap4.min.js"></script>
    <link rel="stylesheet" href="../datatables/media/css/dataTables.bootstrap4.min.css">

        <script src="../jquery.js"></script>

        <div class="card-header bg-primary mb-3">
            <div class="row">
                <div class="col-md-6">
                    <h1 class="m-0 text-white">
                        <strong>Data Pinjam Buku</strong>
                    </h1>
                </div>
            </div><!-- /.row -->
        </div> 

            <table class="table table-striped">
                <thead>
                    <tr>
                        <th>No</th>
                        <th>Buku</th>
                        <th>Tanggal Pinjam</th>
                        <th>Tanggal Kembali</th>
                        <th>Denda</th>
                        <th>Status</th>
                    </tr>
                </thead>
                <tbody>
                    <?php
                        $sessionNis = $_SESSION["nis"];
                        $no = 0;
                        $qryPinjam = mysqli_query($koneksi, "SELECT * FROM tb_kembali p JOIN tb_buku b ON p.id_buku = b.id_buku WHERE p.nis = '$sessionNis'");
                        while($rPinjamBuku = mysqli_fetch_array($qryPinjam)) :
                            $no++;
                    ?>
                    <tr>
                        <td><?= $no ?></td>
                        <td><?= $rPinjamBuku["judul_buku"] ?></td>
                        <td><?= $rPinjamBuku["tgl_pinjam"] ?></td>
                        <td><?= $rPinjamBuku["tgl_kembali"] ?></td>
                        <td><?= $rPinjamBuku["denda"] ?></td>

                        <td>
                            
                            <?php if($rPinjamBuku["status"] == 0 ): ?>
                                <button class="btn btn-danger" disabled>
                                    Pending
                                </button>
                            <?php elseif($rPinjamBuku["status"] == 1 ): ?>
                                <button class="btn btn-success" disabled>
                                    Belum Kembali
                                </button>
                            <?php elseif($rPinjamBuku["status"] == 2 ): ?>
                                <button class="btn btn-primary" disabled>
                                    Sudah Kembali
                                </button>
                            <?php elseif($rPinjamBuku["status"] == 3 ): ?>
                                <button class="btn btn-warning" disabled>
                                    Cancel Peminjaman
                                </button>
                            <?php endif ?>
                        </td>
                    </tr>

                    <!-- ==================================================modal============================================== -->
                    <input class="form-control" type="hidden" name="id_buku" id="id_buku<?= $rPinjamBuku["id_buku"] ?>" value="<?= $rPinjamBuku["id_buku"] ?>" readonly>
                    <input class="form-control" type="hidden" name="judul_buku" id="judul_buku<?= $rPinjamBuku["id_buku"] ?>" value="<?= $rPinjamBuku["judul_buku"] ?>" readonly>
                    <input class="form-control" type="hidden" name="pengarang" id="pengarang<?= $rPinjamBuku["id_buku"] ?>" value="<?= $rPinjamBuku["pengarang"] ?>" readonly>
                    <input class="form-control" type="hidden" name="tahun_terbit" id="tahun_terbit<?= $rPinjamBuku["id_buku"] ?>" value="<?= $rPinjamBuku["tahun_terbit"] ?>" readonly>

                    <div id="tampil-modal"></div>
                    
                    <script type="text/javascript">
                        $(document).ready(function(){

                            $('#testModal<?= $rPinjamBuku["id_buku"] ?>').on('click', function (event) {
                                event.preventDefault();
                                var id = $("#id_buku<?= $rPinjamBuku["id_buku"] ?>").attr("value");
                                var judul_buku = $("#judul_buku<?= $rPinjamBuku["id_buku"] ?>").attr("value");
                                var pengarang = $("#pengarang<?= $rPinjamBuku["id_buku"] ?>").attr("value");
                                var tahun_terbit = $("#tahun_terbit<?= $rPinjamBuku["id_buku"] ?>").attr("value");
                                $.ajax({
                                    type : 'get',
                                    url : '../../../proses/proses.php?pinjamBukuId',
                                    data :  {id : id, judul_buku : judul_buku, tahun_terbit : tahun_terbit, pengarang : pengarang},
                                    success : function(data){
                                        $('#tampil-modal').html(data);//menampilkan data ke dalam modal
                                        $('#myModal').modal();
                                    }
                                });
                            });

                        });
                            
                    </script>
    <!-- =========================================/modal============================================== -->

                    <?php endwhile ?>
                </tbody>
            </table>

            <?php
                $page = (isset($_GET['pagePinjam']))? $_GET['pagePinjam'] : 1; // Cek apakah terdapat data page pada URL
                $limit = 5; // Jumlah data per halamannya
                // Untuk menentukan dari data ke berapa yang akan ditampilkan pada tabel yang ada di database      
                $limit_start = ($page - 1) * $limit;
                // Buat query untuk menampilkan data siswa sesuai limit yang ditentukan          
                $sql = mysqli_query($koneksi, "SELECT * FROM tb_kembali p JOIN tb_buku b ON p.id_buku = b.id_buku LIMIT ".$limit_start.",".$limit);  
                $no = $limit_start + 1; // Untuk penomoran tabel
            ?>

            <ul class="pagination" <?php if($cekPinjam == null){ echo "style='display:none'";} ?>>
            <?php        
                if($page === 1){ // Jika page adalah page ke 1, maka disable link PREV        
            ?>

                <li class="disabled" style="display: none">
                    <!-- <a href="#">First</a> -->
                </li>      

                <li class="disabled" style="display: none">
                    <a href="#">&laquo;</a></li>        
                    <?php        
                        }else{ // Jika page bukan page ke 1          
                            $link_prev = ($page > 1) ? $page - 1 : 1;        
                    ?>
                <li>
                    <!-- <a class="page-link" href="index.php?pagePinjam=1">First</a></li> -->
                        <li><a class="page-link" href="index.php?pagePinjam=<?php echo $link_prev; ?>">&laquo;</a></li>  
                    <?php    
                        }        
                    ?>

                <?php        
                    // Buat query untuk menghitung semua jumlah data        
                    $sql2 = mysqli_query($koneksi, "SELECT COUNT(*) AS jumlah FROM tb_pinjam");   
                    // $get_jumlah = $sql2->fetch();                
                    // $get_jumlah = mysqli_num_rows($sql2);      

                    $sql    ="SELECT * FROM tb_pinjam";
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
                        $link_active = ($page == $i)? ' class="page-link active"' : '';        ?>          
                        <!-- <li<?php echo $link_active; ?>><a class="page-link" href="index.php?pagePinjam=<?php echo $i; ?>"> -->
                        <!-- <?php echo $i; ?></a></li>         -->
                        <?php        
                            }        
                ?>                
        <!-- LINK NEXT AND LAST -->        
        <?php        
        // Jika page sama dengan jumlah page, maka disable link NEXT nya        
        // Artinya page tersebut adalah page terakhir         
        if($page == $jumlah_page){// Jika page terakhir        
        ?>          
        <li class="disabled" style="display: none">
            <a href="#">&raquo;</a></li>          
            <li class="disabled" style="display: none"><a href="#">Last</a></li>        
                <?php        
                    }else{ // Jika Bukan page terakhir          
                        $link_next = ($page < $jumlah_page)? $page + 1 : $jumlah_page;        
                    ?>          
                        <li>
                            <!-- <a class="page-link" href="index.php?pagePinjam=<?php echo $link_next; ?>">&raquo;</a></li> -->
                                <!-- <li><a class="page-link" href="index.php?pagePinjam=<?php echo $jumlah_page; ?>">Last</a></li>         -->
                <?php        
                    }        
                ?>      
            </ul>

        </div>

        <script>
            $(document).ready( function () {
                $('.table').DataTable();
            } );
        </script>
        

       

<?php endif ?>

    <!-- <form action="../../../proses/proses.php" method="post">
        <ul class="navbar-nav">
          <li class="nav-item d-none d-sm-inline-block">
            <select class="nav-link" name="nisLaporan" id="nisLaporan">
                <option value="">--Pilih Nama--</option>
              <?php
              
                $qNisPinjam = mysqli_query($koneksi, "SELECT * FROM tb_kembali k JOIN tb_anggota a ON k.nis = a.nis");
                while($rowNisPinjam = mysqli_fetch_array($qNisPinjam)):
              ?>
                  <option value="<?= $rowNisPinjam["nis"] ?>"><?= $rowNisPinjam["nama_anggota"] ?></option>
                <?php endwhile ?>
            </select>
        </li>
        <button class="btn btn-primary" type="submit" name="laporanPeminjaman">Laporan Peminjaman</button>
          
        </ul>
    </form> -->
    <?php if($_SESSION["cekStatus"] == 0 || $_SESSION["cekStatus"] == 1): ?>
<div>
    <nav class="navbar navbar-expand navbar-white navbar-light">
        <ul class="navbar-nav">
            <li class="nav-item">
                <a class="nav-link" data-widget="pushmenu" href="#"><i class="fas fa-bars"></i></a>
            </li>
            <form action="../../../proses/proses.php" method="post">
                <li class="nav-item d-none d-sm-inline-block">
                    <select class="nav-link" name="nisLaporan" id="nisLaporan">
                        <option value="0">--Pilih Nama--</option>
                        <?php
                        
                        $qNisPinjam = mysqli_query($koneksi, "SELECT * FROM tb_kembali k JOIN tb_anggota a ON k.nis = a.nis GROUP BY k.nis");
                        while($rowNisPinjam = mysqli_fetch_array($qNisPinjam)):
                        ?>
                            <option value="<?= $rowNisPinjam["nis"] ?>"><?= $rowNisPinjam["nama_anggota"] ?></option>
                        <?php endwhile ?>
                    </select>
                </li>
                <li class="nav-item d-none d-sm-inline-block">
                    <button class="btn btn-primary btn-sm" type="submit" name="laporanPeminjaman">Laporan Peminjaman</button>
                </li>
            </form> 
        </ul>

        <!-- ====================================================================== -->

        <ul class="navbar-nav">
            <form action="../../../proses/proses.php" method="post">
                <li class="nav-item d-none d-sm-inline-block">
                    <select class="nav-link" name="tglPinjamLaporan" id="tglPinjamLaporan">
                        <option value="0">--Tgl Pinjam-- </option>
                        <?php
                        
                        $qNisPinjam = mysqli_query($koneksi, "SELECT * FROM tb_kembali");
                        ?>
                        <?php while($rowTglPinjam = mysqli_fetch_array($qNisPinjam)): ?>
                            <option value="<?= $rowTglPinjam["tgl_pinjam"] ?>"><?= $rowTglPinjam["tgl_pinjam"] ?></option>
                        <?php endwhile ?>
                    </select>
                </li>
                <li class="nav-item d-none d-sm-inline-block">
                    <button class="btn btn-primary" type="submit" name="tglPinjamReport">Laporan Peminjaman</button>
                </li>
            </form>
        </ul>

        <!-- ====================================================================== -->

        <ul class="navbar-nav">
            <form action="../../../proses/proses.php" method="post">
                <li class="nav-item d-none d-sm-inline-block">
                    <select class="nav-link" name="tglKembaliLaporan" id="tglKembaliLaporan">
                        <option value="0">--Tgl Kembali--</option>
                        <?php
                        
                        $qNisKembali = mysqli_query($koneksi, "SELECT * FROM tb_kembali WHERE tgl_kembali > 0");
                        ?>
                        <?php while($rowTglKembali = mysqli_fetch_array($qNisKembali)): ?>
                            <option value="<?= $rowTglKembali["tgl_kembali"] ?>"><?= $rowTglKembali["tgl_kembali"] ?></option>
                        <?php endwhile ?>
                    </select>
                </li>
                <li class="nav-item d-none d-sm-inline-block">
                    <button class="btn btn-primary" type="submit" name="tglKembaliReport">Laporan Peminjaman</button>
                </li>
            </form>
        </ul>

        <!-- ====================================================================== -->
    </nav>
</div>
<?php endif ?>

