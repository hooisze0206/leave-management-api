<?php
namespace Src\Controller;

use Src\Gateway\utilityGateway;
use Src\Gateway\emailGateway;
header("Access-Control-Allow-Origin: *");
header("Content-Type: application/json; charset=UTF-8");
class UtilityController {

    private $db;
    private $requestMethod;
    private $type;
    private $other;

    private $utilityGateway;
    private $emailGateway;


    public function __construct($db, $requestMethod, $type, $other)
    {
        $this->db = $db;
        $this->requestMethod = $requestMethod;
        $this->type = $type;
        $this->other = $other;

        $this->utilityGateway = new utilityGateway($db);
        $this->emailGateway = new emailGateway($db);
    }

    public function processRequest()
    {
        switch ($this->requestMethod) {
            case 'GET':
                if ($this->type == 'position'){
                    $response = $this->getAllPositions($this->other);
                }
                elseif ($this->type == 'active_dept_count') {
                    $response = $this->getAllActiveDepartmentsCount();
                }
                elseif ($this->type == 'employee_count') {
                    $response = $this->getAllEmployeesCount();
                }
                elseif ($this->type == 'feedback_type') {
                    $response = $this->getFeedbackType();
                }
                elseif ($this->type == 'leave_information') {
                    $response = $this->getLeaveInformation($this->other);
                }
                elseif ($this->type == 'pending_leave_count') {
                    $response = $this->getPendingLeaveCount($this->other);
                }
                elseif ($this->type == 'unread_feedback_count') {
                    $response = $this->getUnreadFeedbackCount();
                }
                elseif ($this->type == 'leave_summary_department') {
                    $response = $this->getLeaveSummaryDepartment();
                }
                elseif ($this->type == 'leave_summary_leavetype') {
                    $response = $this->getLeaveSummaryLeaveType();
                }elseif ($this->type == 'leave_summary_department_leavetype') {
                    $response = $this->getLeaveSummaryDepartmentLeaveType();
                }
                break;
            case 'POST':
                if ($this->type == 'forgotPassword') {
                    
                    $response = $this->forgotPassword();   
  
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

    private function getAllPositions($other)
    {
        $result = $this->utilityGateway->get_all_positions($other);
        $response['status_code_header'] = 'HTTP/1.1 200 OK';
        $response['body'] = json_encode($result);
        return $response;
    }

    private function getAllActiveDepartmentsCount()
    {
        $result = $this->utilityGateway->get_all_active_departments_count();
        $response['status_code_header'] = 'HTTP/1.1 200 OK';
        $response['body'] = json_encode($result);
        return $response;
    }

    private function getAllEmployeesCount()
    {
        $result = $this->utilityGateway->get_all_employees_count();
        $response['status_code_header'] = 'HTTP/1.1 200 OK';
        $response['body'] = json_encode($result);
        return $response;
    }

    private function getFeedbackType()
    {
        $result = $this->utilityGateway->get_feedback_type();
        $response['status_code_header'] = 'HTTP/1.1 200 OK';
        $response['body'] = json_encode($result);
        return $response;
    }

    private function getLeaveInformation($other)
    {
        $result = $this->utilityGateway->get_leave_information($other);
        $response['status_code_header'] = 'HTTP/1.1 200 OK';
        $response['body'] = json_encode($result);
        return $response;
    }

    private function getPendingLeaveCount($other)
    {
        $result = $this->utilityGateway->get_pending_leave_count($other);
        $response['status_code_header'] = 'HTTP/1.1 200 OK';
        $response['body'] = json_encode($result);
        return $response;
    }

    private function getUnreadFeedbackCount()
    {
        $result = $this->utilityGateway->get_unread_feedback_count();
        $response['status_code_header'] = 'HTTP/1.1 200 OK';
        $response['body'] = json_encode($result);
        return $response;
    }

    private function getLeaveSummaryDepartment()
    {
        $result = $this->utilityGateway->get_leave_summary_department();
        $response['status_code_header'] = 'HTTP/1.1 200 OK';
        $response['body'] = json_encode($result);
        return $response;
    }

    private function getLeaveSummaryLeaveType()
    {
        $result = $this->utilityGateway->get_leave_summary_leavetype();
        $response['status_code_header'] = 'HTTP/1.1 200 OK';
        $response['body'] = json_encode($result);
        return $response;
    }

    private function getLeaveSummaryDepartmentLeaveType()
    {
        $result = $this->utilityGateway->get_leave_summary_department_leavetype();
        if ($result) {
            $response['status_code_header'] = 'HTTP/1.1 200 OK';
            $response['body'] = json_encode($result);           
            return $response;
        }
        $response['status_code_header'] = 'HTTP/1.1 404 Not Found';
        $response['body'] = json_encode(array('Status' => 'Failed'));
        
        return $response;
    }

    private function forgotPassword()
    {
        $input = file_get_contents('php://input');
        $data = json_decode($input);
        
        $result = $this->utilityGateway->forgot_password($data);
        
        if ($result) {

            $res = $this->emailGateway->forgot_password_email($result);
            $response['status_code_header'] = 'HTTP/1.1 200 OK';
            $response['body'] = json_encode(array('status' => 'Success', 'message' =>"Reset Password Success, you will receive an email"));           
            return $response;
        }
        $response['status_code_header'] = 'HTTP/1.1 404 Not Found';
        $response['body'] = json_encode(array('Status' => 'Failed', 'message' =>$result));
        
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