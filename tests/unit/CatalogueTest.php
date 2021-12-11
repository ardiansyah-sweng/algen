<?php
require 'vendor/autoload.php';

use PHPUnit\Framework\TestCase;

class CatalogueTest extends TestCase
{
    function testDBConnection_isSuccess()
    {
        $dbConnection = new Catalogue;
        $this->assertIsObject($dbConnection->getDBConnection());
        $this->assertNotNull($dbConnection->getDBConnection());
    }

    function testGetAllProducts()
    {
        $allProducts = new Catalogue;
        print_r($allProducts->getAllProducts());die;
        if ($allProducts->getAllProducts()){
            $this->assertNotEmpty($allProducts->getAllProducts());
        } else {
            $this->assertEmpty($allProducts->getAllProducts());
        }
    }

    function test_createFakeCatalogue()
    {
        $allProducts = new Catalogue;
        $result = $allProducts->createFakeCatalogue();
        //print_r($result);

        $this->assertTrue($result);
    }
}