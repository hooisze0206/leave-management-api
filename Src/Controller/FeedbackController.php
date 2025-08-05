<?php
namespace Src\Controller;

use Src\Gateway\feedbackGateway;
header('Access-Control-Allow-Origin: http://localhost:3000');
header('Access-Control-Allow-Methods: POST, GET, PUT, OPTIONS, PATCH, DELETE');
header('Access-Control-Allow-Credentials: true');
header('Access-Control-Allow-Headers: Authorization, Content-Type, x-xsrf-token, x_csrftoken, Cache-Control, X-Requested-With');
class FeedbackController {

    private $db;
    private $requestMethod;
    private $id;
    private $type;

    private $feedbackGateway;

    public function __construct($db, $requestMethod, $type, $id)
    {
        $this->db = $db;
        $this->requestMethod = $requestMethod;
        $this->type = $type;
        $this->id = $id;

        $this->feedbackGateway = new feedbackGateway($db);
    }

    public function processRequest()
    {
        switch ($this->requestMethod) {
            case 'GET':
                if ($this->type == 'get_feedback_by_status') {
                    if ($this->id) {
                        $response = $this->getFeedbackStatus($this->id);   
                    }   
                }
                if ($this->type == 'get_feedback_by_user') {
                    $response = $this->getFeedbackByUser($this->id);   
                }
                break;
            case 'POST':
                if ($this->type == 'updateFeedbackStatus') {
                    if ($this->id) {
                        $response = $this->updateFeedbackStatus($this->id);   
                    }   
                }else{
                    $response = $this->createFeedback();
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

    private function getFeedbackStatus($id)
    {
        $result = $this->feedbackGateway->get_feedback_status($id);
        $response['status_code_header'] = 'HTTP/1.1 200 OK';
        $response['body'] = json_encode($result);
        return $response;
    }

    private function getFeedbackByUser($id)
    {
        $result = $this->feedbackGateway->get_feedback_by_user($id);
        $response['status_code_header'] = 'HTTP/1.1 200 OK';
        $response['body'] = json_encode($result);
        return $response;
    }

    private function updateFeedbackStatus($id)
    {
        $result = $this->feedbackGateway->update_feedback_status($id);
        $response['status_code_header'] = 'HTTP/1.1 200 OK';
        $response['body'] = json_encode($result);
        return $response;
    }

    
    private function createFeedback()
    {
        $input = file_get_contents('php://input');
        $data = json_decode($input);
        $this->feedbackGateway->create_feedback($data);
        $response['status_code_header'] = 'HTTP/1.1 200 OK';
        $response['body'] = json_encode(['status'=> 'Success', 'message' => 'Add feedback success']);
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