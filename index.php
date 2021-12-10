<h2>Parcel Hari Raya menggunakan Algoritma Genetika</h2>
<hr>
<form method="post" action="<?= $_SERVER["PHP_SELF"]; ?>">

    Budget Rp. <input type='text' name="inputBudget" autofocus>
    &nbsp;
    <input type="submit" name="submit" value="Submit">
    <p></p>
</form>

<?php
require 'vendor/autoload.php';

$maxBudget = "";
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $maxBudget = $_POST["inputBudget"];
    
    if ($maxBudget === ''){
        echo '<font color =red>Enter your budget.</font>';
        die;
    }

    $main = new Main;
    $main->popSize = 85;
    $main->crossoverRate = 0.8;
    $main->maxGen = 250;
    $main->selectionType = 'elitism';
    $main->maxBudget = $maxBudget;
    $main->stoppingValue = 100;
    $main->numOfLastResult = 10;

    $result = $main->runMain();

    if (empty($result)) {
        echo 'Optimum solution was not found. Try again, or raise your Budget.';
    } else {
        echo 'Optimum amount <b>Rp. ' . $result['amount'] . "</b>";
        echo "<br>";
        echo "Number of items: <b>" . $result['numOfItems'] . "</b>";
        echo "<br>Items: <br>";

        foreach ($result['items'] as $key => $item) {
            echo ($key + 1) . ' ' . $item[0] . ' Rp. ' . $item[1];
            echo "<br>";
        }
    }
}

?>


<?php
    // $main = new Main;
    // $main->popSize = 85;
    // $main->crossoverRate = 0.8;
    // $main->maxGen = 250;
    // $main->selectionType = 'elitism';
    // $main->maxBudget = $maxBudget;
    // $main->stoppingValue = 100;
    // $main->numOfLastResult = 10;

    // $result = $main->runMain();
    // if (empty($result)) {
    //     echo 'Solution is not found. Try again, or raise your Budget.';
    // } else {
    //     echo 'Optimum amount <b>Rp. ' . $result['amount'] . "</b>";
    //     echo "<br>";
    //     echo "Number of items: <b>" . $result['numOfItems'] . "</b>";
    //     echo "<br>Items: <br>";

    //     foreach ($result['items'] as $key => $item) {
    //         echo ($key + 1) . ' ' . $item[0] . ' Rp. ' . $item[1];
    //         echo "<br>";
    //     }
    // }
