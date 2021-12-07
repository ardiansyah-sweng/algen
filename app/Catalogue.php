<?php

/**
 * Create product catalogue from database
 */
class Catalogue
{
    function getDBConnection()
    {
        $koneksiDB = new KoneksiDatabase;
        $koneksiDB->namaServer = 'localhost';
        $koneksiDB->namaDB = 'algen';
        $koneksiDB->namaUser = 'root';
        $koneksiDB->passwordInPlaintext = '';

        return $koneksiDB->konekKeDatabase();
    }

    function getAllProducts()
    {
        $sql = "SELECT kode, item, item_price, item_picture FROM produk";
        //$sql = "SELECT kode, item, item_price, item_picture FROM produk WHERE kode=100";

        $listOfProduct = $this->getDBConnection()->query($sql);
        $ret = [];
        if ($listOfProduct->num_rows){
            while ($row = $listOfProduct->fetch_assoc()) {
                $ret[] = $row;
            }
        }
        return $ret;
    }
}