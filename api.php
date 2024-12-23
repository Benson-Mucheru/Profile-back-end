<?php

if ($_SERVER["REQUEST_METHOD"] === "POST") {

    //Headers

    header("Access-Control-Allow-Origin: *");
    header("Content-Type: application/json");
    print_r($_POST);


    // Example endpoint to fetch data
    $username = $_POST['username'];
    $age = $_POST['age'];
    $bio = $_POST['bio'];
    $profilePic = $_FILES["profile_pic"]["name"];
    //$password = $_POST['password'];
    

    /* Connect to try database */
    include_once "./dbconnect.php";

    $conn = new mysqli($servername, $dbusername, $password, $dbname);
    if ($conn->connect_error) {
        die("Connection failed: " . $conn->connect_error);
    } else {
        echo "Connection success";
    }

    $target_dir = "./images/";
    $actualPath = $target_dir . basename($profilePic);
    move_uploaded_file($_FILES["profile_pic"]["tmp_name"], $actualPath);
    echo $actualPath;



    //Insert data into try database
    $sql = "INSERT INTO details(username, age, bio, image) 
VALUES('$username', '$age', '$bio', '$actualPath')";

    if ($conn->query($sql) === true) {
        echo "added";
        header("Location: http://localhost:3001/profiles");
    } else {
        echo "not added";
    }
    echo "<br/>" . $actualPath . "<br/>";
}

if ($_SERVER["REQUEST_METHOD"] === "GET") {
    //connect to database
    include_once './dbconnect.php';

    //headers required
    header("Access-Control-Allow-Origin: *");
  //header("Content-Type: application/json");


    //query statement
    $sqlGet = "SELECT * FROM details;";
    $resultArr = [];
    $selectQuery = $conn->query($sqlGet);
    

   

    while($imageUrl = $selectQuery->fetch_assoc()){ 
        $resultArr[] = $imageUrl;
    }
   /* for($i = 1; $i <= $selectQuery->num_rows; $i++){
    array_push($resultArr, $imageUrl);
   } */
    
    print_r(json_encode($resultArr));
    //print_r(json_encode($imageUrl));
    //print_r($imageUrl);
}
