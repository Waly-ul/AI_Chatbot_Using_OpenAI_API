<?php 

    include_once("connect.php");

    $name = $_POST['name']; 
    $email = $_POST['email']; 
    $password = md5($_POST['password']);
    $cpassword = md5($_POST['cpassword']); 
    $address = $_POST['address']; 
    $image = $_FILES['image']['name'];
    $tmp_name = $_FILES['image']['tmp_name'];
    $role = $_POST['role'];

    if($password == $cpassword){
        move_uploaded_file($tmp_name,"../uploads/$image");

        $sql = "INSERT INTO user (name,email,password,address,image,role,status,votes) VALUES ('$name','$email','$password','$address','$image','$role',0,0)";

        $insert =   mysqli_query($connect,$sql);

        if($insert){
            echo '
        <script>
            alert("Registration Successful!");
            window.location = "../";
        </script>
        '; 
        }
        else{
            echo '
        <script>
            alert("Some Error occurred!");
            window.location = "../routes/register.html";
        </script>
        ';
        }

    }else{
        echo '
        <script>
            alert("Password and Confirm password does not match!");
            window.location = "../routes/register.html";
        </script>
        ';
    }
?>