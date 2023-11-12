<?php

function edit($data){
    global $conn;
    $no = $data["no"];
    $picture = $data["picture"];
    $petid = $data["petid"];
    $petname = $data["petname"];
    $harga = $data["harga"];
    $jenis = $data["jenis"];

    $query = "UPDATE productlist SET
        picture = '$picture',
        petid = '$petid',
        petname = '$petname',
        harga = '$harga',
        jenis = '$jenis'
        WHERE no = $no
    ";
    mysqli_query($conn, $query);
    return mysqli_affected_rows($conn);
}


$conn = mysqli_connect("localhost:3308", "root", "", "IQMLPETSHOP");

function query($query){

    global $conn;
    $result = mysqli_query($conn, $query);
    $rows = [];
    while ($row = mysqli_fetch_assoc($result)){
        $rows [] = $row;
    }
    return $rows;
}

function tambah($data){
    global $conn;
    $picture = $data["picture"];
    $petid = $data["petid"];
    $petname = $data["petname"];
    $harga = $data["harga"];
    $jenis = $data["jenis"];

    $query = "INSERT INTO productlist
        VALUES
        ('','$picture', '$petid', '$petname', '$harga
        ', '$jenis')";
    mysqli_query($conn,$query);
    return mysqli_affected_rows($conn);
}

function del($no){
    global $conn;
    $no = mysqli_real_escape_string($conn, $no);
    mysqli_query($conn, "DELETE FROM productlist WHERE no = $no");
    return mysqli_affected_rows($conn);
}

