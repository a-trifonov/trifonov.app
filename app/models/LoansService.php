<?php
    require_once 'app/models/LoansGateway.php';
    require_once 'app/models/ValidationException.php';

    class LoansService {

        private $loansGateway = NULL;
        private $dbConnection;
        
        public function __construct() {
            $this->dbConnection = $this->openDB();
            $this->loansGateway = new LoansGateway();
        }

        public function openDB() {
            try {
                $conn = new PDO("mysql:host=mysql;dbname=trifonov_app;charset=UTF8", 'trifonov', 'trifonov');
                // set the PDO error mode to exception
                $conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
                $conn->setAttribute(PDO::ATTR_DEFAULT_FETCH_MODE, PDO::FETCH_OBJ);
                return $conn;
            }catch(PDOException $e){
                throw new Exception("Connection error. ". $e->getMessage());
            }
        }

        public function closeDB() {
            $this->dbConnection = NULL;
        }

        public function getAll() {
            try {
                $this->openDB();
                $res = $this->loansGateway->selectAll($this->dbConnection);
                $this->closeDB();
                return $res;
            } catch (Exception $e) {
                $this->closeDB();
                throw new Exception($e);
            }
        }

        public function getLoan($number) {
            try{
                $this->openDB();
                $res = $this->loansGateway->selectByNumber($number,$this->dbConnection);
                $this->closeDB();
                return $res;
            } catch (Exception $e) {
                $this->closeDB();
                throw new Exception($e);
            }
            return $this->loansGateway->find($id);
        }

        private function validateLoanParams($number, $amount) {
            $errors = array();
          
            if(!isset($number) || empty($number)){
                $errors[] = 'Name is required';
            }
          
            if($this->loansGateway->selectByNumber($number,$this->dbConnection)) {
                $errors[] = 'Loan with number '.$number.' already exists';
            }
          
            if(!isset($amount) || empty($amount)){
                $errors[] = 'Amount is required';
            }
          
            if(empty($errors)){
                return true;
            } else {
                return false;
            }
          
            
        }

        public function createNewLoan($number, $amount) {
            try{
                  $this->openDB();
                  $this->validateLoanParams($number, $amount);
                  $res = $this->loansGateway->insertLoan($number, $amount, $this->dbConnection);
                  $this->closeDB();
                  return $res;
            } catch (Exception $e) {
                $this->closeDB();
                throw new Exception($e);
            }
        }

        public function deleteLoan($number) {
            try {
                $this->openDB();
                $res = $this->loansGateway->deleteLoan($number,$this->dbConnection);
                $this->closeDB();
                return $res;
            } catch (Exception $e) {
                $this->closeDB();
                throw $e;
            }
        }
      
        public function deletePayment($number) {
            try {
                $this->openDB();
                $res = $this->loansGateway->deletePayment($number,$this->dbConnection);
                $this->closeDB();
                return $res;
            } catch (Exception $e) {
                $this->closeDB();
                throw $e;
            }
        }
      
        public function importPayments() {
            if (($handle = fopen("data/payments.csv", "r")) !== FALSE) {
                $row=1; //titles of columns in csv file
                while (($data = fgetcsv($handle, 1000, ",")) !== FALSE) {
                    if($row>1) {
                      try {
                          $this->loansGateway->insertPayment($data,$this->dbConnection);
                      } catch (Exception $e) {
                          $this->closeDB();
                          throw new Exception($e);
                      }
                    }
                    $row++;
                }
                fclose($handle);
                return true;
            } else 
                return false;
        }
      
        public function assignPayments() {
            $loans = $this->loansGateway->selectActiveLoans($this->dbConnection);
            if($loans) {
                foreach($loans as $loan) {
                    $totalPaymentsAmount = $this->loansGateway->selectPaymentsAmountByLoanNumber($loan->number,$this->dbConnection);
                    if($totalPaymentsAmount>=$loan->amount) {
                        try {
                              $this->loansGateway->changeLoanStatus($loan->number,$this->dbConnection);
                        } catch (Exception $e) {
                              $this->closeDB();
                              throw new Exception($e);
                        }
                    }
                }
                return true;
            } else 
                return false;
        }
    }
?>