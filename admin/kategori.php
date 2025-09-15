<?php
session_start();
include '../koneksi.php';

// Tambah kategori
if (isset($_POST['tambahkategori'])) {
    $nama = htmlspecialchars($_POST['nama']);
    $keterangan = htmlspecialchars($_POST['keterangan']);

    $query = mysqli_query($conn, "INSERT INTO kategori (nama_kategori, keterangan) VALUES ('$nama', '$keterangan')");
    if ($query) {
        echo "<div class='alert alert-success'>Kategori berhasil ditambahkan</div>";
        echo "<meta http-equiv='refresh' content='1; url=kategori.php'>";
    } else {
        echo "<div class='alert alert-danger'>Gagal menambahkan kategori</div>";
    }
}

// Edit kategori
if (isset($_POST['editkategori'])) {
    $id = $_POST['id_kategori'];
    $nama = htmlspecialchars($_POST['nama']);
    $keterangan = htmlspecialchars($_POST['keterangan']);

    $query = mysqli_query($conn, "UPDATE kategori SET nama_kategori='$nama', keterangan='$keterangan' WHERE id_kategori='$id'");
    if ($query) {
        echo "<div class='alert alert-success'>Kategori berhasil diupdate</div>";
        echo "<meta http-equiv='refresh' content='1; url=kategori.php'>";
    } else {
        echo "<div class='alert alert-danger'>Gagal update kategori</div>";
    }
}

// Hapus kategori
if (isset($_GET['delete'])) {
    $id = $_GET['delete'];
    $query = mysqli_query($conn, "DELETE FROM kategori WHERE id_kategori='$id'");
    if ($query) {
        echo "<div class='alert alert-success'>Kategori berhasil dihapus</div>";
        echo "<meta http-equiv='refresh' content='1; url=kategori.php'>";
    } else {
        echo "<div class='alert alert-danger'>Gagal hapus kategori</div>";
    }
}

$querykategori = mysqli_query($conn, "SELECT * FROM kategori ORDER BY id_kategori DESC");
$jumlahkategori = mysqli_num_rows($querykategori);
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="utf-8" />
    <title>Kategori Produk - Admin</title>
    <link href="vendor/fontawesome-free/css/all.min.css" rel="stylesheet" type="text/css" />
    <link href="bootstrap/css/bootstrap.css" rel="stylesheet" />
    <link href="css/sb-admin-2.min.css" rel="stylesheet" />
</head>
<body id="page-top">

<div class="container mt-4">
    <h2>Daftar Kategori Produk</h2>
    <a href="index.php" class="btn btn-secondary mb-3">⬅ Kembali</a>
    <button class="btn btn-primary mb-3" data-bs-toggle="modal" data-bs-target="#tambahKategori">+ Tambah Kategori</button>

    <table class="table table-bordered table-striped">
        <thead>
            <tr>
                <th>No</th>
                <th>Nama Kategori</th>
                <th>Keterangan</th>
                <th>Aksi</th>
            </tr>
        </thead>
        <tbody>
        <?php if ($jumlahkategori == 0) { ?>
            <tr><td colspan="4" class="text-center">Belum ada kategori</td></tr>
        <?php 
        } else {
            $no=1;
            while ($row = mysqli_fetch_assoc($querykategori)) { ?>
                <tr>
                    <td><?= $no++ ?></td>
                    <td><?= $row['nama_kategori'] ?></td>
                    <td><?= $row['keterangan'] ?></td>
                    <td>
                        <!-- Tombol edit -->
                        <button class="btn btn-warning btn-sm" data-bs-toggle="modal" data-bs-target="#editKategori<?= $row['id_kategori'] ?>"><i class="fas fa-edit"></i></button>
                        <!-- Tombol hapus -->
                        <a href="kategori.php?delete=<?= $row['id_kategori'] ?>" class="btn btn-danger btn-sm" onclick="return confirm('Yakin hapus kategori ini?')"><i class="fas fa-trash"></i></a>
                    </td>
                </tr>

                <!-- Modal Edit -->
                <div class="modal fade" id="editKategori<?= $row['id_kategori'] ?>" tabindex="-1" aria-hidden="true">
                    <div class="modal-dialog">
                        <form method="post">
                            <div class="modal-content">
                                <div class="modal-header">
                                    <h5>Edit Kategori</h5>
                                    <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
                                </div>
                                <div class="modal-body">
                                    <input type="hidden" name="id_kategori" value="<?= $row['id_kategori'] ?>">
                                    <div class="mb-2">
                                        <label>Nama Kategori</label>
                                        <input type="text" class="form-control" name="nama" value="<?= $row['nama_kategori'] ?>" required>
                                    </div>
                                    <div class="mb-2">
                                        <label>Keterangan</label>
                                        <input type="text" class="form-control" name="keterangan" value="<?= $row['keterangan'] ?>">
                                    </div>
                                </div>
                                <div class="modal-footer">
                                    <button type="submit" name="editkategori" class="btn btn-primary">Simpan Perubahan</button>
                                </div>
                            </div>
                        </form>
                    </div>
                </div>
            <?php }
        } ?>
        </tbody>
    </table>
</div>

<!-- Modal Tambah -->
<div class="modal fade" id="tambahKategori" tabindex="-1" aria-hidden="true">
  <div class="modal-dialog">
    <form method="post">
        <div class="modal-content">
            <div class="modal-header">
                <h5>Tambah Kategori Baru</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
            </div>
            <div class="modal-body">
                <div class="mb-2">
                    <label>Nama Kategori</label>
                    <input type="text" class="form-control" name="nama" required>
                </div>
                <div class="mb-2">
                    <label>Keterangan</label>
                    <input type="text" class="form-control" name="keterangan">
                </div>
            </div>
            <div class="modal-footer">
                <button type="submit" name="tambahkategori" class="btn btn-success">Tambah</button>
            </div>
        </div>
    </form>
  </div>
</div>

<script src="vendor/jquery/jquery.min.js"></script>
<script src="bootstrap/js/bootstrap.bundle.min.js"></script>
</body>
</html>
