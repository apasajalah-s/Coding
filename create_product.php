<?php
// Sertakan file koneksi dan kelas produk
include_once 'Database.php';
include_once 'Product.php';
// Inisialisasi koneksi ke database
$database = new Database();
$db = $database->getConnection();
// Inisialisasi objek produk
$product = new Product($db);
// Set properti produk yang akan ditambahkan
$product->NIK = $_POST['nik'];
$product->name = $_POST['name'];
$product->price = $_POST['price'];
$product->description = $_POST['description'];
$product->created = date('Y-m-d H:i:s'); // Set waktu pembuatan produk
// Tambahkan produk ke database
if ($product->create()) {
    echo "Produk berhasil ditambahkan!"; // Tampilkan pesan sukses
} else {
    echo "Gagal menambahkan produk."; // Tampilkan pesan gagal
}
