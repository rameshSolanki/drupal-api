<?php
 session_start();
   $uid = $_SESSION['uid'];
    //echo $uid;
   $csrf_token = $_SESSION['csrf_token'];
  // $username = $_SESSION['name'];
   //$auth = 'Basic '. base64_encode ($username . ':' . $pass);
//$url = file_get_contents('http://fridayapp.cu.ma/lawncare/rest/session/token?value');
//echo $csrf_token;
if (!isset($_SESSION['name'])) {
    header('Location: http://fridayapp.cu.ma/drupal-api/login.php');
}
if(isset($_POST["Submit"])) {

	$check = getimagesize($_FILES["field_task_thumbnail"]["tmp_name"]);
    $filename = $_FILES['field_task_thumbnail']['name'];
			
	if($check !== false) {
		$data = base64_encode(file_get_contents( $_FILES["field_task_thumbnail"]["tmp_name"] ));
		//echo "<textarea rows='5' cols='150' id='data'>data:".$check["mime"].";base64,".$data."</textarea>";

    $serialized_entity = json_encode([
    '_links' => ['type' => [
        'href' => 'http://fridayapp.cu.ma/lawncare/rest/type/file/image'
    ]],
	'filename' => [['value' => $filename]],
	'filemime' => [['value' => $check["mime"]]],
	'uri' => [['value' => 'public://'.$filename]],
	'type' => [['target_id'=> 'image',
	          'uuid'=> '1',
              'status'=>'1'
    ]],
	'data' => [['value' => $data]],
    ]);

    $curl = curl_init();

curl_setopt_array($curl, array(
  CURLOPT_URL => 'http://fridayapp.cu.ma/lawncare/entity/file?_format=hal_json',
  CURLOPT_RETURNTRANSFER => true,
  CURLOPT_ENCODING => '',
  CURLOPT_MAXREDIRS => 10,
  CURLOPT_TIMEOUT => 0,
  CURLOPT_FOLLOWLOCATION => true,
  CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
  CURLOPT_CUSTOMREQUEST => 'POST',
  CURLOPT_POSTFIELDS => $serialized_entity,
  CURLOPT_HTTPHEADER => array(
    'X-CSRF-Token: '.$csrf_token,
    'Content-Type: application/hal+json',
    'Authorization: Basic YWRtaW46ZHJ1cGFsQCMwMDc='
  ),
));

$response = curl_exec($curl);
$data = json_decode($response);
curl_close($curl);
//echo $response;
//echo "<br>";
//echo "ID:".$data->fid[0]->value;
//echo "<br>";
//echo '<pre>';
//print_r($data);
//echo  '</pre>';
if (isset($_POST['Submit'])) {
    $title = $_POST['title'];
    $body = $_POST['body'];
    $field_task_date = $_POST['field_task_date'];
    $field_task_thumbnail = $_POST['field_task_thumbnail'];

    $serialized_entity = json_encode([
    'title' => [['value' => $title]],
    'body' => [['value' => $body]],
    'field_task_date' => [['value' => $field_task_date]],
    'field_task_thumbnail' => [['target_id' => $data->fid[0]->value]],
    '_links' => ['type' => [
        'href' => 'http://fridayapp.cu.ma/lawncare/rest/type/node/task'
    ]],
    ]);

    $curl = curl_init();

    curl_setopt_array($curl, array(
    CURLOPT_URL => 'http://fridayapp.cu.ma/lawncare/entity/node?_format=json',
    CURLOPT_RETURNTRANSFER => true,
    CURLOPT_ENCODING => '',
    CURLOPT_MAXREDIRS => 10,
    CURLOPT_TIMEOUT => 0,
    CURLOPT_FOLLOWLOCATION => true,
    CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
    CURLOPT_CUSTOMREQUEST => 'POST',
    CURLOPT_POSTFIELDS => $serialized_entity,
    CURLOPT_HTTPHEADER => array(
    'X-CSRF-Token: '.$csrf_token,
    'Content-Type: application/hal+json',
    'Authorization: Basic YWRtaW46ZHJ1cGFsQCMwMDc='
    ),
    ));

    $responseInsert = curl_exec($curl);

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
} else {
	echo "File is not an image.";
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
                <form method="post" action="http://fridayapp.cu.ma/drupal-api/postBlog.php" enctype="multipart/form-data">
                    <div class="alert alert-primary" role="alert">Add Blog </div>
                    <div class="form-group">
                        <input class="form-control" type="text" id="title" name="title" placeholder="title" required>
                    </div>
                    <div class="form-group">
                        <textarea class="form-control" type="text" name="body" placeholder="body" id="body"
                            rows="3"></textarea>
                    </div>
                    <div class="form-group">
                        <input step="any" class="form-control" type="datetime-local" name="field_task_date" placeholder="date" id="field_task_date">
                    </div>
                    <div class="form-group">
                    <input type="file" id="field_task_thumbnail" name="field_task_thumbnail">
                     </div>
                    <button type="submit" name="Submit" class="btn btn-primary"><b>Submit</b>
                    </button>
                </form>
                </div>
        </div>
    </div>
    <script>
	
	/* fetch('http://fridayapp.cu.ma/lawncare/session/token')
     .then(function(response) {
       return response;
     })
     .then(function(token) {
       console.log('CSRF TOKEN'+token);
	   alert('CSRF TOKEN'+token);
     }); */

function timestampToDatetimeInputString(timestamp) {
     const date = new Date((timestamp + _getTimeZoneOffsetInMs()));
     // slice(0, 19) includes seconds
     return date.toISOString().slice(0, 19);
 }

 function _getTimeZoneOffsetInMs() {
     return new Date().getTimezoneOffset() * -60 * 1000;
 }

 document.getElementById('field_task_date').value = timestampToDatetimeInputString(Date.now());
</script>
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
