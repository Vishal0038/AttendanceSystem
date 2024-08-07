<?php
include("DB_Connection.php");

$ID = $_POST["ID"];
$Module_Name = $_POST["Module_Name"];
$Permissions_Query = "SELECT * FROM Permissions_Table where Module_Name = '$Module_Name'";

if($Permissions_Query_Result = mysqli_query($DB_Connection, $Permissions_Query)){
   if(mysqli_num_rows($Permissions_Query_Result) > 0){
        while($Permissions_Query_Row = mysqli_fetch_array($Permissions_Query_Result)){
            $ID = $Permissions_Query_Row["ID"];
            $Module_Name = $Permissions_Query_Row["Module_Name"];
            $Add_Permission = $Permissions_Query_Row["Add_Permission"];
            $View_Permission = $Permissions_Query_Row["View_Permission"];
            $Update_Permission = $Permissions_Query_Row["Update_Permission"];
            $Delete_Permission = $Permissions_Query_Row["Delete_Permission"];
        
            echo json_encode(["ID" =>$ID, "Add_Permission" => $Add_Permission,"View_Permission" => $View_Permission,"Update_Permission" => $Update_Permission,"Delete_Permission" => $Delete_Permission]);
        }
    }
}
?>