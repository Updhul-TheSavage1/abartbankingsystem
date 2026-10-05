<!DOCTYPE html>
<html lang="en">

<head>

    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Dashboard</title>
    <link rel="stylesheet" type="text/css" href="../../style/sidebar.css">
    <link rel="stylesheet" type="text/css" href="../../style/dashboard/adminboard.css">

</head>


<body>

<?php
include "../adincludes/sidebar.php";
require "../../configs/db_connect.php";
/** @var mysqli $conn */

$sql = "SELECT count(customer_id) as cus from customer;";
$r_sql = mysqli_query($conn, $sql);
$row = mysqli_fetch_assoc($r_sql);
$cus = $row['cus'];

$sql = "SELECT SUM(total_deposit) as t_depos from book; ";
$r_sql = mysqli_query($conn, $sql);
$row = mysqli_fetch_assoc($r_sql);
$collections = $row['t_depos'];

$sql = "SELECT count(book_id) as ac from book where bk_status = 'Active';";
$r_sql = mysqli_query($conn, $sql);
$row = mysqli_fetch_assoc($r_sql);
$ac_books = $row['ac'];


?>


<div class="dashboard">

<?php include "../adincludes/header.php" ?>
    <!-- Dashboard Cards -->

    <div class="dashboard-cards">
        <a href="../customer/customer.php">

        <div class="dashboard-card">

            <h3>
                Customers
            </h3>

            <p>
                <?php echo $cus ?>
            </p>

        </div>
    </a>



        <div class="dashboard-card">

            <h3>
                Collection
            </h3>

            <p>
                GH₵ <?php echo $collections;?>
            </p>

        </div>




        <div class="dashboard-card">

            <h3>
                Withdrawal
            </h3>

            <p>
                GH₵5,000
            </p>

        </div>




        <div class="dashboard-card">

            <h3>
                Active Books
            </h3>

            <p>
                <?php echo $ac_books; ?>
            </p>

        </div>




        <div class="dashboard-card">

            <h3>
                Staff Members
            </h3>

            <p>
                25
            </p>

        </div>



    </div>







    <!-- Recent Transactions -->


    <div class="table-container">


        <h2>
            Recent Transactions
        </h2>



        <table>


            <thead>

                <tr>

                    <th>ID</th>

                    <th>Customer</th>

                    <th>Type</th>

                    <th>Amount</th>

                </tr>

            </thead>



            <tbody>


                <tr>

                    <td>
                        TR001
                    </td>

                    <td>
                        John
                    </td>

                    <td>
                        Collection
                    </td>

                    <td>
                        GH₵50
                    </td>

                </tr>




                <tr>

                    <td>
                        TR002
                    </td>

                    <td>
                        Musa
                    </td>

                    <td>
                        Withdrawal
                    </td>

                    <td>
                        GH₵200
                    </td>

                </tr>




            </tbody>


        </table>


    </div>





</div>


</body>

</html>
