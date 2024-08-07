<?php
include("DB_Connection.php");

$Updated_Date = $_POST["Updated_Date"];
$Updated_Occasion = $_POST["Updated_Occasion"];

$Update_Holiday_Query = "UPDATE Holiday_Table SET Holiday_Occasion = '$Updated_Occasion' WHERE Holiday_Date = '$Updated_Date'";

if($Update_Holiday_Query_Result = mysqli_query($DB_Connection,$Update_Holiday_Query)){

    echo json_encode(["Key" => "Holiday Updated"]);
}
else{
    echo json_encode(["Key" => "Failed to Update"]);
}
?>