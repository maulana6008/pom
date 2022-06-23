
<?php

include 'config.php';
$user = $koneksi->query("SELECT * FROM users");

if(!isset($_GET['id']) or !isset($_GET['edit'])){
    echo "<script>location='index.php'</script>";
}
$id = $_GET['id'];
if($_GET['edit'] == 'gas'){
    $bensin = $koneksi->query("SELECT * FROM bensin WHERE id_bensin='$id'");
    if($bensin->num_rows <= 0){
        echo "<script>alert('Gas not available')</script>";
        echo "<script>location='bensin.php'</script>";
    }
    
}
if($_GET['edit'] == 'topup'){
    $topup = $koneksi->query("SELECT * FROM top_up WHERE id_top_up='$id'");
}

if(isset($_POST['gas'])){
    $gas_type = $_POST['type'];
    $qty = $_POST['qty'];
    $price = $_POST['price'];
    $update = $koneksi->query("UPDATE bensin SET jenis='$gas_type', isi='$qty', harga='$price' WHERE id_bensin='$id'");
    if($update){
        echo "<script>alert('Edit Successfuly')</script>";
        echo "<script>location='bensin.php'</script>"; 
    }else{
        echo "<script>alert('Edit Failed')</script>";
    }
}
if(isset($_POST['topup'])){
    $id_user = $_POST['user'];
    $amount = $_POST['amount'];
    $obj_topup = $topup->fetch_object();
    $user_topup = $koneksi->query("SELECT * FROM users WHERE id_users='$id_user'");
    $saldo = $user_topup->fetch_object()->saldo - $obj_topup->amount + $amount;
    $update_saldo = $koneksi->query("UPDATE users SET saldo='$saldo' WHERE id_users='$id_user'");
    $update = $koneksi->query("UPDATE top_up SET id_user='$id_user', amount='$amount' WHERE id_top_up='$id'");
    if($update){
        echo "<script>alert('Edit Successfuly')</script>";
        echo "<script>location='top_up.php'</script>"; 
    }else{
        echo "<script>alert('Edit Failed')</script>";
    }
}


?>
<!DOCTYPE html>
<html lang="en">

<head>

<meta charset="utf-8">
<meta http-equiv="X-UA-Compatible" content="IE=edge">
<meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
<meta name="description" content="">
<meta name="author" content="">

<title>Online Refuel</title>

<!-- Custom fonts for this template-->
<link href="vendor/fontawesome-free/css/all.min.css" rel="stylesheet" type="text/css">
<link
    href="https://fonts.googleapis.com/css?family=Nunito:200,200i,300,300i,400,400i,600,600i,700,700i,800,800i,900,900i"
    rel="stylesheet">

<!-- Custom styles for this template-->
<link href="css/sb-admin-2.min.css" rel="stylesheet">

</head>

<body id="page-top">

<!-- Page Wrapper -->
<div id="wrapper">

    <!-- Sidebar -->
    <ul class="navbar-nav bg-gradient-primary sidebar sidebar-dark accordion" id="accordionSidebar">

        <!-- Sidebar - Brand -->
        <a class="sidebar-brand d-flex align-items-center justify-content-center" href="index.php">
            <div class="sidebar-brand-icon rotate-n-15">
                <i class="fas fa-laugh-wink"></i>
            </div>
            <div class="sidebar-brand-text mx-3">Refuel</div>
        </a>

        <!-- Divider -->
        <hr class="sidebar-divider my-0">

        <!-- Nav Item - Dashboard -->
        <li class="nav-item">
            <a class="nav-link" href="index.php">
                <i class="fas fa-fw fa-tachometer-alt"></i>
                <span>Dashboard</span></a>
        </li>

        <!-- Divider -->
        <hr class="sidebar-divider">

        <!-- Heading -->
        <div class="sidebar-heading">
            Features
        </div>

        <!-- Nav Item - Pages Collapse Menu -->
        <li class="nav-item">
            <a class="nav-link" href="refuel.php">
                <i class="fas fa-solid fa-gas-pump"></i>
                <span>Refuel Users</span></a>
        </li>
        
        <li class="nav-item">
            <a class="nav-link" href="top_up.php">
                <i class="fas fa-solid fa-money-bill"></i>
                <span>Top Up Users</span></a>
        </li>

        <li class="nav-item">
            <a class="nav-link" href="bensin.php">
                <i class="fas fa-solid fa-gas-pump"></i>
                <span>Gas Type</span></a>
        </li>

        <!-- Divider -->
        <hr class="sidebar-divider">

        <!-- Heading -->
        <div class="sidebar-heading">
            Addons
        </div>

        <li class="nav-item">
            <a class="nav-link" href="profile.php">
            <i class="fas fa-solid fa-address-card"></i>
            <span>Profile</span></a>
        </li>

        <li class="nav-item">
            <a class="nav-link" href="logout.php">
            <i class="fa-solid fas fa-sign-out-alt"></i>
            <span>Logout</span></a>
        </li>

        <!-- Divider -->
        <hr class="sidebar-divider d-none d-md-block">

        <!-- Sidebar Toggler (Sidebar) -->
        <div class="text-center d-none d-md-inline">
            <button class="rounded-circle border-0" id="sidebarToggle"></button>
        </div>


    </ul>
    <!-- End of Sidebar -->

    <!-- Content Wrapper -->
    <div id="content-wrapper" class="d-flex flex-column">

        <!-- Main Content -->
        <div id="content">

            <!-- Topbar -->
            <nav class="navbar navbar-expand navbar-light bg-white topbar mb-4 static-top shadow">

                <!-- Sidebar Toggle (Topbar) -->
                <button id="sidebarToggleTop" class="btn btn-link d-md-none rounded-circle mr-3">
                    <i class="fa fa-bars"></i>
                </button>

                

                <!-- Topbar Navbar -->
                <ul class="navbar-nav ml-auto">

                    <!-- Nav Item - Search Dropdown (Visible Only XS) -->
                    <li class="nav-item dropdown no-arrow d-sm-none">
                        <a class="nav-link dropdown-toggle" href="#" id="searchDropdown" role="button"
                            data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                            <i class="fas fa-search fa-fw"></i>
                        </a>
                        <!-- Dropdown - Messages -->
                        <div class="dropdown-menu dropdown-menu-right p-3 shadow animated--grow-in"
                            aria-labelledby="searchDropdown">
                            <form class="form-inline mr-auto w-100 navbar-search">
                                <div class="input-group">
                                    <input type="text" class="form-control bg-light border-0 small"
                                        placeholder="Search for..." aria-label="Search"
                                        aria-describedby="basic-addon2">
                                    <div class="input-group-append">
                                        <button class="btn btn-primary" type="button">
                                            <i class="fas fa-search fa-sm"></i>
                                        </button>
                                    </div>
                                </div>
                            </form>
                        </div>
                    </li>

                    <div class="topbar-divider d-none d-sm-block"></div>

                    <!-- Nav Item - User Information -->
                    <li class="nav-item dropdown no-arrow">
                        <a class="nav-link dropdown-toggle" href="#" id="userDropdown" role="button"
                            data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                            <span class="mr-2 d-none d-lg-inline text-gray-600 small">Douglas McGee</span>
                            <img class="img-profile rounded-circle"
                                src="img/undraw_profile.svg">
                        </a>
                        <!-- Dropdown - User Information -->
                        <div class="dropdown-menu dropdown-menu-right shadow animated--grow-in"
                            aria-labelledby="userDropdown">
                            <a class="dropdown-item" href="profile.php">
                                <i class="fas fa-user fa-sm fa-fw mr-2 text-gray-400"></i>
                                Profile
                            </a>
                            <div class="dropdown-divider"></div>
                            <a class="dropdown-item" href="#" data-toggle="modal" data-target="#logoutModal">
                                <i class="fas fa-sign-out-alt fa-sm fa-fw mr-2 text-gray-400"></i>
                                Logout
                            </a>
                        </div>
                    </li>

                </ul>

            </nav>
            <!-- End of Topbar -->

            <!-- Begin Page Content -->
            <div class="container-fluid">

                <!-- Page Heading -->
                <div class="d-sm-flex align-items-center justify-content-between mb-4">
                    <h1 class="h3 mb-0 text-gray-800">Page Edit</h1>
                </div>


                <!-- DataTales Example -->
                <div class="card shadow mb-4">
                    <div class="card-header py-3">
                        <h6 class="m-0 font-weight-bold text-primary">Edit <?= $_GET['edit'] ?></h6>
                    </div>
                    <div class="card-body">
                        <form action="" method="post">
                            <div class="row">
                                <div class="col-12">
                                    <div class="alert alert-info">Apabila tidak ingin mengubah jangan di kosongkan</div>
                                </div>
                                <?php 
                                if($_GET['edit'] == 'gas'): 
                                    $gas = $bensin->fetch_object();
                                    ?>
                                <div class="col-12">
                                    <label for="jenis">Gas Type</label>
                                    <input type="text" class="form-control" name="type" id="type" 
                                        value="<?= $gas->jenis ?>">
                                    </div>
                                    <div class="col-12 mt-3">
                                        <label for="isi">Quantity</label>
                                        <input type="text" class="form-control" name="qty" id="qty"
                                        value="<?= $gas->isi ?>">
                                    </div>
                                    <div class="col-12 mt-3">
                                        <label for="harga">Price (/ltr)</label>
                                    <input type="text" class="form-control" name="price" id="price"
                                    value="<?= $gas->harga ?>">
                                </div>
                                <div class="col-12 mt-3">
                                    <button type="submit" class="btn btn-primary" name="gas">Edit</button>
                                </div>
                                <?php 
                                elseif($_GET['edit']=='topup'):
                                    $top = $topup->fetch_object();
                                ?>
                                <form action="" method="post">
                                    <div class="col-12">
                                        <label for="users">user</label>
                                        <select name="user" id="users" class="form-control">
                                            <?php while($users = $user->fetch_object()): ?>
                                            <option value="<?= $users->id_users ?>"><?= $users->nama ?></option>
                                            <?php endwhile; ?>
                                        </select>
                                    </div>
                                    <div class="col-12 mt-3">
                                        <label for="amount">Amount</label>
                                        <input type="text" name="amount" class="form-control" placeholder="Input Cash Amount"
                                        value="<?= $top->amount ?>">
                                    </div>
    
                                    <div class="col-12 mt-3">
                                        <button type="submit" class="btn btn-primary" name="topup">Edit</button>
                                    </div>
                                </form>
                            </div>

                            <?php endif; ?>
                        </form>
                    </div>
                </div>

            </div>
            <!-- /.container-fluid -->

        </div>
        <!-- End of Main Content -->

        <!-- Footer -->
        <footer class="sticky-footer bg-white">
            <div class="container my-auto">
                <div class="copyright text-center my-auto">
                    <span>Copyright &copy; Your Website 2021</span>
                </div>
            </div>
        </footer>
        <!-- End of Footer -->

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

</body>

</html>