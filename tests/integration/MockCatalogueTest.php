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
}
