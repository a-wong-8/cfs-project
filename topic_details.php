<?
require 'auth_check.php';
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Connectd for Schools: Topic Details</title>
    <link rel="icon" type="image/x-icon" href="./favicon.png">
    <link rel="stylesheet" href="./styles.css">
    <style> 
        a:hover { 
            color: black; 
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
        <a href=./checkin.php?school={$school}&role={$role}> Check-in Questions</a> &nbsp|&nbsp
        <a href=./topics.php?school={$school}&role={$role}> Topics </a> &nbsp|&nbsp
        <span><b>Topic Details</b></span> &nbsp|&nbsp
        <a href=./directory.php?school={$school}&role={$role}> Directory </a>
    </span>
    <span>
        <a href=./inspirations.php?>Inspirations</a> &nbsp|&nbsp
        <a href=./goals.php?>Goals</a> &nbsp|&nbsp
        <a href=./logout.php>Logout</a>
    </span>";
    ?>
</header>

<body class="pathway-detail-body">
    <div id="questions">
    <?
        $id = $_GET['id'];

        echo '<h2>Topic Details for '.ucfirst($school).' '.ucfirst($role).'</h2>';

        $link = "https://connectd-api.allyance.io/c/web/topic?d={$school}&r={$role}&id={$id}";

        $jsonData = file_get_contents($link);
        $data = json_decode($jsonData, true);

        foreach ($data as $item) {
            
            echo $item['video_type']=='youtube'?
            "<div id='video-div'><h3>{$item['title']}</h3><object width=600 height=350 data=http://www.youtube.com/v/".$item['video_id']. " type=application/x-shockwave-flash><param name=src value=http://www.youtube.com/v/".$item['video_id']. " /></object>
            <p style='padding-right:30px'>{$item['description']}</p>
            </div>"
            : '';

            echo ($item['video_type']=='wistia') ? 
            '<div id="video-div"><h3>'.$item['title'].'</h3><iframe src="https://fast.wistia.net/embed/iframe/'.$item['video_id'].'"
            allowtransparency="true" frameborder="0" scrolling="no" class="wistia_embed" name="wistia_embed" allowfullscreen mozallowfullscreen webkitallowfullscreen oallowfullscreen msallowfullscreen width="600" height="350"></iframe>
            <p style=padding-right:30px>'.$item['description'].'</p>
            </div>': '';

            echo $item['rtype']=='audio'?
            "<div id=topic-div><h3>{$item['title']}</h3><audio controls>
                <source src={$item['document_url']} type=audio/mp3>
            </audio></div>":'';

            echo ($item['video_type']=='mp4') ? 
            '<div id=video-div><h3>'.$item['title'].'</h3><video width="600" height="350" controls>
                <source src='.$item['mp4_url'].' type="video/mp4">
            </video></div>': '';

            echo $item['rtype']=='website'?
            "<div id=topic-div><h3>{$item['title']}</h3><a href={$item['document_url']}>{$item['document_url']}</a></div>":'';

            echo $item['rtype']=='document'?
            "<div id=topic-div><h3>{$item['title']}</h3><a href={$item['document_url']}>
                <img style='height:150px' src={$item['thumbnail_sq']}></img>
            </a></div>":'';

        }
    ?>
    </div>
</body>

</html>