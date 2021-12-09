<?php
require 'vendor/autoload.php';

use PHPUnit\Framework\TestCase;

class MutationTest extends TestCase
{
    function test_mutation()
    {
        $mutation = new Mutation;
        $mutation->runMutation();
    }
}