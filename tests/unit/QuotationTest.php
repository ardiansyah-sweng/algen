<?php
require 'vendor/autoload.php';
use PHPUnit\Framework\TestCase;

class QuotationTest extends TestCase
{
    public function testTaxesInformationDriveTheQuotationsTotalAndTypeFields()
    {
        $quotation = new Quotation();
        $quotation->addRow(1000);
        $quotation->specifyTaxes(new VatRate(10, 'VATCODE'), 20, 'VATCODE');

        
        $this->assertEquals(1100, $quotation->getTotal());
        $this->assertEquals('Type: VATCODE', $quotation->getTypeOfService());
    }
}