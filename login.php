<?php
if (isset($_POST['Submit'])) {
    $name = $_POST['name'];
    $pass = $_POST['pass'];

    $serialized_entity = json_encode([
        'name' => [['value' => $name]],
        'pass' => [['value' => $pass]]
      ]);
    $curl = curl_init();

    curl_setopt_array($curl, array(
    CURLOPT_URL => 'http://fridayapp.cu.ma/lawncare/user/login?_format=json',
    CURLOPT_RETURNTRANSFER => true,
    CURLOPT_ENCODING => '',
    CURLOPT_MAXREDIRS => 10,
    CURLOPT_TIMEOUT => 0,
    CURLOPT_HEADER, true,
    CURLOPT_NOBODY, true,
    CURLOPT_FOLLOWLOCATION => true,
    CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
    CURLOPT_CUSTOMREQUEST => 'POST',
    CURLOPT_POSTFIELDS => '{ "name": "'.$name.'", "pass": "'.$pass.'" }',
    CURLOPT_HTTPHEADER => array(
    'Content-Type: application/x-www-form-urlencoded'
    ),
    ));

    $response = curl_exec($curl);
    $httpcode = curl_getinfo($curl, CURLINFO_HTTP_CODE);
    
    $data = json_decode($response);
    curl_close($curl);
    //echo 'HTTP code: ' . $httpcode;
    // if ($response) {
    //     curl_setopt($curl, CURLOPT_POST, 0); // change back to GET
    //     curl_setopt($curl, CURLOPT_URL, 'http://fridayapp.cu.ma/drupal-api/'); // set url for next request
    //     $exec = curl_exec($curl); // make request to buy on the same handle with the current login session
    //     echo $exec;
    //     //echo $response;
    // }

    if ($httpcode == '200') {
        //echo "Sucess";
        //echo $response;
        header('Location: http://fridayapp.cu.ma/drupal-api/');
        session_start();
        $_SESSION['csrf_token'] = $data->csrf_token;
        $_SESSION['logout_token'] = $data->logout_token;
        $_SESSION['uid'] = $data->current_user->uid;
        $_SESSION['name'] = $data->current_user->name;
        unset($_POST);
        exit;
    } else {
        //echo "Fail";
        echo $response;
        //header('Location: http://fridayapp.cu.ma/drupal-api/login.php');
    }
    // if ($err) {
    //     echo "cURL Error is :" .$err;
    //     //echo $response;
    //     // echo '<pre>';
    //     // print_r($data);
    //     // echo  '</pre>';
    //     //header('Location: http://fridayapp.cu.ma/drupal-api/login.php');
    // } else {
    //     //echo $response;
    //     // echo '<pre>';
    //     // print_r($data);
    //     // echo  '</pre>';
    //     //header('Location: http://fridayapp.cu.ma/drupal-api/');
    //     //unset($serialized_entity);
    //    // exit;
    // }
        // echo "<br>";
        // echo "User Id: " . $data->current_user->uid;
        // echo "<br>";
        // echo "User Name: " . $data->current_user->name;
        // echo "<br>";
        // echo "CSRF Token: " . $data->csrf_token;
        // echo "<br>";
        // echo "Logout Token: " . $data->logout_token;
        
        // session_start();
        // $_SESSION['csrf_token'] = $data->csrf_token;
        // $_SESSION['logout_token'] = $data->logout_token;
}
?>

<!DOCTYPE html>
<html lang="en" ng-app="taskApp">

<head>
    <base href="/">
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <title>Drupal JS API</title>
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/font-awesome/4.4.0/css/font-awesome.min.css">
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0/css/bootstrap.min.css" integrity="sha384-Gn5384xqQ1aoWXA+058RXPxPg6fy4IWvTNh0E263XmFcJlSAwiGgFAW/dAiS6JXm" crossorigin="anonymous">
    <script src="https://code.jquery.com/jquery-3.2.1.slim.min.js" integrity="sha384-KJ3o2DKtIkvYIK3UENzmM7KCkRr/rE9/Qpg6aAZGJwFDMVNA/GpGFF93hXpG5KkN" crossorigin="anonymous"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.12.9/umd/popper.min.js" integrity="sha384-ApNbgh9B+Y1QKtv3Rn7W3mgPxhU9K/ScQsAP7hUibX39j7fakFPskvXusvfa0b4Q" crossorigin="anonymous"></script>
    <script src="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0/js/bootstrap.min.js" integrity="sha384-JZR6Spejh4U02d8jOt6vLEHfe/JQGiRRSQQxSfFWpi1MquVdAyjUar5+76PVCmYl" crossorigin="anonymous"></script>
</head>

<body>
    <div class="container mt-4">
        <div class="row">
            <div class="col-sm-4">
                <div id="msg" class="alert alert-success" role="alert">
                    <span id="message"></span>
                </div>
                <form method="post" action="http://fridayapp.cu.ma/drupal-api/login.php">
                    <div class="alert alert-primary" role="alert">Login</div>
                    <div class="form-group">
                        <input class="form-control" type="text" id="name" name="name" placeholder="name" required>
                    </div>
                    <div class="form-group">
                        <input class="form-control" type="password" id="pass" name="pass" placeholder="password" required>
                    </div>
                    <button type="submit" name="Submit" class="btn btn-primary"><b>Submit</b> </button>
                   <!--  <a href="http://fridayapp.cu.ma/drupal-api/register.php" class="btn btn-primary">Register</a> -->
                </form>
            </div>
            <div class="col-sm-8">
            </div>
        </div>
    </div>
</body>

</html>
