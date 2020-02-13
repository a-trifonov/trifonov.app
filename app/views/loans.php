<!DOCTYPE html>
<html>
    <head>
        <meta http-equiv="Content-Type" content="text/html; charset=UTF-8">
        <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
        <link rel="stylesheet" href="/public/css/bootstrap.css">
        <title>Loans App (Trifonov A.)</title>
    </head>
    <body style="margin-top: 20px;">
        <div class="container-fluid">
            <div class="row">
              <div class="col-md-8 offset-md-2">
                <h1 style="margin-bottom: 30px;">Loans app (test task)</h1>
              </div>
            </div>
            <div class="row">
                <div class="col-md-6 offset-md-2">
                    <div><a href="index.php?op=new" class="btn btn-primary">Add new loan</a>&nbsp;&nbsp;&nbsp;<a href="index.php?op=import" class="btn btn-warning">Import Payments From File</a>&nbsp;&nbsp;&nbsp;<a href="index.php?op=assign" class="btn btn-success">Assign Payments</a></div>
                    <br />
                    <div>
                      <h2>Loans list</h2>
                    </div>
                    <?php if ($loans) { ?>
                    <table border="0" cellpadding="0" cellspacing="0" class="table table-bordered table-striped">
                        <thead>
                            <tr>
                                <th width="200">Loan Number</th>
                                <th width="100">Amount</th>
                                <th width="100">Currency</th>
                                <th width="100">Status</th>
                                <th width="50">Action</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php foreach ($loans as $loan): ?>
                            <tr>
                                <td><?php echo htmlentities($loan->number); ?></td>
                                <td><?php echo htmlentities($loan->amount); ?></td>
                                <td><?php echo htmlentities($loan->currency); ?></td>
                                <td><?php echo htmlentities($loan->status); ?></td>
                                <td>
                                <a href="index.php?op=delete&number=<?php echo $loan->number; ?>"><i class="fa fa-trash-o"></i> Delete</a>
                                </td>
                            </tr>
                            <?php endforeach; ?>
                        </tbody>
                    </table>
                  <?php } else { ?>
                  <p>Loans not found.</p>
                  <?php } ?>
                  <div>
                      <h2>Payments list</h2>
                    </div>
                    <?php if ($payments) { ?>
                    <table border="0" cellpadding="0" cellspacing="0" class="table table-bordered table-striped">
                        <thead>
                            <tr>
                                <th width="200">Payment Info (Loan Number)</th>
                                <th width="100">Amount</th>
                                <th width="100">Currency</th>
                                <th width="100">Payment Number</th>
                                <th width="50">Action</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php foreach ($payments as $payment): ?>
                            <tr>
                                <td><?php echo htmlentities($payment->info); ?></td>
                                <td><?php echo htmlentities($payment->amount); ?></td>
                                <td><?php echo htmlentities($payment->currency); ?></td>
                                <td><?php echo htmlentities($payment->number); ?></td>
                                <td>
                                <a href="index.php?op=deletepayment&number=<?php echo $payment->number; ?>"><i class="fa fa-trash-o"></i> Delete</a>
                                </td>
                            </tr>
                            <?php endforeach; ?>
                        </tbody>
                    </table>
                  <?php } else { ?>
                  <p>Payments not found.</p>
                  <?php } ?>
                </div>
            </div>
            <div class="row">
              <div class="col-md-8 offset-md-2">
                <h2>Currency calculator</h2>
                <p>To calculate, enter the amount or change the currency</p>
              </div>
              <div class="col-md-8 offset-md-2">
                <input type="text" id="usd_currency" size="10"> USD&nbsp;=&nbsp;<input type="text" id="result_currency" size="10">
                <select name="select_currency">
                  <option value="RUB">RUB</option>
                  <option value="EUR">EUR</option>
                  <option value="GBP">GBP</option>
                </select>
              </div>
            </div>
        </div>
    </body>
  <script src="/public/js/jquery-latest.min.js"></script>
  <script src="/public/js/bootstrap.js"></script>
  <script>
    $(document).ready(function() {
      $('#usd_currency').on('input',function(e){
        var currency = $('select[name="select_currency"]').val();
        var usd_amount = $(this).val();
        $.get("https://openexchangerates.org/api/latest.json?app_id=8094eb2f4d4d4743b4833a256968853b", function(data) {
          var result_amount = (usd_amount/data.rates['USD'])*data.rates[currency];
          $('#result_currency').val(result_amount);
        });
      });
      $('#result_currency').on('input',function(e){
        var currency = $('select[name="select_currency"]').val();
        var result_amount = $(this).val();
        $.get("https://openexchangerates.org/api/latest.json?app_id=8094eb2f4d4d4743b4833a256968853b", function(data) {
          var usd_amount = (result_amount/data.rates[currency]);
          $('#usd_currency').val(usd_amount);
        });
      });
      $('select[name="select_currency"]').on('change',function(e){
        var currency = $(this).val();
        var usd_amount = $('#usd_currency').val();
        $.get("https://openexchangerates.org/api/latest.json?app_id=8094eb2f4d4d4743b4833a256968853b", function(data) {
          var result_amount = (usd_amount/data.rates['USD'])*data.rates[currency];
          $('#result_currency').val(result_amount);
        });
      });
    });
  </script>
</html>