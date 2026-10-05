<?php

include "../includes/sidebar.php";
include "../includes/header.php";

?>

<link rel="stylesheet" type="text/css" href="../toools/style/transaction.css">
<div class="main-content">


    <div class="page-header">


        <h1>
            Staff Management
        </h1>


        <button class="add-btn">
            + Add Staff
        </button>


    </div>





    <div class="search-box">

        <input 
        type="text" 
        placeholder="Search staff member">

    </div>





    <div class="table-container">


        <table>


            <thead>

                <tr>

                    <th>
                        Staff ID
                    </th>

                    <th>
                        Name
                    </th>

                    <th>
                        Role
                    </th>

                    <th>
                        Phone
                    </th>

                    <th>
                        Status
                    </th>

                    <th>
                        Action
                    </th>

                </tr>

            </thead>



            <tbody>


                <tr>

                    <td>
                        <span class="staff-id">
                            ST001
                        </span>
                    </td>


                    <td>
                        Abdul
                    </td>


                    <td>
                        Admin
                    </td>


                    <td>
                        0200000000
                    </td>


                    <td>

                        <span class="status-active">
                            Active
                        </span>

                    </td>


                    <td>

                        <button class="view-btn">
                            View
                        </button>

                    </td>


                </tr>






                <tr>


                    <td>
                        <span class="staff-id">
                            ST002
                        </span>
                    </td>


                    <td>
                        Musa
                    </td>


                    <td>
                        Collector
                    </td>


                    <td>
                        0240000000
                    </td>


                    <td>

                        <span class="status-active">
                            Active
                        </span>

                    </td>


                    <td>

                        <button class="view-btn">
                            View
                        </button>

                    </td>


                </tr>


            </tbody>


        </table>


    </div>




</div>
