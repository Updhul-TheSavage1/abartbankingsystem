<?php 
require_once "../../configs/validate.php";
require_once "../../configs/db_connect.php";

class customer{

	protected $customer_id;
	protected $surname;
	protected $othername;
	protected $gender;
	protected $phone;
	protected $location;
	protected $errors =[];
	protected $conn;

	public function __construct(){
		$this->conn = new db_connect();


	}

	private function id_generator(){		
			$conn = $this->conn->conn;

            $sql = $conn->prepare("SELECT customer_id from customer order by customer_id desc limit 1");
            $sql->execute();
            $result = $sql->get_result();
            if(!$result){
                echo "An error Occured ";
                die();
            } else {
                if(mysqli_num_rows($result) > 0){
                    $row= $result->fetch_assoc();
                    $number = substr($row['customer_id'], 5);
                    $number++;
                    $id = "AZCUS".str_pad($number,4,"0" , STR_PAD_LEFT);
                } else {
                    $id = "AZCUS0001";
                }
            }
            return $id;
	}

	private function userInput(array $formData){

		$this->customer_id = $this->id_generator();
		$this->surname = clean($formData['Sname']);
		$this->othername = clean($formData['Oname']);
		$this->gender = $formData['gender'];
		$this->phone = clean($formData['phone']);
		$this->location = clean($formData['location']);

		 $this->errors['surname'] = validateName($this->surname, "Surname");
		 $this->errors['othername'] = validateName($this->othername, "Othername");
		 $this->errors['phone'] = validatePhone($this->phone);
		 $this->errors['location'] = validateloc($this->location,"Location");
		 $this->errors['gender'] = validateGender($this->gender);

		 if(empty($this->errors['surname']) && empty($this->errors['othername']) && empty($this->errors['phone']) && empty($this->errors['location']) && empty($this->errors['gender'])){

		 		return [
		 			"id" => $this->customer_id,
		 			"Sname" => $this->surname,
		 			"Oname" =>$this->othername,
		 			"phone" =>$this->phone,
		 			"gender" =>$this->gender,
		 			"location" =>$this->location,
		 			"check" => true
		 		];
		 }else{
		 	return[
		 		"surname"=> $this->errors['surname'],
		 		"othername"=> $this->errors['othername'],
		 		"phoneE"=> $this->errors['phone'],
		 		"locationE"=> $this->errors['location'],
		 		"genderE"=> $this->errors['gender'],
		 		"Sname"=> $this->surname,
		 		"Oname"=> $this->othername,
		 		"phone"=> $this->phone,
		 		"location"=> $this->location,
		 		"gender"=> $this->gender,
		 		"check" => false
		 	];
		 }


	}

	public function fetch_customer_data($id){
	 	$conn = $this->conn->conn;
	 	if($id == 0){
			 	$sql = $conn->prepare("SELECT * FROM customer order by customer_id desc");
				$sql->execute();
				$result = $sql->get_result();
	 	}else{
			 	$sql = $conn->prepare("SELECT * FROM customer where customer_id = ?");
				$sql->bind_param("s", $id);
				$sql->execute();
				$result = $sql->get_result();

	 	}
	 	return $result;
	

	}	

	public function new_customer(array $formData){
		$conn = $this->conn->conn;
		$userInput = $this->userInput($formData);

		if($userInput["check"]){
			try{

					$id = $userInput["id"];
					$Sname = $userInput["Sname"];
					$Oname = $userInput["Oname"];
					$gender = $userInput["gender"];
					$phone = $userInput["phone"];
					$location = $userInput["location"];

		 			$conn->begin_transaction();

		 			$sql = $conn->prepare("INSERT INTO customer(customer_id, surname, othername, gender, phone, location) values(?,?,?,?,?,?)");
		 			$sql->bind_param("ssssss", $id, $Sname, $Oname, $gender, $phone, $location);
		 			$sql->execute();
		 			$sql->close();
		 			$conn->commit();

		 			return ["check" =>true];

		 		}catch(Exception $e){
		 			$conn->rollback();
		 			echo "<script>alert('Couldnot add customer');</script>";
		 			return ["check"=>false];


				}




		}else{
			return $userInput;

		}
	}

	public function searchCustomer($info){
		$conn = $this->conn->conn;
		$info = "%".$info."%";
		$squery = $conn->prepare("SELECT * from customer
                                   where
                                   customer_id like ? or
                                   surname like ? or 
                                   othername like ?;");
		$squery->bind_param("sss", $info, $info, $info);

		$squery->execute();
		return $squery->get_result();


                      
	}


	public function update_customer(array $formData, $id){
		$conn = $this->conn->conn;
		$userInput = $this->userInput($formData);

		if($userInput["check"]){
			try{
					$Sname = $userInput["Sname"];
					$Oname = $userInput["Oname"];
					$gender = $userInput["gender"];
					$phone = $userInput["phone"];
					$location = $userInput["location"];

					$conn->begin_transaction();
					$sql = $conn->prepare("UPDATE customer set surname = ?, othername = ?, gender = ?, phone = ?, location = ? where customer_id = ?");
					$sql->bind_param("ssssss", $Sname, $Oname, $gender, $phone, $location, $id );

					$sql->execute();
					$sql->close();
					$conn->commit();
					echo "<script>alert('Update Succesfully');</script>";

					return ["check"=>true];

			}catch(Exception $e){
				$conn->rollback();
				echo "<script>alert('Failed to update record');</script>";
				return ["check"=>false];

			}
		}else{
			return $userInput;
		}
	}
}

class book extends customer{

	protected $book_id;
	protected $book_label;
	protected $total_pages;
	protected $current_page;
	protected $total_deposit;
	protected $current_balance;
	protected $total_withdrawals;
	protected $book_status;
	protected $deposit_status;
	protected $issue_date;


	

	private function id_generator(){
		$conn = $this->conn->conn;
		 $current_year = "BK" . date('y')."%";
            $sql = $conn->prepare("SELECT book_id FROM book WHERE book_id LIKE ? ORDER BY book_id DESC LIMIT 1;");
            $sql->bind_param("s", $current_year);
            $sql->execute();
            $result = $sql->get_result();
            $current_year = "BK" . date('y');

            
   
                if(mysqli_num_rows($result) > 0){
                	
                    $row = $result->fetch_assoc();
                 
                    $number = substr($row['book_id'], 4);
                    $number++;
                    $this->book_id = $current_year.str_pad($number, 4, "0" , STR_PAD_LEFT);

                } else {

                    $this->book_id = $current_year.'0001';
                }
                 return $this->book_id;
            }

	private function userInput(array $formData){
		date_default_timezone_set('Africa/Accra');
		
		$this->book_id = $this->id_generator();
		$this->book_label = $formData['book_label'];
		$this->issue_date = $formData['issue_date']." ".date('H:i:s');
		$this->customer_id = $formData['customer_id'];
		$error = validateBook($this->book_label);

		if(empty($error)){
			return [
				"book_id" => $this->book_id,
				"book_label" => $this->book_label,
				"customer_id" => $this->customer_id,
				"issue_date" => $this->issue_date,
				"check" => true
			];
		}else{
			return ["check"=>false, "error" => $error, "book_label" => $this->book_label];
		}

	}

	public function fetch_book($id){
		$conn = $this->conn->conn;

		if($id == 0){
			$sql = $conn->prepare("SELECT * from book order by book_id desc");
			$sql->execute();
			$result = $sql->get_result();
			
		}elseif(strlen($id) == 8){
			$sql = $conn->prepare("SELECT * FROM book where book_id = ?");
			$sql->bind_param("s", $id);
			$sql->execute();
			$result = $sql->get_result();
		}else{
			$sql = $conn->prepare("SELECT * FROM book where customer_id = ?");
			$sql->bind_param("s", $id);
			$sql->execute();
			$result = $sql->get_result();

		}
		return $result;
		



	}

	public function new_book(array $formData){
		$conn = $this->conn->conn;

		$bookInfo = $this->userInput($formData);
		$book_label =  $bookInfo['book_label'];

		if($bookInfo['check']){
			$book_id= $bookInfo['book_id'];
			$book_label =  $bookInfo['book_label'];
			$customer_id =  $bookInfo['customer_id'];
			$issue_date =  $bookInfo['issue_date'];

			$sql = $conn->prepare("INSERT INTO book(book_id, bk_lbl, customer_id, created_at) values(?,?,?,?)");
			$sql->bind_param("ssss", $book_id, $book_label, $customer_id, $issue_date);
			$r_sql = $sql->execute();
			if ($r_sql) {
				echo '<script>window.alert("Book Created Succesfully")</script>';
				return[
					"id" => $book_id,
					"check" => true
					];
			}
			echo '<script>window.alert("An error Occured !! please try again.")</script>';
			return ["check" => false];

		}else{
			return["check" => false, "error" => $bookInfo['error'], "book_label" => $book_label];
		}

	}

	public function searchBook($info){
		$conn = $this->conn->conn;
		$info = "%".$info."%";
		$squery = $conn->prepare("SELECT * from book
                                   where
                                   book_id like ? or
                                   bk_lbl like ? ;");
		$squery->bind_param("ss", $info, $info);

		$squery->execute();
		return $squery->get_result();


	}

}

class book_page extends book{

	protected $page_number;
	protected $fixed_amount;
	protected $total_boxes;
	protected $boxes_deposited;
	protected $boxes_withdrawn;
	protected $page_status;
	protected $withdrawal_status;

	private function userInput(array $formData){

		$fixed_amount = $formData['fixed_amount'];
		$book_id = $formData['book_id'];
		$customer_id = $formData['customer_id'];

		if($fixed_amount <= 0  || !is_numeric($fixed_amount)){
			return['check' => false, 'fixed_amount' => $fixed_amount, 'error' => "Invalid amount"];
		}else{
			return ['check' => true,
			 'fixed_amount' => $fixed_amount,
			 'book_id' => $book_id,
			 'customer_id' => $customer_id
			];
		}
	}
	public function fetch_page($id, $pn){
		$conn = $this->conn->conn;
		if($pn == 0){

			#Fetch all pages of book
			$sql = $conn->prepare("SELECT * from book_page where book_id = ?");
			$sql->bind_param("s", $id);
			$sql->execute();
			$result = $sql->get_result();

		}elseif($pn == -1){

			#Select the recent page to create a new page
			$sql = $conn->prepare("SELECT * from book_page where book_id = ? and page_number = (SELECT max(page_number) from book_page where book_id = ?);");
			$sql->bind_param("ss", $id, $id);
			$sql->execute();
			$result = $sql->get_result();

		}elseif($pn == -2){
			#Selecting page to withdraw money
	
			$sql = $conn->prepare("SELECT * from book_page where book_id = ? and page_number = (SELECT min(page_number) from book_page where book_id = ?) and (withdrawal_status = 'NOT' or withdrawal_status = 'Partially') and boxes_deposited > 0;");
			$sql->bind_param("ss", $id, $id);
			$sql->execute();
			$result = $sql->get_result();

		}else{
			$sql = $conn->prepare("SELECT * from book_page where book_id = ? and page_number = ?");
			$sql->bind_param("si", $id, $pn);
			$sql->execute();
			$result = $sql->get_result();			
		}

		return $result;
		
	}
	public function new_page(array $formData){
		$conn = $this->conn->conn;
		$data = $this->userInput($formData);

		if(!$data['check']){
			return $data;
		}

		$this->fixed_amount = $data['fixed_amount'];
		$this->book_id = $data['book_id'];
		$this->customer_id = $data['customer_id'];

		$page = $this->fetch_page($this->book_id, -1);

		if(mysqli_num_rows($page) <= 0){
			$page_number = 1;
		}else{
			$result = $page->fetch_assoc();
			$page_number = $result['page_number'];
			$page_number += 1;

			if($page_number > 12){
				return['check' => false, 'error' => "The book is full"];
			}
		}

		try{
				$conn->begin_transaction();

				$sql = $conn->prepare("INSERT INTO book_page(page_number, fixed_amount, book_id, customer_id) values(?,?,?,?)");
				$sql->bind_param("idss", $page_number,$this->fixed_amount, $this->book_id, $this->customer_id);
				$sql->execute();

				$sql = $conn->prepare("UPDATE book set current_page = ? where book_id = ?");
				$sql->bind_param("is", $page_number, $this->book_id);
				$sql->execute();

				$conn->commit();

				return ['check' => true, 'page_number' => $page_number];

			}catch(Exception $e){
				$conn->rollback();
				return ['check' => false, 'error' => "Failed to add new page", 'fixed_amount' => $this->fixed_amount];
			}



		}

	Public function displayPages(array $pages){
		foreach ($pages as $row) {
			$b = ($row["fixed_amount"] * ( $row["boxes_deposited"] - 1) ) - ($row['boxes_withdrawn'] * $row['fixed_amount']);
			echo '
			   <tr>
                  <td>
                     '.$row['page_number'].'
                   </td>

                   <td>
                     '.$row['fixed_amount'].'
                   </td>

                    <td>
					  <span>
                       '.$row['boxes_deposited'].' / 31
                      </span>

                    </td>

                   

                    <td>
   					  <span >
                       '.$row['boxes_withdrawn'].' / 30
                      </span>

                     </td>

                      <td>
                      '.$b.'
                    </td>

              </tr>';
		}
	}
		
}

class transaction extends book_page{



	private function userInput(array $formData){
	
		$deposit = $formData['amount'];
		if($deposit <= 0 || !is_numeric($deposit)){
			return['check' => false,'amount' => $deposit, 'error' => "Invalid Amount Entered"];
		}
		return['check' => true,'amount' => $deposit];
	}

	private function id_generator(){
		return date('YmdHis');
	}
	protected function internal_deposit(array $deposit){
		$conn = $this->conn->conn;

		$deposit_amount = $deposit['deposit_amount'];
		$fixed_amount = $deposit['fixed_amount'];
		$page_number = $deposit['page_number'];
		$boxes_deposited = $deposit['boxes_deposited'];
		$total_boxes_deposited = $deposit['total_boxes_deposited'];
		$book_id = $deposit['book_id'];
		$customer_id = $deposit['customer_id'];
		$n = 1;

		do{

			if ($total_boxes_deposited >= 31) {
				$r_boxes = $total_boxes_deposited - 31;
				$boxes_deposited = 31;
				$page_status = "Completed";
				$depo_status = "Incomplete"; 
				if($page_number == 12){
					$depo_status = "Completed";
				}
			}else{
				$r_boxes = 0;
				$boxes_deposited = $total_boxes_deposited;
				$page_status = 'incomplete';
				$depo_status = "Incomplete"; 
			}


			 try{
			 	$conn->begin_transaction();

			 	$sql = $conn->prepare("UPDATE book_page set boxes_deposited = ?, page_status = ? where book_id = ? and page_number = ? ");
			 	$sql->bind_param("issi", $boxes_deposited, $page_status, $book_id, $page_number);
			 	$sql->execute();

			 	if($n == 1){
			 		$sql = $conn->prepare("UPDATE book set total_deposit = total_deposit + ?, current_balance = current_balance + ?, deposit_status = ? where book_id = ?");
			 		$sql->bind_param("ddss", $deposit_amount, $deposit_amount, $depo_status, $book_id);
			 		$sql->execute();

			 	}else{
			 		$sql = $conn->prepare("UPDATE book set  deposit_status = ?, current_page = ? where book_id = ?");
			 		$sql->bind_param("sis", $depo_status, $page_number, $book_id);
			 		$sql->execute();
			 	}
			 	if($n == 1){
			 		$trans_id = $this->id_generator();
			 		$sql = $conn->prepare("INSERT into transactions(transaction_id,Amount, book_id, customer_id) values(?,?,?,?)");
			 		$sql->bind_param("sdss",$trans_id, $deposit_amount, $book_id, $customer_id);
			 		$sql->execute();

			 	}
			 	
			 	$conn->commit();

			 }catch(Exception $e){
			 	$conn->rollback();
			 	return ['check' => false, 'error' => "A Database error occured"];

			 }

			 if($r_boxes > 0 && $depo_status != "Completed" ){

			 	$data = ['fixed_amount' => $fixed_amount, 'book_id' => $book_id, 'customer_id' => $customer_id];
			 	$page = $this->new_page($data);

			 	if(!$page['check']){
			 		return ['check'=> false, 'error' => "Could not add new page"];
			 	}
			 	$page_number = $page['page_number'];

			 	$page_data = $this->fetch_page($book_id, $page_number);

			 	$page_data_r = $page_data->fetch_assoc();
			 	$boxes_deposited = $page_data_r['boxes_deposited'];
			 	$fixed_amount = $page_data_r['fixed_amount'];
			 	$total_boxes_deposited =$r_boxes;
			 }


			 $n++;
		}while($r_boxes > 0 && $depo_status != "Completed" );

		return['check' => true];

	}


	protected function internal_withdraw(array $withdraw){
		$conn = $this->conn->conn;


		$withdrawal_amount   = $withdraw['amount'];
		$boxes_withdrawn = $withdraw['boxes_withdrawn'];
		$fixed_amount = $withdraw['fixed_amount'];
		$book_id = $withdraw['book_id'];
		$customer_id = $withdraw['customer_id'];

		$page_balance = $fixed_amount * $boxes_deposited;

		if($withdrawal_amount >= $page_balance){
			$r_amount = $withdrawal_amount - $page_balance;

		}else{
			
		}


	}
	public function deposit(array $formData, array $page ){
		$conn = $this->conn->conn;
		$data = $this->userInput($formData);

		if(!$data['check']){
			return $data;
		}

		$boxes_deposited = $page['boxes_deposited'];
		$fixed_amount = $page['fixed_amount'];
		$page_number = $page['page_number'];
		$deposit_amount = $data['amount'];
		$book_id = $page['book_id'];
		$customer_id = $page['customer_id'];

		 if($deposit_amount % $fixed_amount != 0){
		 	return['check' => false, 'error' => "Please enter a divisible amount", 'deposit_amount' => $deposit_amount];
		 }

		 $deposit_boxes = $deposit_amount / $fixed_amount;

		 $total_boxes_deposited = $deposit_boxes + $boxes_deposited;
		 

		 $deposit_info = [
		 				"deposit_amount" => $deposit_amount,
		 				"total_boxes_deposited" => $total_boxes_deposited,
		 				"fixed_amount" => $fixed_amount,
		 				"page_number" => $page_number,
		 				"boxes_deposited" => $boxes_deposited,
		 				"book_id" => $book_id,
		 				"customer_id" => $customer_id
		 					];

		 		$deposit = $this->internal_deposit($deposit_info);

		 		if(!$deposit['check']){
		 			return $deposit;
		 		}
		 		return ['check' => true];

	}

	public function withdraw(array $formData, array $page){
		$conn = $this->conn->conn;
		$data = $this->userInput($formData);

		if(!$data['check']){
			return $data;
		}


		$withdrawal_amount   = $data['amount'];
		$boxes_withdrawn = $page['boxes_withdrawn'];
		$boxes_deposited = $page['boxes_deposited'];
		$fixed_amount = $page['fixed_amount'];
		$book_id = $page['book_id'];
		$customer_id = $page['customer_id'];

		 if($deposit_amount % $fixed_amount != 0){
		 	return['check' => false, 'error' => "Please enter a divisible amount", 'amount' => $deposit_amount];
		 }




		 $withdrawal_info=[
		 			'withdrawal_amount' => $withdrawal_amount,
		 			'boxes_withdrawn' => $boxes_withdrawn,
		 			'boxes_deposited' => $boxes_deposited,
		 			'fixed_amount' => $fixed_amount,
		 			'book_id' => $book_id,
		 			'customer_id' => $customer_id
		 					];


	}
}










?>