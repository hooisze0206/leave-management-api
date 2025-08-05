<?php
namespace Src\Gateway;
header("Access-Control-Allow-Origin: http://localhost:3000");
header("Content-Type: application/json; charset=UTF-8");
    class loginGateway{
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

        // LOGIN
        public function login_user($input){
            $cmd = "CALL `sp_user_login`(:user_id, :pass)";
            // bind data  
            $pass = base64_encode($input->password);        
        
            try {
                $stmt = $this->conn->prepare($cmd);
                $stmt->bindParam(":user_id", $input->user_id);
                $stmt->bindParam(":pass", $pass);
                $stmt->execute();
                $result = $stmt->fetch(\PDO::FETCH_ASSOC);
                

                if ($result){
                    return $result;
                }
                else{
                    return "User not Found";
                }

                // return $stmt->rowCount();
                
            } catch (\PDOException $e) {
                exit($e->getMessage());
            }    
        }

        // change password
        public function change_password($input){
            $cmd = "CALL `sp_update_user_password`(:user_id, :pass)";
            // bind data  
            $pass = base64_encode($input->password);        
        
            try {
                $stmt = $this->conn->prepare($cmd);
                $stmt->bindParam(":user_id", $input->user_id);
                $stmt->bindParam(":pass", $pass);
                $stmt->execute();

                return $stmt->rowCount();
                
            } catch (\PDOException $e) {
                exit($e->getMessage());
            }    
        }

// LOGIN
        public function check_user_id($input){
            $cmd = "SELECT user_id
                    FROM user_details where user_id = :user_id";
        
            try {
                $stmt = $this->conn->prepare($cmd);
                $stmt->bindParam(":user_id", $input->user_id);
                $stmt->execute();
                $result = $stmt->fetch(\PDO::FETCH_ASSOC);
                

                if ($result){
                    return "exist";
                }
                else{
                    return "available";
                }

                // return $stmt->rowCount();
                
            } catch (\PDOException $e) {
                exit($e->getMessage());
            }    
        }
            public function check_user_password($input){
            $cmd = "SELECT password
                    FROM active_users where user_id = :user_id AND password = :pass";

            $pass = base64_encode($input->password);
        
            try {
                $stmt = $this->conn->prepare($cmd);
                $stmt->bindParam(":pass", $pass);
                $stmt->bindParam(":user_id", $input->user_id);
                $stmt->execute();
                $result = $stmt->fetch(\PDO::FETCH_ASSOC);
                

                if ($result){
                    return "Password Correct";
                }
                else{
                    return "Password Invalid";
                }

                // return $stmt->rowCount();
                
            } catch (\PDOException $e) {
                exit($e->getMessage());
            }    
        }
       
    }
?>