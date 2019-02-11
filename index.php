<!DOCTYPE html>
<!--[if IE 8]>         <html class="no-js lt-ie9"> <![endif]-->
<!--[if gt IE 8]><!--> <html class="no-js"> <!--<![endif]-->
  <head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <title></title>
    <meta name="description" content="">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.3.0/css/bootstrap.min.css" integrity="sha384-PDle/QlgIONtM1aqA2Qemk5gPOE7wFq8+Em+G/hmo5Iq0CCmYZLv3fVRDJ4MMwEA" crossorigin="anonymous">    <link rel="stylesheet" href="">
  </head>
  <body>
    <div class="container">
    <div class="card mb-3 mt-3">
      <div class="card-header">
        Collatz Spiral
      </div>
      <div class="card-body">
      <object type="image/svg+xml">
        <?php
            require './Collatz.php';
            try {
              $presets = [13, 10000];
              $collatz = new CollatzSpiral($presets);
              $collatz->printCollatzNumbersToConsole();
            } catch (Exception $e) {
              echo 'Caught exception: ', $e->getMessage(), "\n";
            }
          ?>
        </object>
      </div>
  </div>
    </div>

    <script src="" async defer></script>
  </body>
</html>