<?php

require '../inc/dbconn.php';

function error422($message)
{
    $data = [
        'status'  => 422,
        'message'  => $message,

    ];
    header("HTTP/1.0 422 unprocessable entity");
    echo json_encode($data);
    exit();
}



function storeUser($userInput)
{

    global $conn;

    $username = mysqli_real_escape_string($conn, $userInput['username']);
    $email = mysqli_real_escape_string($conn, $userInput['email']);
    $password = mysqli_real_escape_string($conn, $userInput['password']);

    if (empty(trim($username))) {

        return error422("enter your name ");
    } elseif (empty(trim($email))) {

        return error422("enter your eamil ");
    } elseif (empty(trim($password))) {

        return error422("enter your password ");
    } else {
        $query = "INSERT INTO users (username,email,password) VALUES ('$username','$email','$password')";
        $result = mysqli_query($conn, $query);

        if ($result) {
            $data = [
                'status'  => 201,
                'message'  => 'user created successfully',
            ];
            header("HTTP/1.0 201 created");
            return json_encode($data);
        } else {
            $data = [
                'status'  => 500,
                'message'  => 'Internal Server Error',
            ];
            header("HTTP/1.0 500 Internal Server Error");
            return json_encode($data);
        }
    }
}




function getUserList()
{
    global $conn;

    $query  = "SELECT * FROM users ";
    $query_run  = mysqli_query($conn, $query);

    if ($query_run) {

        if (mysqli_num_rows($query_run) > 0) {

            $response  = mysqli_fetch_all($query_run, MYSQLI_ASSOC);

            $data = [
                'status'  => 200,
                'message'  => 'User List Fetched Successfully',
                'data'  => $response
            ];
            header("HTTP/1.0 200 ok ");
            return json_encode($data);
        } else {
            $data = [
                'status'  => 404,
                'message'  => 'No users Found',
            ];
            header("HTTP/1.0 404 No users Found");
            return json_encode($data);
        }
    } else {

        $data = [
            'status'  => 500,
            'message'  => 'Internal Server Error',
        ];
        header("HTTP/1.0 500 Internal Server Error");
        return json_encode($data);
    }
}

function getuser($user)
{
    global $conn;

    if ($user['id'] == null) {
        return error422('Enter your user id ');
    }

    $userId  = mysqli_real_escape_string($conn, $user['id']);
    $query = "SELECT * FROM users WHERE id='$userId' LIMIT 1";
    $result = mysqli_query($conn, $query);

    if ($result) {
        if (mysqli_num_rows($result) == 1) {
            $response = mysqli_fetch_assoc($result);
            $data = [
                'status'  => 200,
                'message'  => 'user fetched successfuly',
                'data' => $response
            ];
            header("HTTP/1.0 200 ok ");
            return json_encode($data);
        } else {
            $data = [
                'status'  => 404,
                'message'  => 'no user found',
            ];
            header("HTTP/1.0 404 Not found");
            return json_encode($data);
        }
    } else {
        $data = [
            'status'  => 500,
            'message'  => 'Internal Server Error',
        ];
        header("HTTP/1.0 500 Internal Server Error");
        return json_encode($data);
    }
}

function updateUser($userInput, $userparams)
{

    global $conn;

    if (!isset($userparams['id'])) {
        return error422('user id not found in url');
    } elseif ($userparams['id'] == null) {
        return error422('Enter the user id');
    }

    $userId = mysqli_real_escape_string($conn, $userparams['id']);
    $username = mysqli_real_escape_string($conn, $userInput['username']);
    $email = mysqli_real_escape_string($conn, $userInput['email']);
    $password = mysqli_real_escape_string($conn, $userInput['password']);

    if (empty(trim($username))) {
        return error422("enter your name ");
    } elseif (empty(trim($email))) {
        return error422("enter your eamil ");
    } elseif (empty(trim($password))) {
        return error422("enter your password ");
    } else {
        $query = "UPDATE users SET  username='$username',email='$email',password='$password' WHERE id='$userId' LIMIT 1 ";
        $result = mysqli_query($conn, $query);

        if ($result) {
            $data = [
                'status'  => 200,
                'message'  => 'user updated successfully',
            ];
            header("HTTP/1.0 200 Success");
            return json_encode($data);
        } else {
            $data = [
                'status'  => 500,
                'message'  => 'Internal Server Error',
            ];
            header("HTTP/1.0 500 Internal Server Error");
            return json_encode($data);
        }
    }
}

function deleteUser($userparams)
{
    global $conn;

    if (!isset($userparams['id'])) {
        return error422('user id not found in url');
    } elseif ($userparams['id'] == null) {
        return error422('Enter the user id');
    }

    $userId = mysqli_real_escape_string($conn, $userparams['id']);
    $query = "DELETE FROM users WHERE id='$userId' LIMIT 1";
    $result = mysqli_query($conn, $query);

    if ($result) {
        $data = [
            'status'  => 200,
            'message'  => 'user deleted successfully',
        ];
        header("HTTP/1.0 200 Deleted ");
        return json_encode($data);
    } else {
        $data = [
            'status'  => 404,
            'message'  => 'user not found',
        ];
        header("HTTP/1.0 404 not found");
        return json_encode($data);
    }
}
