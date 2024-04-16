<?
require 'auth_check.php';
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Connectd for Schools: Onboarding Questions</title>
    <link rel="icon" type="image/x-icon" href="./favicon.png">
    <link rel="stylesheet" href="./styles.css">
    <style>
        #welcome-img-div {
            border-radius: 5px;
            background-color: azure;
            box-shadow: 1px 1px 4px #111111;
        }

        #onboard-q-div {
            border-radius: 5px;
            background-color: azure;
            box-shadow: 1px 1px 4px #111111;
            padding: 1rem;
            width: 400px;
        }
    </style>
</head>

<header>
<?
    $school = $_GET['school'];
    $role = $_GET['role'];
    $school=='4youth' ? $school='4Youth':'';
    ucfirst($role)=='Teacher' ? $role='Staff':'';
    
    echo 
    "<span>
        <a href=./codes.php>Home</a> &nbsp|&nbsp
        <span><b>".ucfirst($school).' '.ucfirst($role)."</b></span> &nbsp|&nbsp
        <a href=./pathways.php?school={$school}&role={$role}> Pathways </a> &nbsp|&nbsp
        <span><b>Onboarding Questions</b></span> &nbsp|&nbsp
        <a href=./checkin.php?school={$school}&role={$role}> Check-in Questions</a> &nbsp|&nbsp
        <a href=./topics.php?school={$school}&role={$role}> Topics </a> &nbsp|&nbsp
        <a href=./directory.php?school={$school}&role={$role}> Directory </a>
    </span>
    <span>
        <a href=./inspirations.php?>Inspirations</a> &nbsp|&nbsp
        <a href=./goals.php?>Goals</a> &nbsp|&nbsp
        <a href=./logout.php>Logout</a>
    </span>";
?>
</header>
    
    <body class="questions-body">

    <?php
        ucfirst($role)=='Staff'?$role='teacher':'';
        ucfirst($role)=='Parent_es'?$role='parent_es':'';
        
        $link = "https://connectd-api.allyance.io/c/web/onboarding?d={$school}";

        $jsonData = file_get_contents($link);
        $data = json_decode($jsonData, true);

        foreach ($data as $item) {
            echo '<div id="questions">';
            
            if ($item['key'] == $role) {
                echo "<h2 style=text-align:center;><span>Onboarding Questions for ". ucfirst($school) . "</span>".' '.$item['name'].'</h2>';

                echo "<section id='welcome-section'>";
                foreach ($item['welcome_screens'] as $img) {
                    echo "<div id='welcome-img-div'><h3>{$img['title']}</h3>";
                    echo '<img id=welcome-img style="width:200px" src='.$img['image'].'></img>
                    <p>'.$img['body'].'</p></div>';
                }
                echo "</section>";

                echo '<br><div id="onboard-intro">'.$item['intro'].'</div>';

                foreach ($item['onboarding'] as $ele) {
                    echo "<div id=onboard-q-div>";
                    echo '<b>'.$ele['prompt'].'</b>';
                    foreach ($ele['answers'] as $item) {
                        echo '<li>'.$item['label'].'</li>';
                    }
                    echo "</div>";
                echo "<br>";

                }
            }
            echo '</div>';

        }
    ?>

    </body>
</html>