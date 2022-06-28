<?php   
    $bensin = $koneksi->query("SELECT * FROM bensin");
    if(isset($_POST['add'])){
        $gas_type = $_POST['type'];
        $qty = $_POST['qty'];
        $price = $_POST['price'];
        if($koneksi->query("SELECT * FROM bensin WHERE jenis='$gas_type'")->num_rows <= 0){
            $insert = $koneksi->query("INSERT INTO bensin VALUES(
                NULL,
                '".$gas_type."',
                '".$qty."',
                '".$price."'
            )");
            if($insert){
                echo "<script>alert('Inserting Successfuly')</script>";
                echo '<meta http-equiv="refresh" content="1">';
            }else{
                echo "<script>alert('Inserting Error')</script>";
            }
        }else{
            echo "<script>alert('The Gas Type is Available in Database')</script>";
        }
    }