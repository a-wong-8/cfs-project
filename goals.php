<?
require 'auth_check.php';
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Connectd for Schools: Goals</title>
    <link rel="icon" type="image/x-icon" href="./favicon.png">
    <link rel="stylesheet" href="./styles.css">
</head>

<header>
    <span>
        <a href="./codes.php">Home</a>
    </span>
    <span>
        <a href="./inspirations.php">Inspirations</a> &nbsp|&nbsp
        <span><b>Goals</b></span> &nbsp|&nbsp
        <a href="./logout.php">Logout</a>
    </span>
</header>

<body class="goals-body">
    <?
    echo '<h2 style=text-align:center>Goals</h2>';

    $link = "https://connectd-api.allyance.io/c/web/goals";
    $jsonData = file_get_contents($link);
    $data = json_decode($jsonData, true);

    foreach ($data as $item) {
        echo "<div id='goal'>";

        echo "<h2 style=text-align:center>{$item['title']}</h2>
        <h4 style=text-align:center>{$item['subtitle']}</h4>";

        echo "<img style='width:200px; padding-left:28%;' src={$item['image']}></img>";

        echo 
        "<p style='padding: right 20px; text-align:center'>
            {$item['description']}
        </p>";

        foreach ($item['settings'] as $settings) {
            echo "<ul><p><b>Settings</b></p>";

            foreach ($settings as $key => $value) {
                echo "<li>".ucfirst($key).": {$value}</li>";
            }
            echo "</ul>";
        }
        echo "</div>";
    }
    ?>
</body>
</html>