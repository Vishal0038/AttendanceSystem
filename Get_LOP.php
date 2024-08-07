<?php
include "DB_Connection.php";

$Select_Query = "SELECT Employee_ID,Employee_Name,Employee_Monthly_Salary FROM Employee_Details";
if ($Select_Query_Result = mysqli_query($DB_Connection, $Select_Query)) {
    if (mysqli_num_rows($Select_Query_Result) > 0) {
        $Attendance = array();
        while (($Select_Query_Row = mysqli_fetch_array($Select_Query_Result))) {
            $Employee_ID = $Select_Query_Row["Employee_ID"];
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
            $Select_Distinct_Month_Query = "SELECT DISTINCT MONTH(Date_Of_Entry) FROM Attendance_Table";
            if ($Select_Distinct_Month_Query_Result = mysqli_query($DB_Connection, $Select_Distinct_Month_Query)) {
                $Month_Count = mysqli_num_rows($Select_Distinct_Month_Query_Result);
            }

            $Available_Leave = ($Month_Count * 3) - $Absent_Sessions/2;
            if ($Available_Leave < 0) {
                $Loss_Of_Pay = abs($Available_Leave);
                $Available_Leave = 0;
            } else {
                $Loss_Of_Pay = 0;
            }
            $Update_LOP_Query = "UPDATE Employee_Details SET Loss_Of_Pay ='$Loss_Of_Pay' WHERE Employee_ID = '$Employee_ID'";
            $Attendance_Array = array("Available_Leave" => $Available_Leave , "Loss_Of_Pay" => $Loss_Of_Pay);
            array_push($Attendance,$Attendance_Array);
            }
        }
        $JSON_Response["Attendance_Array"] = $Attendance;
    }
    echo json_encode($JSON_Response);
}

?>