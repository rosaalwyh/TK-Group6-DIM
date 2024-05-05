<?php
// Kredensial koneksi database
$host = 'localhost'; // Ganti dengan nama host Anda jika berbeda
$dbname = 'produk'; // Nama database yang telah Anda buat
$username = 'root'; // Ganti dengan username database Anda
$password = ''; // Ganti dengan password database Anda

// Membuat koneksi ke database menggunakan PDO
try {
    $koneksi = new PDO("mysql:host=$host;dbname=$dbname", $username, $password);
    $koneksi->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
} catch(PDOException $e) {
    echo "Koneksi database gagal: " . $e->getMessage();
    die();
}

// Jika parameter id produk diberikan melalui URL
if(isset($_GET["id"]) && !empty(trim($_GET["id"]))){
    // Mendapatkan nilai parameter dari URL
    $id_produk = trim($_GET["id"]);
    
    // Query SQL untuk hapus produk
    $query = "DELETE FROM produk WHERE id_produk = :id_produk";
    
    try {
        // Prepare statement
        $statement = $koneksi->prepare($query);
        
        // Bind parameter
        $statement->bindParam(':id_produk', $id_produk);
        
        // Execute statement
        $statement->execute();

        // Redirect kembali ke halaman view_produk setelah berhasil menghapus produk
        header("Location: view_produk.php");
        exit();
    } catch(PDOException $e) {
        echo "Error: " . $e->getMessage();
    }
}
?>