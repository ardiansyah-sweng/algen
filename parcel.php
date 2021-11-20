<?php

class Parameters
{
    public $file_name;
    public $indexes;
    public $columns;
    public $population_size;
    public $fitness;
    public $max_generation;
    public $knapsack;
    public $crossover_rate;

    public function __construct($parameters)
    {
        $this->file_name = $parameters['file_name'];
        $this->indexes = $parameters['indexes'];
        $this->columns = $parameters['columns'];
        $this->population_size = $parameters['population_size'];
        $this->fitness = $parameters['fitness'];
        $this->max_generation = $parameters['max_generation'];
        $this->knapsack = $parameters['knapsack'];
        $this->crossover_rate = $parameters['crossover_rate'];
    }
}

class Products
{
    public static function catalogue($parameters)
    {
        ## Todo change into open closed principles/polymorphism
        if (!is_array($parameters->indexes)) {
            return new Exception("Indexes parameter must be an array!");
        }
        if (!is_array($parameters->columns)) {
            return new Exception("Columns parameter must be an array!");
        }
        if (!is_string($parameters->file_name)) {
            return new Exception("Filename parameter must be a string!");
        }

        $raw_data = file($parameters->file_name);
        foreach ($raw_data as $val) {
            $data[] = explode(",", $val);
        }

        foreach ($data as $key => $val) {
            foreach (array_keys($val) as $subkey) {
                if ($subkey == $parameters->indexes[$subkey]) {
                    $data[$key][$parameters->columns[$subkey]] = $data[$key][$subkey];
                    unset($data[$key][$subkey]);
                }
            }
        }
        return [
            'dataset' => $data,
            'gen_length' => count($data)
        ];
    }
}

class Generate
{
    public static function initialPopulation($parameters)
    {
        $catalogue = Products::catalogue($parameters);
        for ($i = 0; $i <= $parameters->population_size - 1; $i++) {
            for ($j = 0; $j <= $catalogue['gen_length'] - 1; $j++) {
                $ret[$i][$j] = rand(0, 1);
            }
        }
        return $ret;
    }

    public static function randomZeroToOne()
    {
        return (float) rand() / (float) getrandmax();
    }

    public static function randomGenLength($parameters)
    {
        $catalogue = Products::catalogue($parameters);
        return rand(1, $catalogue['gen_length'] - 1);
    }
}

class Pairing
{
    public static function chromosomeGenWithProducts($populations, $parameters)
    {
        $ret = [];
        echo "Populations: <br>";
        foreach ($populations as $no => $solution) {
            echo $no . ' ';
            foreach ($solution as $key => $gen) {
                print_r($gen);
            }
            echo '<br>';
        }
        echo '<p>';
        foreach ($populations as $no => $solution) {
            foreach ($solution as $key => $gen) {
                if ($gen === 1) {
                    $selected_product = Products::catalogue($parameters)['dataset'][$key]['item'];
                    $price = Products::catalogue($parameters)['dataset'][$key]['price'];
                    $ret[$no][] = [
                        'product' => $selected_product,
                        'price' => $price
                    ];
                }
            }
        }
        return $ret;
    }
}

class Calculate
{
    public static function sumOfBuy($selected_product)
    {
        $ret = [];
        foreach ($selected_product as $key => $products) {
            echo $key . '<br>';
            print_r($products);
            $sum = array_sum(array_column($products, 'price'));
            echo $sum;
            $ret[] = $sum;
            echo '<br>';
        }
        return $ret;
    }
}

class Fitness
{
    public static function evaluation($sumOfBuy, $knapsack)
    {
        $ret = [];
        $negative_residu = 2;
        $positive_residu = 1;
        foreach ($sumOfBuy as $total) {
            $residu = $knapsack - $total;
            if ($residu < 0) {
                $ret[] = 1 / (1 + $negative_residu);
            }
            if ($residu > 0) {
                $ret[] = 1 / (1 + $positive_residu);
            }
            if ($residu === 0) {
                $ret[] = 1;
            }
        }
        return $ret;
    }

    public static function isOne($individual_fitness)
    {
        if (array_search(1, $individual_fitness)) {
            return true;
        }
    }

    public static function result($population, $individual_fitness, $sumOfBuy)
    {
        $max_value = 1 / 2;
        foreach ($individual_fitness as $key => $fitness_value) {
            if ($max_value === $fitness_value) {
                $indexes[] = $key;
            }
        }
        foreach ($sumOfBuy as $key => $val) {
            foreach ($indexes as $subyek => $ind) {
                if ($key === $ind) {
                    $optimized[] = [
                        'index' => $key,
                        'price' => $val
                    ];
                    break;
                }
            }
        }
        $price = max(array_column($optimized, 'price'));
        $id = array_search($price, array_column($optimized, 'price'));
        $individu = $population[$optimized[$id]['index']];
        return [
            'price' => $price,
            'solution' => $individu
        ];
    }
}

class RandomNumbers
{
    public static function zeroToOne($population_size)
    {
        for ($i = 0; $i <= $population_size - 1; $i++) {
            $ret[] = Generate::randomZeroToOne();
        }
        return $ret;
    }
}

class RouletteWheelSelection
{
    public $population_size;

    function __construct($population_size)
    {
        $this->population_size = $population_size;
    }

    function probability($individual_fitness)
    {
        foreach ($individual_fitness as $fitness) {
            $ret[] = $fitness / array_sum($individual_fitness);
        }
        return $ret;
    }

    function cummulative($individual_fitness)
    {
        foreach ($this->probability($individual_fitness) as $key => $probability) {
            if ($key === 0) {
                $ret[$key] = $probability;
            } else {
                $ret[$key] = $probability + $ret[$key - 1];
            }
        }
        return $ret;
    }

    function selection($individual_fitness, $initial_populations)
    {
        $randomZeroToOne = RandomNumbers::zeroToOne($this->population_size);
        foreach ($randomZeroToOne as $key => $random) {
            echo $random;
            echo '<br>';
            foreach ($this->cummulative($individual_fitness) as $subkey => $roulette) {
                echo $roulette . ' ';
                if ($random < $roulette) {
                    echo ' [ ' . $subkey . ' ' . $roulette . ' ] ';
                    $ret[$key] = $initial_populations[$subkey];
                    break;
                }
            }
            echo '<br>';
        }
        return $ret;
    }
}

class CrossOver
{
    public $population_size;
    public $crossover_rate;

    function __construct($population_size, $crossover_rate)
    {
        $this->population_size = $population_size;
        $this->crossover_rate = $crossover_rate;
    }

    function selectedIndividual()
    {
        $randomZeroToOne = RandomNumbers::zeroToOne($this->population_size);
        foreach ($randomZeroToOne as $key => $val) {
            if ($val < $this->crossover_rate) {
                $ret[] = $key;
            }
        }
        return $ret;
    }

    function generateCombination($selectedIndividual)
    {
        foreach ($selectedIndividual as $val) {
            $acak = $selectedIndividual[array_rand($selectedIndividual)];
            $result[] = [$val, $acak];
        }
        return $result;
    }

    function combination($selectedIndividual)
    {
        $counter = 0;
        while ($counter < 1) {
            $combination = $this->generateCombination($selectedIndividual);
            foreach ($combination  as $val) {
                $sum[] = count(array_unique($val));
            }
            if (array_sum($sum) === count($combination) * 2) {
                return $combination;
            }
            $counter = 0;
            $sum = [];
        }
    }

    function cutPositions($parameters, $number_of_parents)
    {
        for ($i = 0; $i <= $number_of_parents - 1; $i++) {
            $ret[] = Generate::randomGenLength($parameters);
        }
        return $ret;
    }

    function newIndividuals($selected_chromosome, $selected_individuals, $cut_positions, $combinations, $parameters)
    {
        $catalogue = Products::catalogue($parameters);
        $offspring = [];

        foreach ($combinations as $key => $combination) {
            $individu1 = $selected_chromosome[$combination[0]];
            $individu2 = $selected_chromosome[$combination[1]];

            for ($i = 0; $i <= $catalogue['gen_length'] - 1; $i++) {
                if ($i < $cut_positions[$key]) {
                    $offspring[$key][] = $individu1[$i];
                } else {
                    $offspring[$key][] = $individu2[$i];
                }
            }
            $ret[] = [
                'index' => $selected_individuals[$key],
                'offspring' => $offspring[$key]
            ];
        }
        return $ret;
    }

    function updatePopulations($selected_chromosome, $new_individuals)
    {
        for ($i = 0; $i <= count($selected_chromosome) - 1; $i++) {
            foreach ($new_individuals as $key => $individual) {
                if ($i === $individual['index']) {
                    $ret[$i][$key] = [
                        'a' => 'new',
                        'b' => $i
                    ];
                } else {
                    $ret[$i][$key] = [
                        'a' => 'old',
                        'b' => $i
                    ];
                }
            }
        }

        foreach ($ret as $key => $z) {
            $index = array_search('new', array_column($z, 'a'));
            if ($index || $index === 0) {
                $index_new = array_search($z[$index]['b'], array_column($new_individuals, 'index'));
                $result[] = $new_individuals[$index_new]['offspring'];
            } else {
                $result[] = $selected_chromosome[$key];
            }
        }
        return $result;
    }
}

$parameters = [
    'file_name' => '../datasets/products.txt',
    'indexes' => [0, 1],
    'columns' => ['item', 'price'],
    'population_size' => 10,
    'fitness' => 1000,
    'max_generation' => 1000,
    'crossover_rate' => 0.75,
    'knapsack' => 150000
];

$parameters = new Parameters($parameters);
$catalogue = Products::catalogue($parameters);

for ($i = 0; $i <= $parameters->max_generation; $i++) {
    if ($i === 0) {
        $initial_populations = Generate::initialPopulation($parameters);
        $selected_product = Pairing::chromosomeGenWithProducts($initial_populations, $parameters);
        echo '<p>';
        $sumOfBuy = Calculate::sumOfBuy($selected_product);
        print_r($sumOfBuy);
        echo '<p>';
        $individual_fitness = Fitness::evaluation($sumOfBuy, $parameters->knapsack);
        print_r($individual_fitness);

        echo ' Total fitness ' . array_sum($individual_fitness);
        echo '<br>';

        if (Fitness::isOne($individual_fitness)) {
            echo ' Total fitness ' . array_sum($individual_fitness);
            echo 'Maximum 1 achieved!';
            $solution = Fitness::result($initial_populations, $individual_fitness, $sumOfBuy);
            print_r($solution);
            exit();
        }
        $solution = Fitness::result($initial_populations, $individual_fitness, $sumOfBuy);
        print_r($solution);
        $bests[] = $solution;

        $select = new RouletteWheelSelection($parameters->population_size);
        echo '<p>';
        print_r($select->probability($individual_fitness));
        echo '<p>';
        $cummulative = $select->cummulative($individual_fitness);
        echo '<p>';
        print_r($cummulative);

        $selected_chromosome = $select->selection($individual_fitness, $initial_populations);
        echo '<p>';
        echo 'Hasil seleksi<br>';
        print_r($selected_chromosome);
        echo '<br>';
        $crossover = new CrossOver($parameters->population_size, $parameters->crossover_rate);
        $selected_individuals = $crossover->selectedIndividual($selected_chromosome, $initial_populations);
        $number_of_parents = count($selected_individuals);
        echo 'Individu terpilih: ';
        echo $number_of_parents;
        echo '&nbsp;';
        print_r($selected_individuals);
        echo '<p>Combination:<br>';
        $combinations = $crossover->combination($selected_individuals);
        print_r($combinations);
        echo '<p>';
        $cut_positions = $crossover->cutPositions($parameters, $number_of_parents);
        echo 'Cut position:&nbsp;';
        print_r($cut_positions);
        echo '<br>';
        $new_individuals = $crossover->newIndividuals($selected_chromosome, $selected_individuals, $cut_positions, $combinations, $parameters);
        print_r($new_individuals);

        echo '<p>';
        echo 'New populations<br>';
        $new_populations = $crossover->updatePopulations($selected_chromosome, $new_individuals);
        print_r($new_populations);
        echo '<p>';
    }

    if ($i > 0) {
        echo ' Generasi: ' . $i . '<br>';
        $selected_product = Pairing::chromosomeGenWithProducts($new_populations, $parameters);
        echo '<p>';
        $sumOfBuy = Calculate::sumOfBuy($selected_product);
        print_r($sumOfBuy);
        echo '<p>';
        $individual_fitness = Fitness::evaluation($sumOfBuy, $parameters->knapsack);
        print_r($individual_fitness);

        echo ' Total fitness ' . array_sum($individual_fitness);
        echo '<br>';

        if (Fitness::isOne($individual_fitness)) {
            echo ' Total fitness ' . array_sum($individual_fitness);
            echo 'Maximum 1 achieved!';
            $solution = Fitness::result($new_populations, $individual_fitness, $sumOfBuy);
            print_r($solution);
            exit();
        }
        $solution = Fitness::result($new_populations, $individual_fitness, $sumOfBuy);
        print_r($solution);
        $bests[] = $solution;

        $select = new RouletteWheelSelection($parameters->population_size);
        echo '<p>';
        print_r($select->probability($individual_fitness));
        echo '<p>';
        $cummulative = $select->cummulative($individual_fitness);
        echo '<p>';
        print_r($cummulative);

        $selected_chromosome = $select->selection($individual_fitness, $initial_populations);
        echo '<p>';
        echo 'Hasil seleksi<br>';
        print_r($selected_chromosome);
        echo '<br>';
        $crossover = new CrossOver($parameters->population_size, $parameters->crossover_rate);
        $selected_individuals = $crossover->selectedIndividual($selected_chromosome, $new_populations);
        $number_of_parents = count($selected_individuals);
        echo 'Individu terpilih: ';
        echo $number_of_parents;
        echo '&nbsp;';
        print_r($selected_individuals);
        echo '<p>Combination:<br>';
        $combinations = $crossover->combination($selected_individuals);
        print_r($combinations);
        echo '<p>';
        $cut_positions = $crossover->cutPositions($parameters, $number_of_parents);
        echo 'Cut position:&nbsp;';
        print_r($cut_positions);
        echo '<br>';
        $new_individuals = $crossover->newIndividuals($selected_chromosome, $selected_individuals, $cut_positions, $combinations, $parameters);
        print_r($new_individuals);

        echo '<p>';
        echo 'New populations<br>';
        $new_populations = $crossover->updatePopulations($selected_chromosome, $new_individuals);
        print_r($new_populations);
        echo '<p>';
    }
}
echo '<p>';
echo '<p>Final: <br>';
print_r($bests);
echo '<br>';
$max_price = max(array_column($bests, 'price'));
$index = array_search($max_price, array_column($bests, 'price'));
echo '<p>';
print_r($bests[$index]);
$selected_product = Pairing::chromosomeGenWithProducts($bests[$index], $parameters);
