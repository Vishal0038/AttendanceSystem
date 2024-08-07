<?php
include("DB_Connection.php");
$Selected_Date = $_POST["Selected_Date"];
$View_Attendance_Query = "SELECT ID,Employee_ID, Employee_Name FROM Employee_Details";

if($View_Attendance_Query_Result = mysqli_query($DB_Connection,$View_Attendance_Query)){
    if(mysqli_num_rows($View_Attendance_Query_Result) > 0){
        $Employees = array();
        while(($View_Attendance_Query_Row = mysqli_fetch_array($View_Attendance_Query_Result))){
            $ID = $View_Attendance_Query_Row["ID"];
            $Employee_ID =  $View_Attendance_Query_Row["Employee_ID"];
            $Employee_Name = $View_Attendance_Query_Row["Employee_Name"];

            $Select_Query = "SELECT * FROM Attendance_Table WHERE Date_Of_Entry = '$Selected_Date' AND Employee_ID = '$Employee_ID'";
            if($Select_Query_Result = mysqli_query($DB_Connection, $Select_Query)){
                if(mysqli_num_rows($Select_Query_Result) > 0){
                    while(($Select_Query_Result_Row = mysqli_fetch_array($Select_Query_Result))){
                        $Morning = $Select_Query_Result_Row["Morning"];
                        $Evening = $Select_Query_Result_Row["Evening"];
                        $Day_Type = $Select_Query_Result_Row["Day_Type"];
                    }
                    $Status = "Data Entered";
                }
                else{
                    $Day_Type = "";
                    $Morning = "";
                    $Evening = "";
                    $Status = "No data";
                }
            }
            $Employees_Array = array("ID" => $ID, "Employee_ID" => $Employee_ID, "Employee_Name" => $Employee_Name , "Status" => $Status,"Morning" => $Morning , "Evening" => $Evening , "Day_Type" => $Day_Type);
            array_push($Employees, $Employees_Array);
        }
        $JSON_Response["Employees_Array"] = $Employees;
    
}
echo json_encode($JSON_Response);
}
?>