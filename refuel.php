<?php

    include 'config.php';

    $user = $koneksi->query("SELECT * FROM users");
    $id_pegawai = 1;
    $bensin = $koneksi->query("SELECT * FROM bensin");
    $transaction = $koneksi->query("SELECT * FROM transaksi");

    if(isset($_POST['add'])){
        $usr = $_POST['user'];
        $gas_type = $_POST['gas'];
        $re = $_POST['refuel'];
        $tgl = date("d-m-Y");

        if(!$gas_type or !$re){
            echo "<script>alert('All input are required')</script>";
        }else{
            $data = $koneksi->query("SELECT bensin.harga, bensin.isi, users.saldo from bensin,users WHERE bensin.id_bensin='$gas_type' and users.id_users='$usr' ");
            $obj = $data->fetch_object();
    
            $liter = $re/$obj->harga;
            $liter = $liter;
            $sisa = $obj->isi - $liter;
            $saldo = $obj->saldo - $re;
            if($sisa >= 0){
                $insert = $koneksi->query("INSERT INTO transaksi VALUES(
                    NULL,
                    '".$usr."',
                    '".$gas_type."',
                    '".$id_pegawai."',
                    '".$liter."',
                    '".$re."',
                    '".$tgl."'
                )");

                if($insert){
                    $update_bensin = $koneksi->query("UPDATE bensin set isi='$sisa' WHERE id_bensin='$gas_type'");
                    if($update_bensin){
                            
                        if($obj->saldo < $re){
                            $u_user = $koneksi->query("UPDATE users set saldo='0' WHERE id_users='$usr'");
                            $pay = abs($saldo);
                            if($u_user){
                                echo "<script>alert('You Balance is less, you have to pay $pay')</script>";
                                echo "<script>alert('Successfuly Add Refuel')</script>";
                            }

                        }else{
                            $u_user = $koneksi->query("UPDATE users set saldo='$saldo' WHERE id_users='$usr'");
                            if($u_user){
                                echo "<script>alert('Successfuly Add Refuel')</script>";
                            }
                        }
                    }
                }
            }else{
                echo "<script>alert('Stock is not enough')</script>";
            }

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
            <!-- Nav Item - Charts -->
            <li class="nav-item active">
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

            <li class="nav-item">
            <a class="nav-link" href="user.php">
                <i class="fas fa-solid fa-user"></i>
                <span>Users</span></a>
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
                        <h1 class="h3 mb-0 text-gray-800">Refuel Users</h1>
                            <a class="d-none d-sm-inline-block btn btn-sm btn-primary shadow-sm" href="#" data-toggle="modal" data-target="#refuelmodal">
                        <i class="fas fa-solid fa-plus"></i> Add</a>
                        </a>
                            
                    </div>


                    <!-- DataTales Example -->
                    <div class="card shadow mb-4">
                        <div class="card-header py-3">
                            <h6 class="m-0 font-weight-bold text-primary">Refuel Data</h6>
                        </div>
                        <div class="card-body">
                            <div class="table-responsive">
                                <table class="table table-bordered" id="dataTable" width="100%" cellspacing="0">
                                <thead>
                                        <tr>
                                            <th>No</th>
                                            <th>User</th>
                                            <th>Pegawai</th>
                                            <th>Pengisian</th>
                                            <th>Total</th>
                                            <th>Tanggal</th>
                                            <th colspan="2">Action</th>
                                        </tr>
                                    </thead>
                                    <tfoot>
                                        <tr>
                                            <th>No</th>
                                            <th>User</th>
                                            <th>Pegawai</th>
                                            <th>Pengisian</th>
                                            <th>Total</th>
                                            <th>Tanggal</th>
                                            <th colspan="2">Action</th>
                                        </tr>
                                    </tfoot>
                                    <tbody>
                                    <?php 
                                    $no=1;
                                    while($obj = $transaction->fetch_object()): 
                                    $id_u = $obj->id_user;
                                    $id_p = $obj->id_pegawai;
                                    $user_akun = $koneksi->query("SELECT * FROM users WHERE id_users='$id_u'");
                                    $pegawai_akun = $koneksi->query("SELECT * FROM pegawai WHERE id_pegawai='$id_p'");
                                    ?>
                                        <tr>
                                            <td><?= $no ?></td>
                                            <td><?= $user_akun->fetch_object()->nama; ?></td>
                                            <td><?= $pegawai_akun->fetch_object()->nama; ?></td>
                                            <td><?= $obj->pengisian ?> liter</td>
                                            <td>Rp <?= $obj->total_harga?>,-</td>
                                            <td><?= $obj->tgl?></td>
                                            <td>
                                                <a href="edit.php?id=<?= $obj->id_transaksi ?>&edit=tra-ed" class="btn btn-secondary">
                                                    Edit
                                                </a>
                                            </td>
                                            <td>
                                                <a href="delete.php?id=<?= $obj->id_transaksi ?>&delete=tra-del" class="btn btn-danger">
                                                    Delete
                                                </a>
                                            </td>
                                        </tr>
                                        <?php $no++;endwhile; ?>
                                    </tbody>
                                </table>
                            </div>
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

    <!-- Logout Modal-->
    <div class="modal fade" id="logoutModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel"
        aria-hidden="true">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="exampleModalLabel">Ready to Leave?</h5>
                    <button class="close" type="button" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">×</span>
                    </button>
                </div>
                <div class="modal-body">Select "Logout" below if you are ready to end your current session.</div>
                <div class="modal-footer">
                    <button class="btn btn-secondary" type="button" data-dismiss="modal">Cancel</button>
                    <a class="btn btn-primary" href="login.html">Logout</a>
                </div>
            </div>
        </div>
    </div>

    <!-- Refuel Modal-->
    <div class="modal fade" id="refuelmodal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel"
        aria-hidden="true">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="exampleModalLabel">Add Refuel</h5>
                    <button class="close" type="button" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">×</span>
                    </button>
                </div>
                <div class="modal-body">
                    <form action="" method="post">
                        <div class="row">
                            <div class="col-12 ml-3">
                                <label for="users">user</label>
                                <select name="user" id="users" class="form-control">
                                    <?php while($users = $user->fetch_object()): ?>
                                    <option value="<?= $users->id_users ?>"><?= $users->nama ?></option>
                                    <?php endwhile; ?>
                                </select>
                            </div>
                            <div class="col-12 mt-3">
                                <label for="gas">Gas Type</label>
                                <select name="gas" id="gas" class="form-control">
                                    <option value="">-- Choose --</option>
                                    <?php while($gas = $bensin->fetch_object()): ?>
                                    <option class="gas-<?= $gas->id_bensin ?>" value="<?= $gas->id_bensin ?>" data-price="<?= $gas->harga ?>"><?= $gas->jenis ?></option>
                                    <?php endwhile; ?>
                                </select>
                            </div>
                            <div class="col-12 mt-3">
                                <label for="gas">Price Gas</label>
                                <input type="text" class="price form-control" readonly>
                            </div>
                            <div class="col-12 mt-3">
                                <label for="refuel">Refuel</label>
                                <input type="text" class="form-control" name="refuel" placeholder="Enter cash amount">
                            </div>
                            <div class="col-12 mt-3">
                                <button type="submit" class="btn btn-primary" name="add">Add</button>
                            </div>
    
                        </div>
                    </form>
                    
                </div>
                <div class="modal-footer">
                    <button class="btn btn-secondary" type="button" data-dismiss="modal">Cancel</button>
                    
                </div>
            </div>
        </div>
    </div>

    <!-- Bootstrap core JavaScript-->
    <script src="vendor/jquery/jquery.min.js"></script>
    <script src="vendor/bootstrap/js/bootstrap.bundle.min.js"></script>

    <!-- Core plugin JavaScript-->
    <script src="vendor/jquery-easing/jquery.easing.min.js"></script>

    <!-- Custom scripts for all pages-->
    <script src="js/sb-admin-2.min.js"></script>
    <script>
        let gas = document.querySelector('#gas')
        let price = document.querySelector('.price')
        gas.addEventListener('change', (e) => {
            if(e.target.value){
                price.value = document.querySelector(`.gas-${e.target.value}`).dataset.price
            }else{
                price.value = "";
            }
        })
    </script>

</body>

</html>