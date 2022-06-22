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
    }