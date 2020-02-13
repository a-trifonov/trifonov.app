<!DOCTYPE html>
<html>
    <head>
        <meta http-equiv="Content-Type" content="text/html; charset=UTF-8">
        <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
        <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/css/bootstrap.min.css" integrity="sha384-ggOyR0iXCbMQv3Xipma34MD+dH/1fQ784/j6cY/iJTQUOhcWr7x9JvoRxT2MZw1T" crossorigin="anonymous">
        <title>
        <?php echo htmlentities($title) ?>
        </title>
    </head>
    <body style="margin-top: 50px;">
        <div class="container-fluid">
            <div class="row">
                <div class="col-md-6 offset-md-3">
                    <?php
                    if ( $errors ) {
                        echo '<div class="alert alert-danger>';
                        foreach ( $errors as $field => $error ) {
                            echo htmlentities($error).'<br />';
                        }
                        echo '</div>';
                    }
                    ?>
                    <div class="card">
                    <div class="card-header">
                    <?php echo htmlentities($title) ?>
                    </div>
                        <div class="card-body">                            
                            <form method="POST" action="">
                                <div class="form-group">
                                <label for="name">Loan Number:</label><br/>
                                <input type="text" class="form-control"  name="number" value="<?php echo htmlentities($number) ?>" required />
                                <br/>                        
                                </div>
                                <label for="phone">Amount (USD):</label><br/>
                                <input type="text" class="form-control"  name="amount" value="<?php echo htmlentities($amount) ?>" required />
                                <br/>
                                <input type="hidden" name="form-submitted" value="1" />
                                <input type="submit" class="btn btn-primary" value="Submit" />
                            </form>
                        </div>
                    </div>                
                </div>
            </div>
        </div>

    </body>
   <script src="/public/js/jquery-latest.min.js"></script>
  <script src="/public/js/bootstrap.js"></script>
</html>