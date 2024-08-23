<?php 
    session_start();
    include_once("connect.php");

    $email = $_POST['email'];
    $password = md5($_POST['password']);
    $role = $_POST['role'];

    $sql_one = "Select * from user where email='$email' and password = '$password' and role='$role'";
    $check = mysqli_query($connect,$sql_one);

    if(mysqli_num_rows($check)>0){
        $userdata = mysqli_fetch_array($check);
        $sql_two = "Select * from user where role=2";
        $groups = mysqli_query($connect,$sql_two);
        $groupsdata = mysqli_fetch_all($groups, MYSQLI_ASSOC);

        $_SESSION['userdata'] = $userdata;
        $_SESSION['groupsdata'] = $groupsdata;

        echo '
        <script>
            window.location = "../routes/dashboard.php";
        </script>
        '; 

    }else{
        echo '
        <script>
            alert("Invalid Credentials or user not found!");
            window.location = "../";
        </script>
        ';
    }

?>