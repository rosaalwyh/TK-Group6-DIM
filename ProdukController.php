<?php
require_once 'Produk.php'; // Import class Produk

class ProdukController {
    private static $koneksi; // Variabel untuk menyimpan koneksi database

    // Method untuk mengatur koneksi ke database
    public static function setKoneksi($koneksi) {
        self::$koneksi = $koneksi;
    }

    // Method untuk membuat produk baru
    public static function create(Produk $produk) {
        $query = "INSERT INTO produk (nama_produk, stock_produk, harga_produk) VALUES (:nama, :stock, :harga)";
        $statement = self::$koneksi->prepare($query);
        $statement->bindParam(':nama', $produk->getNama());
        $statement->bindParam(':stock', $produk->getStock());
        $statement->bindParam(':harga', $produk->getHarga());
        $statement->execute();
    }

    // Method untuk membaca detail produk berdasarkan ID
    public static function read($id_produk) {
        $query = "SELECT * FROM produk WHERE id_produk = :id";
        $statement = self::$koneksi->prepare($query);
        $statement->bindParam(':id', $id_produk);
        $statement->execute();
        $result = $statement->fetch(PDO::FETCH_ASSOC);

        if ($result) {
            return new Produk($result['nama_produk'], $result['stock_produk'], $result['harga_produk']);
        } else {
            return null;
        }
    }

    // Method untuk mengupdate produk
    public static function update(Produk $produk) {
        $query = "UPDATE produk SET nama_produk = :nama, stock_produk = :stock, harga_produk = :harga WHERE id_produk = :id";
        $statement = self::$koneksi->prepare($query);
        $statement->bindParam(':nama', $produk->getNama());
        $statement->bindParam(':stock', $produk->getStock());
        $statement->bindParam(':harga', $produk->getHarga());
        $statement->bindParam(':id', $produk->getId());
        $statement->execute();
    }

    // Method untuk menghapus produk berdasarkan ID
    public static function delete($id_produk) {
        $query = "DELETE FROM produk WHERE id_produk = :id";
        $statement = self::$koneksi->prepare($query);
        $statement->bindParam(':id', $id_produk);
        $statement->execute();
    }

    // Method untuk mengambil semua produk dari database
    public static function getAllProduk() {
        $query = "SELECT * FROM produk";
        $statement = self::$koneksi->prepare($query);
        $statement->execute();
        $result = $statement->fetchAll(PDO::FETCH_ASSOC);

        $produk_list = [];
        foreach ($result as $row) {
            $produk_list[] = new Produk($row['nama_produk'], $row['stock_produk'], $row['harga_produk']);
        }
        return $produk_list;
    }
}
?>
