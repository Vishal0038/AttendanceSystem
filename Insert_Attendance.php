<?php
include "DB_Connection.php";

$Current_Date = date("Y-m-d");
$Attendance = $_POST["Attendance"];
$Selected_Date = $_POST["Selected_Date"];
$Date_Select = new DateTime($Selected_Date);

if (isset($_POST["Selected_Date"]) && !empty($_POST["Selected_Date"])) {
    foreach($Attendance as $Checkbox){
        $Employee_ID = $Checkbox["Employee_ID"];
        $Morning = $Checkbox["Morning"];
        $Evening = $Checkbox["Evening"];
        $Day_Type ="Working";
        $Select_Query = "SELECT * FROM Attendance_Table WHERE Date_Of_Entry = '$Selected_Date' AND Employee_ID = '$Employee_ID'";
        
        if($Select_Query_Result = mysqli_query($DB_Connection, $Select_Query)){
            if(mysqli_num_rows($Select_Query_Result) > 0){
                $Insert_Update_Query = "UPDATE Attendance_Table SET Morning = '$Morning', Evening = '$Evening' WHERE Date_Of_Entry = '$Selected_Date' AND Employee_ID = '$Employee_ID'";
                $Update_Status = Run_Insert_Query ($Insert_Update_Query, $DB_Connection); 
            } 
            else {
                $Select_Holiday_Query = "SELECT Holiday_Date FROM Holiday_Table WHERE Holiday_Date = '$Selected_Date'";
                if($Select_Holiday_Query_Result = mysqli_query($DB_Connection,$Select_Holiday_Query)){
                    if(mysqli_num_rows($Select_Holiday_Query_Result) > 0){
                        while(($Select_Holiday_Query_Row = mysqli_fetch_array($Select_Holiday_Query_Result))){
                            $Holiday_Date = $Select_Holiday_Query_Row["Holiday_Date"];
                            if((date_format($Date_Select,"w") == 0) || $Holiday_Date == $Selected_Date){
                                $Day_Type ="Holiday";
                                if($Morning == "Present" || $Evening == "Present"){
                                    $Insert_Update_Query = "INSERT INTO Attendance_Table (Employee_ID, Date_Of_Entry, Day_Type, Morning, Evening) VALUES ('$Employee_ID', '$Selected_Date','$Day_Type','$Morning', '$Evening')";
                                    $Update_Status = Run_Insert_Query ($Insert_Update_Query, $DB_Connection);
                                }
                                else{   
                                }
                            }
                            else{
                            }
                        }
                    }
                    else{
                        $Insert_Update_Query = "INSERT INTO Attendance_Table (Employee_ID, Date_Of_Entry, Day_Type, Morning, Evening) VALUES ('$Employee_ID', '$Selected_Date','$Day_Type','$Morning', '$Evening')";
                        
                        $Update_Status = Run_Insert_Query ($Insert_Update_Query, $DB_Connection);
                    }   
                }
            }
        }
        else {
            $Update_Status = "Failure";
        }
    }
}
else{
    $Update_Status = "Select a date to insert/update";
}

if($Update_Status){
    echo json_encode(["Status" => $Update_Status , "Added_Date" => $Selected_Date]);
} else {
    echo json_encode(["Status" => $Update_Status]);
}
 function Run_Insert_Query ($Insert_Update_Query, $DB_Connection){
    if($Insert_Update_Query_Result = mysqli_query($DB_Connection, $Insert_Update_Query)){
        return "Success";
    }else{
        return "Failure";
    }
 }

?>
