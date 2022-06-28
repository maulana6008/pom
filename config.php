<?php 

    session_start();

    $koneksi = new mysqli("localhost","root","","pom_bensin");

    
    if($koneksi->connect_errno){
        echo "Koneksi Gagal : ".$koneksi->connect_error;
        exit();
    }
    $user = $koneksi->query("SELECT * FROM users");

