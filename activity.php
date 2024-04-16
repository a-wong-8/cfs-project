<?php
    require 'auth_check.php';
?>

<?
    $school = ucfirst(strtolower($_GET['school']));
    $link = "https://connectd-api.allyance.io/c/web/deployment-stats?depoyment={$school}";
    $jsonData = file_get_contents($link);
    $data = json_decode($jsonData, true);

    function epochToDate($epochTimestamp) {
        $epochTimestampInSeconds = floor($epochTimestamp / 1000);
        $formattedDate = date("m/d/y", $epochTimestampInSeconds);
        return $formattedDate;
    }

    $dataPoints = [];
    foreach ($data['checkins'] as $checkin) {
        $dataPoints[] = ["label" => epochToDate($checkin["time"]), "y" => $checkin["count"], "color"=>"rgba(15, 209, 154, 0.7)"];
    }

    $dataPointsPathway = [];
    foreach ($data['pathways'] as $pathway) {
        $dataPointsPathway[] = ["label" => epochToDate($pathway["time"]), "y" => $pathway["count"], "color"=>"rgba(52, 105, 197, 0.7)"];
    }
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Connectd for Schools: Activity Statistics</title>
    <link rel="icon" type="image/x-icon" href="./favicon.png">
    <link rel="stylesheet" href="./styles.css">
    <script>
        window.onload = function () {

            const chart = document.getElementById('checkin-chart');
            const chart2 = document.getElementById('pathway-chart');

            new Chart(chart, {
                type: 'bar',
                data: {
                    labels: <?php echo json_encode(array_column($dataPoints, 'label')); ?>,
                    datasets: [{
                        label: 'Check-ins',
                        data: <?php echo json_encode(array_column($dataPoints, 'y'), JSON_NUMERIC_CHECK); ?>,
                        borderWidth: 1
                }]
                },
                options: {
                scales: {
                    y: {
                    beginAtZero: true
                    }
                }
                },   
            });

            new Chart(chart2, {
                type: 'bar',
                data: {
                    labels: <?php echo json_encode(array_column($dataPointsPathway, 'label')); ?>,
                    datasets: [{
                        label: 'Pathways',
                        data: <?php echo json_encode(array_column($dataPointsPathway, 'y'), JSON_NUMERIC_CHECK); ?>,
                        backgroundColor: 'rgba(15, 209, 154, 0.7)',
                        borderColor: 'rgba(15, 209, 154, 1)',
                        borderWidth: 1
                }]
                },
                options: {
                scales: {
                    y: {
                    beginAtZero: true
                    }
                }
                },   
            });
        
        chart.render();
        chart2.render();
        }
    </script>
    <style>
        #chartContainer, #chartContainerPathway {
            box-shadow: 1px 1px 4px #111111;
            margin: 5rem auto;
            background-color: azure;
            padding: 1rem;
            border-radius: 5px;
        }
    </style>
</head>

<header>
    <?
    $role = strtolower($_GET['role']);
    $school=='4youth'? $school = '4Youth' : '';
    $role=='staff'||$role=='Staff'?$role='teacher':'';

    echo
    "<span>
        <a href='./codes.php'>Home</a> &nbsp|&nbsp
        <span><b>".ucfirst($school)." User Activity</b></span>
    </span>
    <span>
        <a href='./inspirations.php'>Inspirations</a> &nbsp|&nbsp
        <a href='./goals.php'>Goals</a> &nbsp|&nbsp
        <a href='./logout.php'>Logout</a>
    <span>";
    ?>
</header>

<body class="goals-body">
    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
    <div id="chartContainer" style="height: auto; width: 80%;">
        <canvas id="checkin-chart"></canvas>
    </div>
    <div id="chartContainerPathway" style="height: auto; width: 80%;">
        <canvas id="pathway-chart"></canvas>
    </div>
</body>

</html>