<?php
require 'vendor/autoload.php';

class Main
{
    public $popSize;
    public $maxGen;
    public $maxBudget;
    public $crossoverRate;
    public $selectionType;
    public $stoppingValue;
    public $numOfLastResult;

    // function __construct(int $popSize, int $maxGen, float $maxBudget, float $crossoverRate)
    // {
    //     $this->popSize = $popSize;
    //     $this->maxGen = $maxGen;
    //     $this->maxBudget = $maxBudget;
    //     $this->crossoverRate = $crossoverRate;
    // }

    function runMain()
    {
        $population = new InitialPopulation;   
        $population->popSize = $this->popSize;
        
        $crossover = new Crossover;
        $crossover->popSize = $this->popSize;
        $crossover->crossoverRate = $this->crossoverRate;

        $populations = $population->generatePopulation(new Chromosome);

        $crossoverOffsprings = [];
        $filtereds = [];
        $mutation = new Mutation;
        $selection = new SelectionFactory;
        $catalogue = new Catalogue;
        $analytics = new Analytics;

        for ($i = 0; $i < $this->maxGen; $i++){
            $crossoverOffsprings = $crossover->runCrossover($populations);

            $mutation->popSize = $this->popSize;
            $mutatedChromosomes = $mutation->runMutation(new MutationCalculator, $populations);

            // Jika ada hasil mutasi, maka gabungkan chromosomes offspring dengan hasil chromosome mutasi
            if (count($mutatedChromosomes) > 0){
                foreach ($mutatedChromosomes as $mutatedChromosome){
                    $crossoverOffsprings[] = $mutatedChromosome;
                }
            }

            $this->selectionType = 'elitism';
            
            $lastPopulation = $populations;
            $populations = null;
            $populations = $selection->initializeSelectionFactory($this->selectionType, $lastPopulation, $crossoverOffsprings, $this->maxBudget);
            
            $crossoverOffsprings = [];

            $bestChromosomes = $populations[0]['chromosomes'];
            $amount = $populations[0]['amount'];
            $itemsName = $catalogue->getListOfItemName($bestChromosomes);
            $returnedChromosomes = [
                'amount' => $amount,
                'numOfItems' => array_sum($bestChromosomes),
                'items' => $itemsName
            ];

            //jika best chromosome langsung ditemukan
            if ( ($this->maxBudget - $populations[0]['amount']) <= $this->stoppingValue ) {
                return $returnedChromosomes;
            }

            $bests[] = $returnedChromosomes;
            $analytics->numOfLastResult = $this->numOfLastResult;
            $analitics[] = $returnedChromosomes['amount'];

            //jika N hasil terakhir tidak berubah/sama
            if ($analytics->evaluation($i, $analitics)) {
                break;
            }

            foreach ($populations as $population){
                $filtereds[] = $population['chromosomes'];
            }
            $populations = $filtereds;
            $filtereds = [];
        }
        rsort($bests);
        return $bests[0];
    }
}

//$main = new Main(10, 100, 155000, 0.8);
//$main->runMain();