<?php


class LoansGateway {

    public function RunQuery($query,$dbLink) {
		$queryString = $dbLink->prepare($query);
		$queryString->execute();
		return $queryString;
	}
    
    public function selectAll($dbConnection) {
        $dbres = $this->RunQuery("SELECT l.loan_number as number, ROUND(l.amount,2) as amount, l.currency, s.title as status FROM loans l, statuses s WHERE l.status_id=s.id ORDER BY l.loan_number", $dbConnection);
          
        $loans = array();
        while ( ($obj = $dbres->fetch()) != NULL ) {
            $loans[] = $obj;
        }
      
        $result['loans'] = $loans;
      
        $dbres = $this->RunQuery("SELECT p.payment_number as number, ROUND(p.amount,2) as amount, p.currency, p.payment_info as info FROM payments p ORDER BY p.payment_info", $dbConnection);
        
        $payments = array();
        while ( ($obj = $dbres->fetch()) != NULL ) {
            $payments[] = $obj;
        }
      
        $result['payments'] = $payments;
      
        return $result;
    }
  
    public function selectActiveLoans($dbConnection) {
        $dbres = $this->RunQuery("SELECT l.loan_number as number, ROUND(l.amount,2) as amount, l.currency, s.title as status FROM loans l, statuses s WHERE l.status_id=s.id AND s.id=1", $dbConnection);
          
        $loans = array();
        while ( ($obj = $dbres->fetch()) != NULL ) {
            $loans[] = $obj;
        }
          
        return $loans;
    }
  
    public function selectByNumber($number, $dbConnection) {
        $dbNumber = htmlspecialchars(trim($number), ENT_QUOTES, 'UTF-8');
    
        $dbres = $this->RunQuery("SELECT l.loan_number as number, ROUND(l.amount,2) as amount, l.currency, s.title as status FROM loans l, statuses s WHERE l.loan_number='".$dbNumber."' AND l.status_id=s.id", $dbConnection);
        
        return $dbres->fetch();
		
    }
  
    public function selectPaymentsAmountByLoanNumber($number, $dbConnection) {
        $dbNumber = htmlspecialchars(trim($number), ENT_QUOTES, 'UTF-8');
      
        $rate = array();
        $rate['RUB'] = 63.6845;
        $rate['EUR'] = 0.918874;
        $rate['GBP'] = 0.770943;
        $rate['USD'] = 1;
      
        $totalPaymentsAmount = 0;
      
        $dbres = $this->RunQuery("SELECT ROUND(p.amount,2) as amount, p.currency, p.payment_info as info FROM payments p WHERE p.payment_info='".$dbNumber."'", $dbConnection);

        $payments = array();
        while ( ($obj = $dbres->fetch()) != NULL ) {
            $totalPaymentsAmount += $obj->amount/$rate[$obj->currency];
        } 
      
        return $totalPaymentsAmount;
		
    }
    
    public function find($id,$dbConnection) {
        
        $dbNumber =  htmlspecialchars(trim($number), ENT_QUOTES, 'UTF-8');
        $dbres = $this->RunQuery("SELECT * FROM loans WHERE loan_number = '".$dbNumber."'", $dbConnection);
        return $dbres->fetch();
    }
    
    public function insertLoan($number, $amount, $dbConnection) {
        
        $dbNumber = ($number != NULL)?"'". htmlspecialchars(trim($number), ENT_QUOTES, 'UTF-8')."'":'NULL';
        $dbAmount = ($amount != NULL)?"'". htmlspecialchars(trim($amount), ENT_QUOTES, 'UTF-8')."'":'NULL';
        
        $query = "INSERT INTO loans (loan_number, amount) VALUES ($dbNumber, $dbAmount)";
        
        $createNew = $this->RunQuery($query,$dbConnection);
        return $dbConnection->lastInsertId();
    }
  
    public function insertPayment($data, $dbConnection) {
        
        $dbNumber = ($data[0] != NULL)?"'". htmlspecialchars(trim($data[0]), ENT_QUOTES, 'UTF-8')."'":'NULL';
        $dbAmount = ($data[1] != NULL)?htmlspecialchars(trim($data[1]), ENT_QUOTES, 'UTF-8'):'NULL';
        $dbCurrency = ($data[2] != NULL)?"'". htmlspecialchars(trim($data[2]), ENT_QUOTES, 'UTF-8')."'":'NULL';
        $dbInfo = ($data[3] != NULL)?"'". htmlspecialchars(trim($data[3]), ENT_QUOTES, 'UTF-8')."'":'NULL';
        
        $query = "INSERT INTO payments (payment_number, amount, currency, payment_info) VALUES ($dbNumber , $dbAmount, $dbCurrency, $dbInfo)";
      
        $createNew = $this->RunQuery($query,$dbConnection);
        return $dbConnection->lastInsertId();
    }
    
    public function deleteLoan($number, $dbConnection) {
        $dbNumber = htmlspecialchars(trim($number), ENT_QUOTES, 'UTF-8');
        $query = "DELETE FROM loans WHERE loan_number='".$dbNumber."'";
        $runQuery = $this->RunQuery($query, $dbConnection);
        if($runQuery){
            return true;
        } else {
            return false;
        }
    }
  
    public function changeLoanStatus($number, $dbConnection) {
        $dbNumber = htmlspecialchars(trim($number), ENT_QUOTES, 'UTF-8');
        $query = "UPDATE loans SET status_id=2 WHERE loan_number='".$dbNumber."'";
        $runQuery = $this->RunQuery($query, $dbConnection);
        if($runQuery){
            return true;
        } else {
            return false;
        }
    }
  
    public function deletePayment($number, $dbConnection) {
        $dbNumber = htmlspecialchars(trim($number), ENT_QUOTES, 'UTF-8');
        $query = "DELETE FROM payments WHERE payment_number='".$dbNumber."'";
        $runQuery = $this->RunQuery($query, $dbConnection);
        if($runQuery){
            return true;
        } else {
            return false;
        }
    }
    
}

?>