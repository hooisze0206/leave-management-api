<?php
namespace Src\Gateway;
    class utilityGateway{
        // Connection
        private $conn;
        // Table
       

    
        // Db connection
        public function __construct($db){
            $this->conn = $db;
        }

        // GET ALL
        public function get_all_positions($other){
            $sqlQuery = "SELECT * FROM utils_position where department_id = ?";
            try {
                $stmt = $this->conn->prepare($sqlQuery);
                $stmt->bindParam(1, $other);
                $stmt->execute();
                $result = $stmt->fetchAll(\PDO::FETCH_ASSOC);
                return $result;
            } catch (\PDOException $e) {
                exit($e->getMessage());
            }
        }

        // GET ALL Count
        public function get_all_departments_count(){
            $sqlQuery = "SELECT COUNT(*) AS count FROM ". $this->department_table ."";
            try {
                $statement = $this->conn->query($sqlQuery);
                $result = $statement->fetchAll(\PDO::FETCH_ASSOC);
                return $result;
            } catch (\PDOException $e) {
                exit($e->getMessage());
            }
        }

        // GET ALL Active Count
        public function get_all_active_departments_count(){
            $sqlQuery = "SELECT COUNT(*) AS count FROM ". $this->department_table ." WHERE status = 1";
            try {
                $statement = $this->conn->query($sqlQuery);
                $result = $statement->fetchAll(\PDO::FETCH_ASSOC);
                return $result;
            } catch (\PDOException $e) {
                exit($e->getMessage());
            }
        }

        // GET employee Count
        public function get_all_employees_count(){
            $sqlQuery = "SELECT COUNT(*) AS count FROM user_details";
            try {
                $statement = $this->conn->query($sqlQuery);
                $result = $statement->fetchAll(\PDO::FETCH_ASSOC);
                return $result;
            } catch (\PDOException $e) {
                exit($e->getMessage());
            }
        }

        // GET ALL
        public function get_feedback_type(){
            $sqlQuery = "SELECT * FROM utils_feedback_type";
            try {
                $statement = $this->conn->query($sqlQuery);
                $result = $statement->fetchAll(\PDO::FETCH_ASSOC);
                return $result;
            } catch (\PDOException $e) {
                exit($e->getMessage());
            }
        }

        // GET ALL
        public function get_leave_information($user){
            $cmd = "CALL `sp_get_leave_information`(:user)";       
        
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

        // GET ALL
        public function get_pending_leave_count($status){
            $cmd = "SELECT COUNT(*) AS count FROM leave_request lr
                    LEFT JOIN utils_leave_status ls ON ls.id = lr.status
                    WHERE lr.current_progress = ". $status ."";     
        
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
        }

// GET ALL
        public function get_leave_summary_department(){
            $cmd = "SELECT * from vw_get_leave_summary_by_dept";     
        
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
        }

        public function get_leave_summary_leavetype(){
            $cmd = "SELECT * from vw_get_leave_summary_by_leave_type";     
        
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
        }

        public function get_leave_summary_department_leavetype(){
            $cmd = "SELECT * from vw_get_leave_info_by_dept";     
        
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
        }

        public function get_unread_feedback_count(){
            $cmd = "SELECT count(*) as count
                    FROM feedbacks where status = 0";     
        
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
        }

        public function forgot_password($input){
            $cmd = "SELECT ud.user_id FROM user_details ud where ud.email = :email";
            // bind data            
        
            try {
                $stmt = $this->conn->prepare($cmd);
                $email = $input->email;
                $stmt->bindParam(":email", $email);
                $stmt->execute();
                $count = $stmt->fetchAll(\PDO::FETCH_ASSOC);
                
                if ($count){
                    foreach($count as $results)
                    {
                       $user_id = $results['user_id'];
                    }
                    $password=rand();

                    $pass = base64_encode($password); 
                    $cmd = "CALL `sp_update_user_password`(:user_id, :pass)";

                    $stmt = $this->conn->prepare($cmd);
                    $stmt->bindParam(":user_id", $user_id);
                    $stmt->bindParam(":pass", $pass);
                    $stmt->execute();
                    $count = $stmt->rowCount();

                    $data = null;
                    if ($count){
                        $data = json_encode(array('email' => $email, 'user_id' => $user_id, 'password' =>$password));
                    }

                    return $data;
                }
            } catch (\PDOException $e) {
                // return $e->getMessage();
                exit($e->getMessage());
            }    
        }
        
    }
?>