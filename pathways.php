<?
require 'auth_check.php';
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Connectd for Schools: Pathways</title>
    <link rel="icon" type="image/x-icon" href="./favicon.png">
    <link rel="stylesheet" href="./styles.css">
</head>

<header>
    <?
    $school = $_GET['school'];
    $role = strtolower($_GET['role']);
    $school=='4youth'? $school = '4Youth' : '';
    
    echo     
    "<span>
        <a href=./codes.php>Home</a>&nbsp|&nbsp
    <span><b>".ucfirst($school).' '.ucfirst($role)."</b></span>&nbsp |&nbsp
    <span><b>Pathways </b></span>&nbsp|&nbsp
        <a href=./onboard_questions.php?school={$school}&role={$role}> Onboarding Questions </a>&nbsp|&nbsp
        <a href=./checkin.php?school={$school}&role={$role}> Check-in Questions </a>&nbsp|&nbsp
        <a href=./topics.php?school={$school}&role={$role}> Topics </a>&nbsp|&nbsp
        <a href=./directory.php?school={$school}&role={$role}> Directory </a>
    </span>
    <span>
        <a href=./inspirations.php?> Inspirations </a>&nbsp|&nbsp
        <a href=./goals.php?> Goals </a> &nbsp|&nbsp
        <a href=./logout.php>Logout</a>
    </span>";
    ?>
</header>

<body class="pathway-body">
    <?php
        $role == 'teacher'? $role = 'staff': '';
        
        $link = "https://connectd-api.allyance.io/c/web/deployment?d={$school}&r={$role}";

        echo '<h2 style=margin-left:35%>Pathways for '.ucfirst($school).' '.ucfirst($role).'</h2>';

        $jsonData = file_get_contents($link);
        $data = json_decode($jsonData, true);

        // Checks if the decoding was successful
        if ($data === null && json_last_error() !== JSON_ERROR_NONE) {
            die("Error decoding JSON");
        }

        echo '<div class="img-pathways">';
            foreach ($data as $item) {
                echo 
                '<a href=./pathway_details.php?school='.$school.'&id='.$item["id"].'&role='.$role.'>
                    <img id="image" src=" '. $item['image']. ' " >
                    </img>
                </a>';
            }
        echo '</div>';
    ?>
</body>

</html>