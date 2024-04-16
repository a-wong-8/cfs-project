<?
require 'auth_check.php';
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Connectd for Schools: Roles</title>
    <link rel="icon" type="image/x-icon" href="./favicon.png">
    <link rel="stylesheet" href="./styles.css">
</head>

<header>
    <span>
        <a href="./codes.php">Home</a>
    </span>
    <span>
        <a href="./inspirations.php">Inspirations</a> &nbsp|&nbsp
        <a href="./goals.php">Goals</a> &nbsp|&nbsp
        <a href=./logout.php>Logout</a>
    </span>
</header>

    <body class="roles-body">
    <div class="school-codes-div" id="roles">
        
        <?php
        $school = $_GET['school'];
        echo "<h2>Roles for ".ucfirst($school)."</h2>";

        $link = "https://connectd-api.allyance.io/c/web/onboarding?d={$school}";

        $jsonData = file_get_contents($link);
        $data = json_decode($jsonData, true);
        
        // Checks if the decoding was successful
        if ($data === null && json_last_error() !== JSON_ERROR_NONE) {
            die("Error decoding JSON");
        }

        // Output links
        foreach ($data as $item) {
            echo '<li><a href=./pathways.php?school='.$school.'&role='.$item['key'].'>' . $item['name'] . '</a></li>';
        }
        ?>

    </div>
    </body>
</html>