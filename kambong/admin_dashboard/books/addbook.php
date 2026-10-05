<?php 
  

if(isset($_GET['uid'])){
    require "../transactions/transact_func.php";
    require_once "../../configs/db_connect.php";
    $conn = new db_connect();
    $customers = new customer();
     $cid = $_GET['uid'];
     $customer = $customers->fetch_customer_data($cid);
     if(mysqli_num_rows($customer) > 0){
        $data = $customer->fetch_assoc();
         $name = $data['surname']." ".$data['othername'];
     }
    


     if(isset($_POST['new_book'])){
        $books = new book();
        $book = $books->new_book($_POST);
        if ($book["check"]) {

            $id = $book['id'];
            header("location: viewbook.php?uid=".$id);
            exit();
            
        }elseif($book['check'] == false && empty($book['error'])){
            header("location: addbook.php?uid=".$cid);
            exit();

        }else{
            $error = $book['error'];
            $book_label = $book['book_label'];
        }
     }

   



?>
<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Create Book</title>
    <link rel="stylesheet" type="text/css" href="../../style/book/addbook.css">
    
    <style>
        
    </style>
</head>
<body>

    <script>
        function bckfn(){
            window.location = "../customer/customer.php";
        }
    </script>

    <form method="POST" action="" class="book-form">
        <div class="back-btn-container">
            <button type="button" onclick="bckfn()" class="back-btn">← Go Back</button>
        </div>
        
        <h2>Create Book</h2>

        <?php 
            if(isset($_POST['new_book'])){
                if(!empty($error)){
                echo '<p class="error">'.$error.'</p>'; 
            }
            }

         ?>

        <div class="form-group">
            <label for="bk_lbl">Book Label</label>
            <input type="text" name="book_label" id="bk_lbl" maxlength="15" value="<?=isset($_POST['new_book'])? $book_label : ''?>">
        </div>

        <div class="form-group">
            <label for="issued_to">Issued To</label>
            <select name="customer_id" id="issued_to" required>
                <option value="<?=isset($_GET['uid'])? $cid : ''?>"><?=isset($_GET['uid'])? $name:''?></option>
            </select>
        </div>

        <div class="form-group">
            <label for="iss_dat">Date Issued</label>
            <input type="date" name="issue_date" id="iss_date" value="<?= date('Y-m-d'); ?>" required>
        </div>

        <div class="form-buttons">
            <button type="submit" name="new_book" class="btn btn-primary">
                Create Book
            </button>

            <button type="reset" class="btn btn-secondary">
                Clear
            </button>
        </div>
    </form>

</body>
</html>
<?php } ?>
