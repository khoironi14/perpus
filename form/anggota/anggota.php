<?php
    // $qAnggota = mysqli_query($koneksi, "SELECT * FROM tb_anggota a LEFT JOIN tb_kelas k ON a.id_kelas = k.id_kelas LEFT JOIN tb_offering o ON a.id_offering = o.id_offering LEFT JOIN tb_jurusan j ON j.id_jurusan = a.id_jurusan ORDER BY nis DESC");
    $qqAnggota = mysqli_query($koneksi, "SELECT * FROM tb_anggota");
    $cekAnggota = mysqli_fetch_array($qqAnggota);
    if($cekAnggota == null){
        $setAutoIncrement = mysqli_query($koneksi, "ALTER TABLE tb_anggota AUTO_INCREMENT = 1");
    }
?>

    
    <?php
        $page = (isset($_GET['pageAnggota']))? $_GET['pageAnggota'] : 1; // Cek apakah terdapat data page pada URL
        $limit = 10; // Jumlah data per halamannya
        // Untuk menentukan dari data ke berapa yang akan ditampilkan pada tabel yang ada di database      
        $limit_start = ($page - 1) * $limit;
        // Buat query untuk menampilkan data siswa sesuai limit yang ditentukan          
        $sql = mysqli_query($koneksi, "SELECT * FROM tb_anggota a LEFT JOIN tb_kelas k ON a.id_kelas = k.id_kelas LEFT JOIN tb_offering o ON a.id_offering = o.id_offering LEFT JOIN tb_jurusan j ON j.id_jurusan = a.id_jurusan ORDER BY nis DESC LIMIT ".$limit_start.",".$limit);  
        $no = $limit_start + 1; // Untuk penomoran tabel 
    
        $nomor = 0;

    ?>

  

    <div class="card-header bg-primary mb-3">
        <div style="position: absolute;">  
            <h3 class="m-0 text-white">
                <strong>Data Anggota</strong>
            </h3>
        </div>
        <div style="position: relative;">
                <a class="btn btn-danger float-right btn-sm" href="index.php?tambahAnggota">(+) Tambah Anggota</a>
            </div>
        </div>
    
        <table id="table_anggota" class="table table-striped">
            <thead>
                <tr>
                    <th>No</th>
                    <th>NIS</th>
                    <th>Nama Anggota</th>
                    <th>Kelas</th>
                    <th>Jurusan</th>
                    <th>Offering</th>
                    <th>Alamat</th>
                    <th>Aksi</th>
                </tr>
            </thead>
            <tbody>
                <?php
                    $no = 0;
                    while($rAnggota = mysqli_fetch_array($sql)) :
                        $no++;
                        if($no == 1){
                            continue;
                        }
                ?>
                <tr>
                    <td><?= $no ?></td>
                    <td><?= $rAnggota["nis"] ?></td>
                    <td><?= $rAnggota["nama_anggota"] ?></td>
                    <td><?= $rAnggota["kelas"] ?></td>
                    <td><?= $rAnggota["nama_jurusan"] ?></td>
                    <td><?= $rAnggota["offering"] ?></td>
                    <td><?= $rAnggota["alamat"] ?></td>
                    <td><div class="btn-group" role="group" aria-label="Basic example">
                        <a onclick="return confirm('Yakin Hapus Anggota?')" class="btn btn-danger btn-sm" href="../../../proses/proses.php?hapusAnggota=<?= $rAnggota["nis"] ?>">Hapus</a>  <a class="btn btn-success btn-sm" href="index.php?editAnggota=<?= $rAnggota["nis"] ?>">Edit</a></div>
                    </td>
                </tr>
                <?php endwhile ?>
            </tbody>
        </table>

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
                    <!-- <a class="page-link" href="index.php?pageAnggota=1">First</a></li> -->
                        <!-- <li><a class="page-link" href="index.php?pageAnggota=<?php echo $link_prev; ?>">&laquo;</a></li>   -->
                    <?php    
                        }        
                    ?>

                <?php        
                    // Buat query untuk menghitung semua jumlah data        
                    $sql2 = mysqli_query($koneksi, "SELECT COUNT(*) AS jumlah FROM tb_anggota");   
                    // $get_jumlah = $sql2->fetch();                
                    // $get_jumlah = mysqli_num_rows($sql2);      

                    $sql    ="SELECT * FROM tb_anggota";
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
                        <!-- <li<?php echo $link_active; ?>><a class="page-link" href="index.php?pageAnggota=<?php echo $i; ?>"> -->
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
                            <!-- <a class="page-link" href="index.php?pageAnggota=<?php echo $link_next; ?>">&raquo;</a></li> -->
                                <!-- <li><a class="page-link" href="index.php?pageAnggota=<?php echo $jumlah_page; ?>">Last</a></li>         -->
                <?php        
                    }        
                ?>      
            </ul>    
    </div>
    
    <script>
         $(document).ready( function () {
            $('#table_anggota').DataTable();
        });
    </script>