<?php

session_start();
include_once("../api/connect.php");

if (!isset($_SESSION['userdata'])) {
    header("location:../");
}

$userdata = $_SESSION['userdata'];

$sql_two = "Select * from user where role=2";
$groups = mysqli_query($connect,$sql_two);
$groupsdata = mysqli_fetch_all($groups, MYSQLI_ASSOC);

// echo "<pre>";
// print_r($groupsdata);


if ($_SESSION['userdata']['status'] == 0) {
    $status = '<b style="color: red;">Not Voted.</b>';
} else {
    $status = '<b style="color: green;">Voted.</b>';
}

?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Voting System</title>
    <!-- Bootstrap css -->
    <link rel="stylesheet" href="../bootstrap_css/bootstrap.css">

    <!-- custom css -->
    <link rel="stylesheet" href="../custom_css/dashboard.css">
</head>

<body class="container">

    <nav class="navigation navbar navbar-expand-lg bg-body-tertiary mb-4">
        <div class="container-fluid d-flex justify-content-between">

            <form action="" method="" class="" role="search">
                <a href="../"><button id="backbtn" class="btn btn-outline-success" type="submit">Back</button></a>
            </form>

            <div>
                <a class="navbar-brand fw-bolder" href="dashboard.html">Online Voting System</a>
            </div>

            <form action="logout.php" method="post" class="" role="search">
                <button id="logoutbtn" class="btn btn-outline-success" type="submit">Logout</button>
            </form>
        </div>
    </nav>

    <div class="row  mb-5">

        <div class="col-4 profile_card p-2 rounded-2 mb-2 mb-sm-2 mb-md-2 mb-lg-0">

            <div class="d-flex justify-content-center">
                <img style="height: 100px; width: 100px;" class="img-fluid rounded-circle" src="../uploads/<?php echo $userdata['image']; ?>" alt="">
            </div>

            <div class="profile_information text-white">
                <p><b>Name:</b> <?php echo $userdata['name']; ?></p>
                <p><b>Email:</b> <?php echo $userdata['email']; ?></p>
                <p><b>Address:</b> <?php echo $userdata['address']; ?></p>
                <p><b>Status:</b> <?php echo $status; ?></p>
            </div>

        </div>

        <div class="col-1">

        </div>
        <div class="col-7 result p-2 rounded-2 text-white d-flex flex-column">

            <?php
            if ($_SESSION['groupsdata']) {
                for ($i = 0; $i < count($groupsdata); $i++) {
            ?>
                    <div class="d-flex justify-content-between">
                        <div>
                            <p><b>Group Name:</b> <?php echo $groupsdata[$i]['name']; ?></p>
                            <p><b>Votes:</b> <?php echo $groupsdata[$i]['votes']; ?></p>

                            <form action="../api/dashboard_vote.php" method="post">
                                <div class="input-group mb-3">
                                    <input type="hidden" name="gvotes" value="<?php echo $groupsdata[$i]['votes']; ?>">
                                    <input type="hidden" name="gid" value="<?php echo $groupsdata[$i]['id']; ?>">
                                    <?php
                                    if ($_SESSION['userdata']['status'] == 0) {
                                    ?>
                                        <button class="btn btn-success rounded" type="submit" name="votebtn" id="votebtn">Vote</button>
                                    <?php
                                    } else {
                                    ?>
                                        <button disabled class="btn btn-success rounded" type="submit" name="votebtn" id="votebtn">Vote</button>
                                    <?php
                                    }
                                    ?>
                                </div>
                            </form>
                        </div>

                        <div>
                            <img style="height: 100px; width: 100px;" class="img-fluid rounded-circle" src="../uploads/<?php echo $groupsdata[$i]["image"]; ?>" alt="">
                        </div>
                    </div>
                    <hr>
            <?php
                }
            } else {
                echo "<p><b>No Groups Available.</b></p>";
            }
            ?>
        </div>
    </div>
    
        <script>
        window.onload = function () {

        var chart = new CanvasJS.Chart("chartContainer", {
            animationEnabled: true,
            theme: "light1", // "light1", "light2", "dark1", "dark2"
            title:{
                text: "Vote Result"
            },
            axisY: {
                title: "Number of votes."
            },
            data: [{        
                type: "column",  
                showInLegend: true, 
                legendMarkerColor: "grey",
                legendText: "MMbbl = one million barrels",
                dataPoints: [   
                    <?php
                    foreach ($groupsdata as $group) {
                        echo "{ y: {$group['votes']}, label: \"{$group['name']}\" },";
                    }
                    ?>
                    
                ]
            }]
        });
        chart.render();

        }
    </script>

    <div id="chartContainer" style="height: 300px; width: 100%;"></div>
    <script src="https://cdn.canvasjs.com/canvasjs.min.js"></script>

    <!-- bootstrap js -->
    <script src="../bootstrap_js/bootstrap.bundle.js"></script>
</body>

</html>