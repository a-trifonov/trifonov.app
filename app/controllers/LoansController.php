<?php
    require_once 'app/models/LoansService.php';

    class LoansController {
        
        private $loansService = NULL;

        public function __construct() {
            $this->loansService = new LoansService();
        }

        public function redirect($location) {
            header('Location: '.$location);
        }

        public function handleRequest() {
            $op = isset($_GET['op'])?$_GET['op']:NULL;

            try {
                if(!$op || $op == 'list') {
                    $this->listLoans();
                }elseif($op == 'new') {
                    $this->saveLoan();
                }elseif($op == 'delete') {
                    $this->deleteLoan();
                }elseif($op == 'deletepayment') {
                    $this->deletePayment();
                }elseif($op == 'import') {
                    $this->importPayments();
                }elseif($op == 'assign') {
                    $this->assignPayments();
                }else {
                    $this->showError("Page not found", "Page for operation ".$op." was not found!");
                }
            } catch (Exception $e) {
                $this->showError("Application error", $e->getMessage());
            }
        }

        public function listLoans() {
            $data = $this->loansService->getAll();
            $loans = $data['loans'];
            $payments = $data['payments'];
            include 'app/views/loans.php';
        }

        public function saveLoan() {
            $title = 'Add new loan';

            $number = '';
            $amount = '';

            $errors = array();

            if(isset($_POST['form-submitted'])) {
                $number = $_POST['number'];
                $amount = $_POST['amount'];

                try {
                    $createLoan = $this->loansService->createNewLoan($number,$amount);
                    if($createLoan) {
                        $deleteMessage = '<div class="alert alert-success>Loan added successfully</div>';
                    } else {
                        $deleteMessage = '<div class="alert alert-danger>Loan with this number already exists</div>';
                    }
                    $this->redirect('index.php');
                } catch (ValidationException $e) {
                    $errors = $e->getErrors();
                }
            }
            include 'app/views/form.php';
        }

        public function deleteLoan() {
            $number = isset($_GET['number'])?$_GET['number']:NULL;
            $deleteMessage = '';
            if(!$number) {
                throw new Exception("Internal error.");
            }

            $deleteLoan = $this->loansService->deleteLoan($number);
            $this->redirect('index.php');
        }
      
        public function deletePayment() {
            $number = isset($_GET['number'])?$_GET['number']:NULL;
            $deleteMessage = '';
            if(!$number) {
                throw new Exception("Internal error.");
            }

            $deleteLoan = $this->loansService->deletePayment($number);
            $this->redirect('index.php');
        }
      
        public function importPayments() {
            $this->loansService->importPayments();
            $this->redirect('index.php');
        }
      
        public function assignPayments() {
            $this->loansService->assignPayments();
            $this->redirect('index.php');
        }

        public function showError($title, $message){
            include 'app/views/error.php';
        }
    }
?>