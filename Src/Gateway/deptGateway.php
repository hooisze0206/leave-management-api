<?php
namespace Src\Gateway;
    class deptGateway{
        // Connection
        private $conn;
        // Table
        private $department_table = "utils_departments";
        // Columns
        public $id;
        public $department_name;
        public $status;
        public $created_by;
        public $created_date;
        public $updated_by;
        public $updated_date;

    
        // Db connection
        public function __construct($db){
            $this->conn = $db;
        }

        // GET ALL
        public function get_all_departments(){
            $sqlQuery = "SELECT * FROM ". $this->department_table ."";
            try {
                $statement = $this->conn->query($sqlQuery);
                $result = $statement->fetchAll(\PDO::FETCH_ASSOC);
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

        // READ single
        public function getSingleDepartment($id){
            $sqlQuery = "SELECT * FROM ". $this->department_table ."
                    WHERE id = ?
                    LIMIT 0,1";

            try{
                $stmt = $this->conn->prepare($sqlQuery);
                $stmt->bindParam(1, $id);
                $stmt->execute();
                $dataRow = $stmt->fetch(\PDO::FETCH_ASSOC);
                return $dataRow;
            }catch (\PDOException $e) {
                exit($e->getMessage());
            }  
        }

        public function create_department($input){
            $cmd = "CALL `sp_add_new_department`(:department, :status, :created_by)";
            // bind data            
        
            try {
                $created_by = "hhee";
                $stmt = $this->conn->prepare($cmd);
                $stmt->bindParam(":department", $input->department);
                $stmt->bindParam(":status", $input->status);
                $stmt->bindParam(":created_by", $created_by);
                $stmt->execute();
                return $stmt->rowCount();
            } catch (\PDOException $e) {
                // return $e->getMessage();
                exit($e->getMessage());
            }    
        }
        public function update_department($input){
            $cmd = "CALL `sp_update_department`(:department, :status, :update_by)";
            // bind data            
        
            try {
                $stmt = $this->conn->prepare($cmd);
                $stmt->bindParam(":department", $input->department);
                $stmt->bindParam(":status", $input->status);
                $stmt->bindParam(":update_by", $update_by);
                $stmt->execute();
                return $stmt->rowCount();
            } catch (\PDOException $e) {
                // return $e->getMessage();
                exit($e->getMessage());
            }    
        }
        
    }
?>