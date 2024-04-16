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
            new DataTable('#deployment-table');
        });
    </script>
</head>

<header>
    <span>
    <?php        
        $url = 'https://connectd-api.allyance.io/cfs/status';

        // Get JSON data from the URL
        $jsonData = file_get_contents($url);
        $data = json_decode($jsonData, true);

        // Check if the "running" key exists and has a value of true
        if (isset($data['status']['running']) && $data['status']['running'] === true) {
            echo '<span>Connectd for Schools Status: 🟢 </span> <span style=color:green> Running </span>';
        } else {
            echo '<span>Connectd for Schools Status: 🔴 </span><span style=color:red>Down </span>';
        }
    ?>
    </span>
    <span>
        <a href="./inspirations.php">Inspirations</a>&nbsp |&nbsp
        <a href="./goals.php">Goals</a>&nbsp |&nbsp
        <a href="./logout.php">Logout</a>
    </span>
</header>

<body class="school-codes-body">
<img src="./cfs-logo.png" class="logo"/>

    <?
        echo "<h1 style='text-align:center;'>Deployment Summary</h1>";
        $linkDashboard = "https://connectd-api.allyance.io/c/web/dashboard";
        $jsonDataDash = file_get_contents($linkDashboard);
        $data = json_decode($jsonDataDash, true);
    ?>

    <div class='table'>
        <table id='deployment-table' class='display' width='80%'>
        <?
        $totalUsers = 0;
        $totalPathways = 0;
        $totalCheckins = 0;
        
        echo 
        "<thead>
            <tr><th><b>Deployment</b></th>
            <th><b>Role</b></th>
            <th><b>Users </b></th>
            <th><b>Pathways</b></th>
            <th><b>Checkins</b></th></tr>
        </thead>";

        echo "<tbody>";

        foreach ($data['deployments'] as $item) {   
            $item['language']=='Spanish'&&$item['role']=='Student'?
            $item['role']='Student_es':'';
            $item['language']=='Spanish'&&$item['role']=='Parent'?
            $item['role']='Parent_es':'';
            if ($item['code']=='4YOUTH') {
                $item['code']='4Youth';
            } else {    
                $item['code']= ucwords(strtolower($item['code']));
            }
            echo "<tr>";
                
                echo "<td>
                        <a href='./activity.php?school={$item['code']}&role={$item['role']}'>".$item['code']."</a>
                    </td>";
                echo "<td>
                        <a href='./pathways.php?school={$item['code']}&role={$item['role']}'>".$item['role']."</a>
                    </td>";
                echo "<td>{$item['users']}</td>";
                echo "<td>
                        <a href='./pathway_stats.php?school={$item['code']}&role={$item['role']}'>{$item['pathways']}</a>
                    </td>";
                echo "<td>
                        <a href='./checkin_stats.php?school={$item['code']}&role={$item['role']}'>{$item['checkins']}</a>
                    </td>";

            echo "</tr>";
                
            $totalUsers += $item['users'];
            $totalPathways += $item['pathways'];
            $totalCheckins += $item['checkins'];
            }

        echo "</tbody>";
        
        echo "<tfoot><tr>";
            echo "<th><b>Total</b></th>";
            echo "<th><b></b></th>";
            echo "<th><b>{$totalUsers}</b></th>";
            echo "<th><b>{$totalPathways}</b></th>";
            echo "<th><b>{$totalCheckins}</b></th>";
        echo "</tfoot></tr>";

        ?>
    </table>
    </div>

    <div class="school-codes-div">
        <h2>School Codes</h2>
        <?
        $link = "https://connectd-api.allyance.io/c/web/deployments";
        $jsonData = file_get_contents($link);
        $data = json_decode($jsonData, true);
        
        for ($i=0; $i<count($data); $i++) {
            $data[$i] == '4youth' ? $data[$i] = '4Youth' : '';

            echo "<li><a href=./roles.php?school=$data[$i]>".ucfirst($data[$i])."</a></li>";
        }
        ?>
    </div>

</body>
</html>