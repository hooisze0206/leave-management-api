<?php
namespace Src\Controller;

use Src\Gateway\loginGateway;
header('Access-Control-Allow-Origin: http://localhost:3000');
header('Access-Control-Allow-Methods: POST, GET, PUT, OPTIONS, PATCH, DELETE');
header('Access-Control-Allow-Credentials: true');
header('Access-Control-Allow-Headers: Authorization, Content-Type, x-xsrf-token, x_csrftoken, Cache-Control, X-Requested-With');
class LoginController {

    private $db;
    private $requestMethod;
    private $type;

    private $loginGateway;

    public function __construct($db, $requestMethod, $type)
    {
        $this->db = $db;
        $this->requestMethod = $requestMethod;
        $this->type = $type;

        $this->loginGateway = new loginGateway($db);
    }

    public function processRequest()
    {
        switch ($this->requestMethod) {
            case 'POST':
                if ($this->type == 'checkUserID'){
                    $response = $this->checkUserID();
                }
                else if ($this->type == 'checkUserPassword'){
                    $response = $this->checkUserPassword();
                }
                else if ($this->type == 'changePassword'){
                    $response = $this->changePassword();
                }
                else{
                    $response = $this->loginUser();
                }
                
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


    private function loginUser()
    {
        $input = file_get_contents('php://input');
        $data = json_decode($input);
        $result = $this->loginGateway->login_user($data);
        if ($result == 'User not Found') {
            $response['status_code_header'] = 'HTTP/1.1 404 Not Found';
            $response['body'] = json_encode(array('status' => 'Failed','message' => 'User not found, Please check username and password'));
            return $response;
        }
        $response['status_code_header'] = 'HTTP/1.1 201 Created';
        $response['body'] = json_encode(array('token' => uniqid(), 'user' =>$result));
        return $response;
    }

    private function changePassword()
    {
        $input = file_get_contents('php://input');
        $data = json_decode($input);
        $result = $this->loginGateway->change_password($data);
        if (! $result) {
            $response['status_code_header'] = 'HTTP/1.1 400 Bad Request';
            $response['body'] = json_encode(array('status' => 'Failed','message' => 'Fail to change password'));
            return $this->notFoundResponse();
        }
        $response['status_code_header'] = 'HTTP/1.1 201 Created';
        $response['body'] = json_encode(array('status' => 'Success','message' => 'Change password Success'));
        return $response;
    }

    private function checkUserID()
    {
        $input = file_get_contents('php://input');
        $data = json_decode($input);
        $result = $this->loginGateway->check_user_id($data);
        
        $response['status_code_header'] = 'HTTP/1.1 201 Created';
        $response['body'] = json_encode($result);
        return $response;
    }

    private function checkUserPassword()
    {
        $input = file_get_contents('php://input');
        $data = json_decode($input);
        $result = $this->loginGateway->check_user_password($data);
        
        $response['status_code_header'] = 'HTTP/1.1 201 Created';
        $response['body'] = json_encode($result);
        return $response;
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