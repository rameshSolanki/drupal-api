<?php
 session_start();
  $csrf_token = $_SESSION['csrf_token'];
if (!isset($_SESSION['name'])) {
    header('Location: http://fridayapp.cu.ma/drupal-api/login.php');
}
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
    'X-CSRF-Token: '.$csrf_token,
    'Content-Type: application/hal+json',
    'Authorization: Basic YWRtaW46ZHJ1cGFsQCMwMDc='
  ),
));

$responseGet = curl_exec($curl);

curl_close($curl);
//echo $responseGet;


if (isset($_POST['Submit'])) {
    $title = $_POST['title'];
    $body = $_POST['body'];
    // $field_task_date = $_POST['field_task_date'];

    // $node = array(
    // 'title' => $title,
    // 'body' => $body,
    // 'date' => $field_blog_date
    // );
    $serialized_entity = json_encode([
        'title' => [['value' => $title]],
        'body' => [['value' => $body]],
        // 'field_task_date' => [['value' => $field_task_date]],
        '_links' => ['type' => [
            'href' => 'http://fridayapp.cu.ma/lawncare/rest/type/node/task'
        ]],
      ]);

    $curl = curl_init();

    curl_setopt_array($curl, array(
    CURLOPT_URL => 'http://fridayapp.cu.ma/lawncare/node/'.$_GET['nid'].'?_format=json',
    CURLOPT_RETURNTRANSFER => true,
    CURLOPT_ENCODING => '',
    CURLOPT_MAXREDIRS => 10,
    CURLOPT_TIMEOUT => 0,
    CURLOPT_FOLLOWLOCATION => true,
    CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
    CURLOPT_CUSTOMREQUEST => 'PATCH',
    CURLOPT_POSTFIELDS => $serialized_entity,
    CURLOPT_HTTPHEADER => array(
    'X-CSRF-Token: 8Js5xygCPT4glAh-T75SaokDJNhUugrJbkntbmHJ6_c',
    'Content-Type: application/hal+json',
    'Authorization: Basic YWRtaW46ZHJ1cGFsQCMwMDc='
    ),
    ));

    $responseUpdate = curl_exec($curl);

    curl_close($curl);
    if ($err) {
        echo "cURL Error is :" .$err;
    } else {
        echo $responseInsert;
        header('Location: http://fridayapp.cu.ma/drupal-api/');
        unset($serialized_entity);
        exit;
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
                <div id="msg" class="alert alert-success" role="alert">
                    <span id="message"></span>
                </div>
                <?php $data = json_decode($responseGet);?>


                <form method="post" action="">
                    <div class="alert alert-primary" role="alert">Update Blog </div>
                    <div class="form-group">
                        <input class="form-control" type="text" id="title" name="title" value="<?php echo $data[0]->title; ?>" required>
                    </div>
                    <div class="form-group">
                        <textarea class="form-control" type="text" name="body" value="<?php echo $data[0]->body; ?>" id="body"
                            rows="3"><?php echo $data[0]->body; ?></textarea>
                    </div>
                    <div class="form-group">
                        <input disabled step="any" class="form-control" type="text" name="field_task_date" value="<?php echo $data[0]->field_task_date; ?>" id="field_task_date">
                    </div>

                    <button type="submit" name="Submit" class="btn btn-primary"><b>Submit</b>
                    </button>
                </form>

                </div>
        </div>
    </div>
    <script>

function timestampToDatetimeInputString(timestamp) {
     const date = new Date((timestamp + _getTimeZoneOffsetInMs()));
     // slice(0, 19) includes seconds
     return date.toISOString().slice(0, 19);
 }

 function _getTimeZoneOffsetInMs() {
     return new Date().getTimezoneOffset() * -60 * 1000;
 }

 document.getElementById('field_task_date').value = timestampToDatetimeInputString();
</script>
    </body>
</html>
