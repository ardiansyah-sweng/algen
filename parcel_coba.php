<?php
$start = microtime(true);

class Parameters
{
    const FILE_NAME = 'parcel_coba.txt';
    const COLUMNS = ['item', 'price'];
    const BUDGET = 250000;
    const STOPPING_VALUE = 100;
    const CROSOVER_RATE = 0.8;
    const MAX_ITER = 250;
}

class Catalogue
{
    function createProductColumn($listOfRawProduct)
    {
        foreach (array_keys($listOfRawProduct) as $listOfRawProductKey) {
            $listOfRawProduct[Parameters::COLUMNS[$listOfRawProductKey]] = $listOfRawProduct[$listOfRawProductKey];
            unset($listOfRawProduct[$listOfRawProductKey]);
        }
        return $listOfRawProduct;
    }

    function product()
    {
        $raw_data = file(Parameters::FILE_NAME);
        foreach ($raw_data as $listOfRawProduct) {
            $collectionOfListProduct[] = $this->createProductColumn(explode(",", $listOfRawProduct));
        }
        return $collectionOfListProduct;
    }
}

class Individu
{
    function countNumberOfGen()
    {
        return count((new Catalogue())->product());
    }

    function createRandomIndividu()
    {
        for ($i = 0; $i <= $this->countNumberOfGen() - 1; $i++) {
            $ret[] = rand(0, 1);
        }
        return $ret;
    }
}

class Population
{
    function createRandomPopulation($popSize)
    {
        for ($i = 0; $i < $popSize; $i++) {
            $ret[] = (new Individu())->createRandomIndividu();
        }
        return $ret;
    }
}

class Fitness
{
    function selectingItem($individu)
    {
        foreach ($individu as $individuKey => $binaryGen) {
            if ($binaryGen === 1) {
                $ret[] = [
                    'selectedKey' => $individuKey,
                    'selectedPrice' => (new Catalogue())->product()[$individuKey]['price']
                ];
            }
        }
        return $ret;
    }

    function calculateFitnessValue($individu)
    {
        return array_sum(array_column($this->selectingItem($individu), 'selectedPrice'));
    }

    function countSelectedItem($individu)
    {
        return count($this->selectingItem($individu));
    }

    function searchBestIndividu($fits, $maxItem, $numberOfIndividuHasMaxItem)
    {
        if ($numberOfIndividuHasMaxItem === 1) {
            return $fits[array_search($maxItem, array_column($fits, 'numberOfSelectedItem'))];
        } else {
            foreach ($fits as $key => $val) {
                if ($val['numberOfSelectedItem'] === $maxItem) {
                    $ret[] = [
                        'individuKey' => $key,
                        'fitnessValue' => $val['fitnessValue'],
                        'chromosome' => $fits[$key]['chromosome']
                    ];
                }
            }
            if (count(array_unique(array_column($ret, 'fitnessValue'))) === 1) {
                $index = rand(0, count($ret) - 1);
            } else {
                $index = array_search(max(array_column($ret, 'fitnessValue')), array_column($ret, 'fitnessValue'));
            }
            return $ret[$index];
        }
    }

    function bestIndividus($fits)
    {
        $countedMaxItems = array_count_values(array_column($fits, 'numberOfSelectedItem'));
        $maxItem = max(array_keys($countedMaxItems));
        $numberOfIndividuHasMaxItem = $countedMaxItems[$maxItem];
        $bestFitnessValue = $this->searchBestIndividu($fits, $maxItem, $numberOfIndividuHasMaxItem);
        return $bestFitnessValue;
    }

    function isFit($fitnessValue)
    {
        if ($fitnessValue <= Parameters::BUDGET) {
            return TRUE;
        }
    }

    function fitnessEvaluation($population)
    {
        foreach ($population as $listOfIndividuKey => $listOfIndividu) {
            $fitnessValue = $this->calculateFitnessValue($listOfIndividu);
            $numberOfSelectedItem = $this->countSelectedItem($listOfIndividu);
            if ($this->isFit($fitnessValue)) {
                $fits[] = [
                    'individuKey' => $listOfIndividuKey,
                    'numberOfSelectedItem' => $numberOfSelectedItem,
                    'fitnessValue' => $fitnessValue,
                    'chromosome' => $population[$listOfIndividuKey]
                ];
            }
        }
        return $fits;
    }
}

class Randomizer
{
    static function getRandomIndexOfGen()
    {
        return rand(0, (new Individu())->countNumberOfGen() - 1);
    }

    function getRandomIndexOfIndividu($popSize)
    {
        return rand( 0, ($popSize - 1));
    }
}

class Crossover
{
    public $populations;

    function __construct($populations, $popSize)
    {
        $this->populations = $populations;
        $this->popSize = $popSize;
    }

    function randomZeroToOne()
    {
        return (float) rand() / (float) getrandmax();
    }

    function randomizingParents()
    {
        for ($i = 0; $i < $this->popSize; $i++) {
            $randomZeroToOne = $this->randomZeroToOne();
            if ($randomZeroToOne < Parameters::CROSOVER_RATE) {
                $parents[$i] = $randomZeroToOne;
            }
        }
        return $parents;
    }

    function generateCrossover()
    {
        $parents = $this->randomizingParents();
        foreach (array_keys($parents) as $key) {
            foreach (array_keys($parents) as $subkey) {
                if ($key !== $subkey) {
                    $ret[] = [$key, $subkey];
                }
            }
            array_shift($parents);
        }
        return $ret;
    }

    ## TODO refaktor karena agak duplikat code
    function offspring($parent1, $parent2, $cutPointIndex, $offspring)
    {
        if ($offspring === 1) {
            for ($i = 0; $i <= (new Individu())->countNumberOfGen() - 1; $i++) {
                if ($i <= $cutPointIndex) {
                    $ret[] = $parent1[$i];
                }
                if ($i > $cutPointIndex) {
                    $ret[] = $parent2[$i];
                }
            }
        }

        if ($offspring === 2) {
            for ($i = 0; $i <= (new Individu())->countNumberOfGen() - 1; $i++) {
                if ($i <= $cutPointIndex) {
                    $ret[] = $parent2[$i];
                }
                if ($i > $cutPointIndex) {
                    $ret[] = $parent1[$i];
                }
            }
        }
        return $ret;
    }

    function cutPointRandom()
    {
        return rand(0, (new Individu())->countNumberOfGen() - 1);
    }

    function crossover()
    {
        $cutPointIndex = $this->cutPointRandom();
        foreach ($this->generateCrossover() as $listOfCrossover) {
            $parent1 = $this->populations[$listOfCrossover[0]];
            $parent2 = $this->populations[$listOfCrossover[1]];
            $offspring1 = $this->offspring($parent1, $parent2, $cutPointIndex, 1);
            $offspring2 = $this->offspring($parent1, $parent2, $cutPointIndex, 2);
            $offsprings[] = $offspring1;
            $offsprings[] = $offspring2;
        }
        return $offsprings;
    }
}

class Mutation
{
    function __construct($population, $popSize)
    {
        $this->population = $population;
        $this->popSize = $popSize;
    }

    function calculateMutationRate()
    {
        return 1 / (new Individu())->countNumberOfGen();
    }

    function calculateNumOfMutation()
    {
        return round($this->calculateMutationRate() * $this->popSize);
    }

    function generateMutation($valueOfGen)
    {
        if ($valueOfGen === 0) {
            return 1;
        } else {
            return 0;
        }
    }

    function isMutationExist()
    {
        if ($this->calculateNumOfMutation() > 0) {
            return TRUE;
        }
    }

    function mutation()
    {
        if ($this->isMutationExist()) {
            for ($i = 0; $i <= $this->calculateNumOfMutation() - 1; $i++) {
                $indexOfIndividu = (new Randomizer())->getRandomIndexOfIndividu($this->popSize);
                $indexOfGen = Randomizer::getRandomIndexOfGen();
                $selectedIndividu = $this->population[$indexOfIndividu];
                $valueOfGen = $selectedIndividu[$indexOfGen];
                $mutatedGen = $this->generateMutation($valueOfGen);
                $selectedIndividu[$indexOfGen] = $mutatedGen;
                $ret[] = $selectedIndividu;
            }
            return $ret;
        }
    }
}

class Selection
{
    function __construct($population, $combinedOffsprings, $popSize)
    {
        $this->population = $population;
        $this->combinedOffsprings = $combinedOffsprings;
        $this->popSize = $popSize;
    }

    function createTemporaryPopulation()
    {
        foreach ($this->combinedOffsprings as $offspring) {
            $this->population[] = $offspring;
        }
        return $this->population;
    }

    function getVariableValue($basePopulation, $fitTemporaryPopulation)
    {
        foreach ($fitTemporaryPopulation as $val) {
            $ret[] = $basePopulation[$val[1]];
        }
        return $ret;
    }

    function sortFitTemporaryPopulation()
    {
        $tempPopulation = $this->createTemporaryPopulation();
        $fitness = new Fitness;
        foreach ($tempPopulation as $key => $individu) {
            $fitnessValue = $fitness->calculateFitnessValue($individu);
            if ($fitness->isFit($fitnessValue)) {
                $fitTemporaryPopulation[] = [
                    $fitnessValue,
                    $key
                ];
            }
        }
        rsort($fitTemporaryPopulation);
        $fitTemporaryPopulation = array_slice($fitTemporaryPopulation, 0, $this->popSize);

        return $this->getVariableValue($tempPopulation, $fitTemporaryPopulation);
    }

    function selectingInvididus()
    {
        return $this->sortFitTemporaryPopulation();
    }
}

class Algen
{
    public $maxIter;

    function __construct($popSize, $maxIter)
    {
        $this->popSize = $popSize;
        $this->maxIter = $maxIter;
    }

    function isFound($bestIndividus)
    {
        $residual = Parameters::BUDGET - $bestIndividus['fitnessValue'];
        if ($residual <= Parameters::STOPPING_VALUE && $residual > 0) {
            return TRUE;
        }
    }

    function countItems($chromosome)
    {
        return array_count_values($chromosome)[1];
    }

    function analytics($iter, $analitics)
    {
        $numOfLastResults = 10;
        if ($iter >= ($numOfLastResults - 1)) {
            $residual = count($analitics) - $numOfLastResults;
            
            if ($residual === 0 && count(array_unique($analitics)) === 1) {
                return true;
            }

            if ($residual > 0) {
                for ($i = 0; $i < $residual; $i++) {
                    array_shift($analitics);
                }
                if (count(array_unique($analitics)) === 1) {
                    return true;
                }
            }
        }
    }

    function algen()
    {
        $fitness = new Fitness;
        $population = (new Population($this))->createRandomPopulation($this->popSize);
        $fitIndividus = $fitness->fitnessEvaluation($population);
        $bestIndividus = $fitness->bestIndividus($fitIndividus);
        $bestIndividuIsFound = $this->isFound($bestIndividus);

        $iter = 0;
        while ($iter < $this->maxIter || $bestIndividuIsFound === FALSE) {

            $crossoverOffsprings = (new Crossover($population, $this->popSize))->crossover();
            $mutation = new Mutation($population, $this->popSize);

            if ($mutation->mutation($this->popSize)) {
                $mutationOffsprings = $mutation->mutation($this->popSize);
                foreach ($mutationOffsprings as $mutationOffspring) {
                    $crossoverOffsprings[] = $mutationOffspring;
                }
            }
            $selection = new Selection($population, $crossoverOffsprings, $this->popSize);
            $population = [];
            $population = $selection->selectingInvididus();
            $fitIndividus = [];
            $fitIndividus = $fitness->fitnessEvaluation($crossoverOffsprings);
            $bestIndividus = $fitness->bestIndividus($fitIndividus);

            $bestIndividuIsFound = $this->isFound($bestIndividus);

            if ($bestIndividuIsFound) {
                $bestIndividus['numOfItems'] = $this->countItems($bestIndividus['chromosome']);
                return $bestIndividus;
            }
            $bests[] = $bestIndividus;
            $analitics[] = $bestIndividus['fitnessValue'];
            if ($this->analytics($iter, $analitics)) {
                break;
            }
            $iter++;
        }

        foreach ($bests as $key => $best) {
            $bests[$key]['numOfItems'] =  $this->countItems($best['chromosome']);
        }

        $maxItems = max(array_column($bests, 'numOfItems'));
        $index = array_search($maxItems, array_column($bests, 'numOfItems'));
        return $bests[$index];
    }
}

function saveToFile($maxIter, $fitnessValue, $numOfItems)
{
    $pathToFile = 'parcel.txt';
    $data = array($maxIter, $fitnessValue, $numOfItems);
    $fp = fopen($pathToFile, 'a');
    fputcsv($fp, $data);
    fclose($fp);
}

for ($popSize = 5; $popSize <= 100; $popSize+=5){
    for ($i = 0; $i < 30; $i++){
        echo 'PopSize: ' . $popSize;
        $algenKnapsack = (new Algen($popSize, 250))->algen();
        echo ' Fitness: '.$algenKnapsack['fitnessValue'] . ' Items: ' . $algenKnapsack['numOfItems'];
        echo "\n";
        saveToFile($popSize, $algenKnapsack['fitnessValue'], $algenKnapsack['numOfItems']);
    }
}

// $popSize = 60;
//     for ($maxIter = 5; $maxIter < 250; $maxIter+=10){
//         echo 'MaxIter: '. $maxIter;
//         for($i=0; $i < 30; $i++){
//             $algenKnapsack = (new Algen($popSize, $maxIter))->algen();
//             echo ' Fitness: '.$algenKnapsack['fitnessValue'] . ' Items: ' . $algenKnapsack['numOfItems'];
//             echo "\n";
//             saveToFile($maxIter, $algenKnapsack['fitnessValue'], $algenKnapsack['numOfItems']);
//         }
//     }

$end = microtime(true);

echo 'Time: '. ($end - $start);