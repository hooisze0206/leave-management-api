<?php
namespace Src\Controller;

use Src\Gateway\emailGateway;
header('Access-Control-Allow-Origin: http://localhost:3000');
header('Access-Control-Allow-Methods: POST, GET, PUT, OPTIONS, PATCH, DELETE');
header('Access-Control-Allow-Credentials: true');
header('Access-Control-Allow-Headers: Authorization, Content-Type, x-xsrf-token, x_csrftoken, Cache-Control, X-Requested-With');
class EmailController {

    private $db;
    private $requestMethod;
    private $id;
    private $type;
    private $emailGateway;

    public function __construct($db, $requestMethod, $type, $id)
    {
        $this->db = $db;
        $this->requestMethod = $requestMethod;
        $this->type = $type;
        $this->id = $id;
        $this->emailGateway = new EmailGateway($db);
    }

    public function processRequest()
    {
        switch ($this->requestMethod) {
            case 'POST':
                if ($this->type == 'forgotPassword') {
                    if ($this->id) {
                        $response = $this->forgotPasswordEmail($this->id);   
                    }   
                }
                if ($this->type == 'leaveRequestEmail') {
                    if ($this->id) {
                        $response = $this->leaveRequestEmail($this->id);   
                    }   
                }
                $response = $this->sendEmail($this->id);
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


    private function forgotPasswordEmail($id)
    {
        $input = file_get_contents('php://input');
        $data = json_decode($input);

        $result = $this->emailGateway->forgot_password_email($data);
        if ($result == 'Message has been sent') {
            $response['status_code_header'] = 'HTTP/1.1 201 Created';
            $response['body'] = json_encode(array('status' => 'Success', 'message' => 'Reset Password Success'));
            return $response;
        }

        $response['status_code_header'] = 'HTTP/1.1 404 Not Found';
        $response['body'] = json_encode(array('status' => 'Failed','message' => 'Fail to reset password'));
        return $response;
    }

    private function leaveRequestEmail($id)
    {
        $input = file_get_contents('php://input');
        $data = json_decode($input);

        $result = $this->emailGateway->leave_leave_email($data);
        if ($result == 'Message has been sent') {
            $response['status_code_header'] = 'HTTP/1.1 201 Created';
            $response['body'] = json_encode(array('status' => 'Success', 'message' => 'Reset Password Success'));
            return $response;
        }

        $response['status_code_header'] = 'HTTP/1.1 404 Not Found';
        $response['body'] = json_encode(array('status' => 'Failed','message' => 'Fail to reset password'));
        return $response;
    }

    private function sendEmail($id)
    {

        $result = $this->emailGateway->send_email($id);
        if ($result == 'Message has been sent') {
            $response['status_code_header'] = 'HTTP/1.1 404 Not Found';
            $response['body'] = json_encode(array('status' => 'Failed','message' => 'User not found, Please check username and password'));
            return $response;
        }
        $response['status_code_header'] = 'HTTP/1.1 201 Created';
        $response['body'] = json_encode(array('token' => uniqid(), 'user' =>$result));
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