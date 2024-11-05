<?php

if ($_SERVER["REQUEST_METHOD"] === "POST") {

    //Headers

    header("Access-Control-Allow-Origin: *");
    header("Content-Type: application/json");
    print_r($_POST);


    // Example endpoint to fetch data
    $firstName = $_POST['first_name'];
    $lastName = $_POST['last_name'];
    $age = $_POST['age'];
    $bio = $_POST['bio'];
    $profilePic = $_FILES["profile_pic"]["name"];
    $password = $_POST['password'];
    echo $firstName . "<br/>";
    echo $lastName . "<br/>";
    echo $age . "<br/>";
    echo $bio . "<br/>";
    echo $profilePic . "<br/>";

    /* Connect to try database */
    $dbhost = "localhost";
    $dbusername = "ben";
    $dbpassword = 12345;
    $dbname = "try";

    $conn = new mysqli($dbhost, $dbusername, $dbpassword, $dbname);
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
    $sql = "INSERT INTO people(first_name, last_name, age, bio, image, password) 
VALUES('$firstName' , '$lastName', '$age', '$bio', '$actualPath', '$password')";

    if ($conn->query($sql) === true) {
        echo "added";
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
    header("Content-Type: application/json");


    //query statement
    $sqlGet = "SELECT * FROM people WHERE id >= 30;";
    $resultArr = [];
    $selectQuery = $conn->query($sqlGet);
    $imageUrl = $selectQuery->fetch_assoc();

    while ($rowResult = $selectQuery->fetch_assoc()) {
        $resultArr[] = $rowResult;
    }
    print_r(json_encode($resultArr));
}
