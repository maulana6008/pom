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
    }