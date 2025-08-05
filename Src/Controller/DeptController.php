<?php
namespace Src\Controller;

use Src\Gateway\deptGateway;
header("Access-Control-Allow-Origin: *");
header("Content-Type: application/json; charset=UTF-8");
class DeptController {

    private $db;
    private $requestMethod;
    private $userId;

    private $deptGateway;

    public function __construct($db, $requestMethod, $userId)
    {
        $this->db = $db;
        $this->requestMethod = $requestMethod;
        $this->userId = $userId;

        $this->deptGateway = new deptGateway($db);
    }

    public function processRequest()
    {
        switch ($this->requestMethod) {
            case 'GET':
                if ($this->userId) {
                    if ($this->userId == 'dept_count'){
                        $response = $this->getAllDepartmentsCount();
                    }
                    elseif ($this->userId == 'active_dept_count') {
                        $response = $this->getAllActiveDepartmentsCount();
                    }
                    else{
                        $response = $this->get_department($this->userId);
                    }
                    
                } else {
                    $response = $this->getAllDepartments();
                };
                break;
            case 'POST':
                if ($this->userId) {
                    $response = $this->updateDepartment();
                }else{
                    $response = $this->createDepartment();
                }
                break;
            case 'PUT':
                $response = $this->updateDepartment();
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

    private function getAllDepartments()
    {
        $result = $this->deptGateway->get_all_departments();
        $response['status_code_header'] = 'HTTP/1.1 200 OK';
        $response['body'] = json_encode($result);
        return $response;
    }

    private function getAllDepartmentsCount()
    {
        $result = $this->deptGateway->get_all_departments_count();
        $response['status_code_header'] = 'HTTP/1.1 200 OK';
        $response['body'] = json_encode($result);
        return $response;
    }

    private function getAllActiveDepartmentsCount()
    {
        $result = $this->deptGateway->get_all_active_departments_count();
        $response['status_code_header'] = 'HTTP/1.1 200 OK';
        $response['body'] = json_encode($result);
        return $response;
    }

    private function get_department($id)
    {
        $result = $this->deptGateway->getSingleDepartment($id);
        if (! $result) {
            $response['status_code_header'] = 'HTTP/1.1 404 Not Found';
            $response['body'] = json_encode(array('status' => 'Failed','message' => 'Department not found'));
            return $response;
        }
        $response['status_code_header'] = 'HTTP/1.1 200 OK';
        $response['body'] = json_encode($result);
        return $response;
    }

    private function createDepartment()
    {
        $input = file_get_contents('php://input');
        $data = json_decode($input);
        $this->deptGateway->create_department($data);
        $response['status_code_header'] = 'HTTP/1.1 200 OK';
        $response['body'] = json_encode(['message' => 'Add department success']);
        return $response;
    }

    private function updateDepartment()
    {
        $input = file_get_contents('php://input');
        $data = json_decode($input);

        $result = $this->deptGateway->update_department($data);
        if (!$result) {
            $response['status_code_header'] = 'HTTP/1.1 400 Bad Request';
            $response['body'] = json_encode(array('status' => 'Failed','message' => 'Fail to update department'));
            return $response;
        }
        $response['status_code_header'] = 'HTTP/1.1 200 OK';
        $response['body'] = json_encode(array('status' => 'Success','message' => 'Update Department Success'));;
        return $response;
    }

    private function updateUserFromRequest($id)
    {
        $result = $this->personGateway->find($id);
        if (! $result) {
            return $this->notFoundResponse();
        }
        $input = (array) json_decode(file_get_contents('php://input'), TRUE);
        if (! $this->validatePerson($input)) {
            return $this->unprocessableEntityResponse();
        }
        $this->personGateway->update($id, $input);
        $response['status_code_header'] = 'HTTP/1.1 200 OK';
        $response['body'] = null;
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