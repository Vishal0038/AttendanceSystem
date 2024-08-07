<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Employee Holidays</title>
    <link rel="stylesheet" href="styles.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.1/css/all.min.css" />
		<meta name="viewport" content="width=device-width, initial-scale=1.0">
        <link href="https://cdn.jsdelivr.net/npm/daisyui@4.4.24/dist/full.min.css" rel="stylesheet" type="text/css" />
        <link href="https://cdnjs.cloudflare.com/ajax/libs/flowbite/2.2.1/flowbite.min.css" rel="stylesheet" />
        <script src="https://cdn.tailwindcss.com"></script>
	    <link href="https://unpkg.com/tailwindcss@1.2.0/dist/tailwind.min.css" rel="stylesheet">
        <script src="https://cdn.jsdelivr.net/gh/alpinejs/alpine@2.x.x/dist/alpine.js" defer></script>
        <link rel="stylesheet" href="https://unpkg.com/@themesberg/flowbite@1.2.0/dist/flowbite.min.css"/>
</head>
<body class = "body bg-white dark:bg-[#0F172A]">
    <!-- Main modal -->
    <div x-data="{ Update_Holiday_Modal: false }">
        
    <!-- Modal -->
    <div x-show="Update_Holiday_Modal" class="fixed inset-0 flex items-center justify-center z-50">
            <div class="bg-white rounded-lg p-6 w-96 max-w-full shadow-lg transform transition-all duration-300" x-show.transition.opacity="Update_Holiday_Modal">
                <!-- Modal Header -->
                <div class="flex justify-between items-center border-b-2 border-gray-200 pb-4">
                    <h2 class="text-2xl font-semibold">Update Holiday</h2>
                    <button @click="Update_Holiday_Modal = false" class="text-gray-500 hover:text-gray-700 focus:outline-none">
                        <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="feather feather-x">
                            <line x1="18" y1="6" x2="6" y2="18"></line>
                            <line x1="6" y1="6" x2="18" y2="18"></line>
                        </svg>
                    </button>
                </div>
                
                <!-- Modal Content -->
                <div class="mt-6 space-y-4">
                    <label for="Updated_Date" class="block dark:text-white text-gray-700 text-sm font-semibold mb-2">Holiday Date</label>
                    <input type="date" id="Updated_Date" class="form-input w-full px-4 py-2 border rounded-lg text-gray-700 focus:ring-blue-500" readonly>
                    <label for="Updated_Occasion" class="block dark:text-white text-gray-700 text-sm font-semibold mb-2">Holiday Occasion</label>
                    <input type="text"  id="Updated_Occasion" class="form-input w-full px-4 py-2 border rounded-lg text-gray-700 focus:ring-blue-500" required>
                    <div class="flex flex-col space-y-4">
                        <button onclick="Update_Holiday(event)" @click="Update_Holiday_Modal = false" class="bg-green-500 text-white px-4 py-2 rounded-lg hover:bg-blue-600 transition duration-300 focus:outline-none">Save</button>
                        </div>
                </div>
            </div>
        </div>
    <div class = "fixed w-full z-30 flex bg-white dark:bg-[#0F172A] p-2 items-center justify-center h-16 px-10">
        <div class = "logo ml-12 dark:text-white transform ease-in-out duration-500 flex-none h-full flex items-center justify-center">
            LISLIP 
        </div>
        <!-- SPACER -->
        <div class = "grow h-full flex items-center justify-center"></div>
        <div class = "flex-none h-full text-center flex items-center justify-center">
            
                <div class = "flex space-x-3 items-center px-3">
                    <div class = "flex-none flex justify-center">
                    <div class="w-8 h-8 flex ">
                    <img src="https://encrypted-tbn0.gstatic.com/images?q=tbn:ANd9GcShta_GXR2xdnsxSzj_GTcJHcNykjVKrCBrZ9qouUl0usuJWG2Rpr_PbTDu3sA9auNUH64&usqp=CAU" alt="profile" class="shadow rounded-full object-cover" />

                    </div>
                    </div>

                    <div class = "hidden md:block text-sm md:text-md text-black dark:text-white">ADMIN</div>
                </div>
        </div>
    </div>
    <aside class = "w-60 -translate-x-48 fixed transition transform ease-in-out duration-1000 z-50 flex h-screen bg-[#1E293B] ">
        <!-- open sidebar button -->

        <div class = "max-toolbar translate-x-24 scale-x-0 w-full -right-6 transition transform ease-in duration-300 flex items-center justify-between border-4 border-white dark:border-[#0F172A] bg-[#1E293B]  absolute top-2 rounded-full h-12">
            
            <div class="flex pl-4 items-center space-x-2 ">
                <div>
                <div onclick="setDark('dark')" class="moon text-white hover:text-blue-500 dark:hover:text-[#38BDF8]">
                    <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" strokeWidth={3} stroke="currentColor" class="w-4 h-4">
                        <path strokeLinecap="round" strokeLinejoin="round" d="M21.752 15.002A9.718 9.718 0 0118 15.75c-5.385 0-9.75-4.365-9.75-9.75 0-1.33.266-2.597.748-3.752A9.753 9.753 0 003 11.25C3 16.635 7.365 21 12.75 21a9.753 9.753 0 009.002-5.998z" />
                    </svg>
                </div>
                <div onclick="setDark('light')" class = "sun hidden text-white hover:text-blue-500 dark:hover:text-[#38BDF8]">
                    <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="w-4 h-4">
                        <path stroke-linecap="round" stroke-linejoin="round" d="M12 3v2.25m6.364.386l-1.591 1.591M21 12h-2.25m-.386 6.364l-1.591-1.591M12 18.75V21m-4.773-4.227l-1.591 1.591M5.25 12H3m4.227-4.773L5.636 5.636M15.75 12a3.75 3.75 0 11-7.5 0 3.75 3.75 0 017.5 0z" />
                      </svg>                      
                </div>
            </div >
                <div class = "text-white hover:text-blue-500 dark:hover:text-[#38BDF8]">
                    <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" strokeWidth={3} stroke="currentColor" class="w-4 h-4">
                        <path strokeLinecap="round" strokeLinejoin="round" d="M14.857 17.082a23.848 23.848 0 005.454-1.31A8.967 8.967 0 0118 9.75v-.7V9A6 6 0 006 9v.75a8.967 8.967 0 01-2.312 6.022c1.733.64 3.56 1.085 5.455 1.31m5.714 0a24.255 24.255 0 01-5.714 0m5.714 0a3 3 0 11-5.714 0" />
                    </svg>
                </div>
            </div>
            <div  class = "flex items-center space-x-3 group bg-gradient-to-r dark:from-cyan-500 dark:to-blue-500 from-indigo-500 via-purple-500 to-purple-500  pl-10 pr-2 py-1 rounded-full text-white  ">
                <div class= "transform ease-in-out duration-300 mr-12">
                    LISLIP
                </div>
            </div>
        </div>
        <div onclick="openNav()" class = "-right-6 transition transform ease-in-out duration-500 flex border-4 border-white dark:border-[#0F172A] bg-[#1E293B] dark:hover:bg-blue-500 hover:bg-purple-500 absolute top-2 p-3 rounded-full text-white hover:rotate-45">
            <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" strokeWidth={3} stroke="currentColor" class="w-4 h-4">
                <path strokeLinecap="round" strokeLinejoin="round" d="M3.75 6A2.25 2.25 0 016 3.75h2.25A2.25 2.25 0 0110.5 6v2.25a2.25 2.25 0 01-2.25 2.25H6a2.25 2.25 0 01-2.25-2.25V6zM3.75 15.75A2.25 2.25 0 016 13.5h2.25a2.25 2.25 0 012.25 2.25V18a2.25 2.25 0 01-2.25 2.25H6A2.25 2.25 0 013.75 18v-2.25zM13.5 6a2.25 2.25 0 012.25-2.25H18A2.25 2.25 0 0120.25 6v2.25A2.25 2.25 0 0118 10.5h-2.25a2.25 2.25 0 01-2.25-2.25V6zM13.5 15.75a2.25 2.25 0 012.25-2.25H18a2.25 2.25 0 012.25 2.25V18A2.25 2.25 0 0118 20.25h-2.25A2.25 2.25 0 0113.5 18v-2.25z" />
            </svg>
        </div>
        <!-- MAX SIDEBAR-->
        <div class= "max hidden text-white mt-20 flex-col space-y-2 w-full h-[calc(100vh)]">
            <div class =  "hover:ml-4 w-full text-white hover:text-purple-500 dark:hover:text-blue-500 bg-[#1E293B] p-2 pl-8 rounded-full transform ease-in-out duration-300 flex flex-row items-center space-x-3">
                <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" strokeWidth={1.5} stroke="currentColor" class="w-4 h-4">
                    <path strokeLinecap="round" strokeLinejoin="round" d="M2.25 12l8.954-8.955c.44-.439 1.152-.439 1.591 0L21.75 12M4.5 9.75v10.125c0 .621.504 1.125 1.125 1.125H9.75v-4.875c0-.621.504-1.125 1.125-1.125h2.25c.621 0 1.125.504 1.125 1.125V21h4.125c.621 0 1.125-.504 1.125-1.125V9.75M8.25 21h8.25" />
                </svg>    
                <div>
                    Home
                </div>
            </div>
            <div class =  "hover:ml-4 w-full text-white hover:text-purple-500 dark:hover:text-blue-500 bg-[#1E293B] p-2 pl-8 rounded-full transform ease-in-out duration-300 flex flex-row items-center space-x-3">
                <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="w-4 h-4">
                    <path stroke-linecap="round" stroke-linejoin="round" d="M3.75 5.25h16.5m-16.5 4.5h16.5m-16.5 4.5h16.5m-16.5 4.5h16.5" />
                </svg>                      
                <div>
                    Employee Details
                </div>
            </div>
            <div class =  "hover:ml-4 w-full text-white hover:text-purple-500 dark:hover:text-blue-500 bg-[#1E293B] p-2 pl-8 rounded-full transform ease-in-out duration-300 flex flex-row items-center space-x-3">
                <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="w-4 h-4">
                    <path stroke-linecap="round" stroke-linejoin="round" d="M10.5 6a7.5 7.5 0 107.5 7.5h-7.5V6z" />
                    <path stroke-linecap="round" stroke-linejoin="round" d="M13.5 10.5H21A7.5 7.5 0 0013.5 3v7.5z" />
                </svg>                      
                <div>
                    Attendance
                </div>
            </div>
            <div class =  "hover:ml-4 w-full text-white hover:text-purple-500 dark:hover:text-blue-500 bg-[#1E293B] p-2 pl-8 rounded-full transform ease-in-out duration-300 flex flex-row items-center space-x-3">
                <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="w-4 h-4">
                    <path stroke-linecap="round" stroke-linejoin="round" d="M10.5 6a7.5 7.5 0 107.5 7.5h-7.5V6z" />
                    <path stroke-linecap="round" stroke-linejoin="round" d="M13.5 10.5H21A7.5 7.5 0 0013.5 3v7.5z" />
                </svg>                      
                <div>
                    Holiday List
                </div>
            </div>
        </div>
        <!-- MINI SIDEBAR-->
        <div class= "mini mt-20 flex flex-col space-y-2 w-full h-[calc(100vh)]">
            <div class= "hover:ml-4 justify-end pr-5 text-white hover:text-purple-500 dark:hover:text-blue-500 w-full bg-[#1E293B] p-3 rounded-full transform ease-in-out duration-300 flex">
                <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" strokeWidth={1.5} stroke="currentColor" class="w-4 h-4">
                    <path strokeLinecap="round" strokeLinejoin="round" d="M2.25 12l8.954-8.955c.44-.439 1.152-.439 1.591 0L21.75 12M4.5 9.75v10.125c0 .621.504 1.125 1.125 1.125H9.75v-4.875c0-.621.504-1.125 1.125-1.125h2.25c.621 0 1.125.504 1.125 1.125V21h4.125c.621 0 1.125-.504 1.125-1.125V9.75M8.25 21h8.25" />
                </svg>                  
            </div>
            <div class= "hover:ml-4 justify-end pr-5 text-white hover:text-purple-500 dark:hover:text-blue-500 w-full bg-[#1E293B] p-3 rounded-full transform ease-in-out duration-300 flex">
                <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="w-4 h-4">
                    <path stroke-linecap="round" stroke-linejoin="round" d="M3.75 5.25h16.5m-16.5 4.5h16.5m-16.5 4.5h16.5m-16.5 4.5h16.5" />
                </svg>                 
            </div>
            <div class= "hover:ml-4 justify-end pr-5 text-white hover:text-purple-500 dark:hover:text-blue-500 w-full bg-[#1E293B] p-3 rounded-full transform ease-in-out duration-300 flex">
                <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="w-4 h-4">
                    <path stroke-linecap="round" stroke-linejoin="round" d="M10.5 6a7.5 7.5 0 107.5 7.5h-7.5V6z" />
                    <path stroke-linecap="round" stroke-linejoin="round" d="M13.5 10.5H21A7.5 7.5 0 0013.5 3v7.5z" />
                </svg>           
            </div>
        </div>        
    </aside>
    <!-- CONTENT -->
    <div class = "content ml-12 transform ease-in-out duration-500 pt-20 px-2 md:px-5 pb-4 ">
        <h1 class="text-2xl font-bold text-center mb-10 dark:text-white">View Holidays</h1>
        <div class="flex flex-row flex-wrap justify-between items-start">
            <div class="overflow-hidden flex items-center justify-end">
                <div id="Add_Holiday" class="flex items-start justify-center from-teal-100 via-teal-300 to-teal-500 hidden">
                    <input type="date" id="Holiday_Date" name="Holiday_Date" min="<?php echo date("Y-m-d")?>" class="sm:w-half lg:w-full md:w-full px-4 py-2 border rounded-lg text-gray-700 custom-placeholder focus:ring-blue-500" required placeholder="Holiday Date">
                    <input type="text" id="Holiday_Occasion" name="Holiday_Occasion" class="sm:w-half ml-2 md:w-full lg:w-full px-4 py-2 border rounded-lg text-gray-700 custom-placeholder focus:ring-blue-500" required placeholder="Holiday Occasion">
                    <button onclick="Add_Holiday()" class="sm:w-half sm:py-2 px-3 md:px-2 md:w-full lg:w-full py-1 md:py-2 bg-blue-500 border border-white text-white rounded-lg hover:bg-blue-700 hover:text-white ml-3 focus:outline-none">Add Holiday</button>
                </div>
                
            </div>
            <div class="overflow-hidden flex items-center justify-start">
                <div class="relative text-gray-600">
                    <select id="Selected_Month" class="sm:mt-10 bg-white-400 h-10 px-5 pr-10 rounded-full text-sm focus:outline-none lg:w-40 lg:mt-0" onchange="Fetch_Holidays(1,'Holiday_List')">
                    <option value="">Search by Month</option>
                    <option value="1">January</option>
                    <option value="2">February</option>
                    <option value="3">March</option>
                    <option value="4">April</option>
                    <option value="5">May</option>
                    <option value="6">June</option>
                    <option value="7">July</option>
                    <option value="8">August</option>
                    <option value="9">September</option>
                    <option value="10">October</option>
                    <option value="11">November</option>
                    <option value="12">December</option>
                    </select>
                    <select id="Selected_Year" class="ml-5 bg-white-400 h-10 px-5 pr-10 rounded-full text-sm focus:outline-none" onchange="Fetch_Holidays(1,'Holiday_List')">
                    <option value="">Search by Year</option>
                    <option value="2023">2023</option>
                    <option value="2024">2024</option>
                    <option value="2025">2025</option>
                    <option value="2026">2026</option>
                    <option value="2027">2027</option>
                    <option value="2028">2028</option>
                    </select>
                </div>
            </div>
        </div>
        <table class="min-w-full leading-normal table-auto mt-10">
        <thead>
            <tr>
                <th class="px-3 py-3 border-b-2 border-gray-200 bg-gray-100 text-center text-xs font-semibold text-gray-600 uppercase tracking-normal">
                    Date
                </th>
                <th class="py-3 border-b-2 border-gray-200 bg-gray-100 text-center text-xs font-semibold text-gray-600 uppercase tracking-normal">
                    Holiday Day
                </th>
                <th class="py-3 border-b-2 border-gray-200 bg-gray-100 text-center text-xs font-semibold text-gray-600 uppercase tracking-normal">
                    Holiday Occasion    
                </th>
                <th id="Action" class="py-3 border-b-2 border-gray-200 bg-gray-100 text-left text-xs font-semibold text-gray-600 uppercase tracking-normal hidden">
                    Action
                </th>
            </tr>
        </thead>   
        <tbody id="Holiday_List" class="min-w-full leading-normal table-auto">
        </tbody>
        </div>
    </div>
    </table> 
</div>
</body>
<script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.7.1/jquery.min.js"></script>
<script src="https://unpkg.com/@themesberg/flowbite@1.2.0/dist/flowbite.bundle.js"></script>
<script src="app.js"></script>
<script>
    const currentDate = new Date();
    const currentMonth = currentDate.getMonth()+1;
    const currentYear = currentDate.getFullYear();
    document.getElementById('Selected_Month').value = currentMonth;
    document.getElementById('Selected_Year').value = currentYear;
    $(document).ready(function(){
        Fetch_Holidays(1,"Holiday_List");
    })
    </script>
    <script>Get_Module_Permission(1,"Holiday_List")</script>
</html>


