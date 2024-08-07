<?php
include("DB_Connection.php");
$Current_Date = date("Y-m-d");
$Selected_Month = $_POST["Selected_Month"];
$Selected_Year = $_POST["Selected_Year"];
$Fetch_Holiday_Query = "SELECT Holiday_ID, Holiday_Date, MONTHNAME(Holiday_Date) AS Holiday_Month, DAYNAME(Holiday_Date) AS Holiday_Day, YEAR(Holiday_Date) AS Holiday_Year,Holiday_Occasion FROM Holiday_Table WHERE MONTHNAME(Holiday_Date) = '$Selected_Month' AND YEAR(Holiday_Date) = '$Selected_Year' ORDER BY Holiday_Date";



if($Fetch_Holiday_Query_Result = mysqli_query($DB_Connection,$Fetch_Holiday_Query)){
    if(mysqli_num_rows($Fetch_Holiday_Query_Result) > 0){
        $Holidays = array();
        while(($Fetch_Holiday_Query_Row = mysqli_fetch_array($Fetch_Holiday_Query_Result))){
            $Holiday_ID =  $Fetch_Holiday_Query_Row["Holiday_ID"];
            $Holiday_Year = $Fetch_Holiday_Query_Row["Holiday_Year"];
            $Holiday_Date = $Fetch_Holiday_Query_Row["Holiday_Date"];
            $Holiday_Day = $Fetch_Holiday_Query_Row["Holiday_Day"];
            $Holiday_Month = $Fetch_Holiday_Query_Row["Holiday_Month"];
            $Holiday_Occasion = $Fetch_Holiday_Query_Row["Holiday_Occasion"];

            if($Holiday_Date >= $Current_Date){
                $Available_Date = true;
            }
            else{
                $Available_Date = false;
            }
            $Holidays_Array = ["Holiday_ID" => $Holiday_ID, "Holiday_Year" => $Holiday_Year,"Holiday_Date" => $Holiday_Date,"Holiday_Day"=>$Holiday_Day,"Holiday_Month" => $Holiday_Month, "Holiday_Occasion" => $Holiday_Occasion, "Available_Date" => $Available_Date];
            array_push($Holidays, $Holidays_Array);
        }
        $JSON_Response["Holidays_Array"] = $Holidays;
    echo json_encode($JSON_Response);
}
else{

    echo json_encode(["Key" => "Failure"]);
}
}
?>