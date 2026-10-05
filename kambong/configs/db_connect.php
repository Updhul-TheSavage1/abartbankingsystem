<?php 
		class db_connect{
			private $host;
			private $root;
			private $pass;
			private $db;
			public $conn;

			public function __construct(){
				$this->host = "localhost";
				$this->root = "root";
				$this->pass = "";
				$this->db = "chugu";
				
				$this->conn = mysqli_connect($this->host, $this->root, $this->pass, $this->db);

				if(!$this->conn){
					return $this->conn;
					die();
				}
				return  $this->conn;
			}

		}

		


 ?>