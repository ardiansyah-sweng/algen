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

    function runMain()
    {
        $catalogue = new Catalogue;
        $chromosome = new Chromosome($catalogue->getAllProducts());
        $population = new InitialPopulation; 
        
        $chromosomes = $chromosome->createChromosome($catalogue->getAllProducts());
        $populations = $population->generatePopulation($this->popSize, $chromosomes);

        $crossoverOffsprings = [];
        $filtereds = [];

        $selection = new SelectionFactory;
        $analytics = new Analytics;

        for ($i = 0; $i < $this->maxGen; $i++){
            $crossover = new Crossover($this->popSize, $this->crossoverRate, $populations, $catalogue->getAllProducts());
            $crossoverOffsprings = $crossover->runCrossover($populations);

            $mutation = new Mutation($populations, $this->popSize);
            $mutation->catalogue = $catalogue->getAllProducts();
            $mutatedChromosomes = $mutation->runMutation($populations, $this->popSize, $catalogue->getAllProducts());

            // Jika ada hasil mutasi, maka gabungkan chromosomes offspring dengan hasil chromosome mutasi
            if (count($mutatedChromosomes) > 0){
                foreach ($mutatedChromosomes as $mutatedChromosome){
                    $crossoverOffsprings[] = $mutatedChromosome;
                }
            }
            $this->selectionType = 'elitism';

            $lastPopulation = $populations;
            $populations = null;
           
            $populations = $selection->initializeSelectionFactory($this->selectionType, $lastPopulation, $crossoverOffsprings, $this->maxBudget, $catalogue->getAllProducts(), $this->popSize);
            
            return ($populations);

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