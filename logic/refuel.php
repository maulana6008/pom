<?php

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