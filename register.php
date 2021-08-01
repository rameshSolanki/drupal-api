<?php

if (isset($_POST['Submit'])) {
    $name = $_POST['name'];
    $mail = $_POST['mail'];
    $pass = $_POST['pass'];
    $status = $_POST['status'];
    $roles = $_POST['roles'];

    $serialized_entity = json_encode([
    'name' => [['value' => $name]],
    'mail' => [['value' => $mail]],
    'pass' => [['value' => $pass]],
    'status' => [['value' => 1]],
    'roles' => [['target_id' => 'editor']],
    '_links' => ['type' => [
        'href' => 'http://fridayapp.cu.ma/lawncare/rest/type/user/user'
    ]],
    ]);

    $curl = curl_init();

    curl_setopt_array($curl, array(
    CURLOPT_URL => 'http://fridayapp.cu.ma/lawncare/entity/user?_format=json',
    CURLOPT_RETURNTRANSFER => true,
    CURLOPT_ENCODING => '',
    CURLOPT_MAXREDIRS => 10,
    CURLOPT_TIMEOUT => 0,
    CURLOPT_FOLLOWLOCATION => true,
    CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
    CURLOPT_CUSTOMREQUEST => 'POST',
    CURLOPT_POSTFIELDS => $serialized_entity,
    CURLOPT_HTTPHEADER => array(
    'X-CSRF-Token: 2Hfop35H4HAL9fUSNNc6JiKa0YjG4Mp_TSf2w6KEZIc',
    'Content-Type: application/hal+json'
    ),
    ));

    $response = curl_exec($curl);

    curl_close($curl);

    if ($response) {
        echo $response;
    } else {
        echo $response;
        //header('Location: http://fridayapp.cu.ma/drupal-api/');
        //unset($serialized_entity);
        //exit;
    }
}
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

</head>

<body>
    <div class="mt-4 p-3">
        <div class="row">
            <div class="container">
                <div id="msg" class="alert alert-success" role="alert">
                    <span id="message"></span>
                </div>
                <form method="post" action="http://fridayapp.cu.ma/drupal-api/register.php">
                    <div class="alert alert-primary" role="alert">Add User </div>
                    <div class="form-group">
                        <input class="form-control" type="text" id="name" name="name" placeholder="name" required>
                    </div>
                    <div class="form-group">
                       <input class="form-control" type="text" id="mail" name="mail" placeholder="mail" required>
                    </div>
                    <div class="form-group">
                        <input class="form-control" type="text" name="pass" placeholder="pass" id="pass">
                    </div>

                    <button type="submit" name="Submit" class="btn btn-primary"><b>Submit</b>
                    </button>
                    <!--   <a href="http://fridayapp.cu.ma/drupal-api/login.php" class="btn btn-primary">Login</a> -->
                </form>
                </div>
        </div>
    </div>
   
<script src="https://code.jquery.com/jquery-3.2.1.slim.min.js"
        integrity="sha384-KJ3o2DKtIkvYIK3UENzmM7KCkRr/rE9/Qpg6aAZGJwFDMVNA/GpGFF93hXpG5KkN" crossorigin="anonymous">
    </script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.12.9/umd/popper.min.js"
        integrity="sha384-ApNbgh9B+Y1QKtv3Rn7W3mgPxhU9K/ScQsAP7hUibX39j7fakFPskvXusvfa0b4Q" crossorigin="anonymous">
    </script>
    <script src="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0/js/bootstrap.min.js"
        integrity="sha384-JZR6Spejh4U02d8jOt6vLEHfe/JQGiRRSQQxSfFWpi1MquVdAyjUar5+76PVCmYl" crossorigin="anonymous">
    </script>
    </body>
</html>
