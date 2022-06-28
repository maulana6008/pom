<?php
    include 'config.php';
    if(!isset($_GET)){
        echo "<script>location='index.php'</script>";
    }else{
        $id = $_GET['id'];
        if($_GET['delete'] == "bensin"){
            $delete = $koneksi->query("DELETE FROM bensin WHERE id_bensin='$id'");
            if($delete){
                echo "<script>alert('delete successfuly')</script>";
                echo "<script>location='bensin.php'</script>";
            }else{
                echo "<script>alert('delete failed')</script>";
                echo "<script>location='bensin.php'</script>";
            }
        }
        elseif($_GET['delete'] == "top-up"){
            $delete = $koneksi->query("DELETE FROM top_up WHERE id_top_up='$id'");
            if($delete){
                echo "<script>alert('delete successfuly')</script>";
                echo "<script>location='top_up.php'</script>";
            }else{
                echo "<script>alert('delete failed')</script>";
                echo "<script>location='top_up.php'</script>";
            }
        }
        elseif($_GET['delete'] == "user"){
            $delete = $koneksi->query("DELETE FROM users WHERE id_users='$id'");
            if($delete){
                echo "<script>alert('delete successfuly')</script>";
                echo "<script>location='user.php'</script>";
            }else{
                echo "<script>alert('delete failed')</script>";
                echo "<script>location='user.php'</script>";
            }
        }
        elseif($_GET['delete'] == "pegawai"){
            $delete = $koneksi->query("DELETE FROM pegawai WHERE id_pegawai='$id'");
            if($delete){
                echo "<script>alert('delete successfuly')</script>";
                echo "<script>location='pegawai.php'</script>";
            }else{
                echo "<script>alert('delete failed')</script>";
                echo "<script>location='pegawai.php'</script>";
            }
        }
        elseif($_GET['delete'] == "tra-del"){
            $select = $koneksi->query("SELECT users.saldo, bensin.isi, transaksi.id_user, transaksi.id_bensin,
            transaksi.pengisian, transaksi.total_harga from transaksi,users,bensin
            WHERE transaksi.id_transaksi='$id' and users.id_users=transaksi.id_user
            and bensin.id_bensin = transaksi.id_bensin ");
            $obj = $select->fetch_object();
            $saldo = $obj->saldo + $obj->total_harga;
            $isi = $obj->isi + $obj->pengisian;
            $id_user = $obj->id_user;
            $id_bensin = $obj->id_bensin;
            $delete = $koneksi->query("DELETE FROM transaksi WHERE id_transaksi='$id'");
            if($delete){
                $update = $koneksi->query("UPDATE users SET saldo='$saldo' WHERE id_users='$id_user'");
                $update1 = $koneksi->query("UPDATE bensin SET isi='$isi' WHERE id_bensin='$id_bensin'");
                if($update and $update1){
                    echo "<script>alert('delete successfuly')</script>";
                    echo "<script>location='refuel.php'</script>";
                }else{
                    echo "<script>alert('delete failed')</script>";
                    echo "<script>location='refuel.php'</script>";
                }
            }else{
                echo "<script>alert('delete failed')</script>";
                echo "<script>location='refuel.php'</script>";
            }
        }
    }