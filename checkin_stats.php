<?
require 'auth_check.php';
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Connectd for Schools: School Codes</title>
    <link rel="stylesheet" href="./styles.css">
    <link rel="icon" type="image/x-icon" href="./favicon.png">
      <link href="https://cdn.datatables.net/v/dt/jqc-1.12.4/dt-1.13.8/datatables.min.css" rel="stylesheet">
    <script src="https://cdn.datatables.net/v/dt/jqc-1.12.4/dt-1.13.8/datatables.min.js">
    </script>
    <script>
        $(document).ready(function() {
            new DataTable('#checkin-table');
        });
    </script>
    <style>
        table > tbody > tr > td > img {
            width: 100px;
            display: flex;
            align-items: center;
            justify-content: center;
            position: relative;
        }

        #checkin-title {
            position: relative;
            font-size: 12px;
            padding-bottom: 90px;
        }

        .dataTables_wrapper {
            background-color: azure;
            padding: 2rem;
            border-radius: 5px;
            box-shadow: 1px 1px 4px #111111;
            width: 40%;
        }

        td {
            border-bottom: 0.5px solid #aaa;
        }
    </style>
</head>

<header>
    <?
    $school = $_GET['school'];
    $role = $_GET['role'];
    $school=='4youth' ? $school='4Youth':'';

    echo 
    "<span>
        <a href=./codes.php>Home</a> &nbsp|&nbsp
        <span><b>".ucfirst($school).' '.ucfirst($role)."</b></span> &nbsp|&nbsp
        <a href=./pathways.php?school={$school}&role={$role}> Pathways </a> &nbsp|&nbsp
        <a href=./onboard_questions.php?school={$school}&role={$role}> Onboarding Questions </a>&nbsp|&nbsp
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

<body class="roles-body">
    <?
    ucfirst($role)=='Parent_es'?$role='parent_es':'';
    
    $link = "https://connectd-api.allyance.io/c/web/stats/checkins?d={$school}&r={$role}";

    $jsonData = file_get_contents($link);
    $data = json_decode($jsonData, true);

    echo "<h2 style='text-align:center;'>Checkin Statistics for ".ucfirst($school)." ".ucfirst($role)."</h2>";
    ?>

    <div class="graph">
    <?
        echo "<table id=checkin-table>";
        echo "<thead><tr>";
            echo "<th><b>Checkin</b></th>";
            echo "<th><b>Completions</b></th>";
            echo "<th><b>Orange</b></th>";
            echo "<th><b>Yellow</b></th>";
            echo "<th><b>Green</b></th>";
        echo "<thead></tr>";
        

            $matches = false;
        echo "<tbody>";
            foreach ($data['checkinStats'] as $stat) {

                foreach ($data['checkins'] as $items) {
                    
                    if ($items['id']==$stat['id']) {
                        echo 
                        "<tr><td><img src='{$items['thumbnail']}'>
                            <span id='checkin-title'>
                            {$items['title']}
                        </span></img></td>";
                        echo "<td>{$stat['submissions']}</td>";
                        echo "<td>{$stat['orange']}</td>";
                        echo "<td>{$stat['yellow']}</td>";
                        echo "<td>{$stat['green']}</td></tr>"; 

                        $matches = true;
                    }
                }
            } 
        echo "</tbody>";
        
        echo !$matches?"<span>No checkin statistics yet</span>":'';

        echo "</table>";
    ?>
    </div>
</body>

</html>