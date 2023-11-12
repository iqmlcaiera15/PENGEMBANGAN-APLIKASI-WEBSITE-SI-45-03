
<DOCTYPE html>
    <html lang="en">
        <head>
            <title>Edit Product List</title>
        </head>
        <body>
            <h1>Edit Product List</h1>
            <form action="" method="post">
            <input type="hidden" name="no" value="<?= $prd["no"];?>">
                <ul>
                    <li>
                        <label for="picture">Picture: </label>
                        <input type="text" name="picture" id="picture" required
                        value="<?= $prd["picture"];?>">
                    </li>
                    <li>
                        <label for="petid">Pet ID: </label>
                        <input type="text" name="petid" id="petid" required
                        value="<?= $prd["petid"];?>">
                    </li>
                    <li>
                        <label for="petname">Pet Name: </label>
                        <input type="text" name="petname" id="petname" required
                        value="<?= $prd["petname"];?>">
                    </li>
                    <li>
                        <label for="harga">harga: </label>
                        <input type="text" name="harga" id="harga" required
                        value="<?= $prd["harga"];?>">
                    </li>
                    <li>
                        <label for="jenis">Jenis: </label>
                        <input type="text" name="jenis" id="jenis" required
                        value="<?= $prd["jenis"];?>">
                    </li>
                    <li>
                        <button type="submit" name="submit">Edit Data</button>
                    </li>
                </ul>
            </form>
        </body>
    </html>



    <?php
require 'functions.php';
$no = $_GET["no"];
$prd = query("SELECT * FROM productlist WHERE no =$no")[0];

if (isset($_POST["submit"])){
    if (edit($_POST)> 0){
        echo "
            <script>
            alert('Data berhasil diubah!');
            document.location.href = 'index.php';
            </script>
        ";
    } else {
        echo "
        <script>
        alert('Data gagal diubah!');
        document.location.href = 'index.php';
        </script>
        ";
    }
}

?>