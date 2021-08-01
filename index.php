<?php
 session_start();
if (!isset($_SESSION['name'])) {
    header('Location: http://fridayapp.cu.ma/drupal-api/login.php');
}
$curl = curl_init();

curl_setopt_array($curl, array(
  CURLOPT_URL => 'http://fridayapp.cu.ma/lawncare/api',
  CURLOPT_RETURNTRANSFER => true,
  CURLOPT_ENCODING => '',
  CURLOPT_MAXREDIRS => 10,
  CURLOPT_TIMEOUT => 0,
  CURLOPT_FOLLOWLOCATION => true,
  CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
  CURLOPT_CUSTOMREQUEST => 'GET',
  CURLOPT_HTTPHEADER => array(
    'Authorization: Basic YWRtaW46ZHJ1cGFsQCMwMDc='
  ),
));

$response = curl_exec($curl);

curl_close($curl);
//echo $response;
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
    <script type="text/javascript" src="http://fridayapp.cu.ma/drupal-api/script.js"></script>

</head>

<body>
    <div class="mt-4 p-3">
        <div class="row">
            <div class="container">
            <div id="msg" class="alert alert-success" role="alert">
                    <span id="message"></span>
                </div>
               
                  <?php

                   
                    $csrf_token = $_SESSION['csrf_token'];
                    $logout_token = $_SESSION['logout_token'];
                    $uid = $_SESSION['uid'];
                    $name = $_SESSION['name'];

                    //echo "Your csrf_token is: ".$csrf_token."";
                   // echo "<br>";
                    //echo "Your logout_token is: ".$logout_token."";
                   // echo "<br>";
                    //echo "Your ID is: ".$uid."";
                    //echo "<br>";
                    echo "Welcome: ".$name." | <a href='http://fridayapp.cu.ma/drupal-api/logout.php'>Logout</a>";
                    echo "<br>";

                    ?>
            <div class="row ml-2">

                <div class="alert alert-primary mt-4 col-sm-4" role="alert">All Blogs </div>
                <div class="alert alert-primary  ml-2 mt-4 col-sm-4" role="alert" ><a href="http://fridayapp.cu.ma/drupal-api/postBlog.php">Add Blog </a></div>
                </div>
                <div class="table table-responsive">
                    <table class="table table-bordered" id='items_table'>
                        <thead class="thead-light">
                            <tr>

                                <th>Id</th>
                                <th>Title</th>
                                <th>Date</th>
                                <!-- <th>Body</th>
                                <th>Thumbnail</th> -->
                                <th>Action</th>
                            </tr>
                        </thead>
                        <tbody>
                        <?php $data = json_decode($response);
                        // echo "<pre>";
                        // print_r($data);

                        foreach ($data as $node) {?>
                            <tr>
                                <td><?php echo $node->nid; ?></td>
                                <td><a href="http://fridayapp.cu.ma/drupal-api/singleBlog.php?nid=<?php echo $node->nid; ?>"><?php echo $node->title; ?></a></td>
                                <td><?php echo $node->field_task_date; ?></td>
                                <!-- <td><?php //echo $node->body; ?></td>
                                <td><img class="img-thumbnail" width="100" src="<?php //echo $node->field_task_thumbnail; ?>"></img></td> -->
                                <td><button class="mt-2 btn btn-sm btn-success"><a class="text-white" href="http://fridayapp.cu.ma/drupal-api/updateBlog.php?nid=<?php echo $node->nid; ?>"><i class="fa fa-pencil-square-o" aria-hidden="true"></i></a></button>
                                <button id="delBtn" class="mt-2 btn btn-sm btn-danger"  data-nid="<?php echo $node->nid; ?>" onclick="fun(event)"><i class="fa fa-trash-o" aria-hidden="true"></i></button></td>
                            </tr>
                        <?php }?>
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>

</body>
</html>
