<?php
session_start();
include '../koneksi.php';


$query = mysqli_query($conn, "select a.*, b.nama_kategori AS nama_kategori from produk a join kategori b on a.id_kategori=b.id_kategori ");
$jumlahproduk = mysqli_num_rows($query);

$querykategori = mysqli_query($conn, "select * from kategori");


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
<style>
    .deskProduk {
        max-width: 300px;
        white-space: nowrap;
        overflow: hidden;
        text-overflow: ellipsis;
    }
</style>

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
            <li class="nav-item active">
                <a class="nav-link" href="#">
                    <span>Produk</span>
                </a>
            </li>
            <li class="nav-item ">
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



                <!-- Begin Page Content -->
                <div class="container-fluid">
                    <!-- Page Heading -->
                    <div
                        class="d-sm-flex align-items-center justify-content-between mb-4">
                        <h1 class="h3 mb-0 text-gray-800">Produk</h1>
                        <div>
                            <button type="button" class="btn btn-primary" data-bs-toggle="modal" data-bs-target="#staticBackdrop"><i class="fa fa-plus mr-2"></i>Tambah Produk</button>
                        </div>
                    </div>

                    <!-- Modal -->
                    <div class="modal fade" id="staticBackdrop" data-bs-backdrop="static" data-bs-keyboard="false" tabindex="-1" aria-labelledby="staticBackdropLabel" aria-hidden="true">
                        <div class="modal-dialog modal-dialog-centered">
                            <div class="modal-content">
                                <div class="modal-header">
                                    <h1 class="modal-title fs-5" id="staticBackdropLabel"><b>Tambah Produk</b></h1>
                                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                                </div>
                                <div class="modal-body">
                                    <form action="produk.php" method="post" enctype="multipart/form-data" class="mb-1">
                                        <div>
                                            <label for="nama"><b>Nama Produk</b></label>
                                            <input type="text" id="nama" name="nama" class="form-control" autocomplete="off" required>
                                        </div>
                                        <div>
                                            <label for="harga"><b>Harga</b></label>
                                            <input type="number" id="harga" name="harga" class="form-control" autocomplete="off" required>
                                        </div>
                                        <div>
                                            <label for="kategori"><b>Kategori</b></label>
                                            <select name="kategori" id="kategori" class="form-control">
                                                <?php
                                                while ($data = mysqli_fetch_array($querykategori)) {
                                                ?>
                                                    <option value="<?php echo $data['id_kategori'] ?>"><?php echo $data['nama_kategori'] ?></option>
                                                <?php
                                                }
                                                ?>
                                            </select>
                                        </div>
                                        <div>
                                            <label for="foto"><b>Foto Produk</b></label>
                                            <input type="file" id="foto" name="foto" class="form-control" accept=".jpg, .jpeg, .png" autocomplete="off">
                                        </div>
                                        <div>
                                            <label for="stok"><b>Ketersediaan Produk</b></label>
                                            <select name="stok" id="stok" class="form-control">
                                                <option value="tersedia">Tersedia</option>
                                                <option value="habis">Habis</option>
                                            </select>
                                        </div>
                                        <div>
                                            <label for="detail"><b>Deskripsi Produk</b></label>
                                            <textarea type="text" id="detail" name="detail" cols="30" rows="5" class="form-control"></textarea>
                                        </div>
                                        <div class="modal-footer">
                                            <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Tutup</button>
                                            <button type="submit" class="btn btn-primary" name="addproduk">Tambahkan</button>
                                        </div>
                                    </form>

                                </div>

                            </div>
                        </div>

                    </div>
                    <?php
                    if (isset($_POST['addproduk'])) {
                        $nama = htmlspecialchars($_POST['nama']);
                        $kategori = htmlspecialchars($_POST['kategori']);
                        $harga = htmlspecialchars($_POST['harga']);
                        $detail = htmlspecialchars($_POST['detail']);
                        $stok = htmlspecialchars($_POST['stok']);

                        $target_dir = "../assets/image/";
                        $nama_file = basename($_FILES["foto"]["name"]);
                        $target_file = $target_dir . $nama_file;
                        $imageFileType = strtolower(pathinfo($target_file, PATHINFO_EXTENSION));
                        $image_size = $_FILES["foto"]["size"];
                        $random_name = generateRandomString(20);
                        $new_name = $random_name . "." . $imageFileType;

                        if ($image_size <=  3000000) {
                            move_uploaded_file($_FILES["foto"]["tmp_name"], $target_dir . $new_name);
                            $querytambah = mysqli_query($conn, "INSERT INTO produk (id_kategori, nama, harga, foto, detail, stok)
                                         VALUES ('$kategori', '$nama', '$harga', '$new_name', '$detail', '$stok')");
                            echo '<div class="alert alert-success" role="alert">Sukses tambah produk</div>';
                            echo "<div><br><meta http-equiv='refresh' content='1 URL=produk.php'></div>";
                        } else if ($image_size >  3000000) {
                            echo '<div class="alert alert-danger" role="alert">Ukuran foto terlalu besar, pastikan ukuran di bawah 3MB!</div>';
                            echo "<div><br><meta http-equiv='refresh' content='1 URL=produk.php'></div>";
                        } else {
                            echo '<div class="alert alert-danger" role="alert">Gagal tambah produk</div>';
                            echo "<div><br><meta http-equiv='refresh' content='1 URL=produk.php'></div>";
                            mysqli_error($conn);
                        }
                    }


                    ?>
                    <div>

                    </div>

                    <!-- Content Row -->
                    <div class="card container-fluid row">
                        <div class="table-responsive mt-5">
                            <table class="table">
                                <thead>
                                    <tr>
                                        <th scope="col">No.</th>
                                        <th scope="col">Gambar</th>
                                        <th scope="col">Nama Produk</th>
                                        <th scope="col">Kategori</th>
                                        <th scope="col">Deskripsi</th>
                                        <th scope="col">Harga</th>
                                        <th scope="col">Stok</th>
                                        <th scope="col">Edit</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <?php if ($jumlahproduk == 0) { ?>
                                        <tr>
                                            <td colspan=8 class="text-center">Data produk tidak tersedia</td>
                                        </tr>
                                        <?php
                                    } else {
                                        $jumlah = 1;
                                        while ($data1 = mysqli_fetch_array($query)) {
                                        ?>
                                            <tr class="align-items-center">
                                                <td><?php echo $jumlah ?></td>
                                                <td><img src="../assets/image/<?php echo $data1['foto'] ?>" alt="foto" style="width: 100px; height: 50px; object-fit:cover"></td>
                                                <td><?php echo $data1['nama'] ?></td>
                                                <td><?php echo $data1['nama_kategori'] ?></td>
                                                <td class="deskProduk"><?php echo $data1['detail'] ?></td>
                                                <td><?php echo $data1['harga'] ?></td>
                                                <td><?php echo $data1['stok'] ?></td>
                                                <td>
                                                    <a href="edit-produk.php?p=<?php echo $data1['id'] ?>" class="btn btn-info">
                                                        <i class="fas fa-search"></i>
                                                    </a>
                                                    <a class="btn btn-info" href="deleteproduk.php?id=<?php echo $data1['id']; ?>">
                                                        <i class="fas fa-trash"></i>
                                                    </a>
                                                </td>
                                            </tr>

                                    <?php
                                            $jumlah++;
                                        }
                                    }

                                    ?>
                                </tbody>
                            </table>
                        </div>

                    </div>
                    <!-- End of Main Content -->

                </div>
                <!-- End of Content Wrapper -->
            </div>
            <!-- End of Page Wrapper -->

            <!-- Scroll to Top Button-->
            <a class="scroll-to-top rounded" href="#page-top">
                <i class="fas fa-angle-up"></i>
            </a>



            <!-- Bootstrap core JavaScript-->
            <script src="vendor/jquery/jquery.min.js"></script>
            <script src="vendor/bootstrap/js/bootstrap.bundle.min.js"></script>

            <!-- Core plugin JavaScript-->
            <script src="vendor/jquery-easing/jquery.easing.min.js"></script>

            <!-- Custom scripts for all pages-->
            <script src="js/sb-admin-2.min.js"></script>

            <!-- Page level plugins -->
            <script src="vendor/chart.js/Chart.min.js"></script>

            <!-- Page level custom scripts -->
            <script src="js/demo/chart-area-demo.js"></script>
            <script src="js/demo/chart-pie-demo.js"></script>

            <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js" integrity="sha384-YvpcrYf0tY3lHB60NNkmXc5s9fDVZLESaAA55NDzOxhy9GkcIdslK1eN7N6jIeHz" crossorigin="anonymous"></script>
</body>


</html>