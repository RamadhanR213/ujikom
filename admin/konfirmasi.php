<?php
session_start();
include '../koneksi.php';

$queryListPesanan = mysqli_query($conn, "SELECT * FROM pesanan JOIN pendaftar ON pesanan.id_pengguna = pendaftar.id")


?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="utf-8" />
    <meta http-equiv="X-UA-Compatible" content="IE=edge" />
    <meta
        name="viewport"
        content="width=device-width, initial-scale=1, shrink-to-fit=no" />
    <meta name="description" content="" />
    <meta name="author" content="" />

    <title>Admin Panel</title>

    <!-- Custom fonts for this template-->
    <link
        href="vendor/fontawesome-free/css/all.min.css"
        rel="stylesheet"
        type="text/css" />
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-QWTKZyjpPEjISv5WaRU9OFeRpok6YctnYmDr5pNlyT2bRjXh0JMhjY6hW+ALEwIH" crossorigin="anonymous">
    <link
        href="https://fonts.googleapis.com/css?family=Nunito:200,200i,300,300i,400,400i,600,600i,700,700i,800,800i,900,900i"
        rel="stylesheet" />

    <!-- Custom styles for this template-->
    <link href="css/sb-admin-2.min.css" rel="stylesheet" />
</head>

<body id="page-top">
    <!-- Page Wrapper -->
    <div id="wrapper">
        <!-- Sidebar -->
        <ul
            class="navbar-nav bg-gradient-primary sidebar sidebar-dark accordion"
            id="accordionSidebar">
            <!-- Sidebar - Brand -->
            <a
                class="sidebar-brand d-flex align-items-center justify-content-center"
                href="index.php">
                <div class="sidebar-brand-text mx-1">Dashboard Admin</div>
            </a>

            <!-- Divider -->
            <hr class="sidebar-divider my-0" />


            <li class="nav-item">
                <a class="nav-link" href="index.php">
                    <span>Beranda</span></a>
            </li>

            <!-- Divider -->
            <hr class="sidebar-divider" />

            <!-- Heading -->
            <div class="sidebar-heading">Menu</div>

            <!-- Nav Item - Pages Collapse Menu -->
            <li class="nav-item">
                <a class="nav-link" href="produk.php">
                    <span>Produk</span>
                </a>
            </li>
            <li class="nav-item active">
                <a class="nav-link" href="konfirmasi.php">
                    <span>Konfirmasi Pesanan</span>
                </a>
            </li>
            <li class="nav-item">
                <a class="nav-link" href="../index.php">
                    <span>Kembali ke toko</span>
                </a>
            </li>

            <!-- Divider -->
            <hr class="sidebar-divider d-none d-md-block" />
        </ul>
        <!-- End of Sidebar -->

        <!-- Content Wrapper -->
        <div id="content-wrapper" class="d-flex flex-column">
            <!-- Main Content -->
            <div id="content">
                <!-- Topbar -->
                <nav
                    class="navbar navbar-expand navbar-light bg-white topbar mb-4 static-top shadow">
                    <!-- Sidebar Toggle (Topbar) -->
                    <button
                        id="sidebarToggleTop"
                        class="btn btn-link d-md-none rounded-circle mr-3">
                        <i class="fa fa-bars"></i>
                    </button>

                    <!-- Topbar Navbar -->
                    <ul class="navbar-nav ml-auto">


                        <div class="topbar-divider d-none d-sm-block"></div>


                        <li class="nav-item dropdown no-arrow">
                            <a
                                class="nav-link dropdown-toggle"
                                href="#"
                                role="button"
                                data-toggle="dropdown"
                                aria-haspopup="true"
                                aria-expanded="false">
                                <span class="mr-2 d-none d-lg-inline text-gray-600 small">
                                    <?php echo $_SESSION['username'] ?>
                                </span>
                                <img
                                    class="img-profile rounded-circle"
                                    src="img/undraw_profile.svg" />
                            </a>

                        </li>
                    </ul>
                </nav>
                <!-- End of Topbar -->


                <div class="container-fluid">
                    <div
                        class="d-sm-flex align-items-center justify-content-between mb-4">
                        <h1 class="h3 mb-0 text-gray-800">Konfirmasi Pesanan</h1>
                    </div>

                    <!-- Content Row -->
                    <div class="card container-fluid row">
                        <div class="table-responsive mt-5">
                            <table class="table">
                                <thead>
                                    <tr>
                                        <th scope="col">No.</th>
                                        <th scope="col">ID Pesanan</th>
                                        <th scope="col">Nama Pengguna</th>
                                        <th scope="col">Tanggal</th>
                                        <th scope="col">Total</th>
                                        <th scope="col">Status</th>
                                    </tr>
                                </thead>
                                <tbody>

                                    <?php

                                    $jumlah = 1;
                                    while ($data = mysqli_fetch_array($queryListPesanan)) {
                                    ?>
                                        <tr class="align-items-center">
                                            <td><?php echo $jumlah ?></td>
                                            <td><?php echo $data['id_pesanan'] ?></td>
                                            <td><?php echo $data['username'] ?></td>
                                            <td><?php echo $data['tanggal'] ?></td>
                                            <td><?php echo $data['total'] ?></td>
                                            <td>
                                                <a class="btn btn-primary" href="setujupesanan.php?id=<?php echo $data['id'] ?>"><i class="fa fa-check"></i></a>
                                                <a class="btn btn-primary" href="tolakpesanan.php?id=<?php echo $data['id'] ?>"><i class="fa fa-minus"></i></a>
                                            </td>
                                        </tr>

                                    <?php
                                        $jumlah++;
                                    }


                                    ?>
                                </tbody>
                            </table>
                        </div>

                    </div>


                </div>

</body>