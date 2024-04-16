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
            new DataTable('#pathway-table');
        });
    </script>
    <style>
        body {
            margin-bottom: 16rem;
            overflow-y: hidden;
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

<body class="school-codes-body">
    <?
    // ucfirst($role)=='Staff'?$role='teacher':'';
    ucfirst($role)=='Parent_es'?$role='parent_es':'';
    
    $link = "https://connectd-api.allyance.io/c/web/stats/pathways?d={$school}&r={$role}";

    $jsonData = file_get_contents($link);
    $data = json_decode($jsonData, true);

    echo "<h2 style='text-align:center;'>Pathway Statistics for ".ucfirst($school)." ".ucfirst($role)."</h2>";
    ?>

    <div class="pathway-stats-chart graph">
        <?
        echo "<table id=pathway-table>";
        echo "<thead><tr>";
            echo "<th id='row-1'><b>Pathway</b></th>";
            echo "<th id='row-1'><b>Visits</b></th>";
            echo "<th id='row-1'><b>Completions</b></th>";
            echo "<th id='row-1'><b>Takeaways</b></th>";
        echo "</thead></tr>";
        
            $matchesFound = false;
            
        echo "<tbody>";
            foreach ($data['pathwayStats'] as $stat) {

                foreach ($data['pathways'] as $items) {
                    if ($items['id']==$stat['id']) {
                        echo "<tr><td >
                        <img style='width: 120px;;' src='{$items['image']}'></img>
                        </td>";
                        echo 
                        "<td>
                            {$stat['visits']}
                        </td>";
                        echo "<td>    
                            {$stat['completions']}
                        </td>";
                        echo "<td>
                            {$stat['takeaways']}
                        </td></tr>"; 
                        $matchesFound = true;
                    }
                }
            }   
        echo "</tbody>";

        echo !$matchesFound?"<span>No Pathway statistics yet</span>":'';

        echo "</table>"
        ?>
    </div>
</body>

</html>