<?php
//sertakan file koneksi dan kelas produkk
include_once 'Database.php';
include_once 'Product.php';

//inisialisasi koneksi ke database
$database = new Database();
$db = $database->getConnection();

//inisialisasi objek produk
$product = new Product($db);

//Ambil ID produk yang akan dihapus dari request
// Periksa apakah 'id' dikirim dalam request
if (isset($_POST['id'])) {
    // Ambil ID produk yang akan dihapus dari request
    $product->id = $_POST['id'];

    // Hapus produk dari database
    if ($product->delete()) {
        echo "Produk berhasil dihapus!";
    } else {
        echo "Gagal menghapus produk.";
    }
} else {
    echo "ID produk tidak ditemukan.";
}

?>