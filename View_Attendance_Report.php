<?php
include "DB_Connection.php";
$Selected_Month = $_POST["Selected_Month"];
$From_Date = $_POST["From_Date"];
$To_Date = $_POST["To_Date"];

$Select_Query = "SELECT ID,Employee_ID,Employee_Name,Total_LOP FROM Employee_Details";
if ($Select_Query_Result = mysqli_query($DB_Connection, $Select_Query)) {
    if (mysqli_num_rows($Select_Query_Result) > 0) {
        $Employees = array();
        while (($Select_Query_Row = mysqli_fetch_array($Select_Query_Result))) {
            $ID = $Select_Query_Row["ID"];
            $Employee_ID = $Select_Query_Row["Employee_ID"];
            $Employee_Name = $Select_Query_Row["Employee_Name"];
            $Total_LOP = $Select_Query_Row["Total_LOP"];

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
                $Select_Distinct_Month_Query = "SELECT DISTINCT MONTH(Date_Of_Entry) FROM Attendance_Table WHERE Employee_ID = '$Employee_ID'";
                if ($Select_Distinct_Month_Query_Result = mysqli_query($DB_Connection, $Select_Distinct_Month_Query)) {
                    $Month_Count = mysqli_num_rows($Select_Distinct_Month_Query_Result);
                }

                $Available_Leave = $Month_Count * 3 - $Absent_Sessions/2;
                if ($Available_Leave < 0) {
                    $Loss_Of_Pay = abs($Available_Leave);
                    $Available_Leave = 0;
                } else {
                    $Loss_Of_Pay = 0;
                }

            }
            $Working_Days = 0;
            $Present_Sessions = 0;
            $Select_Attendance_Query = "SELECT * FROM Attendance_Table WHERE Employee_ID = '$Employee_ID' AND MONTH(Date_Of_Entry)='$Selected_Month' AND Date_Of_Entry BETWEEN '$From_Date' AND '$To_Date'";
            if ($Select_Attendance_Query_Result = mysqli_query($DB_Connection, $Select_Attendance_Query)) {
                if (mysqli_num_rows($Select_Attendance_Query_Result) > 0) {
                    while (($Select_Attendance_Query_Row = mysqli_fetch_array($Select_Attendance_Query_Result))) {
                        $Morning = $Select_Attendance_Query_Row["Morning"];
                        $Evening = $Select_Attendance_Query_Row["Evening"];
                        $Day_Type = $Select_Attendance_Query_Row["Day_Type"];
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
            }
            $Present_Days = $Present_Sessions / 2;
            $Employees_Array = array("ID" => $ID,"Employee_ID" => $Employee_ID, "Employee_Name" => $Employee_Name, "Working_Days" => $Working_Days, "Present_Days" => $Present_Days,"Available_Leave" => $Available_Leave , "Loss_Of_Pay" => $Loss_Of_Pay);
            array_push($Employees, $Employees_Array);
        }
        $JSON_Response["Employees_Array"] = $Employees;
    }
    echo json_encode($JSON_Response);
}
?>
