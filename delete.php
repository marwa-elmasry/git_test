<?php 

// Allow any origin to access this API
header('Access-Control-Allow-Origin: *');
header('Content-Type: application/json');
header('Access-Control-Allow-Method: DELETE');
header('Access-Control-Allow-Headers: content-Type, Access-control-Allow-Headers,Authorization,X-Request-With');

include('function.php');

$requestMethod  = $_SERVER["REQUEST_METHOD"];

if ($requestMethod == "DELETE") {
 
 $deleteuser = deleteUser($_GET);
 echo $deleteuser;
    
}
else {
    $data = [
        'status'  => 405,
        'message'  => $requestMethod.' Method Not Allowed',
        
    ];
    header("HTTP/1.0 405 Method Not Allowed");
    echo json_encode($data);
}



?>
