<?php
require 'functions.php';

if (isset($_POST["submit"])) {
    if (tambah ($_POST) > 0) {
        echo "
        <script>
        alert('Data berhasil ditambahkan!');
        document.location.href = 'index.php';
        </script>
        ";
    } else {
        echo "
        <script>
        alert('Data gagal ditambahakan!');
        document.location.href = 'index.php';
        </script>
        ";
    }
}
?>

<!DOCTYPE html>
<html lang="en">
    <head>
        <title>Add Product</title>
    </head>
    <body>
        <h1>Add product to list</h1>
        <form action="" method="post">
            <ul>
                <li>
                    <label for="picture">Picture:</label>
                    <input type="text" name="picture" id="picture">
                </li>
                <li>
                    <label for="petid">Product ID:</label>
                    <input type="text" name="petid" id="petid">
                </li>
                <li>
                    <label for="petname">Product Name:</label>
                    <input type="text" name="petname" id="petname">
                </li>
                <li>
                    <label for="harga">harga:</label>
                    <input type="text" name="harga" id="harga">
                </li>
                <li>
                    <label for="jenis">Stock:</label>
                    <input type="text" name="jenis" id="jenis">
                </li>
                <li>
                    <button type="submit" name="submit">Add Data</button>
                </li>
            </ul>
        </form>
    </body>
</html>