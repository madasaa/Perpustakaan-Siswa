<?php
$host       = "localhost";
$user       = "root";
$pass       = "";
$db         = "akademik";

$koneksi    = mysqli_connect($host, $user, $pass, $db);
if (!$koneksi) { //cek koneksi
    die("TIdak bisa terkoneksi ke database");
}
$NIS        = "";
$Nama       = "";
$Alamat     = "";
$Image     = "";
$Kelas   = "";
$sukses     = "";
$error      = "";

if (isset($_GET['op'])) {
    $op = $_GET['op'];
} else {
    $op = "";
}
if($op == 'delete'){
    $Id         = $_GET['Id'];
    $sql1       = "delete from siswa where Id = '$Id'";
    $q1         = mysqli_query($koneksi,$sql1);
    if($q1){
        $sukses = "Berhasil hapus data";
    }else{
        $error  = "Gagal melakukan delete data";
    }
}
if ($op == 'edit') {
    $Id         = $_GET['Id'];
    $sql1       = "select * from siswa where Id = '$Id'";
    $q1         = mysqli_query($koneksi, $sql1);
    $r1         = mysqli_fetch_array($q1);
    $NIS        = $r1['NIS'];
    $Nama       = $r1['Nama'];
    $Alamat     = $r1['Alamat'];
    $Kelas   = $r1['Kelas'];

    if ($NIS == '') {
        $error = "Data tidak ditemukan";
    }
}
if (isset($_POST['simpan'])) { //untuk create
    $NIS        = $_POST['NIS'];
    $Nama       = $_POST['Nama'];
    $Alamat     = $_POST['Alamat'];
    $Kelas   = $_POST['Kelas'];
    $Image   = $_FILES["Image"];
    $imageData = file_get_contents($Image["tmp_name"]);
    $base64Image = "data:image/jpeg;base64,".base64_encode($imageData);

    if ($NIS && $Nama && $Alamat && $Kelas && $Image) {
        if ($op == 'edit') { //untuk update
            $sql1       = "update siswa set NIS = '$NIS',Nama='$Nama',Alamat = '$Alamat',Kelas='$Kelas', GambarBuku='$base64Image' where Id = '$Id'";
            $q1         = mysqli_query($koneksi, $sql1);
            if ($q1) {
                $sukses = "Data berhasil diupdate";
            } else {
                $error  = "Data gagal diupdate";
            }
        } else { //untuk insert
            $sql1   = "insert into siswa(NIS,Nama,Alamat,Kelas, GambarBuku) values ('$NIS','$Nama','$Alamat','$Kelas', '$base64Image')";
            $q1     = mysqli_query($koneksi, $sql1);
            if ($q1) {
                $sukses     = "Berhasil memasukkan data baru";
            } else {
                $error      = "Gagal memasukkan data";
            }
        }
    } else {
        $error = "Silakan masukkan semua data";
    }
}
?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="wIdth=device-wIdth, initial-scale=1.0">
    <title>Perpustakaan Siswa</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.0-beta2/dist/css/bootstrap.min.css" rel="stylesheet"
        integrity="sha384-BmbxuPwQa2lc/FVzBcNJ7UAyJxM6wuqIj61tLrc4wSX0szH/Ev+nYRRuWlolflfl" crossorigin="anonymous">
    <style>
    .mx-auto {
        wIdth: 800px
    }

    .card {
        margin-top: 10px;
    }
    </style>
</head>

<body>
    <div class="mx-auto">
        <!-- untuk memasukkan data -->
        <div class="card">
            <div class="card-header">
                Silahkan Mengisi Data Dibawah
            </div>
            <div class="card-body">
                <?php
                if ($error) {
                ?>
                <div class="alert alert-danger" role="alert">
                    <?php echo $error ?>
                </div>
                <?php
                    header("refresh:5;url=index.php");//5 : detik
                }
                ?>
                <?php
                if ($sukses) {
                ?>
                <div class="alert alert-success" role="alert">
                    <?php echo $sukses ?>
                </div>
                <?php
                    header("refresh:5;url=index.php");
                }
                ?>
                <form action="" enctype="multipart/form-data" method="POST">
                    <div class="mb-3 row">
                        <label for="NIS" class="col-sm-2 col-form-label">NIS</label>
                        <div class="col-sm-10">
                            <input type="text" class="form-control" Id="NIS" name="NIS" value="<?php echo $NIS ?>">
                        </div>
                    </div>
                    <div class="mb-3 row">
                        <label for="Nama" class="col-sm-2 col-form-label">Nama</label>
                        <div class="col-sm-10">
                            <input type="text" class="form-control" Id="Nama" name="Nama" value="<?php echo $Nama ?>">
                        </div>
                    </div>
                    <div class="mb-3 row">
                        <label for="Alamat" class="col-sm-2 col-form-label">Alamat</label>
                        <div class="col-sm-10">
                            <input type="text" class="form-control" Id="Alamat" name="Alamat"
                                value="<?php echo $Alamat ?>">
                        </div>
                    </div>
                    <div class="mb-3 row">
                        <label for="Kelas" class="col-sm-2 col-form-label">Kelas</label>
                        <div class="col-sm-10">
                            <select class="form-control" name="Kelas" Id="Kelas">
                                <option value="">- Pilih Kelas -</option>
                                <option value="X RPL 1" <?php if ($Kelas == "X RPL") echo "selected" ?>>X RPL 1</option>
                                <option value="X RPL 2" <?php if ($Kelas == "X RPL") echo "selected" ?>>X RPL 2</option>
                                <option value="X RPL 3" <?php if ($Kelas == "X RPL") echo "selected" ?>>X RPL 3</option>
                                <option value="X RPL 4" <?php if ($Kelas == "X RPL") echo "selected" ?>>X RPL 4</option>
                                <option value="X RPL 5" <?php if ($Kelas == "X RPL") echo "selected" ?>>X RPL 5</option>
                                <option value="X RPL 6" <?php if ($Kelas == "X RPL") echo "selected" ?>>X RPL 6</option>
                                <option value="X RPL 7" <?php if ($Kelas == "X RPL") echo "selected" ?>>X RPL 7</option>
                                <option value="X RPL 8" <?php if ($Kelas == "X RPL") echo "selected" ?>>X RPL 8</option>
                                <option value="X TKJ 1" <?php if ($Kelas == "X TKJ") echo "selected" ?>>X TKJ 1</option>
                                <option value="X TKJ 2" <?php if ($Kelas == "X TKJ") echo "selected" ?>>X TKJ 2</option>
                                <option value="X TKJ 3" <?php if ($Kelas == "X TKJ") echo "selected" ?>>X TKJ 3</option>
                                <option value="X TKJ 4" <?php if ($Kelas == "X TKJ") echo "selected" ?>>X TKJ 4</option>
                                <option value="X TKJ 5" <?php if ($Kelas == "X TKJ") echo "selected" ?>>X TKJ 5</option>
                                <option value="X TKJ 6" <?php if ($Kelas == "X TKJ") echo "selected" ?>>X TKJ 6</option>
                                <option value="XI RPL 1" <?php if ($Kelas == "XI RPL") echo "selected" ?>>XI RPL 1
                                </option>
                                <option value="XI RPL 2" <?php if ($Kelas == "XI RPL") echo "selected" ?>>XI RPL 2
                                </option>
                                <option value="XI RPL 3" <?php if ($Kelas == "XI RPL") echo "selected" ?>>XI RPL 3
                                </option>
                                <option value="XI RPL 4" <?php if ($Kelas == "XI RPL") echo "selected" ?>>XI RPL 4
                                </option>
                                <option value="XI RPL 5" <?php if ($Kelas == "XI RPL") echo "selected" ?>>XI RPL 5
                                </option>
                                <option value="XI RPL 6" <?php if ($Kelas == "XI RPL") echo "selected" ?>>XI RPL 6
                                </option>
                                <option value="XI RPL 7" <?php if ($Kelas == "XI RPL") echo "selected" ?>>XI RPL 7
                                </option>
                                <option value="XI RPL 8" <?php if ($Kelas == "XI RPL") echo "selected" ?>>XI RPL 8
                                </option>
                                <option value="XI TKJ 1" <?php if ($Kelas == "XI TKJ") echo "selected" ?>>XI TKJ 1
                                </option>
                                <option value="XI TKJ 2" <?php if ($Kelas == "XI TKJ") echo "selected" ?>>XI TKJ 2
                                </option>
                                <option value="XI TKJ 3" <?php if ($Kelas == "XI TKJ") echo "selected" ?>>XI TKJ 3
                                </option>
                                <option value="XI TKJ 4" <?php if ($Kelas == "XI TKJ") echo "selected" ?>>XI TKJ 4
                                </option>
                                <option value="XI TKJ 5" <?php if ($Kelas == "XI TKJ") echo "selected" ?>>XI TKJ 5
                                </option>
                                <option value="XI TKJ 6" <?php if ($Kelas == "XI TKJ") echo "selected" ?>>XI TKJ 6
                                </option>
                                <option value="XII RPL 1" <?php if ($Kelas == "XII RPL") echo "selected" ?>>XII RPL 1
                                </option>
                                <option value="XII RPL 2" <?php if ($Kelas == "XII RPL") echo "selected" ?>>XII RPL 2
                                </option>
                                <option value="XII RPL 3" <?php if ($Kelas == "XII RPL") echo "selected" ?>>XII RPL 3
                                </option>
                                <option value="XII RPL 4" <?php if ($Kelas == "XII RPL") echo "selected" ?>>XII RPL 4
                                </option>
                                <option value="XII RPL 5" <?php if ($Kelas == "XII RPL") echo "selected" ?>>XII RPL 5
                                </option>
                                <option value="XII RPL 6" <?php if ($Kelas == "XII RPL") echo "selected" ?>>XII RPL 6
                                </option>
                                <option value="XII RPL 7" <?php if ($Kelas == "XII RPL") echo "selected" ?>>XII RPL 7
                                </option>
                                <option value="XII RPL 8" <?php if ($Kelas == "XII RPL") echo "selected" ?>>XII RPL 8
                                </option>
                                <option value="XII TKJ 1" <?php if ($Kelas == "XII TKJ") echo "selected" ?>>XII TKJ 1
                                </option>
                                <option value="XII TKJ 2" <?php if ($Kelas == "XII TKJ") echo "selected" ?>>XII TKJ 2
                                </option>
                                <option value="XII TKJ 3" <?php if ($Kelas == "XII TKJ") echo "selected" ?>>XII TKJ 3
                                </option>
                                <option value="XII TKJ 4" <?php if ($Kelas == "XII TKJ") echo "selected" ?>>XII TKJ 4
                                </option>
                                <option value="XII TKJ 5" <?php if ($Kelas == "XII TKJ") echo "selected" ?>>XII TKJ 5
                                </option>
                                <option value="XII TKJ 6" <?php if ($Kelas == "XII TKJ") echo "selected" ?>>XII TKJ 6
                                </option>
                            </select>
                        </div>
                    </div>
                    <div class="mb-3 row">
                        <label for="Image" class="col-sm-2 col-form-label">Foto Buku</label>
                        <div class="col-sm-10">
                            <input type="file" class="form-control" Id="Image" name="Image">
                        </div>
                    </div>
                    <div class="col-12">
                        <input type="submit" name="simpan" value="Simpan Data" class="btn btn-primary" />
                    </div>
                </form>
            </div>
        </div>

        <!-- untuk mengeluarkan data -->
        <div class="card">
            <div class="card-header text-white bg-secondary">
                Data Peminjaman Buku
            </div>
            <div class="card-body">
                <table class="table">
                    <thead>
                        <tr>
                            <th scope="col">#</th>
                            <th scope="col">NIS</th>
                            <th scope="col">Nama</th>
                            <th scope="col">Alamat</th>
                            <th scope="col">Kelas</th>
                            <th scope="col">Gambar</th>
                            <th scope="col">Aksi</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php
                        $sql2   = "select * from siswa order by Id desc";
                        $q2     = mysqli_query($koneksi, $sql2);
                        $urut   = 1;
                        while ($r2 = mysqli_fetch_array($q2)) {
                            $Id         = $r2['Id'];
                            $NIS        = $r2['NIS'];
                            $Nama       = $r2['Nama'];
                            $Alamat     = $r2['Alamat'];
                            $Kelas   = $r2['Kelas'];
                            $Image   = $r2['GambarBuku'];

                        ?>
                        <tr>
                            <th scope="row"><?php echo $urut++ ?></th>
                            <td scope="row"><?php echo $NIS ?></td>
                            <td scope="row"><?php echo $Nama ?></td>
                            <td scope="row"><?php echo $Alamat ?></td>
                            <td scope="row"><?php echo $Kelas ?></td>
                            <td scope="row"><img height="100" width="auto" src="<?php echo $Image ?>"e alt="gambar"></td>
                            <td scope="row">
                                <a href="index.php?op=edit&Id=<?php echo $Id ?>"><button type="button"
                                        class="btn btn-warning">Edit</button></a>
                                <a href="index.php?op=delete&Id=<?php echo $Id?>"
                                    onclick="return confirm('Yakin mau delete data?')"><button type="button"
                                        class="btn btn-danger">Delete</button></a>
                            </td>
                        </tr>
                        <?php
                        }
                        ?>
                    </tbody>

                </table>
            </div>
        </div>
    </div>
</body>

</html>