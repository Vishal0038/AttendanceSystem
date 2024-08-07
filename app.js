const sidebar = document.querySelector("aside");
const maxSidebar = document.querySelector(".max")
const miniSidebar = document.querySelector(".mini")
const roundout = document.querySelector(".roundout")
const maxToolbar = document.querySelector(".max-toolbar")
const logo = document.querySelector('.logo')
const content = document.querySelector('.content')
const moon = document.querySelector(".moon")
const sun = document.querySelector(".sun")

function setDark(val){
    if(val === "dark"){
        document.documentElement.classList.add('dark')
        moon.classList.add("hidden")
        sun.classList.remove("hidden")
    }else{
        document.documentElement.classList.remove('dark')
        sun.classList.add("hidden")
        moon.classList.remove("hidden")
    }
}

function openNav() {
    if(sidebar.classList.contains('-translate-x-48')){
        // max sidebar 
        sidebar.classList.remove("-translate-x-48")
        sidebar.classList.add("translate-x-none")
        maxSidebar.classList.remove("hidden")
        maxSidebar.classList.add("flex")
        miniSidebar.classList.remove("flex")
        miniSidebar.classList.add("hidden")
        maxToolbar.classList.add("translate-x-0")
        maxToolbar.classList.remove("translate-x-24","scale-x-0")
        logo.classList.remove("ml-12")
        content.classList.remove("ml-12")
        content.classList.add("ml-12","md:ml-60")
    }else{
        // mini sidebar
        sidebar.classList.add("-translate-x-48")
        sidebar.classList.remove("translate-x-none")
        maxSidebar.classList.add("hidden")
        maxSidebar.classList.remove("flex")
        miniSidebar.classList.add("flex")
        miniSidebar.classList.remove("hidden")
        maxToolbar.classList.add("translate-x-24","scale-x-0")
        maxToolbar.classList.remove("translate-x-0")
        logo.classList.add('ml-12')
        content.classList.remove("ml-12","md:ml-60")
        content.classList.add("ml-12")
    }
}


function Get_Module_Permission(ID, Module_Name){
    return new Promise(function(resolve, reject) {
    $.ajax({
        type: "POST",
        url: "Get_Module_Permission.php",
        data: { ID: ID, Module_Name: Module_Name},
        dataType: "json",
        success: function (Response) {
            resolve(Response);
        },
        error: function (xhr, status, error) {
            reject(error);
        },
    })
    });
}


function Fetch_Holidays(ID,Module_Name,Holiday_ID) {

    Get_Module_Permission(ID, Module_Name).then(function(Permission_Response) {
        var Add_Permission = Permission_Response.Add_Permission;
        var View_Permission = Permission_Response.View_Permission;
        var Update_Permission = Permission_Response.Update_Permission;
        var Delete_Permission = Permission_Response.Delete_Permission;

        var Month = document.getElementById('Selected_Month').value;
        const months = ["January","February","March","April","May","June","July","August","September","October","November","December"];
        var Selected_Month = months[Month-1];
        var Selected_Year = document.getElementById('Selected_Year').value;
        var Add_Holiday_Button = document.getElementById("Add_Holiday");
        var Holiday_List = $("#Holiday_List");
        Holiday_List.empty();
        $.ajax({
            url : "Fetch_Holiday.php",
            type : "POST",
            data  : {Holiday_ID : Holiday_ID, Selected_Month : Selected_Month, Selected_Year : Selected_Year},
            dataType : "json",
            success : function(Response){
            var Holidays_Array = Response.Holidays_Array;
            if(Holidays_Array){      
                var Holidays_Array_Length = Holidays_Array.length;
                for (var i = 0; i < Holidays_Array_Length; i++) {
                    var Holidays = Holidays_Array[i];
                    var Holiday_ID = Holidays.Holiday_ID;
                    var Holiday_Date = Holidays.Holiday_Date;
                    var Holiday_Day = Holidays.Holiday_Day;
                    var Holiday_Month = Holidays.Holiday_Month;
                    var Holiday_Occasion = Holidays.Holiday_Occasion;
                    var Available_Date = Holidays.Available_Date; 

                    if(Add_Permission == "Default True" || Add_Permission =="True"){
                        Add_Holiday_Button.classList.remove('hidden');
                        Add_Holiday_Button.classList.add('block');
                    }
                    if(View_Permission == "Default True" || View_Permission == "True"){
                        
                        var HTML = "<tr class='min-w-full leading-normal table-auto'><td class='py-5 border-b border-gray-200 bg-white text-center text-sm'>"+Holiday_Date+"</td>";
                        HTML += "<td class='py-5 border-b border-gray-200 bg-white text-center text-sm'>"+Holiday_Day+"</td>";
                        HTML += "<td class='py-5 border-b border-gray-200 bg-white text-center text-sm'>"+Holiday_Occasion+"</td>";
                    }
                        HTML += "<td class='py-5 border-b border-gray-200 bg-white text-sm'>";

                    if(Delete_Permission == "Default True" || Delete_Permission == "True"){
                        document.getElementById("Action").classList.remove('hidden');
                        document.getElementById("Action").classList.add('block');
                        
                        if(Available_Date == true){
                            HTML += "<button class='fa-solid fa-trash-can fa-lg focus:outline-none' style='color: #fa0000;' " +
                            "onclick=\"Delete_Holiday(event, " + Holiday_ID + ", '" + Holiday_Date + "', '" + Holiday_Occasion + "')\">" +
                            "</button>";
                        }
                        else{
                            HTML += "<button class='fa-solid fa-trash-can fa-lg' style='color: #B2BEB5;' disabled></button>";
                        }
                    }

                    if(Update_Permission == "Default_True" || Update_Permission == "True"){
                        document.getElementById("Action").classList.remove('hidden');
                        document.getElementById("Action").classList.add('block');

                        if(Available_Date == true){
                            HTML+= "<button class='ml-10 fa-solid fa-pen-to-square fa-lg focus:outline-none' style='color: #0096FF;' " +
                            "@click='Update_Holiday_Modal = true' onclick=\"Open_Update_Holiday_Modal('" + Holiday_Date + "', '" + Holiday_Occasion + "')\">" +
                            "</button>" +
                            "<a href='Employee_Holidays.php?Holiday_ID=" + Holiday_ID + "'></a>" +
                            "</td></tr>";
                        }
                        else{
                            HTML += "<button class='ml-10 fa-solid fa-pen-to-square fa-lg' style='color: #B2BEB5;'disabled></button></a></td></tr>";
                        }
                    }
                    Holiday_List.append(HTML);
                }   
            }
            else{
                if(View_Permission == "Default True" || View_Permission == "True"){
                    var HTML = "<tbody><td class='px-5 py-5 border-b border-gray-200 bg-white text-sm'>No holidays found for the selected month</td>";
                    Holiday_List.append(HTML);
                }
            }       
            },
            error: function (xhr, status, error) {
                console.error("An error occurred while fetching the product list:", xhr.responseText);
            }
        })
        .catch(function(error) {
            console.error('Error:', error);
        })
    });
}

function Open_Update_Holiday_Modal(Holiday_Date,Holiday_Occasion){
    var Updated_Date = $("#Updated_Date");
    var Updated_Occasion = $("#Updated_Occasion");
    Updated_Date.prop("Disabled");
    Updated_Date.val(Holiday_Date);
    Updated_Occasion.val(Holiday_Occasion);
}

function Add_Holiday() {
    var Holiday_Date = $("#Holiday_Date").val();
    var Month_Select = document.getElementById('Selected_Month');
    var Year_Select = $("#Selected_Year");
    var Holiday_Occasion = $("#Holiday_Occasion").val();
    var Added_Date = document.getElementById('Holiday_Date').value;
    var Added_Year = new Date(Added_Date).getFullYear();
    var Added_Month = new Date(Added_Date).getMonth()+1;

    $.ajax({
        url : "Add_Holiday.php",
        type : "POST",
        dataType: "json",
        data : { Holiday_Date : Holiday_Date, Holiday_Occasion : Holiday_Occasion },
        success : function(Response){
            var Key = Response.Key;
            alert(Key);
            Month_Select.selectedIndex = Added_Month;
            Year_Select.val(Added_Year);
            Fetch_Holidays(1,"Holiday_List");
            document.getElementById('Holiday_Date').value="";
            document.getElementById('Holiday_Occasion').value="";
            
        },
        error: function (xhr, status, error) {
            console.error("An error occurred while fetching the product list:", xhr.responseText);
        }
    });
}

function Delete_Holiday(Event,Holiday_ID,Holiday_Date,Holiday_Occasion){
    Event.preventDefault();

    if(confirm("Delete the holiday on "+Holiday_Date+" for "+Holiday_Occasion+"?")){
        $.ajax({
            type: "POST",
            url: "Delete_Holiday.php",
            data: {Holiday_ID : Holiday_ID},
            dataType: "json",
            success: function (Response) {
                var Message = Response.Message;
                alert(Message);
                Fetch_Holidays(1,"Holiday_List");
            },
            error: function (xhr, status, error) {
            console.error("An error occurred while fetching the product list:", xhr.responseText);
            }
        })
    }
};

function Update_Holiday(Event){
    Event.preventDefault();
    var Updated_Occasion = $("#Updated_Occasion").val();
    var Updated_Date = $("#Updated_Date").val();

    $.ajax({
        type : "POST",
        url : "Update_Holiday.php",
        data : {Updated_Occasion : Updated_Occasion , Updated_Date : Updated_Date},
        dataType : "json",
        success : function(Response){
            var Key = Response.Key;
            alert(Key);
            Fetch_Holidays(1,"Holiday_List");
        },
        error: function (xhr, status, error) {
            console.error("An error occurred while fetching the product list:", xhr.responseText);
        }
    });
}


function Attendance_Table(ID,Module_Name){
    Get_Module_Permission(ID, Module_Name).then(function(Permission_Response) {
        var Add_Permission = Permission_Response.Add_Permission;
        var View_Permission = Permission_Response.View_Permission;
        var Update_Permission = Permission_Response.Update_Permission;
        var Selected_Date = $("#Selected_Date").val();
        var Attendance_Table = $("#Attendance_Table");
        Attendance_Table.empty();
        var Check_Box_Visibility;
        var Check_Box_Status;
        $.ajax({
            type: "POST",
            url: "View_Attendance.php",
            dataType: "json",
            data : {Selected_Date : Selected_Date},
            success: function (Response) {
                if (Response.Employees_Array) {
                    var Employees_Array = Response.Employees_Array;
                    var Employees_Array_Length = Employees_Array.length;
                    for (var i = 0; i < Employees_Array_Length; i++) {
                        var Employees = Employees_Array[i];
                        var Employee_ID = Employees.Employee_ID;
                        var Employee_Name = Employees.Employee_Name;
                        var Status = Employees.Status;
                        var Morning = Employees.Morning;
                        var Evening = Employees.Evening;
                        var Day_Type = Employees.Day_Type;
                        Check_Box_Status = (Morning == "Present" || Evening == "Present") ? "checked" : "";
                        if (Update_Permission == "Default True" || Update_Permission == "True") {
                            Check_Box_Visibility =  "";
                            $("#Save_Button").show();
                            setMaxToToday();
                        }
                        else{
                            setDatePickerToToday();
                            Check_Box_Visibility = "disabled";
                        }
                        if (Add_Permission == "Default True" || Add_Permission == "True") {
                            var currentTime = new Date();
                            var currentHour = currentTime.getHours();
                            if (Status == "No data" && Day_Type == "Working"){
                                if(currentHour >= 17){
                                    Check_Box_Visibility = "";
                                    $("#Save_Button").show();
                                    $( "#Save_Button" ).on( "click", function() {
                                        location.reload();
                                      } );
                                }
                                else{
                                    $("#Save_Button").hide();
                                }
                            }
                            
                        }else{
                            Check_Box_Visibility = "disabled";
                        }
                    
                        if(View_Permission == "Default True" || View_Permission == "True"){
                        var HTML = "<tr><td class='px-5 py-5 border-b border-gray-200 bg-white text-sm'><p class='text-gray-900 whitespace-no-wrap'>"+Employee_ID+"</p></td>";
                        HTML+= "<td class='px-5 py-5 border-b border-gray-200 bg-white text-sm'><p class='text-gray-900 whitespace-no-wrap'>"+Employee_Name+"</p></td>";
                        HTML+= "<td class='px-5 py-5 border-b border-gray-200 bg-white text-sm'><input type='checkbox' class='checkbox text-gray-900 whitespace-no-wrap' data-id="+Employee_ID+" data-column='Morning' class='mr-2'"+Check_Box_Visibility+" "+Check_Box_Status+"></td>";
                        HTML+= "<td class='px-5 py-5 border-b border-gray-200 bg-white text-sm'><input type='checkbox' class='checkbox text-gray-900 whitespace-no-wrap' data-id="+Employee_ID+" data-column='Evening' class='mr-2'"+Check_Box_Visibility+" "+Check_Box_Status+"></td></tr>";
                        }
                        Attendance_Table.append(HTML);
                    }
                }
                else {
                    console.error("Unexpected response format:", Response);
                }
            },
            error: function (xhr, status, error) {
                console.error("An error occurred", xhr.responseText);
            }
        });
    })
}

function setDatePickerToToday() {
    var today = new Date().toISOString().split('T')[0];
    $('#Selected_Date').attr({
        'min': today,
        'max': today,
        'value': today
    });
}

function setMaxToToday() {
    var today = new Date().toISOString().split('T')[0];
    $('#Selected_Date').attr({
        'max': today,
        'value': today
    });
}

function Insert_Attendance(Event){
    Event.preventDefault;
    var Selected_Date = $("#Selected_Date").val();
    var Attendance = {};
    $('.checkbox').each(function() {
        var Employee_ID = $(this).data('id');
        var Column_Name = $(this).data('column');
        
        if (!Attendance[Employee_ID]) {
            Attendance[Employee_ID] = {Employee_ID : Employee_ID, Morning: '', Evening: '' };
        }

        if(Column_Name == "Morning"){
            Attendance[Employee_ID].Morning = $(this).is(':checked') ? 'Present' : 'Absent';
        }
    
        if(Column_Name == "Evening"){
            Attendance[Employee_ID].Evening = $(this).is(':checked') ? 'Present' : 'Absent';
        }
    });

    $.ajax({
        type: 'POST',
        url: 'Insert_Attendance.php',
        dataType:'json',
        data: {Attendance : Attendance ,Selected_Date : Selected_Date},
        success: function(Response) {
            var Status = Response.Status;
            var Added_Date = Response.Added_Date;
            alert('Status : '+ Status);
            document.getElementById('Selected_Date').value = Added_Date;
        },
        error: function(xhr, status, error) {
            console.error('Error updating status:', error);
        }
    });
}


function View_Attendance_Report(ID,Module_Name){
    Get_Module_Permission(ID, Module_Name).then(function(Permission_Response) {
        var Add_Permission = Permission_Response.Add_Permission;
        var View_Permission = Permission_Response.View_Permission;
        var Update_Permission = Permission_Response.Update_Permission;
        var Delete_Permission = Permission_Response.Delete_Permission;

        var Selected_Month = document.getElementById('Selected_Month').value;
        var Selected_Year = document.getElementById('Selected_Year').value;
        var From_Date = document.getElementById('From_Date').value;
        var To_Date = document.getElementById('To_Date').value;
        var Attendance_Report = $("#Attendance_Report");
        Attendance_Report.empty();
        $.ajax({
            type : "POST",
            dataType : "json",
            url : "View_Attendance_Report.php",
            data : {Selected_Month : Selected_Month ,Selected_Year : Selected_Year, From_Date : From_Date , To_Date : To_Date},
            success: function(Response){
                if (Response.Employees_Array) {
                    var Employees_Array = Response.Employees_Array;
                    var Employees_Array_Length = Employees_Array.length;
                    for (var i = 0; i < Employees_Array_Length; i++) {
                        var Employees = Employees_Array[i];
                        var ID = Employees.ID;
                        var Employee_ID = Employees.Employee_ID;
                        var Employee_Name = Employees.Employee_Name;
                        var Working_Days = Employees.Working_Days;
                        var Present_Days = Employees.Present_Days;
                        var Available_Leave = Employees.Available_Leave;
                        var Loss_Of_Pay = Employees.Loss_Of_Pay;
                        if(View_Permission == "Default True" || View_Permission == "True"){
                            var HTML = "<tr><td class='px-3 py-3 border-b border-gray-200 bg-white text-sm'><p class='text-gray-900 whitespace-no-wrap'>"+Employee_ID+"</p></td>";
                            HTML += "<td class='px-3 py-3 border-b border-gray-200 bg-white text-sm'><p class='text-gray-900 whitespace-no-wrap'>"+Employee_Name+"</p></td>";
                            HTML += "<td class='px-3 py-3 border-b border-gray-200 bg-white text-sm'><p class='text-gray-900 whitespace-no-wrap'>"+Present_Days+"</p></td>";
                            HTML += "<td class='px-3 py-3 border-b border-gray-200 bg-white text-sm'><p class='text-gray-900 whitespace-no-wrap'>"+Working_Days+"</p></td>";
                            HTML += "<td class='px-3 py-3 border-b border-gray-200 bg-white text-sm'><p class='text-gray-900 whitespace-no-wrap'>"+Available_Leave+"</p></td>";
                            HTML += "<td class='px-3 py-3 border-b border-gray-200 bg-white text-sm'><p class='text-gray-900 whitespace-no-wrap'>"+Loss_Of_Pay+"</p></td>";
                            HTML += "<td class='px-3 py-3 border-b border-gray-200 bg-white text-sm'><button onclick='window.location.href=\"Employee_Salary_Table.php?ID=" + ID + "\"' class='w-auto bg-blue-500 text-white px-4 py-2 rounded-lg hover:bg-blue-600 focus:outline-none focus:ring-2 focus:ring-blue-500 focus:ring-opacity-50 mr-2'>View</button></td></tr>";
                        }
                        Attendance_Report.append(HTML);
                    }
                }
            },
            error: function(xhr, status, error) {
                console.error("Unexpected response format:",xhr.responseText);
            }
        });
    })
}

function Get_Single_Report(ID){
    var Employee_ID_Field = $("#Employee_ID");
    var Employee_Name_Field = $("#Employee_Name");
    var Monthly_Salary_Field = $("#Monthly_Salary");
    var Present_Days_Field = $("#Present_Days");
    var Working_Days_Field = $("#Working_Days");
    var Loss_Of_Pay_Field = $("#Loss_Of_Pay");
    var Salary_Field = $("#Salary");
    var Incentive_Field = $("#Incentive");

    $.ajax({
        type : "POST",
        data : {ID : ID},
        dataType: "json",
        url : "Get_Single_Report.php",
        success: function(Response){
            if (Response.Single_Info_Array) {
                var Single_Info_Array = Response.Single_Info_Array;
                var Single_Info_Array_Length = Single_Info_Array.length;
                for (var i = 0; i < Single_Info_Array_Length; i++) {
                    var Employees = Single_Info_Array[i];
                    var Employee_ID = Employees.Employee_ID;
                    var Monthly_Salary = Employees.Monthly_Salary;
                    var Employee_Name = Employees.Employee_Name;
                    var Working_Days = Employees.Working_Days;
                    var Present_Days = Employees.Present_Days;
                    var Available_Leave = Employees.Available_Leave;
                    var Monthly_LOP = Employees.Monthly_LOP;
                    Employee_ID_Field.val(Employee_ID);
                    Employee_Name_Field.val(Employee_Name);
                    Monthly_Salary_Field.val(Monthly_Salary);
                    Present_Days_Field.val(Present_Days);
                    Working_Days_Field.val(Working_Days);
                    //Available_Leave_Field.val(Available_Leave);
                    Loss_Of_Pay_Field.val(Monthly_LOP);
                    // var Calculated_LOP = ((Monthly_Salary)/Working_Days)*Monthly_LOP;                    
                    Incentive_Field.on('input', function() {
                        updateSalaryWithIncentive(Monthly_Salary, Working_Days,Monthly_LOP);
                    });
                }
            }
        }
    });
}

function updateSalaryWithIncentive(Monthly_Salary, Working_Days, Monthly_LOP) {
    var Incentive = $("#Incentive").val();
    if (Incentive == "") {
        Incentive = 0;
    }
    Incentive = +Incentive;  // Convert to number

    var Calculated_LOP = ((+Monthly_Salary + Incentive) / +Working_Days) * +Monthly_LOP;
    var Calculated_Salary = (+Monthly_Salary - Calculated_LOP) + Incentive;
    $("#Salary").val(Calculated_Salary.toFixed(2));
}
