<?php
if ($_SERVER["REQUEST_METHOD"] === "POST") {
    header("Access-Control-Allow-Origin: *");
    header("Content-Type: application/json");
    //print_r($_POST);

    $userName = $_POST['username'];


    //Connect to the database
    include "dbconnect.php";

    $sql = "SELECT * FROM details WHERE username = '$userName'";
    $sql_id = "SELECT id from details WHERE username = '$userName'";

    //Check if user exist in the database
    //If connect send user to their profile
    if ($conn->query($sql) && $conn->affected_rows == 1) {
        $profileId = $conn->query($sql_id);
        $assocId = $profileId->fetch_assoc();
        $actualId = $assocId["id"];

        header("Location: http://localhost:3001/profile/$actualId");
    }
    //Else redirect to the create page
    else {
        //Define the error object
        $err_message = "Account does not exist";
        echo json_encode(['err' => $err_message]);

        //Redirect use back to the login page and return the error message
        header("Location: http://localhost:3001/login");
    }
}
