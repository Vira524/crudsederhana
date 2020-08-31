<?php
    //Koneksi Database
    $server = "localhost";
    $user = "root";
    $pass = "";
    $database = "dblatihan";

    $koneksi = mysqli_connect($server, $user, $pass, $database)or die(mysqli_error($koneksi));

    //jika tombol simpan diklik
    if(isset($_POST['bsimpan']))
    {
        //Pengujian Apakah data akan diedit atau disimpan baru
        if($_GET['hal'] == "edit")
        {
            //Data akan diedit
            $edit = mysqli_query($koneksi, "UPDATE tsiswa set
                                                nis ='$_POST[tnis]',
                                                nama ='$_POST[tnama]',
                                                alamat ='$_POST[talamat]',
                                                jurusan ='$_POST[tjurusan]'
                                            WHERE id_siswa = '$_GET[id]'    
                                          ");
            if($edit) //jika edit sukses
            {
                echo "<script>
                        alert('Edit data suksess!');
                        document.location='index.php';
                    </script>";
            }
            else
            {   
                echo "<script>
                        alert('Edit data GAGAL!!');
                        document.location='index.php';
                    </script>";
            }
        }
        else
        {
            //Data akan disimpan baru
            $simpan = mysqli_query($koneksi, "INSERT INTO tsiswa (nis, nama, alamat, jurusan)
                                          VALUES ('$_POST[tnis]',
                                                 '$_POST[tnama]',
                                                 '$_POST[talamat]',
                                                 '$_POST[tjurusan]')
                                         ");
            if($simpan) //jika simpan sukses
            {
                echo "<script>
                        alert('Simpan data suksess!');
                        document.location='index.php';
                    </script>";
            }
            else
            {
                echo "<script>
                        alert('Simpan data GAGAL!!');
                        document.location='index.php';
                    </script>";
            }
         }


        
    }


    //Pengujian jika tombol Edit / Hapus di klik
    if(isset($_GET['hal']))
    {
        //Pengujian jika edit data
        if($_GET['hal'] == "edit")
        {
            //Tampilkan Data yang akan diedit
            $tampil = mysqli_query($koneksi, "SELECT * FROM tsiswa WHERE id_siswa = '$_GET[id]' ");
            $data = mysqli_fetch_array($tampil);
            if($data)
            {
                //Jika data ditemukan, maka data ditampung kedalam variabel
                $vnis = $data['nis'];
                $vnama = $data['nama'];
                $valamat = $data['alamat'];
                $vjurusan = $data['jurusan'];
            }
        }
        else if ($_GET['hal'] == "hapus")
        {
            //Persiapan hapus data 
            $hapus = mysqli_query($koneksi,"DELETE FROM tsiswa WHERE id_siswa = '$_GET[id]' ");
            if($hapus){
                echo "<script>
                        alert('Hapus Data Suksess!!');
                        document.location='index.php';
                    </script>";
            }
        }
    }

?>

<!DOCTYPE html>
<html lang="en">
<head>
    <title>CRUD</title>
    <link rel="stylesheet" type="text/css" href="css/bootstrap.min.css">
</head>
<body>
<div class="container">

    <h1 class="text-center">Formulir Data Siswa</h1>  
    <h2 class="text-center">SMKN 1 PURWOSARI</h2>

    <!-- Awal Card Form -->
    <div class="card mt-3">
        <div class="card-header bg-primary text-white ">
            Form Input Data Siswa
        </div>
        <div class="card-body">
            <form method="post" action="">
                <div class="form-group">
                    <label>Nis</label>
                    <input type="text" name="tnis" value="<?=@$vnis?>" class="form-control" placeholder="Input Nis anda disini!" required>
                </div>
                <div class="form-group">
                    <label>Nama</label>
                    <input type="text" name="tnama" value="<?=@$vnama?>" class="form-control" placeholder="Input Nama anda disini!" required>
                </div>
                <div class="form-group">
                    <label>Alamat</label>
                    <textarea class="form-control" name="talamat" placeholder="Input Alamat anda disini!"><?=@$valamat?></textarea>
                </div>
                <div class="form-group">
                    <label>Jurusan</label>
                    <select class="form-control" name="tjurusan">
                        <option value="<?=@$vjurusan?>"><?=@$vjurusan?></option>
                        <option value="Teknologi Informatika">Teknologi Informatika</option>
                        <option value="Permesinan">Permesinan</option>
                        <option value="Pertanian">Pertanian</option>
                    </select>
                </div>

                <button type="submit" class="btn btn-success" name="bsimpan">Simpan</button>
                <button type="reset" class="btn btn-danger" name="breset">Refresh</button>

            </form>
        </div>
    </div>
    <!-- Akhir Card Form -->

    <!-- Awal Card Tabel -->
    <div class="card mt-3">
        <div class="card-header bg-success text-white ">
            Daftar Siswa
        </div>
        <div class="card-body">

            <table class="table table-bordered table-striped">
                <tr>
                    <th>No.</th>
                    <th>Nis</th>
                    <th>Nama</th>
                    <th>Alamat</th>
                    <th>Jurusan</th>
                    <th>Aksi</th>
                </tr>
                <?php
                    $no =1;
                    $tampil = mysqli_query($koneksi, "SELECT * from tsiswa order by id_siswa desc");
                    while($data = mysqli_fetch_array($tampil))  :
                
                ?>
                <tr>
                    <td><?=$no++;?></td>
                    <td><?=$data['nis']?></td>
                    <td><?=$data['nama']?></td>
                    <td><?=$data['alamat']?></td>
                    <td><?=$data['jurusan']?></td>
                    <td>
                        <a href="index.php?hal=edit&id=<?=$data['id_siswa']?>" class="btn btn-warning"> Edit </a>
                        <a href="index.php?hal=hapus&id=<?=$data['id_siswa']?>" onclick="return confirm('Apakah yakin ingin menghapus data ini?')" class="btn btn-danger"> Hapus </a>
                    </td>
                </tr>
                    <?php endwhile; //penutup pengulangan while?>
            </table>

        </div>
    </div>
    <!-- Akhir Card Tabel -->

</div>
<script type="text/javascript"> src="js/bootstrap.min.js" </script>    
</body>
</html>