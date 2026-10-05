<?php
include "../adincludes/sidebar.php";
include "../adincludes/header.php";

require_once "../../configs/db.php";
/** @var mysqli $conn */

$sql = $conn->prepare("SELECT * FROM transaction");
$r_sql = mysqli_query($conn, $sql);




?>

<link rel="stylesheet" type="text/css" href="../../toools/style/transaction.css">
<div class="main-content">


    <div class="page-header">


        <h1>
            Transactions
        </h1>


        <button class="add-btn">
            + New Transaction
        </button>


    </div>





    <div class="filter-section">


        <select>

            <option>
                All Transactions
            </option>

            <option>
                Collections
            </option>


            <option>
                Withdrawals
            </option>


        </select>



        <input 
        type="text" 
        placeholder="Search customer">


    </div>







    <div class="table-container">


        <table>


            <thead>

                <tr>

                    <th>
                        ID
                    </th>


                    <th>
                        Customer
                    </th>


                    <th>
                        Type
                    </th>


                    <th>
                        Amount
                    </th>


                    <th>
                        Status
                    </th>


                    <th>
                        Date
                    </th>


                    <th>
                        Action
                    </th>


                </tr>


            </thead>




            <tbody>

<?php while ($row = $r_sql->fetch_assoc()){?>
                <tr>


                    <td><?php echo $row['book_id']; ?></td>


                    <td><?php echo $row['customer_id']; ?></td>


                    <td><?php echo $row['transaction_type']; ?></td>


                    <td><?php echo $row['amount']; ?></td>


                    <td><span class="status-completed">Completed</span> </td>


                    <td><?php echo $row['created_at']; ?></td>


                    <td><button class="view-btn">View</button></td>


                </tr>

<?php } ?>

            </tbody>


        </table>


    </div>




</div>
