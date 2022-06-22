<?php 

    session_start();

    $koneksi = new mysqli("localhost","root","","pom");

    if($koneksi->connect_errno){
        echo "Koneksi Gagal : ".$koneksi->connect_error;
        exit();
    }