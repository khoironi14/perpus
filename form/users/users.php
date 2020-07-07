<?php
    $qUser = mysqli_query($koneksi, "SELECT * FROM tb_user");
    $cekUsers = mysqli_fetch_array($qUser);
    if($cekUsers == null){
        $_SESSION["username"] = "";
        unset($_SESSION["username"]);
        session_unset();
        session_destroy();
        echo "
                <script>
                    alert('Database Kosong');
                    window.location='../../../index.php';
                </script>
            ";
    }
?>

    <?php
        $page = (isset($_GET['pageUsers']))? $_GET['pageUsers'] : 1; // Cek apakah terdapat data page pada URL
        $limit = 10; // Jumlah data per halamannya
        // Untuk menentukan dari data ke berapa yang akan ditampilkan pada tabel yang ada di database      
        $limit_start = ($page - 1) * $limit;
        // Buat query untuk menampilkan data siswa sesuai limit yang ditentukan          
        // $sql = mysqli_query($koneksi, "SELECT * FROM tb_user LIMIT ".$limit_start.",".$limit);  
        $sql = mysqli_query($koneksi, "SELECT * FROM tb_user u LEFT JOIN tb_anggota a ON u.nis = a.nis JOIN tb_kelas k ON k.id_kelas = a.id_kelas JOIN tb_offering o ON o.id_offering = a.id_offering JOIN tb_jurusan j ON j.id_jurusan = a.id_jurusan  LIMIT ".$limit_start.",".$limit);  
        $no = $limit_start + 1; // Untuk penomoran tabel
    ?>


    <div class="card">   
    <div class="card-header bg-primary mb-3">
        <div class="row">
            <div class="col-md-6">
                <h1 class="m-0 text-white">
                    <strong>Data Users</strong>
                </h1>
            </div>
            <div class="col-md-6">
                <form action="../../../proses/proses.php" method="post" class="float-right">
                    <a class="btn btn-danger float-right btn-sm" href="index.php?tambahUsers">(+) Tambah User</a>
                    <div class="form-group row">
                        <div class="col-md-6">
                        <input  type="text" name="search_users" class="form-control" id="search_users" placeholder="Cari User" autocomplete="off"></div>
                    <div class="col-md-6">
                        <button class="btn btn-success btn-sm" type="submit" name="usersReport">Laporan Users</button></div>
                    </div>
                </form>
            </div>
        </div>
    </div>


   
        <table id="myTable" class="table table-striped">
            <thead>
                <tr>
                    <th>No</th>
                    <th>Username</th>
                    <th>Nama</th>
                    <th>Kelas</th>
                    <th>Jurusan</th>
                    <th>Offering</th>
                    <th>Aksi</th>
                </tr>
            </thead>
            <tbody id="tampil">
                <?php
                    $no = 0;
                    while($rUser = mysqli_fetch_array($sql)) :
                        $no++;
                ?>
                <tr>
                    <td><?= $no ?></td>
                    <td><?= $rUser["username"] ?></td>
                    <td><?= $rUser["nama_anggota"] ?></td>
                    <td><?= $rUser["kelas"] ?></td>
                    <td><?= $rUser["nama_jurusan"] ?></td>
                    <td><?= $rUser["offering"] ?></td>
                    <td>
                        <a onclick="return confirm('Yakin Hapus User?')" class="btn btn-danger" href="../../../proses/proses.php?hapusUsers=<?= $rUser["id_user"] ?>">Hapus</a> | <a class="btn btn-success" href="index.php?editUsers=<?= $rUser["id_user"] ?>">Edit</a>
                    </td>
                </tr>
                <?php endwhile ?>
            </tbody>
        </table>
        </div>
        <!-- search -->
        <!-- <div>
            <form style="float: right" action="../../../proses/proses.php" method="post">
                <input style="float: right" type="text" name="search_users" id="search_users" placeholder="Cari User" autocomplete="off">
                <button class="btn btn-primary btn-sm mr-1" type="submit" name="usersReport">Laporan Users</button>
            </form>

        </div> -->
        
        <ul class="pagination" <?php if($cekUsers == null){ echo "style='display:none'";} ?>>
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
                    <a class="page-link" href="index.php?pageUsers=1">First</a></li>
                        <!-- <li><a class="page-link" href="index.php?pageUsers=<?php echo $link_prev; ?>">&laquo;</a></li>   -->
                    <?php    
                        }        
                    ?>

                <?php        
                    // Buat query untuk menghitung semua jumlah data        
                    $sql2 = mysqli_query($koneksi, "SELECT COUNT(*) AS jumlah FROM tb_user");   
                    // $get_jumlah = $sql2->fetch();                
                    // $get_jumlah = mysqli_num_rows($sql2);      

                    $sql    ="SELECT * FROM tb_user";
                    $query  =mysqli_query($koneksi, $sql);
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
                        <!-- <li<?php echo $link_active; ?>><a class="page-link" href="index.php?pageUsers=<?php echo $i; ?>"> -->
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
                            <a class="page-link" href="index.php?pageUsers=<?php echo $link_next; ?>">&raquo;</a></li>
                                <li><a class="page-link" href="index.php?pageUsers=<?php echo $jumlah_page; ?>">Last</a></li>        
                <?php        
                    }        
                ?>      
            </ul>

    </div>

    <script>
        $(document).ready(function(){
        $('#search_users').keyup(function(){
            var search = $('#search_users').val()
            $.ajax({
                type : 'POST',
                url : '../../../proses/ajax_users.php?search_users=' + search,
                data : 'search_users=' + search, 
                success : function(data) {
                    $('#tampil').html(data)
                }
            })
        })
        });

        

    </script>

    <script>
        $(document).ready( function () {
                $('#myTable').DataTable();
        });
    </script>