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
    $main->maxBudget = $maxBudget;
    $main->popSize = 85;
    $main->crossoverRate = 0.8;
    $main->maxGen = 250;
    $main->selectionType = 'elitism';
    $main->stoppingValue = 100;
    $main->numOfLastResult = 10;

    $result = $main->runMain();

    if (empty($result)) {
        echo 'Optimum solution was not found. Try again, or raise your Budget.';
    } else {
        echo "<table>";
        echo "<tr><td>Your budget</td><td>: <b>Rp. ".number_format($main->maxBudget)."</b></td></tr>";
        echo "<tr><td>Optimum amount</td><td>: <b>Rp. " . number_format($result['amount'])  . "</b></td></tr>";
        echo "<tr><td>Number of items</td><td>: <b> " . $result['numOfItems'] . "</b></td></tr>";
        echo "</table>";

        echo "<br>List of items: <br>";
        echo "<table><tr><td>No.</td><td>Item</td><td>Price (Rp)</td></tr>";
        foreach ($result['items'] as $key => $item) {
            echo "<tr><td>". ($key + 1)."</td><td>". $item[0]."</td><td  style=align:right'>".number_format($item[1])."</td></tr>";
        }
        echo "</table>";
    }
}

?>

