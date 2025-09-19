<?php
session_start();
include '../koneksi.php';

if (!isset($_SESSION['log']) || !isset($_SESSION['username'])) {
    header('Location: ../login.php'); // redirect ke login
    exit;
}

// Query produk + kategori
$query = mysqli_query($conn, "SELECT a.*, b.nama_kategori AS nama_kategori FROM produk a JOIN kategori b ON a.id_kategori=b.id_kategori");
$jumlahproduk = mysqli_num_rows($query);

// Query kategori
$querykategori = mysqli_query($conn, "SELECT * FROM kategori");

// Tambah kategori
if (isset($_POST['addkategori'])) {
    $nama_kategori = htmlspecialchars($_POST['nama_kategori']);
    $keterangan = htmlspecialchars($_POST['keterangan']);
    $insertKategori = mysqli_query($conn, "INSERT INTO kategori (nama_kategori, keterangan) VALUES ('$nama_kategori','$keterangan')");
    if ($insertKategori) {
        echo "<div class='alert alert-success'>Kategori berhasil ditambahkan</div>";
        echo "<meta http-equiv='refresh' content='1; url=produk.php'>";
    } else {
        echo "<div class='alert alert-danger'>Gagal menambahkan kategori</div>";
    }
}

// Hapus kategori
if (isset($_GET['delete_kategori'])) {
    $id_kategori = intval($_GET['delete_kategori']);
    $deleteKategori = mysqli_query($conn, "DELETE FROM kategori WHERE id_kategori='$id_kategori'");
    if ($deleteKategori) {
        echo "<div class='alert alert-success'>Kategori berhasil dihapus</div>";
        echo "<meta http-equiv='refresh' content='1; url=produk.php'>";
    } else {
        echo "<div class='alert alert-danger'>Gagal menghapus kategori</div>";
    }
}

// Fungsi untuk generate nama acak
function generateRandomString($length = 10)
{
    $characters = '0123456789abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ';
    $charactersLength = strlen($characters);
    $randomString = '';
    for ($i = 0; $i < $length; $i++) {
        $randomString .= $characters[random_int(0, $charactersLength - 1)];
    }
    return $randomString;
}

// Tambah produk
if (isset($_POST['addproduk'])) {
    $nama       = htmlspecialchars($_POST['nama']);
    $harga      = intval($_POST['harga']);
    $kategori   = intval($_POST['kategori']);
    $stok       = htmlspecialchars($_POST['stok']);
    $detail     = htmlspecialchars($_POST['detail']);

// Proses upload gambar
$foto = null;
if (!empty($_FILES['foto']['name'])) {
    $ext = pathinfo($_FILES['foto']['name'], PATHINFO_EXTENSION);
    $foto = time() . '_' . rand(1000,9999) . '.' . $ext; // nama unik
    $upload = move_uploaded_file($_FILES['foto']['tmp_name'], "../assets/image/" . $foto);

    if (!$upload) {
        echo "<div class='alert alert-danger'>Upload gambar gagal</div>";
        $foto = null;
    }
}

// Insert ke database
$insert = mysqli_query($conn, "INSERT INTO produk (nama, harga, id_kategori, foto, stok, detail) 
                               VALUES ('$nama', '$harga', '$kategori', '$foto', '$stok', '$detail')");

if ($insert) {
    echo "<div class='alert alert-success'>Produk berhasil ditambahkan</div>";
    echo "<meta http-equiv='refresh' content='1; url=produk.php'>";
} else {
    echo "<div class='alert alert-danger'>Gagal menambahkan produk</div>";
    }
}

?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="utf-8" />
    <title>Admin Panel</title>
    <link href="vendor/fontawesome-free/css/all.min.css" rel="stylesheet" />
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <link href="css/sb-admin-2.min.css" rel="stylesheet" />
</head>


<body id="page-top">
    <div id="wrapper">
       <!-- Sidebar -->
    <ul class="navbar-nav bg-gradient-primary sidebar sidebar-dark accordion" id="accordionSidebar">
      <a class="sidebar-brand d-flex align-items-center justify-content-center" href="index.php">
        <div class="sidebar-brand-text mx-1">Dashboard Admin</div>
      </a>
      <hr class="sidebar-divider my-0" />
      
      <!-- Menu -->
      <li class="nav-item">
        <a class="nav-link" href="index.php"><span>Beranda</span></a>
      </li>
      <hr class="sidebar-divider" />
      <div class="sidebar-heading">Menu</div>
      <li class="nav-item"><a class="nav-link" href="customer.php"><span>Customer</span></a></li>
      <li class="nav-item active"><a class="nav-link" href="produk.php"><span>Produk</span></a></li>
      <li class="nav-item"><a class="nav-link" href="konfirmasi.php"><span>Konfirmasi Pesanan</span></a></li>
      <!-- <li class="nav-item"><a class="nav-link" href="../index.php"><span>Kembali ke toko</span></a></li> -->
      <hr class="sidebar-divider d-none d-md-block" />
        </ul>
      <!-- End Sidebar -->

        <!-- Content Wrapper -->
        <div id="content-wrapper" class="d-flex flex-column">
            <div id="content">
                <!-- Topbar -->
                <nav class="navbar navbar-expand navbar-light bg-white topbar mb-4 static-top shadow">
                    <ul class="navbar-nav ml-auto">
                        <div class="topbar-divider d-none d-sm-block"></div>
                        <li class="nav-item dropdown no-arrow">
                            <a class="nav-link dropdown-toggle" href="#" role="button">
                                <span class="mr-2 d-none d-lg-inline text-gray-600 small">
                                    <?php echo $_SESSION['username'] ?>
                                </span>
                                <img class="img-profile rounded-circle" src="img/undraw_profile.svg" />
                            </a>
                        </li>
                    </ul>
                </nav>

        <!-- Kategori Produk -->
        <div class="card mt-5">
            <div class="card-header">
                <h5 class="m-0 font-weight-bold text-primary">Kategori Produk</h5>
            </div>
            <div class="card-body">
                <form method="post" class="mb-3">
                    <div class="row">
                        <div class="col-md-4">
                            <input type="text" name="nama_kategori" class="form-control" placeholder="Nama Kategori" required>
                        </div>
                        <div class="col-md-3">
                            <button type="submit" name="addkategori" class="btn btn-primary">Tambah Kategori</button>
                        </div>
                    </div>
                </form>
                <div class="table-responsive">
                    <table class="table table-bordered">
                        <thead class="table-light">
                            <tr>
                                <th>No</th>
                                <th>Nama Kategori</th>
                                <th>Aksi</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php
                            $no = 1;
                            $resultKategori = mysqli_query($conn, "SELECT * FROM kategori");
                            if (mysqli_num_rows($resultKategori) == 0) {
                                echo "<tr><td colspan='3' class='text-center'>Belum ada kategori</td></tr>";
                            } else {
                                while ($row = mysqli_fetch_assoc($resultKategori)) {
                                    echo "<tr>
                                        <td>$no</td>
                                        <td>{$row['nama_kategori']}</td>
                                        <td>
                                            <a href='produk.php?delete_kategori={$row['id_kategori']}' onclick=\"return confirm('Yakin hapus kategori ini?')\" class='btn btn-danger btn-sm'>
                                                <i class='fa fa-trash'></i>
                                            </a>
                                        </td>
                                    </tr>";
                                    $no++;
                                }
                            }
                            ?>
                        </tbody>
                    </table>
                </div>
            </div>
        </div>

                <!-- Begin Page Content -->
                <div class="container-fluid">
                    <div class="d-sm-flex align-items-center justify-content-between mb-4">
                         <h5 class="m-0 font-weight-bold text-primary">Produk</h5>
                        <div>
                            <button type="button" class="btn btn-primary" data-bs-toggle="modal" data-bs-target="#modalTambahProduk"><i class="fa fa-plus mr-2"></i>Tambah Produk</button>
                        </div>
                    </div>

                    <!-- Modal Tambah Produk -->
                    <div class="modal fade" id="modalTambahProduk" tabindex="-1" aria-hidden="true">
                        <div class="modal-dialog modal-dialog-centered">
                            <div class="modal-content">
                                <div class="modal-header">
                                    <h5 class="modal-title">Tambah Produk</h5>
                                    <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
                                </div>
                                <div class="modal-body">
                                    <form action="produk.php" method="post" enctype="multipart/form-data">
                                        <div class="mb-2">
                                            <label>Nama Produk</label>
                                            <input type="text" name="nama" class="form-control" required>
                                        </div>
                                        <div class="mb-2">
                                            <label>Harga</label>
                                            <input type="number" name="harga" class="form-control" required>
                                        </div>
                                        <div class="mb-2">
                                            <label>Kategori</label>
                                            <select name="kategori" class="form-control">
                                                <?php while ($data = mysqli_fetch_array($querykategori)) { ?>
                                                    <option value="<?php echo $data['id_kategori'] ?>"><?php echo $data['nama_kategori'] ?></option>
                                                <?php } ?>
                                            </select>
                                        </div>
                                        <div class="mb-2">
                                            <label>Foto Produk</label>
                                            <input type="file" name="foto" class="form-control" accept=".jpg,.jpeg,.png">
                                        </div>
                                        <div class="mb-2">
                                            <label>Ketersediaan Produk</label>
                                            <select name="stok" class="form-control">
                                                <option value="tersedia">Tersedia</option>
                                                <option value="habis">Habis</option>
                                            </select>
                                        </div>
                                        <div class="mb-2">
                                            <label>Deskripsi Produk</label>
                                            <textarea name="detail" rows="4" class="form-control"></textarea>
                                        </div>
                                        <div class="modal-footer">
                                            <button type="submit" class="btn btn-primary" name="addproduk">Tambahkan</button>
                                        </div>
                                    </form>
                                </div>
                            </div>
                        </div>
                    </div>

                    <!-- Tabel Produk -->
                    <div class="card mt-4">
                        <div class="table-responsive">
                            <table class="table">
                                <thead>
                                    <tr>
                                        <th>No.</th>
                                        <th>Gambar</th>
                                        <th>Nama Produk</th>
                                        <th>Kategori</th>
                                        <th>Deskripsi</th>
                                        <th>Harga</th>
                                        <th>Stok</th>
                                        <th>Edit</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <?php if ($jumlahproduk == 0) { ?>
                                        <tr><td colspan="8" class="text-center">Data produk tidak tersedia</td></tr>
                                    <?php } else {
                                        $no = 1;
                                        while ($data1 = mysqli_fetch_array($query)) { ?>
                                            <tr>
                                                <td><?php echo $no++ ?></td>
                                                <td><img src="../assets/image/<?php echo $data1['foto'] ?>" style="width:100px;height:50px;object-fit:cover"></td>
                                                <td><?php echo $data1['nama'] ?></td>
                                                <td><?php echo $data1['nama_kategori'] ?></td>
                                                <td><?php echo $data1['detail'] ?></td>
                                                <td><?php echo $data1['harga'] ?></td>
                                                <td><?php echo $data1['stok'] ?></td>
                                                <td>
                                                    <a href="edit-produk.php?p=<?php echo $data1['id'] ?>" class="btn btn-info btn-sm"><i class="fas fa-search"></i></a>
                                                    <a href="deleteproduk.php?id=<?php echo $data1['id'] ?>" class="btn btn-danger btn-sm"><i class="fas fa-trash"></i></a>
                                                </td>
                                            </tr>
                                    <?php } } ?>
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>
                <!-- End Page Content -->
            </div>
        </div>
    </div>

<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
<script src="vendor/jquery/jquery.min.js"></script>
<script src="vendor/jquery-easing/jquery.easing.min.js"></script>
<script src="js/sb-admin-2.min.js"></script>

</body>
</html>
