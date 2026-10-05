<?php 
    
    if(isset($_GET['uid'])){

        require "transact_func.php";
        require_once "../../configs/db_connect.php";
        $book_id = $_GET['uid'];
        $conn = new db_connect();
        $book_page = new book_page();
        $transact = new transaction();
        $book_id = $_GET['uid'];

        $page = $book_page->fetch_page($book_id, -2);
        $book = $book_page->fetch_book($book_id);

        if(mysqli_num_rows($page) <= 0){
            echo '<script>alert("Insufficient Funds");
                 window.location.href="../books/viewbook.php?uid='.$book_id.'";
                 </script>';
                 exit();
        }

        $page_r = $page->fetch_assoc();
        $book_r = $book->fetch_assoc();
        $customer_id = $book_r['book_id'];
        $book_label = $book_r['bk_lbl'];
        $boxes_withdrawn = $page_r['boxes_withdrawn'];
        $boxes_deposited = $page_r['boxes_deposited'];
        $current_withdrawal_page = $page_r['page_number'];
        $fixed_amount = $page_r['fixed_amount'];

        if(isset($_POST['withdraw'])){

        }


?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Withdraw</title>
    <link rel="stylesheet" href="../../style/transaction/deposit.css">
</head>
<body>
<div class="deposit-container">
    <div class="deposit-header">
        <h2>Withdraw</h2>
        <p>withdraw money from this collection book.</p>
    </div>
        <?php 
        if(isset($_POST['deposit']) && isset($error)){
            echo $error;
        } ?>
    <div class="book-info">
        <div class="info-box">
            <span>BOOK(<?php echo $book_id; ?>)</span>
            <strong><?php echo $book_label; ?></strong>
        </div>
          <div class="info-box">
            <span>Fixed Amount</span>
            <strong><?php echo $fixed_amount; ?></strong>
        </div>
        <div class="info-box">
            <span>Current withdrawal Page</span>
            <strong><?php echo $current_withdrawal_page; ?> / 12</strong>
        </div>
        <div class="info-box">
            <span>Boxes Withdrawn</span>
            <strong><?php echo $boxes_withdrawn; ?> / 30</strong>
        </div>
    </div>

    <form method="POST" action="">
        <div class="form-group">
            <label for="amount">Withdrawal Amount</label>
            <div class="amount-box">
                <span>GH₵ </span>
                <input type="number" id="amount" name="amount"  required>
            </div>
        </div>
        <button type="submit" name="deposit" class="deposit-btn">Withdraw</button>
        <a href="../books/viewbook.php?uid=<?= urlencode((string) $book_id); ?>" class="cancel-btn">Cancel</a>
    </form>
</div>
</body>
</html>
<?php } ?>