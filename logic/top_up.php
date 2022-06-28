<?php

    $pegawai = $koneksi->query("SELECT * FROM pegawai WHERE id_pegawai='1' ");
    $top_ups = $koneksi->query("SELECT * FROM top_up WHERE id_pegawai='1' ");
    // $user_amount = $user->fetch_object();
    // echo "<pre>";
    // print_r($user_amount);
    // echo "</pre>";

    if(isset($_POST['refuel'])){

        $buyer = $_POST['user'];
        $amount = $_POST['amount'];
        $date = date("d-m-Y");
        $insert = $koneksi->query("INSERT INTO top_up VALUES(
            NULL,
            '".$id_pegawai."',
            '".$amount."',
            '".$buyer."',
            '".$date."'
        )");
        if($insert){
            $user_amount = $koneksi->query("SELECT * FROM users WHERE id_users='$buyer'");
            $user_amount = $user_amount->fetch_object()->saldo;
            $amount = $user_amount + $amount;
            $top_up = $koneksi->query("UPDATE users SET saldo='$amount' WHERE id_users='$buyer' ");
            if($top_up){
                echo "<script>alert('Successfully added to your balance')</script>";
                echo '<meta http-equiv="refresh" content="1">';
            }
        }else{
            echo "error";
        }

    }