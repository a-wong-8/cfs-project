<?
require 'auth_check.php';
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Connectd for Schools: Directory</title>
    <link rel="icon" type="image/x-icon" href="./favicon.png">
    <link rel="stylesheet" href="./styles.css">
</head>

<header>
<?
    $school = $_GET['school'];
    $role = $_GET['role'];
    $school=='4youth'? $school = '4Youth' : '';

    echo
    "<span>
        <a href=./codes.php>Home</a> &nbsp|&nbsp
        <span><b>".ucfirst($school).' '.ucfirst($role)."</b></span> &nbsp|&nbsp
        <a href=./pathways.php?school={$school}&role={$role}> Pathways </a>&nbsp|&nbsp
        <a href=./onboard_questions.php?school={$school}&role={$role}> Onboarding Questions </a> &nbsp|&nbsp
        <a href=./checkin.php?school={$school}&role={$role}> Check-in Questions</a> &nbsp|&nbsp 
        <a href=./topics.php?school={$school}&role={$role}> Topics </a> &nbsp|&nbsp
        <span><b>Directory</b></span>
    </span>
    <span>
        <a href=./inspirations.php?>Inspirations</a> &nbsp|&nbsp
        <a href=./goals.php?>Goals</a> &nbsp|&nbsp
        <a href=./logout.php>Logout</a>
    </span>";
?>
</header>

<body class="directory-body" >
    <div id="questions">
    <?
        $link = "https://connectd-api.allyance.io/c/web/directory?d={$school}&r={$role}";
        $jsonData = file_get_contents($link);
        $data = json_decode($jsonData, true);

        echo '<h2>Directory for '.ucfirst($school).' '.ucfirst($role).'</h2>';

        foreach ($data['items'] as $section) {
            echo "<h2><u>{$section['section_name']}</u></h2>";
        
            foreach ($section['items'] as $item) {
                echo "<h3>{$item['title']}</h3>";
                echo "<p>{$item['description']}</p>";
                echo $item['phone']?"<li>{$item['phone']}</li>":'';
            }
        }
    ?>
    </div>
</body>
</html>