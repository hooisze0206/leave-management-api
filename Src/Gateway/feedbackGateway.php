<?php
namespace Src\Gateway;
    class feedbackGateway{
        // Connection
        private $conn;
        // Table
        private $department_table = "utils_departments";
        // Columns
        public $id;


    
        // Db connection
        public function __construct($db){
            $this->conn = $db;
        }

        // GET ALL
        public function get_feedback_status($id){
            $sqlQuery = "CALL `sp_get_feedback_by_status`(:status)";
            try {
                $stmt = $this->conn->prepare($sqlQuery);
                $stmt->bindParam(":status", $id);
                $stmt->execute();
                $dataRow = $stmt->fetchAll(\PDO::FETCH_ASSOC);
                return $dataRow;
            } catch (\PDOException $e) {
                exit($e->getMessage());
            }
        }

        // GET ALL
        public function get_feedback_by_user($user){
            $sqlQuery = "CALL `sp_get_feedback_by_user`(:user)";
            try {
                $stmt = $this->conn->prepare($sqlQuery);
                $stmt->bindParam(":user", $user);
                $stmt->execute();
                $dataRow = $stmt->fetchAll(\PDO::FETCH_ASSOC);
                return $dataRow;
            } catch (\PDOException $e) {
                exit($e->getMessage());
            }
        }

        // GET ALL
        public function update_feedback_status($id){
            $sqlQuery = "CALL `sp_update_feedback_status`(:id)";
            try {
                $stmt = $this->conn->prepare($sqlQuery);
                $stmt->bindParam(":id", $id);
                $stmt->execute();
                return $stmt->rowCount();
            } catch (\PDOException $e) {
                exit($e->getMessage());
            }
        }

        public function create_feedback($input){
            $type = $input->feedback_type;

            $cmd = "CALL `sp_add_feedback_feature_request`(:user_id, :feature, :feedback, :feedback_type)";
            $stmt = $this->conn->prepare($cmd);
            $stmt->bindParam(":user_id", $input->user_id);
            $stmt->bindParam(":feature", $input->feature);
            $stmt->bindParam(":feedback", $input->feedback);
            $stmt->bindParam(":feedback_type", $input->feedback_type);
      
        
            try {
                
                $stmt->execute();
                return $stmt->rowCount();
            } catch (\PDOException $e) {
                // return $e->getMessage();
                exit($e->getMessage());
            }    
        }
        
    }
?>