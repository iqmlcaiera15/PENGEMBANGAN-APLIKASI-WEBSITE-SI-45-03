<?php
require 'functions.php';
$no = $_GET["no"];

if (del($no) > 0) {
    echo "
    <script>
        alert('Data yang ingin dihapus berhasil dihapus!');
        document.location.href = 'index.php';
    </script>
    ";
} else {
    echo "
    <script>
        alert('Data gagal dihapus!');
        document.location.href = 'index.php';
        </script>
    ";
}

?>