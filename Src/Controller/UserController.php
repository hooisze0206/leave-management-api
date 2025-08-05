<?php
namespace Src\Controller;

use Src\Gateway\userGateway;
header("Access-Control-Allow-Origin: *");
header("Content-Type: application/json; charset=UTF-8");
class UserController {

    private $db;
    private $requestMethod;
    private $userId;

    private $userGateway;

    public function __construct($db, $requestMethod, $userId)
    {
        $this->db = $db;
        $this->requestMethod = $requestMethod;
        $this->userId = $userId;

        $this->userGateway = new userGateway($db);
    }

    public function processRequest()
    {
        switch ($this->requestMethod) {
            case 'GET':
                if ($this->userId) {
                    $response = $this->getUser($this->userId);
                } else {
                    $response = $this->getAllUsers();
                };
                break;
            case 'POST':
                if ($this->userId) {
                    $response = $this->updateUser($this->userId);
                }
                else{
                   $response = $this->createUser(); 
                }
                break;
            case 'PUT':
                $response = $this->updateUser($this->userId);
                break;
            case 'DELETE':
                $response = $this->deleteUser($this->userId);
                break;
            default:
                $response = $this->notFoundResponse();
                break;
        }
        header($response['status_code_header']);
        if ($response['body']) {
            echo $response['body'];
        }
    }

    private function getAllUsers()
    {
        $result = $this->userGateway->get_all_user();
        $response['status_code_header'] = 'HTTP/1.1 200 OK';
        $response['body'] = json_encode($result);
        return $response;
    }

    private function getUser($id)
    {
        $result = $this->userGateway->get_user($id);
        if (! $result) {
            return $this->notFoundResponse();
        }
        $response['status_code_header'] = 'HTTP/1.1 200 OK';
        $response['body'] = json_encode($result);
        return $response;
    }

    private function createUser()
    {
        $input = file_get_contents('php://input');
        $data = json_decode($input);

        $result = $this->userGateway->create_user($data);
        if (! $result) {
            $response['status_code_header'] = 'HTTP/1.1 400 Bad Request';
            $response['body'] = json_encode(array('status' => 'Failed','message' => 'Fail to add user'));
            return $this->notFoundResponse();
        }
        $response['status_code_header'] = 'HTTP/1.1 201 Created';
        $response['body'] = json_encode(array('status' => 'Success','message' => 'Add User Success'));
        return $response;
    }

    private function updateUser($id)
    {

        $input = file_get_contents('php://input');
        $data = json_decode($input);

        $result = $this->userGateway->update_user($data);
        if (! $result) {
            $response['status_code_header'] = 'HTTP/1.1 400 Bad Request';
            $response['body'] = json_encode(array('status' => 'Failed','message' => 'Fail to add user'));
            return $this->notFoundResponse();
        }
        $response['status_code_header'] = 'HTTP/1.1 201 Created';
        $response['body'] = json_encode(array('status' => 'Success','message' => 'Add User Success'));
        return $response;
    }

    private function deleteUser($id)
    {
        $result = $this->personGateway->find($id);
        if (! $result) {
            return $this->notFoundResponse();
        }
        $this->personGateway->delete($id);
        $response['status_code_header'] = 'HTTP/1.1 200 OK';
        $response['body'] = null;
        return $response;
    }

    private function validatePerson($input)
    {
        if (! isset($input['firstname'])) {
            return false;
        }
        if (! isset($input['lastname'])) {
            return false;
        }
        return true;
    }

    private function unprocessableEntityResponse()
    {
        $response['status_code_header'] = 'HTTP/1.1 422 Unprocessable Entity';
        $response['body'] = json_encode([
            'error' => 'Invalid input'
        ]);
        return $response;
    }

    private function notFoundResponse()
    {
        $response['status_code_header'] = 'HTTP/1.1 404 Not Found';
        $response['body'] = null;
        return $response;
    }
}