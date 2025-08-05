<?php
namespace Src\Controller;

use Src\Gateway\reportGateway;
header('Access-Control-Allow-Origin: http://localhost:3000');
header('Access-Control-Allow-Methods: POST, GET, PUT, OPTIONS, PATCH, DELETE');
header('Access-Control-Allow-Credentials: true');
header('Access-Control-Allow-Headers: Authorization, Content-Type, x-xsrf-token, x_csrftoken, Cache-Control, X-Requested-With');

class ReportController {

    private $db;
    private $requestMethod;
    private $type;

    private $reportGateway;

    public function __construct($db, $requestMethod, $type)
    {
        $this->db = $db;
        $this->requestMethod = $requestMethod;
        $this->type = $type;

        $this->reportGateway = new reportGateway($db);
    }

    public function processRequest()
    {
        switch ($this->requestMethod) {
            case 'GET':
                if ($this->type == 'allLeave'){
                    $response = $this->getUserLeave();
                }elseif ($this->type == 'annualSituation'){
                    $response = $this->getAnnualSituation();
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


    private function getUserLeave()
    {
        $result = $this->reportGateway->get_user_leave();
        $response['status_code_header'] = 'HTTP/1.1 201 Created';
        $response['body'] = json_encode($result);
        return $response;
    }

    private function getAnnualSituation()
    {
        $result = $this->reportGateway->get_annual_situation();
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