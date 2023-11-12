<?php

require 'functions.php';

$prd = query("SELECT * FROM productlist");
?>

<!DOCTYPE html>
<html lang="en">
    <head>
        <title>IQML Petshop Admin Page</title>
    </head>
    <body>
        <h1>Pet List</h1>

        <a href="add.php">Add New Pet to List</a>
        <br><br>

        <table border="1" cellpadding="10" cellspacing="0">
            <tr>
                <th>No. </th>
                <th>Action</th>
                <th>Picture</th>
                <th>Product ID</th>
                <th>Product Name</th>
                <th>harga</th>
                <th>Stock</th>
            </tr>
            <?php $i=1; ?>
            <?php foreach ($prd as $row) : ?>
            <tr>
                <td><?= $i?></td>
                <td>
                    <a href="edit.php?no=<?= $row["no"]; ?>">Edit</a>
                    <a href="delete.php?no= <?= $row["no"];?>" onclick="return confirm('ingin menghapus data tersebut?');">Delete</a>
                </td>
                <td><img src="img/<?= $row["picture"]; ?>" width="50"></td>
                <td><?= $row["petid"]; ?></td>
                <td><?= $row["petname"]; ?></td>
                <td><?= $row["harga"]; ?></td>
                <td><?= $row["jenis"]; ?></td>
            </tr>
            <?php $i++; ?>
            <?php endforeach; ?>
        </table>
    </body>
</html>