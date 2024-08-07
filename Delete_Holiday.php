<?php
include("DB_Connection.php");

$Holiday_ID= $_POST["Holiday_ID"];

$Delete_Info_Query = "DELETE FROM Holiday_Table WHERE Holiday_ID = '$Holiday_ID' ";

if($Delete_Info_Query_Result = mysqli_query($DB_Connection, $Delete_Info_Query)){
    $Key = "Success";
    $Message = "Deleted Successfully";
}
else{
    $Key = "Failure";
    $Message = "Failed to Delete";
}
echo json_encode(["Key" => $Key, "Message" => $Message]);
?>