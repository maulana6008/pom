<?php

    if(isset($_SESSION['user'])){
        $id = $_SESSION['user'];

        $login_check = $koneksi->query("SELECT * FROM pegawai WHERE id_pegawai='$id' ");
        if($login_check->num_rows){
            echo "<script>alert('You have session')</script>";
            echo "<script>location='index.php'</script>";
        }
    }

    if(isset($_POST['login'])){
        $email = $_POST['email'];
        $pass = $_POST['pass'];

        if($pass == 'coba'){
            $check = $koneksi->query("SELECT * FROM pegawai WHERE email='$email' ");
            if($check->num_rows >= 1){
                $_SESSION['user'] = $check->fetch_object()->id_pegawai;
                echo "<script>alert('Login Successfuly')</script>";
                echo "<script>location='index.php'</script>";
            }
        }else{
            echo "<script>alert('Your Password is Wrong')</script>";
        }

    }

    