<?php
class Produk {
    private $id_produk;
    private $nama_produk;
    private $stock_produk;
    private $harga_produk;

    // Constructor
    public function __construct($nama_produk, $stock_produk, $harga_produk) {
        $this->nama_produk = $nama_produk;
        $this->stock_produk = $stock_produk;
        $this->harga_produk = $harga_produk;
    }

    // Getter and Setter methods
    public function getId() {
        return $this->id_produk;
    }

    public function setId($id) {
        $this->id_produk = $id;
    }

    public function getNama() {
        return $this->nama_produk;
    }

    public function setNama($nama_produk) {
        $this->nama_produk = $nama_produk;
    }

    public function getStock() {
        return $this->stock_produk;
    }

    public function setStock($stock_produk) {
        $this->stock_produk = $stock_produk;
    }

    public function getHarga() {
        return $this->harga_produk;
    }

    public function setHarga($harga_produk) {
        $this->harga_produk = $harga_produk;
    }
}
?>