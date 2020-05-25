<?php
header('Access-Control-Allow-Origin: *');
header('Content-Type: application/json; charset=UTF-8');
header('Access-Control-Allow-Methods: POST, GET, PUT, DELETE');
header('Access-Control-Max-Age: 3600');
header('Access-Control-Allow-Headers: Content-Type, Access-Control-Allow-Headers, Authorization, X-Requested-With');

require_once '../config/core.php';
require_once '../model/User.php';

$user = new User($db->getConnection());

if ($_SERVER['REQUEST_METHOD'] === 'GET')
{
    $stmt = $user->selectAll();
    $num = $stmt->rowCount();

    if ($num > 0)
    {
        $users_arr = [];

        while ($row = $stmt->fetch())
        {
            array_push($users_arr, $row);
        }
        
        http_response_code(200); // OK
        echo json_encode($users_arr);
    }
    else
    {
        http_response_code(404); // Not found
        echo json_encode(['message' => 'No users found.']);
    }
}

if ($_SERVER['REQUEST_METHOD'] === 'POST')
{
    // get posted data
    $data = json_decode(file_get_contents('php://input'));
    
    if (!empty($data->username))
    {
        $user->setUsername($data->username);

        if ($user->create())
        {
            http_response_code(201);
            echo json_encode(['message' => 'User was created.']);
        }
        else
        {
            http_response_code(503); // 503 service unavailable
            echo json_encode(['message' => 'Unable to create a user.']);
        }
    }
    else
    {
        http_response_code(400); // 400 bad request
        echo json_encode(['message' => 'Unable to create user. Data is incomplete.']);
    }
}

if ($_SERVER['REQUEST_METHOD'] === 'PUT')
{
    $data = json_decode(file_get_contents('php://input'));

    $user->setId($data->id);
    $user->setUsername($data->username);

    if ($user->update())
    {
        http_response_code(200); // 200 ok
        echo json_encode(['message' => 'User was updated.']);
    }
    else
    {
        http_response_code(503); // 503 service unavailable
        echo json_encode(['message' => 'Unable to update user.']);
    }
}