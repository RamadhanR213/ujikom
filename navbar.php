<nav class="navbar navbar-expand-lg bg-primary" data-bs-theme="dark">
    <div class="container-fluid">
        <img
            src="assets/image/icon-healthier.png"
            alt="Logo"
            style="width: 50px; height: 50px; margin: 10px"
            class="d-inline-block align-text-top" />
        <a class="navbar-brand mx-2" href="index.php">Health Shop</a>

        <button
            class="navbar-toggler"
            type="button"
            data-bs-toggle="collapse"
            data-bs-target="#navbarNav"
            aria-controls="navbarNav"
            aria-expanded="false"
            aria-label="Toggle navigation">
            <span class="navbar-toggler-icon"></span>
        </button>
        <div
            class="collapse navbar-collapse justify-content-end mr-3"
            id="navbarNav">
            <ul class="navbar-nav">
                <li class="nav-item">
                    <a class="nav-link"  href="index.php">Beranda</a>
                </li>
                <li class="nav-item">
                    <a class="nav-link" href="belanja.php">Belanja</a>
                </li>
                <li class="nav-item">
                    <a class="nav-link active" aria-current="page" href="cart.php?p=0">Keranjang</a>
                </li>
                <li class="nav-item">
                <a class="nav-link" href="https://wa.me/+6281240277417">Kontak Kami</a>
                </li>
            </ul>
            <ul class="navbar-nav mx-4">
                <?php
                if (!isset($_SESSION['log'])) {
                    echo '
					<li><a href="register.php" class="btn btn-light mx-2"> Register</a></li>
					<li><a href="login.php" class="btn btn-light">Login</a></li>
					';
                } else {

                    if ($_SESSION['role'] == 'Member') {
                        echo '
					<li style="color:white">Halo, ' . $_SESSION["username"] . '
					<li><a href="logout.php">Keluar?</a></li>
					';
                    } else {
                        echo '
                    <li><a href="admin.php" class="btn btn-light mb-1 mx-3">Admin Panel</a></li>
					<li><a href="logout.php" class="btn btn-light mb-1">Logout</a></li>
					';
                    };
                }
                ?>
            </ul>
        </div>
    </div>
</nav>