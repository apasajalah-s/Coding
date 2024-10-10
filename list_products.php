<?php
// Sertakan file koneksi dan kelas produk
include_once 'Database.php';
include_once 'Product.php';
// Inisialisasi koneksi ke database
$database = new Database();
$db = $database->getConnection();
// Inisialisasi objek produk
$product = new Product($db);
// Tentukan jumlah produk per halaman
$products_per_page = 5;
// Ambil halaman saat ini dari query string, jika tidak ada set ke 1
$page = isset($_GET['page']) ? $_GET['page'] : 1;
$start = ($page - 1) * $products_per_page; // Tentukan batas mulai produk
// Dapatkan produk dengan pagination
$stmt = $product->readWithPagination($start, $products_per_page);
$num = $stmt->rowCount();
// Tampilkan produk
if ($num > 0) {
    while ($row = $stmt->fetch(PDO::FETCH_ASSOC)) {
        extract($row);
        echo "<div>";
        echo "<h3>{$name}</h3>";
        echo "<p>{$description}</p>";
        echo "<p>Price: \${$price}</p>";
        echo "</div>";
    }
}
// Hitung total halaman
$total_rows = $product->countAll();
$total_pages = ceil($total_rows / $products_per_page);
// Tampilkan pagination
echo "<div>";
for ($i = 1; $i <= $total_pages; $i++) {
    echo "<a href='list_products.php?page={$i}'>{$i}</a> ";
}
echo "</div>";
?>