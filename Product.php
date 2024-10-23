<?php
class Product
{
    // Koneksi database dan nama tabel
    private $conn;
    private $table_name = "products";

    // Properti objek produk
    public $id;
    public $NIK;
    public $name;
    public $price;
    public $description;
    public $created;

    // Constructor untuk menginisialisasi koneksi database
    public function __construct($db)
    {
        $this->conn = $db;
    }

    //Fungsi untuk mengupdate produk
    public function update()
    {
        //query untuk update data produk
        $query = "UPDATE " . $this->table_name . " SET NIK = :NIK, name = :name, price = :price, description = :description WHERE id = :id";
        //Siapkan query
        $stmt = $this->conn->prepare($query);

        // Bersihkan input
        $this->NIK = htmlspecialchars(strip_tags($this->NIK));
        $this->name = htmlspecialchars(strip_tags($this->name));
        $this->price = htmlspecialchars(strip_tags($this->price));
        $this->description = htmlspecialchars(strip_tags($this->description));
        $this->id = htmlspecialchars(strip_tags($this->id));

        // Bind data
        $stmt->bindParam(":NIK", $this->NIK);
        $stmt->bindParam(":name", $this->name);
        $stmt->bindParam(":price", $this->price);
        $stmt->bindParam(":description", $this->description);
        $stmt->bindParam(":id", $this->id);

        // Eksekusi query
        if ($stmt->execute()) {
            return true;
        }
        return false;
    }

    // Fungsi untuk membuat produk baru
    public function create()
    {
        // Query untuk insert data produk
        $query = "INSERT INTO " . $this->table_name . " SET NIK=:NIK, name=:name, price=:price, description=:description, created=:created";

        // Siapkan query
        $stmt = $this->conn->prepare($query);

        // Bersihkan input
        $this->NIK = htmlspecialchars(strip_tags($this->NIK));
        $this->name = htmlspecialchars(strip_tags($this->name));
        $this->price = htmlspecialchars(strip_tags($this->price));
        $this->description = htmlspecialchars(strip_tags($this->description));

        // Bind data
        $stmt->bindParam(":NIK", $this->NIK);
        $stmt->bindParam(":name", $this->name);
        $stmt->bindParam(":price", $this->price);
        $stmt->bindParam(":description", $this->description);
        $stmt->bindParam(":created", $this->created); // Pastikan nilai 'created' juga di-bind

        // Eksekusi query, jika berhasil kembalikan true
        if ($stmt->execute()) {
            return true;
        }
        return false;
    }


    //Fungsi untuk menghapus produk
    public function delete()
    {
        //Query untuk menghapus produk berdasarkan ID
        $query = "DELETE FROM " . $this->table_name . " WHERE id = :id";

        //Siapkan query
        $stmt = $this->conn->prepare($query);

        //Bersihkan input
        $this->id = htmlspecialchars(strip_tags($this->id));

        //Bind data
        $stmt->bindParam(':id', $this->id);

        //Eksekusi query
        if ($stmt->execute()) {
            return true;
        }
        return false;
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
