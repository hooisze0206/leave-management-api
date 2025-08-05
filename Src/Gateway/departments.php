<?php
    class departments{
        // Connection
        private $conn;
        // Table
        private $department_table = "departments";
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
        public function get_departments(){
            $sqlQuery = "SELECT * FROM ". $this->department_table ."";
            $stmt = $this->conn->prepare($sqlQuery);
            $stmt->execute();
            return $stmt;
        }

        // READ single
        public function getSingleDepartment(){
            $sqlQuery = "SELECT * FROM ". $this->department_table ."
                    WHERE id = ?
                    LIMIT 0,1";
            $stmt = $this->conn->prepare($sqlQuery);
            $stmt->bindParam(1, $this->id);
            $stmt->execute();
            $dataRow = $stmt->fetch(PDO::FETCH_ASSOC);
            
            $this->id = $dataRow['id'];
            $this->department_name = $dataRow['department_name'];
            $this->status = $dataRow['status'];
            $this->created_by = $dataRow['created_by'];
            $this->created_date = $dataRow['created_date'];
            $this->updated_by = $dataRow['updated_by'];
            $this->updated_date = $dataRow['updated_date'];
        }
        
    }
?>