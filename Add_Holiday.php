<?php
include("DB_Connection.php");

$Holiday_Date = $_POST["Holiday_Date"];
$Holiday_Occasion = $_POST["Holiday_Occasion"];


$Add_Holiday_Query = "INSERT into Holiday_Table (Holiday_Date,Holiday_Occasion) VALUES ('$Holiday_Date','$Holiday_Occasion')";

if($Add_Holiday_Query_Result = mysqli_query($DB_Connection,$Add_Holiday_Query)){

    echo json_encode(["Key" => "Holiday Added"]);
}
else{
    echo json_encode(["Key" => "Holiday Already Exists!"]);
}
?>