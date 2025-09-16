<?php
session_start();
include '../koneksi.php';

// Ambil daftar pesanan + data pengguna
$queryListPesanan = mysqli_query($conn, "
    SELECT pesanan.*, pendaftar.username 
    FROM pesanan 
    JOIN pendaftar ON pesanan.id_pengguna = pendaftar.id
    ORDER BY pesanan.id_pesanan DESC
");
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="utf-8" />
    <meta http-equiv="X-UA-Compatible" content="IE=edge" />
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no" />
    <title>Admin Panel - Konfirmasi Pesanan</title>

    <link href="vendor/fontawesome-free/css/all.min.css" rel="stylesheet" type="text/css" />
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
            <li class="nav-item"><a class="nav-link" href="index.php"><span>Beranda</span></a></li>
            <hr class="sidebar-divider" />
            <div class="sidebar-heading">Menu</div>
            <li class="nav-item"><a class="nav-link" href="customer.php"><span>Customer</span></a></li>
            <li class="nav-item"><a class="nav-link" href="produk.php"><span>Produk</span></a></li>
            <li class="nav-item active"><a class="nav-link" href="konfirmasi.php"><span>Konfirmasi Pesanan</span></a></li>
            <li class="nav-item"><a class="nav-link" href="../index.php"><span>Kembali ke toko</span></a></li>
            <hr class="sidebar-divider d-none d-md-block" />
        </ul>

        <!-- Content Wrapper -->
        <div id="content-wrapper" class="d-flex flex-column">
            <div id="content">
                <!-- Topbar -->
                <nav class="navbar navbar-expand navbar-light bg-white topbar mb-4 static-top shadow">
                    <ul class="navbar-nav ml-auto">
                        <div class="topbar-divider d-none d-sm-block"></div>
                        <li class="nav-item dropdown no-arrow">
                            <a class="nav-link dropdown-toggle" href="#">
                                <span class="mr-2 d-none d-lg-inline text-gray-600 small">
                                    <?php echo isset($_SESSION['username']) ? $_SESSION['username'] : 'Admin'; ?>
                                </span>
                                <img class="img-profile rounded-circle" src="img/undraw_profile.svg" />
                            </a>
                        </li>
                    </ul>
                </nav>

                <div class="container-fluid">
                    <div class="d-sm-flex align-items-center justify-content-between mb-4">
                        <h1 class="h3 mb-0 text-gray-800">Konfirmasi Pesanan</h1>
                    </div>

                    <div class="card container-fluid row">
                        <div class="table-responsive mt-4 mb-4">
                            <table class="table table-bordered text-center align-middle">
                                <thead class="table-primary">
                                    <tr>
                                        <th>No.</th>
                                        <th>ID Pesanan</th>
                                        <th>Nama Pengguna</th>
                                        <th>Tanggal</th>
                                        <th>Total</th>
                                        <th>Pembayaran</th>
                                        <th>Status</th>
                                        <th>Aksi</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <?php
                                    $jumlah = 1;
                                    if (mysqli_num_rows($queryListPesanan) == 0) {
                                        echo "<tr><td colspan='8' class='text-center'>Belum ada pesanan</td></tr>";
                                    } else {
                                        while ($data = mysqli_fetch_assoc($queryListPesanan)) {
                                            echo "<tr>
                                                    <td>{$jumlah}</td>
                                                    <td>{$data['id_pesanan']}</td>
                                                    <td>{$data['username']}</td>
                                                    <td>{$data['tanggal']}</td>
                                                    <td>Rp " . number_format($data['total'], 0, ',', '.') . "</td>
                                                    <td>{$data['pembayaran']}</td>
                                                    <td><span class='badge bg-" .
                                                        ($data['status_pesanan']=='Menunggu Konfirmasi' ? 'secondary' :
                                                        ($data['status_pesanan']=='Sedang diproses' ? 'warning' :
                                                        ($data['status_pesanan']=='Dikirim' ? 'info' :
                                                        ($data['status_pesanan']=='Selesai' ? 'success' : 'danger')))) .
                                                    "'>{$data['status_pesanan']}</span></td>
                                                    <td>";

                                            // Tombol aksi
                                            if ($data['status_pesanan'] == 'Menunggu Konfirmasi') {
                                                echo "<a class='btn btn-success btn-sm' href='setujupesanan.php?id={$data['id_pesanan']}'><i class='fa fa-check'></i></a>
                                                      <a class='btn btn-danger btn-sm' href='tolakpesanan.php?id={$data['id_pesanan']}'><i class='fa fa-minus'></i></a>";
                                            } elseif ($data['status_pesanan'] == 'Sedang diproses') {
                                                echo "<a class='btn btn-info btn-sm' href='updatestatus.php?id={$data['id_pesanan']}&status=Dikirim'>Kirim</a>";
                                            }

                                            echo "</td></tr>";
                                            $jumlah++;
                                        }
                                    }
                                    ?>
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <script src="vendor/jquery/jquery.min.js"></script>
    <script src="vendor/bootstrap/js/bootstrap.bundle.min.js"></script>
    <script src="vendor/jquery-easing/jquery.easing.min.js"></script>
    <script src="js/sb-admin-2.min.js"></script>
</body>
</html>
