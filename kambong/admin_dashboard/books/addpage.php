<?php
    require "../transactions/transact_func.php";
    require_once "../../configs/db_connect.php";
    $conn = new db_connect();
    $books = new book();
    $book_page = new book_page();
if(isset($_GET['uid'])){
    $bk_id = $_GET['uid'];

    $book_d = $books->fetch_book($bk_id);
    $result = $book_d->fetch_assoc();
    $customer_id = $result['customer_id'];
    $book_id = $result['book_id'];
    $book_label = $result['bk_lbl'];

    $customer = $books->fetch_customer_data($customer_id);
    $customer_info = $customer->fetch_assoc();

    $name = $customer_info['surname'].' '.$customer_info['othername'];

    

}else{
  header('location: book.php');
}

?>
<html>
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <title>Add Page</title>
        <link rel="stylesheet" type="text/css" href="../../style/book/addbook.css">
    </head>
    <?php
    if(isset($_POST['addpage'])){
        $new_page = $book_page->new_page($_POST);

        if($new_page['check']){
           header("location: ../transactions/deposit.php?uid=".$book_id);
            exit();

        }
        $error = $new_page['error'];
        $fixed_amout = $new_page['fixed_amount'];
        echo $error;
       
    }
    
    ?>
    <script>
        function bckfn(){
            window.history.go(-1);
        }
    </script>

    <body>

      
        <form method="POST" action="" class="book-form">
            <div class="back-btn-container">
                <button type="button" onclick="bckfn()" class="back-btn">← Go Back</button>
            </div>
              <h2>Add Page</h2>

            <div class="form-group">
                 <label for="bk_lbl">Book Label (<?php echo $book_id; ?>)</label>
                <select type="text" id="bk_lbl" name="book_id" >
                    <option value= "<?php echo $book_id; ?>" ><?php echo $book_label; ?></option>
                 </select>
                
            </div>
            <div class="form-group">
                <label for="customer_name">Customer Name (<?php echo $customer_id; ?>)</label>
                <select type="text"  id="customer_name" name="customer_id" >
                    <option value= "<?php echo $customer_id; ?>"><?php echo $name; ?></option> 
                </select>
            </div>
            <div class="form-group">
                <label for="">Fixed Amount</label>
                <input type="number" name="fixed_amount" step="5" placeholder="00.00" value = "<?php
                        if(isset($_POST['addpage'])){echo $fixed_amout;}elseif(isset($_GET['fixed_amout'])){echo $_GET['fixed_amout'];}else{echo "0";}
                        ?>"  required>
                
            </div>
            

           <div class="form-buttons">
              <button type="submit"  class="btn btn-primary" name="addpage" onclick=" return confirm('Are you sure you want to add this page?')">
                Add Page
              </button> 
              <button type="reset" class="btn btn-secondary">
                Clear
            </button>
           </div>

        
    </body>
</html>