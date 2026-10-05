<?php 
if(isset($_GET['uid'])){


    require "../transactions/transact_func.php";
    require_once "../../configs/db_connect.php";
    $conn = new db_connect();
    $books = new book();
    $page = new book_page();
    $bid = $_GET['uid'];
    $result = $books->fetch_book($bid);
    $book = $result->fetch_assoc();

    $bk_lbl = $book['bk_lbl'];
    $customer_id = $book['customer_id'];
    $bk_status = $book['bk_status'];
    $total_pages = $book['total_pages'];
    $current_page = $book['current_page'];
    $total_deposit = $book['total_deposit'];
    $current_balance = $book['current_balance'];
    $created_at = $book['created_at'];
    $last_updated = $book['last_updated'];
    $withdrawal_status = $book['withdrawal_status'];
    $customer = $books->fetch_customer_data($customer_id);
    if(mysqli_num_rows($customer)> 0){
        $data = $customer->fetch_assoc();
         $customer_name = $data['surname']." ".$data['othername'];
    }

    $pages = $page->fetch_page($bid, 0);
    $page_r = $pages->fetch_all(MYSQLI_ASSOC);
     


?>

<!DOCTYPE html>
<html>

<head>

    <meta charset="utf-8">

    <meta name="viewport" content="width=device-width, initial-scale=1">

    <title>Book Details</title>

    <link rel="stylesheet" type="text/css" href="../../style/book/vbook.css">

</head>


<body>


<div class="main-content">

    <div class="page-header">

        <div class="header-left">

            <div class="breadcrumb">

                <a href="book.php" class="back-link">
                    ← Back to Books
                </a>

            </div>


            <div class="title-row">

                <h1>
                    <?php echo $bk_lbl; ?>
                </h1>

                <span class="status-badge">
                    <?php echo $bk_status; ?>
                </span>

            </div>


            <p class="customer-name">

                <?php echo $customer_name; ?>

                <span>•</span>

                <?php echo $bid; ?>

            </p>

        </div>


    <div class="header-actions">

            <a <?php echo 'href="../transactions/deposit.php?uid='.$bid.'"';?> class="btn primary-btn">
                + Deposit
            </a>

            <a  <?php echo 'href="../transactions/withdraw.php?uid='.$bid.'"';?>class="btn secondary-btn">
                Withdrawal
            </a>

            <a href="edit_book.php" class="btn secondary-btn">
                Edit
            </a>

        </div>

    </div>


       <div class="section">


        <div class="section-header">

            <div>

                <h2>
                    Book Information
                </h2>

                <p>
                    Basic information associated with this collection book.
                </p>

            </div>

        </div>


        <div class="information-box">


            <div class="information-item">

                <span>
                    Book ID
                </span>

                <strong>
                    <?php echo $bid; ?>
                </strong>

            </div>


            <div class="information-item">

                <span>
                    Book Label
                </span>

                <strong>
                    <?php echo $bk_lbl; ?>
                </strong>

            </div>


            <div class="information-item">

                <span>
                    Issued To
                </span>

                <strong>
                    <?php echo $customer_name; ?>
                </strong>

            </div>


            <div class="information-item">

                <span>
                    Issued By
                </span>

                <strong>
                    <?php echo "SAVAGE"; ?>
                </strong>

            </div>


            <div class="information-item">

                <span>
                    Date Created
                </span>

                <strong>
                    <?php echo date("Y-m-d", strtotime($created_at)); ?>
                </strong>

            </div>


            <div class="information-item">

                <span>
                    Last Updated
                </span>

                <strong>
                    <?php echo date("Y-m-d", strtotime($last_updated));?>
                </strong>

            </div>


        </div>

    </div>



    <!-- =====================================================
         MAIN FINANCIAL SECTION
         ===================================================== -->

    <div class="main-box">


        <!-- BALANCE -->

        <div class="balance-area">

            <span class="label">
                Current Balance
            </span>


            <h2>
                GH₵ <?php echo $current_balance; ?>
            </h2>


            <div class="money-details">

                <div>

                    <span>
                        Total Deposits
                    </span>

                    <strong>
                        GH₵ <?php echo $total_deposit; ?>
                    </strong>

                </div>


                <div>

                    <span>
                        Total Withdrawals
                    </span>

                    <strong>
                        GH₵ <?php echo $total_deposit - $current_balance; ?>
                    </strong>

                </div>

            </div>

        </div>



        <!-- COLLECTION -->

        <div class="collection-area">

            <div class="collection-top">

                <span class="label">
                    Collection
                </span>

                <strong>
                    <?php echo $current_page." / ".$total_pages; ?>
                </strong>

            </div>


            <div class="progress">

                <div class="progress-bar"></div>

            </div>


            <div class="collection-info">

                <div>

                    <span>
                        Current Page
                    </span>

                    <strong>
                        <?php echo $current_page; ?>
                        of
                        <?php echo $total_pages; ?>
                    </strong>

                </div>


                <div>

                    <span>
                        Withdrawal
                    </span>

                    <strong>
                        <?php echo $withdrawal_status; ?>
                    </strong>

                </div>

            </div>

        </div>

    </div>


    <div class="section">


        <div class="section-header transaction-heading">

            <div>

                <h2>
                   Book Pages
                </h2>

                <p>
                    Pages thet encountered transactions
                </p>

            </div>


            <a href="#" class="view-all">
                View All →
            </a>

        </div>



        <div class="transaction-box">


            <table>

                <thead>

                    <tr>

                        <th>
                            Page Number
                        </th>

                        <th>
                            Fixed Amount
                        </th>

                        <th>
                            Boxes Deposited
                        </th>

                        <th>
                           Boxes withdrawn
                        </th>

                        <th>
                            Balance
                        </th>

                    </tr>

                </thead>


                <tbody>
                    <?php $page->displayPages($page_r); ?>
                </tbody>

            </table>


        </div>


    </div>


</div>


</body>

</html>

<?php } ?>