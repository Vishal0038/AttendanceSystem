<?php
include "DB_Connection.php";
$ID = $_POST["ID"];
$Select_Single_Query = "SELECT * FROM Employee_Details WHERE ID = '$ID'";
if($Select_Single_Query_Result = mysqli_query($DB_Connection,$Select_Single_Query)){
    if(mysqli_num_rows($Select_Single_Query_Result)> 0 ){
        $Single_Info = array();
        while($Select_Single_Query_Row = mysqli_fetch_array($Select_Single_Query_Result)){
            $Employee_ID = $Select_Single_Query_Row["Employee_ID"];
            $Employee_Name = $Select_Single_Query_Row["Employee_Name"];
            $Monthly_Salary =  $Select_Single_Query_Row["Employee_Monthly_Salary"];
            
            $Absent_Sessions = 0;
            $Select_Attendance_Query = "SELECT * FROM Attendance_Table WHERE Employee_ID = '$Employee_ID'";
            if ($Select_Attendance_Query_Result = mysqli_query($DB_Connection, $Select_Attendance_Query)) {
                if (mysqli_num_rows($Select_Attendance_Query_Result) > 0) {
                    while (($Select_Attendance_Query_Row = mysqli_fetch_array($Select_Attendance_Query_Result))) {
                        $Morning = $Select_Attendance_Query_Row["Morning"];
                        $Evening = $Select_Attendance_Query_Row["Evening"];
                        $Day_Type = $Select_Attendance_Query_Row["Day_Type"];
                        if ($Morning == "Absent") {
                            $Absent_Sessions++;
                        }
                        if ($Evening == "Absent") {
                            $Absent_Sessions++;
                        }
                        if ($Morning == "Present" && $Day_Type == "Holiday") {
                            $Absent_Sessions--;
                        }
                        if ($Evening == "Present" && $Day_Type == "Holiday") {
                            $Absent_Sessions--;
                        }
                    }
                }                                                                           
                $Select_Distinct_Month_Query = "SELECT DISTINCT MONTH(Date_Of_Entry) FROM Attendance_Table WHERE Employee_ID = '$Employee_ID' AND MONTH(Date_Of_Entry) != MONTH(CURDATE())";
                if ($Select_Distinct_Month_Query_Result = mysqli_query($DB_Connection, $Select_Distinct_Month_Query)) {
                    $Month_Count = mysqli_num_rows($Select_Distinct_Month_Query_Result);
                }

                $Available_Leave = 3 * $Month_Count ;
                
            }
            $Working_Days = 0;
            $Present_Sessions = 0;
            $Select_Single_Attendance_Query = "SELECT * FROM Attendance_Table WHERE Employee_ID = '$Employee_ID' AND MONTH(Date_Of_Entry) = MONTH(CURRENT_DATE - INTERVAL 1 MONTH) AND YEAR(Date_Of_Entry) = YEAR(CURRENT_DATE - INTERVAL 1 MONTH)";
            if($Select_Single_Attendance_Query_Result = mysqli_query($DB_Connection,$Select_Single_Attendance_Query)){
                if(mysqli_num_rows($Select_Single_Attendance_Query_Result) > 0){
                    while (($Select_Single_Attendance_Query_Row = mysqli_fetch_array($Select_Single_Attendance_Query_Result))) {
                        $Morning = $Select_Single_Attendance_Query_Row["Morning"];
                        $Evening = $Select_Single_Attendance_Query_Row["Evening"];
                        $Day_Type = $Select_Single_Attendance_Query_Row["Day_Type"];
                        if ($Day_Type == "Working") {
                            $Working_Days++;
                        }
                        if ($Morning == "Present" && $Day_Type == "Working") {
                            $Present_Sessions++;
                        }
                        if ($Evening == "Present" && $Day_Type == "Working") {
                            $Present_Sessions++;
                        }
                    }
                }
                $Present_Days = $Present_Sessions/2;
                $Monthly_Absent_Days = $Working_Days - $Present_Days;
                if($Monthly_Absent_Days <= $Available_Leave){
                    $Monthly_LOP = 0;
                    $Available_Leave = $Available_Leave - $Monthly_Absent_Days;
                }
                else{
                    $Monthly_LOP = $Monthly_Absent_Days - $Available_Leave;
                    $Available_Leave = 0;
                }
            }
            $Single_Info_Array = array("Employee_ID" => $Employee_ID, "Employee_Name" => $Employee_Name,"Monthly_Salary" => $Monthly_Salary, "Working_Days" => $Working_Days, "Present_Days" => $Present_Days , "Available_Leave" => $Available_Leave , "Monthly_LOP" => $Monthly_LOP);
            array_push($Single_Info, $Single_Info_Array);
        }
        $JSON_Response["Single_Info_Array"] = $Single_Info;
    }
    echo json_encode($JSON_Response);
}