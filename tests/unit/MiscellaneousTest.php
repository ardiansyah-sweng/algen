<?php
require 'vendor/autoload.php';

use PHPUnit\Framework\TestCase;

class MiscellaneousTest extends TestCase
{
    function test_getCutPointIndex()
    {
        $pointIndex = Miscellaneous::getCutPointIndex();
        echo $pointIndex;
    }
}