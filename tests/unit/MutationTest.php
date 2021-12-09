<?php
require 'vendor/autoload.php';

use PHPUnit\Framework\TestCase;

class MutationTest extends TestCase
{
    function test_calculateMutationRate_CatalogueIsExist()
    {
        $chromosome = new Chromosome;
        $chromosomes = $chromosome->createChromosome(new Catalogue);

        $calculator = new MutationCalculator;

        $this->assertIsFloat($calculator->calculateMutationRate($chromosomes));
    }

    function test_calculateMutationRate_CatalogueIsNotExist()
    {
        $mockProduct = $this->createMock(Catalogue::class);
        $faker = Faker\Factory::create('id_ID');
        $faker->addProvider(new \Bezhanov\Faker\Provider\Commerce($faker));

        for ($i = 0; $i < 100; $i++){
            $kode = $faker->numberBetween(1, 1000);            
            $mockProducts[]  = [
                'kode'=> $kode,
                'nama_produk' => $faker->productName(),
                'harga' => $faker->numberBetween(8500, 150000)
            ];
        }
        
        $mockProduct->method('getAllProducts')
                    ->willReturn($mockProducts);
        $catalogues = $mockProduct->getAllProducts();

        $kromosom = new Chromosome($catalogues);
        $chromosomes = $kromosom->createChromosome($mockProduct);

        $calculator = new MutationCalculator;
        //echo $calculator->calculateMutationRate($chromosomes);die;
        $this->assertIsFloat($calculator->calculateMutationRate($chromosomes));
    }

    function test_calculateNumOfMutation_catalogueIsExist()
    {
        $chromosome = new Chromosome;
        $chromosomes = $chromosome->createChromosome(new Catalogue);

        $calculator = new MutationCalculator;
        //echo $calculator->calculateNumOfMutation($chromosomes, 30);die;

        $this->assertIsInt($calculator->calculateNumOfMutation($chromosomes, 10));
    }

    function test_calculateNumOfMutation_catalogueIsNotExist()
    {
        $mockProduct = $this->createMock(Catalogue::class);
        $faker = Faker\Factory::create('id_ID');
        $faker->addProvider(new \Bezhanov\Faker\Provider\Commerce($faker));

        for ($i = 0; $i < 25; $i++){
            $kode = $faker->numberBetween(1, 1000);            
            $mockProducts[]  = [
                'kode'=> $kode,
                'nama_produk' => $faker->productName(),
                'harga' => $faker->numberBetween(8500, 150000)
            ];
        }
        
        $mockProduct->method('getAllProducts')
                    ->willReturn($mockProducts);
        $catalogues = $mockProduct->getAllProducts();

        $kromosom = new Chromosome($catalogues);
        $chromosomes = $kromosom->createChromosome($mockProduct);

        $calculator = new MutationCalculator;
        $numOfMutation = $calculator->calculateNumOfMutation($chromosomes, 30);
        //echo $numOfMutation;die;

        $this->assertIsInt($numOfMutation);
    }

    function test_isContains_greaterThanZero()
    {
        $calculator = new MutationCalculator;
        $result = $calculator->isContains(2);
        $this->assertTrue($result);
    }

    function test_isContains_zero()
    {
        $calculator = new MutationCalculator;
        $result = $calculator->isContains(0);
        $this->assertNull($result);
    }

    function test_changeGen_toZero()
    {
        $mutation = new MutationCalculator;
        $result = $mutation->changeGen(1);
        $this->assertEquals(0, $result);
    }

    function test_changeGen_toOne()
    {
        $mutation = new MutationCalculator;
        $result = $mutation->changeGen(0);
        $this->assertEquals(1, $result);
    }

    function test_mutation_catalogueDatabase_isAvailable_numOfMutation_greaterThanZero()
    {
        $mutation = new Mutation;
        $mutation->popSize = 30;
        $population = new InitialPopulation;   
        $population->popSize = $mutation->popSize;
        $generatedPopulation = $population->generatePopulation(new Chromosome);

        //print_r($mutation->runMutation(new MutationCalculator, $generatedPopulation)); die;

        $this->assertIsArray($mutation->runMutation(new MutationCalculator, $generatedPopulation));
    }

    function test_mutation_catalogueDatabase_isAvailable_numOfMutation_isZero()
    {
        $mutation = new Mutation;
        $mutation->popSize = 0;
        $population = new InitialPopulation;   
        $population->popSize = $mutation->popSize;
        $generatedPopulation = $population->generatePopulation(new Chromosome);

        $result = $mutation->runMutation(new MutationCalculator, $generatedPopulation);

        //print_r($mutation->runMutation(new MutationCalculator, $generatedPopulation)); die;

        $this->assertIsArray($result);
        $this->assertEmpty($result);
    }
}