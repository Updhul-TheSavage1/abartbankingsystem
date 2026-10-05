<?php 
    
    if(isset($_GET['uid'])){

        require "transact_func.php";
        require_once "../../configs/db_connect.php";
         $book_id = $_GET['uid'];
        $conn = new db_connect();
        $book_page = new book_page();
        $transact = new transaction();


         $book = $book_page->fetch_book($book_id);
         $book_r = $book->fetch_assoc();
         $current_page = $book_r['current_page'];
         $book_label = $book_r['bk_lbl'];
         $cid = $book_r['customer_id'];

        $page = $book_page->fetch_page($book_id, $current_page);
      

        if(mysqli_num_rows($page) <= 0 ){
            header("Location: ../books/addpage.php?uid=".$book_id);
        }

            


         $page_r = $page->fetch_assoc();
         $fixed_amount = $page_r['fixed_amount'];
         $boxes_deposited = $page_r['boxes_deposited'];
         $p_num = $page_r['page_number'];
         if($boxes_deposited == 31 && $p_num == 12){

            echo '
            <script>
            if(confirm("Do you want create a new book ?")){
                    window.location.href="../books/addbook.php?uid='.$cid.'";
                }else{
                    window.location.href="../books/viewbook.php?uid='.$book_id.'";
                }
            </script>
            ';
            exit();
          
         }elseif ($boxes_deposited == 31) {
               header("Location: ../books/addpage.php?uid=".$book_id);
         }

         if(isset($_POST['deposit'])){

            $deposit_money = $transact->deposit($_POST, $page_r);

            if(!$deposit_money['check']){
                $error = $deposit_money['error'];
            }else{
                echo '<script>
                        alert("Deposit Successful");
                        window.location.href="../books/viewbook.php?uid='.$book_id.'"
                      </script>';
                        exit();
            }



         }






 ?>


<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Make a Deposit</title>
    <link rel="stylesheet" href="../../style/transaction/deposit.css">
</head>
<body>
<div class="deposit-container">
    <div class="deposit-header">
        <h2>Make a Deposit</h2>
        <p>Record a deposit for this collection book.</p>
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
            <span>Current Page</span>
            <strong><?php echo $current_page ?> / 12</strong>
        </div>
        <div class="info-box">
            <span>Boxes Deposited</span>
            <strong><?php echo $boxes_deposited;?> / 31</strong>
        </div>
    </div>

    <form method="POST" action="">
        <div class="form-group">
            <label for="amount">Deposit Amount</label>
            <div class="amount-box">
                <span>GH₵ </span>
                <input type="number" id="amount" name="amount"  required>
            </div>
        </div>
        <button type="submit" name="deposit" class="deposit-btn">Record Deposit</button>
        <a href="../books/viewbook.php?uid=<?= urlencode((string) $book_id); ?>" class="cancel-btn">Cancel</a>
    </form>
</div>
</body>
</html>
<?php } ?>