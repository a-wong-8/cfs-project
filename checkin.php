<?
require 'auth_check.php';
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Connectd for Schools: Checkin Questions</title>
    <link rel="icon" type="image/x-icon" href="./favicon.png">
    <link rel="stylesheet" href="./styles.css">
    <style>
        #checkin-div {
            background-color: azure;
            border-radius: 5px;
            box-shadow: 1px 1px 4px #111111;
            padding: 0.5rem 2rem 1.5rem;
            margin: 1rem 1rem 0 0;
            width: 35%;
        }
    </style>
</head>

<header>
<?
   $school = $_GET['school'];
   $role = $_GET['role'];
   $school=='4youth'? $school = '4Youth' : '';
   $role=='Teacher'? $role = 'Staff' : '';

   echo 
    "<span>
        <a href=./codes.php>Home</a> &nbsp|&nbsp
        <span><b>".ucfirst($school).' '.ucfirst($role)."</b></span> &nbsp|&nbsp
        <a href=./pathways.php?school={$school}&role={$role}> Pathways </a> &nbsp|&nbsp
        <a href=./onboard_questions.php?school={$school}&role={$role}> Onboarding Questions </a> &nbsp|&nbsp
        <span><b>Check-in Questions</b></span> &nbsp|&nbsp
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

<body class="checkin-questions-body">
    <div id="questions">
        <?
            echo '<h2>Check-in Questions for '.ucfirst($school).' '.ucfirst($role).'</h2>';

            $linkCheckin = "https://connectd-api.allyance.io/c/web/checkins?d={$school}&r={$role}";

            $jsonDataCheckin = file_get_contents($linkCheckin);
            $data = json_decode($jsonDataCheckin, true);

            foreach ($data as $checkin) {
                echo "<h2>{$checkin['title']}</h2>";
                echo "<img id=checkin-img src={$checkin['thumbnail']}></>";
                
                foreach ($checkin['questions'] as $question) {
                    echo "<div id=checkin-div>";
                    echo "<p>{$question['question_text']}</p>";
                    
                    foreach ($question['choices'] as $choice) {
                        echo "<li>{$choice}</li>";
                    }
                    echo "</div>";
                }
                
            }
        ?>
    </div>
</body>
</html>