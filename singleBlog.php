<?php

$curl = curl_init();

curl_setopt_array($curl, array(
  CURLOPT_URL => 'http://fridayapp.cu.ma/lawncare/api/'.$_GET['nid'],
  CURLOPT_RETURNTRANSFER => true,
  CURLOPT_ENCODING => '',
  CURLOPT_MAXREDIRS => 10,
  CURLOPT_TIMEOUT => 0,
  CURLOPT_FOLLOWLOCATION => true,
  CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
  CURLOPT_CUSTOMREQUEST => 'GET',
  CURLOPT_HTTPHEADER => array(
    'X-CSRF-Token: 8Js5xygCPT4glAh-T75SaokDJNhUugrJbkntbmHJ6_c',
    'Content-Type: application/hal+json',
    'Authorization: Basic YWRtaW46ZHJ1cGFsQCMwMDc='
  ),
));

$response = curl_exec($curl);

curl_close($curl);
//echo $response;
$data = json_decode($response);

?>

<!DOCTYPE html>
<html lang="en" ng-app="taskApp">

<head>
    <base href="/">
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <title>Drupal API</title>
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/font-awesome/4.4.0/css/font-awesome.min.css">
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0/css/bootstrap.min.css"
        integrity="sha384-Gn5384xqQ1aoWXA+058RXPxPg6fy4IWvTNh0E263XmFcJlSAwiGgFAW/dAiS6JXm" crossorigin="anonymous">
    <script src="https://code.jquery.com/jquery-3.2.1.slim.min.js"
        integrity="sha384-KJ3o2DKtIkvYIK3UENzmM7KCkRr/rE9/Qpg6aAZGJwFDMVNA/GpGFF93hXpG5KkN" crossorigin="anonymous">
    </script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.12.9/umd/popper.min.js"
        integrity="sha384-ApNbgh9B+Y1QKtv3Rn7W3mgPxhU9K/ScQsAP7hUibX39j7fakFPskvXusvfa0b4Q" crossorigin="anonymous">
    </script>
    <script src="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0/js/bootstrap.min.js"
        integrity="sha384-JZR6Spejh4U02d8jOt6vLEHfe/JQGiRRSQQxSfFWpi1MquVdAyjUar5+76PVCmYl" crossorigin="anonymous">
    </script>

</head>

<body>
<div class="mt-4 p-3">
        <div class="row">
            <div class="container">
            <div class="col-sm-8">
            <div class="row ml-2">
                <div class="alert alert-primary mt-4 col-sm-4" role="alert"><a href="http://fridayapp.cu.ma/drupal-api">All Blogs</a> </div>
                </div>
    <div class="card mb-3">
  <img class="card-img-top" width="100" height="300px" src="<?php echo $data[0]->field_task_thumbnail; ?>" alt="Card image cap">
  <div class="card-body">
    <h5 class="card-title"><?php echo $data[0]->nid; ?><br /> <?php echo $data[0]->title; ?></h5>
    <p class="card-text"><?php echo $data[0]->body; ?></p>
    <p class="card-text"><small class="text-muted"><?php echo $data[0]->field_task_date; ?></small></p>
  </div>
</div>
</div>
</div>
</div>
</div>
</body>
</html>