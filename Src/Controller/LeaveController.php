<?php
namespace Src\Controller;

use Src\Gateway\leaveGateway;
use Src\Gateway\emailGateway;
header('Access-Control-Allow-Origin: http://localhost:3000');
header('Access-Control-Allow-Methods: POST, GET, PUT, OPTIONS, PATCH, DELETE');
header('Access-Control-Allow-Credentials: true');
header('Access-Control-Allow-Headers: Authorization, Content-Type, x-xsrf-token, x_csrftoken, Cache-Control, X-Requested-With');
class LeaveController {

    private $db;
    private $requestMethod;
    private $type;
    private $user_id;

    private $leaveGateway;
    private $emailGateway;

    public function __construct($db, $requestMethod, $type, $user_id)
    {
        $this->db = $db;
        $this->requestMethod = $requestMethod;
        $this->type = $type;
        $this->user_id = $user_id;

        $this->leaveGateway = new leaveGateway($db);
        $this->emailGateway = new emailGateway($db);
    }

    public function processRequest()
    {
        switch ($this->requestMethod) {
            case 'GET':
                if ($this->type == 'myHoliday'){
                    $response = $this->getAllLeaveandHolidayUser($this->user_id);
                }elseif ($this->type == 'upcomingHoliday'){
                    $response = $this->getUpcomingHoliday($this->user_id);
                }elseif ($this->type == 'requested'){
                    $response = $this->getAllRequestedLeaveUser($this->user_id);
                }elseif ($this->type == 'progress'){
                    $response = $this->getAllRequestedLeaveProgressUser($this->user_id);
                }elseif ($this->type == 'leave_type'){
                    $response = $this->getAllLeaveType();
                }
                
                break;
            case 'POST':
                if ($this->type == 'add_leave_request'){
                    $response = $this->addLeaveRequest($this->user_id);
                }elseif ($this->type =='update_leave_request'){
                    $response = $this->updateLeaveRequest();
                }elseif ($this->type =='pending_leave'){
                    $response = $this->getAllPendingRequestedLeave($this->user_id);
                }elseif ($this->type == 'all'){
                    $response = $this->getAllRequestedLeave();                   
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


    private function getAllLeaveandHolidayUser($user_id)
    {
        $result = $this->leaveGateway->get_all_leave_holiday_user($user_id);
        $response['status_code_header'] = 'HTTP/1.1 201 Created';
        $response['body'] = json_encode($result);
        return $response;
    }

    private function getUpcomingHoliday($user_id)
    {
        $result = $this->leaveGateway->get_upcoming_holiday($user_id);
        $response['status_code_header'] = 'HTTP/1.1 201 Created';
        $response['body'] = json_encode($result);
        return $response;
    }

    private function getAllRequestedLeaveUser($user_id)
    {
        $result = $this->leaveGateway->get_all_requested_leave_user($user_id);
        $response['status_code_header'] = 'HTTP/1.1 201 Created';
        $response['body'] = json_encode($result);
        return $response;
    }

    private function getAllRequestedLeaveProgressUser($leave_id)
    {
        $result = $this->leaveGateway->get_all_requested_leave_progress_user($leave_id);
        $response['status_code_header'] = 'HTTP/1.1 201 Created';
        $response['body'] = json_encode($result);
        return $response;
    }

    private function getAllRequestedLeave()
    {
        $input = file_get_contents('php://input');
        $data = json_decode($input);
        $result = $this->leaveGateway->get_all_requested_leave($data);
        $response['status_code_header'] = 'HTTP/1.1 201 Created';
        $response['body'] = json_encode($result);
        return $response;
    }

    private function getAllPendingRequestedLeave($status)
    {
        $input = file_get_contents('php://input');
        $data = json_decode($input);
        $result = $this->leaveGateway->get_all_pending_requested_leave($status,$data);
        $response['status_code_header'] = 'HTTP/1.1 201 Created';
        $response['body'] = json_encode($result);
        return $response;
    }

    private function getAllLeaveType()
    {
        $result = $this->leaveGateway->get_all_leave_type();
        $response['status_code_header'] = 'HTTP/1.1 201 Created';
        $response['body'] = json_encode($result);
        return $response;
    }

    private function addLeaveRequest($user_id)
    {
        $input = file_get_contents('php://input');
        $data = json_decode($input);
        $result = $this->leaveGateway->add_leave_request($data, $user_id);

        if ($result){
            $data->leave_id = $result;
            $data->user_id = $user_id;
            $res = $this->emailGateway->leave_request_email($data);
            $response['status_code_header'] = 'HTTP/1.1 201 Created';
            $response['body'] = json_encode(array('status' => 'Success','message' => 'Leave Request is submitted'));;
            return $response;
        }
        $response['status_code_header'] = 'HTTP/1.1 201 Created';
        $response['body'] = json_encode(array('status' => 'Failed','message' => 'Leave Request is submitted'));;
        return $response;
    }

    private function updateLeaveRequest()
    {
        $input = file_get_contents('php://input');
        $data = json_decode($input);
        $result = $this->leaveGateway->update_leave_request($data);

        if ($result){
            if ($data->action == "Admin_Approved"){
                $res = $this->emailGateway->admin_approval_email($data);
                $response['status_code_header'] = 'HTTP/1.1 201 Created';
                $response['body'] = json_encode(array('status' => 'Success','message' => 'Leave Request is approved by admin, pending approval from manager'));;
                return $response;
            }
            else if($data->action == "Manager_Approved"){
                $res = $this->emailGateway->leave_approval_email($data);
                $response['status_code_header'] = 'HTTP/1.1 201 Created';
                $response['body'] = json_encode(array('status' => 'Success','message' => 'Leave Request is approved'));;
                return $response;
            }
            else if($data->action == "Rejected"){
                $res = $this->emailGateway->leave_reject_email($data);
                $response['status_code_header'] = 'HTTP/1.1 201 Created';
                $response['body'] = json_encode(array('status' => 'Success','message' => 'Leave Request is rejected'));;
                return $response;
            }
            else{
                $response['status_code_header'] = 'HTTP/1.1 201 Created';
                $response['body'] = json_encode(array('status' => 'Success','message' => 'Leave Request is cancelled'));;
                return $response;
            }           
        }
        $response['status_code_header'] = 'HTTP/1.1 201 Created';
        $response['body'] = json_encode(array('status' => 'Failed','message' => 'Leave Request is submitted'));;
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