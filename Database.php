<?php
class Database
{
    // Variabel untuk menyimpan pengaturan database
    private $host = "localhost"; // Host database
    private $db_name = "crud_oop"; // Nama database
    private $username = "root"; // Username MySQL
    private $password = ""; // Password MySQL
    public $conn;
    // Fungsi untuk membuka koneksi ke database
    public function getConnection()
    {
        $this->conn = null;
        try {
            // Buat koneksi menggunakan PDO
            $this->conn = new PDO(
                "mysql:host=" . $this->host . ";dbname=" . $this->db_name,
                $this->username,
                $this->password
            );
            $this->conn->exec("set names utf8"); // Set encoding
        } catch (PDOException $exception) {
            echo "Connection error: " . $exception->getMessage(); // Tangkap error koneksi
        }
        return $this->conn; // Kembalikan koneksi
    }
}
