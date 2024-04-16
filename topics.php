<?
require 'auth_check.php';
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Connectd for Schools: Topics</title>
    <link rel="icon" type="image/x-icon" href="./favicon.png">
    <link rel="stylesheet" href="./styles.css">
</head>

<header>
    <?
    $school = $_GET['school'];
    $role = $_GET['role'];
    $school=='4youth'? $school = '4Youth' : '';
    $role=='teacher'? $role = 'Staff' : '';
    
    echo 
    "<span>
        <a href=./codes.php>Home</a> &nbsp|&nbsp
        <span><b>".ucfirst($school).' '.ucfirst($role)."</b></span> &nbsp|&nbsp
        <a href=./pathways.php?school={$school}&role={$role}> Pathways </a> &nbsp|&nbsp
        <a href=./onboard_questions.php?school={$school}&role={$role}> Onboarding Questions </a> &nbsp|&nbsp
        <a href=./checkin.php?school={$school}&role={$role}> Check-in Questions</a> &nbsp|&nbsp
        <span><b>Topics</b></span> &nbsp|&nbsp
        <a href=./directory.php?school={$school}&role={$role}> Directory </a>
    </span>
    <span>
        <a href=./inspirations.php?>Inspirations</a> &nbsp|&nbsp
        <a href=./goals.php?>Goals</a> &nbsp|&nbsp
        <a href=./logout.php>Logout</a>
    </span>";
    ?>
</header>

<body class="pathway-body">
    <?php
        $link = "https://connectd-api.allyance.io/c/web/topics?d={$school}&r={$role}";

        echo '<h2 style=margin-left:35%>Topics for '.ucfirst($school).' '.ucfirst($role).'</h2>';

        $jsonData = file_get_contents($link);
        $data = json_decode($jsonData, true);

        echo '<div class="img-pathways">';
        foreach ($data as $item) {
            echo 
            '<a href=./topic_details.php?school='.$school.'&id='.$item["id"].'&role='.$role.'>
            <img id="image" src=" '. $item['thumbnail']. ' " >
            </img>
            </a>';
        }
        echo '</div>';
    ?>
</body>
</html>