<?php
require 'vendor/autoload.php';

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

    function createFakeCatalogue()
    {
        $faker = Faker\Factory::create('id_ID');
        $faker->addProvider(new \Bezhanov\Faker\Provider\Commerce($faker));

        // echo $image = $faker->imageUrl(100, 100, 'cats');
        // echo  "URL - " . $image . "<br/>";
        // echo " -- Image -- <br/>";
        // echo "<img src='" . $image . "'/>";
        // echo "<br/>";

        if (count($this->getAllProducts()) > 0){
            $this->emptyCatalogueTable();
        }
        for ($i = 0; $i < 50; $i++) {
            $item = $faker->productName();
            $price =  $faker->numberBetween(8500, 135000);
            $image = $faker->imageUrl(100, 100, 'business');

            //insert into table
            $sql = "INSERT INTO produk (item, item_price, item_picture) VALUES ('$item', '$price', '$image')";
            $this->getDBConnection()->query($sql);
        }
        if (count($this->getAllProducts()) > 0) {
            return true;
        }
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
        // $this->getDBConnection()->close();
        return $ret;
    }

    function emptyCatalogueTable()
    {
        $sql = "TRUNCATE table produk";
        $this->getDBConnection()->query($sql);
    }

    function getListOfItemName(array $chromosomes): array
    {
        $products = $this->getAllProducts();
        $itemsName = [];
        if (count(array_unique($chromosomes)) > 1) {
            foreach ($chromosomes as $key => $gen) {
                if ($gen === 1) {
                    $itemsName[] = [$products[$key]['item'], $products[$key]['item_price']];
                }
            }
        }
        return $itemsName;
    }
}