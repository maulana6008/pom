<?php 


    if(!isset($_SESSION['user'])){
        echo "<script>alert('login terlebih dahulu')</script>";
        echo "<script>location='login.php'</script>";
    }

    $id = $_SESSION['user'];
    
    $login_check = $koneksi->query("SELECT * FROM pegawai WHERE id_pegawai='$id' ");
    if(!$login_check->num_rows){
        echo "<script>alert('Sessin is not valid')</script>";
        echo "<script>location='login.php'</script>";
    }