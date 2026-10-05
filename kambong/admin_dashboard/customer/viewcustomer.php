<?php

    require "../transactions/transact_func.php";
    require_once "../../configs/db_connect.php";
    $conn = new db_connect();
      $customer = new customer();
      $book = new book();


if(isset($_GET['uid'])){
        $id = $_GET['uid'];
    $customer_data = $customer->fetch_customer_data($id);

    if(mysqli_num_rows($customer_data)> 0){
        $data = $customer_data->fetch_assoc();
    }

    $name = $data['surname']." ".$data['othername'];
    $gender = $data['gender'];
    $phone = $data['phone'];
    $location = $data['location'];
    $by = "System";
    $books = $book->fetch_book($id);
    

    function display(array $data){

        foreach ($data as $row) {
            echo '
            <tr>
                <td>'.$row['book_id'].'</td>
                <td>'.$row['bk_lbl'].'</td>
                <td>'.$row['current_page'].' / '.$row['total_pages'].'</td>
                <td>'.$row['current_balance'].'</td>
                <td>Deposit</td>
                <td>Withdrawal</td>
            </tr>



            ';
        }
       
    }
 
}
?>

<!DOCTYPE html>
<html>
<head>
    <title>Customer Profile</title>
    <link rel="stylesheet" type="text/css" href="../../style/customer/viewcustomer.css">
    <style>
       
    </style>
</head>
<body>
    <div class="profile-container">
        <div class="back-btn-container">
            <a href="customer.php" class="back-btn">← Back to Customers</a>
        </div>

        <h1>Customer Profile</h1>

        <div class="profile-card">
            <div class="card-header">
                <h2>Customer Information</h2>
                <a class="btn" href="updatecustomer.php?uid=<?=$id?>">Edit Profile</a>
            </div>

            <div class="info-grid">
                <p><strong>Customer ID:</strong> <?= htmlspecialchars((string) ($id ?? 'N/A'), ENT_QUOTES, 'UTF-8'); ?></p>
                <p><strong>Full Name:</strong> <?= htmlspecialchars((string) ($name ?? 'N/A'), ENT_QUOTES, 'UTF-8'); ?></p>
                <p><strong>Gender:</strong> <?= htmlspecialchars((string) ($gender ?? 'N/A'), ENT_QUOTES, 'UTF-8'); ?></p>
                <p><strong>Phone:</strong> <?= htmlspecialchars((string) ($phone ?? 'N/A'), ENT_QUOTES, 'UTF-8'); ?></p>
                <p><strong>Location:</strong> <?= htmlspecialchars((string) ($location ?? 'N/A'), ENT_QUOTES, 'UTF-8'); ?></p>
                <p><strong>Created By:</strong> <?= htmlspecialchars((string) ($by ?? 'System'), ENT_QUOTES, 'UTF-8'); ?></p>
            </div>
        </div>

        <div class="profile-card">
            <div class="card-header">
                <h2>Collection Books</h2>
                <a class="btn" href="../books/addbook.php?uid=<?= htmlspecialchars((string) ($id ?? ''), ENT_QUOTES, 'UTF-8'); ?>">+ Create Collection Book</a>
            </div>

            <table> 
                    <thead>
                        <tr>
                            <th>Book ID</th>
                            <th>Book Label</th>
                            <th>Current Page</th>
                            <th>Balance</th>
                            <th colspan="3">Action</th>
                        </tr>
                    </thead>

            
                    <tbody>
                        
                          <?php

                            if(mysqli_num_rows($books)){
                                $bks = $books->fetch_all(MYSQLI_ASSOC);
                                display($bks);

                            }else{
                                echo '<p>No collection books found for this customer.</p>';


                            }
                
                        ?>
                 </tbody>
            </table>
        </div>
    </div>
</body>
</html>
