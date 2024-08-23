<?php 

    session_start();
    include_once("connect.php");

    $votes = $_POST['gvotes'];
    $total_votes = $votes + 1;

    $gid = $_POST['gid'];
    $uid = $_SESSION['userdata']['id'];
    
    $sql_one = "UPDATE user SET votes='$total_votes' where id='$gid'";
    $update_votes = mysqli_query($connect,$sql_one);

    $sql_two = "UPDATE user SET status=1 where id='$uid'";
    $update_user_status = mysqli_query($connect,$sql_two);

    if($update_votes and $update_user_status){

        $sql_three = "SELECT id, name, votes, image FROM user WHERE role = 2;";
        $groups =  mysqli_query($connect,$sql_three);
        $groupsdata = mysqli_fetch_all($groups, MYSQLI_ASSOC);

        $_SESSION['userdata']['status'] = 1;

        echo '
        <script>
            alert("Voting Successful!");
            window.location = "../routes/dashboard.php";
        </script>
        ';
    }else{
        echo '
        <script>
            alert("Some Error Ocurred!");
            window.location = "../routes/dashboard.php";
        </script>
        ';
    }


?>