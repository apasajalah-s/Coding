<?php
class Product
{
    // Koneksi database dan nama tabel
    private $conn;
    private $table_name = "products";
    // Properti objek produk
    public $id;
    public $name;
    public $price;
    public $description;
    public $created;
    // Constructor untuk menginisialisasi koneksi database
    public function __construct($db)
    {
        $this->conn = $db;
    }
    // Fungsi untuk membuat produk baru
    public function create()
    {
        // Query untuk insert data produk
        $query = "INSERT INTO " . $this->table_name . " SET name=:name, price=:price,
description=:description, created=:created";
        // Siapkan query
        $stmt = $this->conn->prepare($query);
        // Bersihkan input
        $this->name = htmlspecialchars(strip_tags($this->name));
        $this->price = htmlspecialchars(strip_tags($this->price));
        $this->description = htmlspecialchars(strip_tags($this->description));
        $this->created = htmlspecialchars(strip_tags($this->created));
        // Bind data
        $stmt->bindParam(":name", $this->name);
        $stmt->bindParam(":price", $this->price);
        $stmt->bindParam(":description", $this->description);
        $stmt->bindParam(":created", $this->created);
        // Eksekusi query, jika berhasil kembalikan true
        if ($stmt->execute()) {
            return true;
        }
        return false; // Jika gagal kembalikan false
    }
    // Fungsi untuk mendapatkan semua produk dengan pagination
    public function readWithPagination($from_record_num, $records_per_page)
    {
        // Query untuk memilih produk
        $query = "SELECT * FROM " . $this->table_name . " ORDER BY created DESC LIMIT ?, ?";
        // Siapkan query
        $stmt = $this->conn->prepare($query);
        // Bind nilai limit pagination
        $stmt->bindParam(1, $from_record_num, PDO::PARAM_INT);
        $stmt->bindParam(2, $records_per_page, PDO::PARAM_INT);
        // Eksekusi query
        $stmt->execute();
        return $stmt; // Kembalikan hasil
    }
    // Fungsi untuk menghitung semua produk (untuk pagination)
    public function countAll()
    {
        // Query menghitung semua baris produk
        $query = "SELECT COUNT(*) as total_rows FROM " . $this->table_name;
        // Siapkan query
        $stmt = $this->conn->prepare($query);
        // Eksekusi query
        $stmt->execute();
        $row = $stmt->fetch(PDO::FETCH_ASSOC);
        return $row['total_rows']; // Kembalikan jumlah total
    }
}
?>