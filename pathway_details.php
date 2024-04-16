<?
require 'auth_check.php';
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Connectd for Schools: Pathway Details</title>
    <link rel="icon" type="image/x-icon" href="./favicon.png">
    <link rel="stylesheet" href="./styles.css">
</head>

<header>
    <?
    $school = ucfirst(strtolower($_GET['school']));
    $role = strtolower($_GET['role']);
    $school=='4youth'? $school = '4Youth' : '';
    $role=='staff'||$role=='Staff'?$role='teacher':'';

    echo
    "<span>
        <a href=./codes.php>Home</a> &nbsp|&nbsp
        <span><b>".ucfirst($school).' '.ucfirst($role)."</b></span> &nbsp|&nbsp
        <a href=./pathways.php?school={$school}&role={$role}> Pathways </a> &nbsp|&nbsp
        <span><b>Pathway Details</b></span> &nbsp|&nbsp
        <a href=./onboard_questions.php?school={$school}&role={$role}> Onboarding Questions </a> &nbsp|&nbsp
        <a href=./checkin.php?school={$school}&role={$role}> Check-in Questions</a> &nbsp|&nbsp 
        <a href=./topics.php?school={$school}&role={$role}> Topics </a> &nbsp|&nbsp
        <a href=./directory.php?school={$school}&role={$role}> Directory </a>
    </span>
    <span>
        <a href=./inspirations.php?>Inspirations</a> &nbsp|&nbsp
        <a href=./goals.php?>Goals</a> &nbsp|&nbsp
        <a href=./logout.php>Logout</a>
    <span>";
    ?>
</header>

<body class="pathway-detail-body">
    <div id="questions">
        <?
            $role=='teacher'? $role = 'Staff' : '';
            $id = $_GET['id'];

            echo '<h2>Pathway Details for '.ucfirst($school).' '.ucfirst($role).'</h2>';

            $link = "https://connectd-api.allyance.io/c/web/pathway?d={$school}&id={$id}&r={$role}";

            $jsonData = file_get_contents($link);
            $data = json_decode($jsonData, true);

            echo "<img src={$data['image']} id='main-img'></img><br>";

            foreach ($data['contents'] as $content) {
                if ($content['segment_type'] === 'text') {
                    echo "<div id=pathway-detail-intro>";
                    echo '<h4>' . $content['text'] . '</h4>';
                    echo "</div>";

                } elseif ($content['segment_type'] === 'resource' && $content['resouce_type'] === 'video') {
                    echo "<div id=video-div>";

                    echo '<h3>' . $content['title'] . '</h3>';

                    echo isset($content['mp4_url']) ? 
                    '<video width="600" height="350" controls>
                        <source src='.$content['mp4_url'].' type="video/mp4">
                    </video>'
                     : '';

                    echo $content['video_type']=='youtube'?
                    "<object width=600 height=350 data=http://www.youtube.com/v/".$content['video_id']. " 
                    type=application/x-shockwave-flash><param name=src value=http://www.youtube.com/v/".$content['video_id']. " /></object><br>"
                     : '';
                     
                        echo isset($content['text'])? 
                        "<p style=padding-right:5px;>".$content['text']."</p>":'<p>';
                    
                    echo "</div>";

                } elseif ($content['segment_type'] === 'tips') {
                    echo "<div id=tips-div>";
                    echo '<h3>'. $content['title'].'</h3>';
                    echo '<div class=tips-imgs>';
                        foreach ($content['images'] as $image) {
                            echo "<img src={$image} id=tips-img></img>";
                        }
                    echo '</div></div>';
                
                } elseif ($content['segment_type'] === 'takeways') {
                    echo "<div id=takeaways>";
                    echo '<h3>Takeaways</h3>';

                    foreach ($content['takeways'] as $text) {
                        echo '<div><img src='.$text['thumbnail'].'><span>'.$text['text'].'</span></img></div><br>';
                    }
                    echo "</div>";
                }
            }
        ?>
    </div>
</body>
</html>