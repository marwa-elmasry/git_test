<?php 
error_reporting(0);

// Allow any origin to access this API
header('Access-Control-Allow-Origin: *');
header('Content-Type: application/json');
header('Access-Control-Allow-Method: PUT ');
header('Access-Control-Allow-Headers: content-Type, Access-control-Allow-Headers,Authorization,X-Request-With');

include('function.php');

$requestMethod  = $_SERVER["REQUEST_METHOD"];


if ($requestMethod =='PUT') {
    
    
    $inputData = json_decode(file_get_contents("php://input"),true);
    $updateUser = updateUser($inputData,$_GET);
    // if (empty($inputData)) {
        
    //     $updateUser = updateUser($_POST,$_GET);
    // }else {
        
    //     $updateUser = updateUser($inputData,$_GET);
    // }

    echo $updateUser;

    

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