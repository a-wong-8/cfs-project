<?
require 'auth_check.php';
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Connectd for Schools: Inspirations</title>
    <link rel="icon" type="image/x-icon" href="./favicon.png">
    <link rel="stylesheet" href="./styles.css">
</head>

<header>
    <span>
        <a href="./codes.php">Home</a>
    </span>
    <span>
        <span><b>Inspirations</b></span> &nbsp|&nbsp
        <a href="./goals.php">Goals</a> &nbsp|&nbsp
        <a href="./logout.php">Logout</a>
    </span>
</header>

<body class="checkin-questions-body">
    <div id="questions">
    <?php
        $link = "https://connectd-api.allyance.io/c/web/inspirations";

        $jsonData = file_get_contents($link);
        $data = json_decode($jsonData, true);

        echo "<h2>Inspirations</h2>";

        foreach ($data as $item) {
            echo "<li style='padding:5px'>$item</li>";
        }
    ?>
    </div>
</body>
</html>