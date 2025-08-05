<?php
namespace Src\Gateway;
header("Access-Control-Allow-Origin: http://localhost:3000");
header("Content-Type: application/json; charset=UTF-8");
    class reportGateway{
        // Connection
        private $conn;
        // Table
        private $user_details_table = "user_details";
        private $department_table = "utils_departments";
        private $user_roles_table = "user_roles";
        private $db_table = "user_details";
        // Columns
        public $id;
        public $user_id;
        public $user_role;
        public $status;

    
        // Db connection
        public function __construct($conn){
            $this->conn = $conn;
        }

        // all requested leave
        public function get_user_leave(){
            $cmd = "SELECT * from vw_get_all_leaves";       
        
            try {
                $stmt = $this->conn->prepare($cmd);
                $stmt->execute();
                $result = $stmt->fetchAll(\PDO::FETCH_ASSOC);

                if ($result){
                    return $result;
                }
                else{
                    return "No data";
                }

                
            } catch (\PDOException $e) {
                exit($e->getMessage());
            }    
        }// all requested leave

        public function get_annual_situation(){
            $cmd = "CALL `sp_get_annual_situation`()";       
        
            try {
                $stmt = $this->conn->prepare($cmd);
                $stmt->execute();
                $result = $stmt->fetchAll(\PDO::FETCH_ASSOC);

                if ($result){
                    return $result;
                }
                else{
                    return "No data";
                }

                
            } catch (\PDOException $e) {
                exit($e->getMessage());
            }    
        }

        // upcoming holiday and leave
        public function get_upcoming_holiday($user){
            $cmd = "CALL `sp_get_upcoming_holiday`(:user)";       
        
            try {
                $stmt = $this->conn->prepare($cmd);
                $stmt->bindParam(":user", $user);
                $stmt->execute();
                $result = $stmt->fetchAll(\PDO::FETCH_ASSOC);

                if ($result){
                    return $result;
                }
                else{
                    return "No data";
                }

                // return $stmt->rowCount();
                
            } catch (\PDOException $e) {
                exit($e->getMessage());
            }    
        }

        // all requested leave
        public function get_all_requested_leave_user($user){
            $cmd = "CALL `sp_get_requested_leave`(:user)";       
        
            try {
                $stmt = $this->conn->prepare($cmd);
                $stmt->bindParam(":user", $user);
                $stmt->execute();
                $result = $stmt->fetchAll(\PDO::FETCH_ASSOC);

                if ($result){
                    return $result;
                }
                else{
                    return "No data";
                }

                // return $stmt->rowCount();
                
            } catch (\PDOException $e) {
                exit($e->getMessage());
            }    
        }

        // all requested leave
        public function get_all_requested_leave(){
            $cmd = "CALL `sp_get_all_requested_leave`()";       
        
            try {
                $stmt = $this->conn->prepare($cmd);
                $stmt->execute();
                $result = $stmt->fetchAll(\PDO::FETCH_ASSOC);

                if ($result){
                    return $result;
                }
                else{
                    return "No data";
                }

                // return $stmt->rowCount();
                
            } catch (\PDOException $e) {
                exit($e->getMessage());
            }    
        }// all requested leave
        public function get_all_pending_requested_leave($status){
            $cmd = "CALL `sp_get_all_pending_requested_leave`(:status)";       
        
            try {
                $stmt = $this->conn->prepare($cmd);
                $stmt->bindParam(":status", $status);
                $stmt->execute();
                $result = $stmt->fetchAll(\PDO::FETCH_ASSOC);

                if ($result){
                    return $result;
                }
                else{
                    return "No data";
                }

                // return $stmt->rowCount();
                
            } catch (\PDOException $e) {
                exit($e->getMessage());
            }    
        }

        // requested leave progress
        public function get_all_requested_leave_progress_user($leave_id){
            $cmd = "CALL `sp_get_requested_leave_status`(:leave_id)";       
        
            try {
                $stmt = $this->conn->prepare($cmd);
                $stmt->bindParam(":leave_id", $leave_id);
                $stmt->execute();
                $result = $stmt->fetchAll(\PDO::FETCH_ASSOC);

                if ($result){
                    return $result;
                }
                else{
                    return "No data";
                }

                // return $stmt->rowCount();
                
            } catch (\PDOException $e) {
                exit($e->getMessage());
            }    
        }

        // CREATE
        public function add_leave_request($input, $user_id){
            $cmd = "CALL `sp_add_leave_request`(:user_id, :leave_type, :leave_request_id, :day, :start_date, :end_date, :amount)";
            // bind data            
        
            try {
                $stmt = $this->conn->prepare($cmd);
                $request_id = $user_id . strval(rand(100000,1000000));
                $stmt->bindParam(":user_id", $user_id);
                $stmt->bindParam(":leave_type", $input->leave_type);
                $stmt->bindParam(":leave_request_id", $request_id);
                $stmt->bindParam(":day", $input->day);
                $stmt->bindParam(":start_date", $input->start_date);
                $stmt->bindParam(":end_date", $input->end_date);
                $stmt->bindParam(":amount", $input->amount);
                $stmt->execute();
                return $stmt->rowCount();
            } catch (\PDOException $e) {
                exit($e->getMessage());
            }    
        }

        // CREATE
        public function update_leave_request($input){
            $cmd = "CALL `sp_update_leave_request_status`(:user_id,:leave_id,:leave_type, :amount, :update_status, :curr_action)";
            // bind data            
        
            try {
                $stmt = $this->conn->prepare($cmd);
                $stmt->bindParam(":user_id", $input->user_id);
                $stmt->bindParam(":leave_id", $input->leave_id);
                $stmt->bindParam(":leave_type", $input->leave_type);
                $stmt->bindParam(":amount", $input->amount);
                $stmt->bindParam(":update_status", $input->status);
                $stmt->bindParam(":curr_action", $input->action);
                $stmt->execute();
                return $stmt->rowCount();
            } catch (\PDOException $e) {
                exit($e->getMessage());
            }    
        }
       
    }
?>