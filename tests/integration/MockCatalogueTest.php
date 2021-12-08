<?php
require 'vendor/autoload.php';

use PHPUnit\Framework\TestCase;

class MockCatalogueTest extends TestCase
{
    function testGetDBConnection_isNotNull()
    {
        $mockProduct = $this->createMock(Catalogue::class);
        $connectionStatus = ['affected_rows' => 0];
        $mockProduct->method('getDBConnection')
                    ->willReturn($connectionStatus);
        $status = $mockProduct->getDBConnection();
        $this->assertNotNull($status);
    }

    function testGetDBConnection_isNull()
    {
        $mockProduct = $this->createMock(Catalogue::class);
        $connectionStatus = null;
        $mockProduct->method('getDBConnection')
                    ->willReturn($connectionStatus);
        $status = $mockProduct->getDBConnection();
        $this->assertNull($status);
    }

    function testMockCatalogueAreReturned_isEmpty()
    {
        $mockProduct = $this->createMock(Catalogue::class);
        $mockProducts = [];

        $mockProduct->method('getAllProducts')
        ->willReturn($mockProducts);
        $products = $mockProduct->getAllProducts();

        $this->assertIsArray($products);
        $this->assertEmpty($products);
    }

    function testMockCatalogueAreReturned()
    {
        $mockProduct = $this->createMock(Catalogue::class);
        $mockProducts = [
            ['kode' => 1, 'item'=>'Coca Cola', 'item_price'=>10500, 'item_picture'=>'coke.png'],
            ['kode' => 2, 'item' => 'Coklat Cookies Biskuit', 'item_price' => 8600, 'item_picture' => 'cookies.png'],
            ['kode' => 3, 'item' => 'Vionelli Minyak Goreng', 'item_price' => 27800, 'item_picture' => 'minyak.png']
        ];
        $mockProduct->method('getAllProducts')
                    ->willReturn($mockProducts);
        $products = $mockProduct->getAllProducts();
        
        $this->assertIsArray($products);
        $this->assertNotEmpty($products);

        $kromosom = new Chromosome($products);
        $kromosom->numOfGen = count($products);
        $result = $kromosom->createChromosome();
        $this->assertIsArray($result);
        $this->assertNotEmpty($result);
        $this->assertContainsEquals(0, $result);
        $this->assertContainsEquals(1, $result);
    }

    function test_createChromosome_usingFaker_products()
    {
        $mockProduct = $this->createMock(Catalogue::class);
        $faker = Faker\Factory::create('id_ID');
        $faker->addProvider(new \Bezhanov\Faker\Provider\Commerce($faker));

        for ($i = 0; $i < 10; $i++){
            $kode = $faker->numberBetween(1, 100);            
            $mockProducts[]  = [
                'kode'=> $kode,
                'nama_produk' => $faker->productName(),
                'harga' => $faker->numberBetween(8500, 150000)
            ];
        }
        
        $mockProduct->method('getAllProducts')
                    ->willReturn($mockProducts);
        $products = $mockProduct->getAllProducts();
        
        $this->assertIsArray($products);
        $this->assertNotEmpty($products);

        $kromosom = new Chromosome($products);
        $result = $kromosom->createChromosome();

        $this->assertIsArray($result);
        $this->assertNotEmpty($result);
        $this->assertContainsEquals(0, $result);
        $this->assertContainsEquals(1, $result);
    }
}
