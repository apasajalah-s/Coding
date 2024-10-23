<?php
//sertakan file koneksi dan kelas produk
include_once 'Database.php';
include_once 'Product.php';

//inisialisasi koneksi ke database
$database = new Database();
$db = $database->getConnection();

//inisialisasi objek produk
$product = new Product($db);

//set properti berdasarkan data yang diterima
$product->NIK = $_POST['NIK'];
$product->id = $_POST['id'];
$product->name = $_POST['name'];
$product->price = $_POST['price'];
$product->description = $_POST['description'];

//Update produk di database
if ($product->update()){
    echo "Produk berhasil diupdate!";
}else{
    echo "gagal megupdate produk";
}
?>