<?php 
//received user input
$username = $_POST["username"];
$password = $_POST["password"];

session_start();


include('../config/DatabaseConnect.php');
if($_SERVER["REQUEST_METHOD"] == "POST"){
    
      
//db connection

    $db = new DatabaseConnect();
    $conn = $db ->connectDB();
       
        try {
           
            
            $stmt = $conn->prepare('SELECT * FROM `users` WHERE username = :p_username');
            $stmt->bindParam(':p_username',$username);
            $stmt->execute();
            $users = $stmt->fetchAll();
            if($users){
          
                if(password_verify($password,$users[0]["password"])){
                    header ("location: /index.php");
                    $_SESSION["fullname"] = $users[0]["fullname"];
                } else {
                    echo "password did not match";
                }
            } else {
                echo "user not exist";
            }

        } catch (Exception $e){
            echo "Connection Failed: " . $e->getMessage();
        }


    
}


?>