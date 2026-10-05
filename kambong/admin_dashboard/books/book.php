<?php
    require "../transactions/transact_func.php";
    require_once "../../configs/db_connect.php";
    $conn = new db_connect();
    $books = new book();
    $result = $books->fetch_book(0);


  



     function display_books(array $book, book $books){
        foreach ($book as $row) {
            $customer = $books->fetch_customer_data($row['customer_id']);
            if(mysqli_num_rows($customer) > 0){
             $data = $customer->fetch_assoc();   
            }
            else{
                return false;
            }
            
            $name =$data['surname']." ".$data['othername'];
             $status = strtolower($row['bk_status']);

                                if($status == 'active'){
                                    $status_class = 'active';

                                } elseif($status == 'inactive'){
                                    $status_class = 'inactive';

                                }
             echo '
                        <tr>

                            <td>'.$row['book_id'].'</td>

                            <td>'.$name.'</td>

                            <td>
                                <span class="badge '.$status_class.'">
                                    '.$row['bk_status'].'
                                </span>
                            </td>

                            <td class="action-cell">
                                <a href="viewbook.php?uid='.$row['book_id'].'" 
                                   class="action-link">
                                    View
                                </a>
                            </td>

                            <td class="action-cell">
                                <a href="../transactions/deposit.php?uid='.$row['book_id'].'" 
                                   class="action-link edit">
                                    Deposit
                                </a>
                            </td>

                        </tr>
                        ';
                        
        }
        return true;
     }

     function no_books($check){

        if($check == 1){
             echo '
                        <tr>
                            <td colspan="5" class="no-records-cell">

                                <div class="no-records-wrapper">
                                    <span class="no-records-icon">🔍</span>
                                    <p class="no-records-text">
                                        No  Matching Records Found
                                    </p>
                                </div>

                                <div class="back-btn-container">
                                    <a href="../books/book.php" class="back-btn">
                                        ← Go Back
                                    </a>
                                </div>

                            </td>
                        </tr>
                        ';

        }else{
             echo '
                        <tr>
                            <td colspan="5" class="no-records-cell">

                                <div class="no-records-wrapper">
                                    <span class="no-records-icon">🔍</span>
                                    <p class="no-records-text">
                                        No Records Found
                                    </p>
                                </div>

                            </td>
                        </tr>
                        ';
        }

     }



?>

<link rel="stylesheet" href="../../style/book/books.css">
<link rel="stylesheet" type="text/css" href="../../style/sidebar.css">

<?php 
include "../adincludes/sidebar.php";
include "../adincludes/header.php";
?>

<div class="main-content">
<?php  ?>
    <div class="page-header">
        <h1>
            Collection Books
        </h1>
    </div>

    <div class="search-box">

        <form method="GET" action="">
            <input type="text"
                   name="info"
                   value="<?=isset($_GET['Search']) ? $_GET['info'] : ''?>"
                   placeholder="Search Customer">

            <button class="add-btn"
                    type="submit"
                    id="srch-btn"
                    name="Search">
                    Search
            </button>
        </form>

    </div>

    <div class="table-container">

        <table>

            <thead>

                <tr>
                    <th>Book ID</th>
                    <th>Customer</th>
                    <th>Status</th>
                    <th colspan="2" class="action-header">Action</th>
                </tr>

            </thead>

            <tbody>

                <?php 

                if(isset($_GET['Search'])){

                    $info = $_GET['info'];

                    if(empty($info)){
                        no_books(1);
                    }else{
                        $result = $books->searchBook($info);
                        if(mysqli_num_rows($result) > 0){
                            $book = $result->fetch_all(MYSQLI_ASSOC);
                            display_books($book, $books);
                        }
                        else{
                            no_books(1);
                        }
                    }

                    // if(empty($info)){

                       

                    // } else {

                    //     $squery = "SELECT 
                    //                 b.book_id as id,
                    //                 concat(c.surname,' ',c.othername) as name,
                    //                 b.bk_status as bstats
                    //                FROM book as b
                    //                JOIN customer as c 
                    //                ON b.customer_id = c.customer_id
                    //                WHERE book_id like '%$info%'
                    //                OR bk_lbl like '%$info%'";

                    //     $r_squery = mysqli_query($conn, $squery);

                    //     if(mysqli_num_rows($r_squery) > 0){

                    //         while ($row = mysqli_fetch_assoc($r_squery)) {

                    //             /*
                    //              * Convert database status into
                    //              * the CSS status classes.
                    //              */

                               

                    //             echo '
                    //             <tr>

                    //                 <td>'.$row['id'].'</td>

                    //                 <td>'.$row['name'].'</td>

                    //                 <td>
                    //                     <span class="badge '.$status_class.'">
                    //                         '.$row['bstats'].'
                    //                     </span>
                    //                 </td>

                    //                 <td class="action-cell">
                    //                     <a href="viewbook.php?uid='.$row['id'].'" 
                    //                        class="action-link">
                    //                         View
                    //                     </a>
                    //                 </td>

                    //                 <td class="action-cell">
                    //                     <a href="updatebook.php?uid='.$row['id'].'" 
                    //                        class="action-link edit">
                    //                         Edit
                    //                     </a>
                    //                 </td>

                    //             </tr>
                    //             ';
                    //         }

                    //     } else {

                    //         echo '
                    //         <tr>
                    //             <td colspan="5" class="no-records-cell">

                    //                 <div class="no-records-wrapper">
                    //                     <span class="no-records-icon">🔍</span>
                    //                     <p class="no-records-text">
                    //                         No Records Found
                    //                     </p>
                    //                 </div>

                    //                 <div class="back-btn-container">
                    //                     <a href="../books/book.php" class="back-btn">
                    //                         ← Go Back
                    //                     </a>
                    //                 </div>

                    //             </td>
                    //         </tr>
                    //         ';
                    //     }

                    // }

                } else {
                      
                      if(mysqli_num_rows($result) > 0){
                        $book = $result->fetch_all(MYSQLI_ASSOC);
                        if(!display_books($book,$books)){
                            no_books(0);
                        }

                      }else{
                        no_books(0);
                      }

                }

                ?>

            </tbody>

        </table>

    </div>

</div>