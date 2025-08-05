<?php
namespace Src\Gateway;

header('Access-Control-Allow-Origin: *');
header('Access-Control-Allow-Methods: POST, GET, PUT, OPTIONS, PATCH, DELETE');
header('Access-Control-Allow-Credentials: true');
header('Access-Control-Allow-Headers: Authorization, Content-Type, x-xsrf-token, x_csrftoken, Cache-Control, X-Requested-With');

    class userGateway{
        // Connection
        private $conn;
        // Table
        private $user_details_table = "user_details";
        private $department_table = "utils_departments";
        private $user_roles_table = "user_roles";
        private $position_table = "utils_position";
        private $db_table = "user_details";
        // Columns
        public $id;
        public $user_id;
        public $name;
        public $gender;
        public $email;
        public $phone;
        public $address;
        public $department_name;
        public $department;
        public $position;
        public $roles;
        public $user_role;
        public $status;
        public $created_by;
        public $created_date;
        public $updated_by;
        public $updated_date;
        public $pass;

    
        // Db connection
        public function __construct($conn){
            $this->conn = $conn;
        }
        // GET ALL
        public function get_all_user(){
            $sqlQuery = "SELECT u.id, u.user_id as user_id, u.name as name, u.gender as gender, d.department_name as department_name, d.color as color, u.email as email, u.phone as phone, u.address as address,
                p.position, u.status, u.created_by, u.created_date, u.updated_date, u.updated_by, u.updated_date, r.roles
                FROM " . $this->user_details_table . " u
                LEFT JOIN " . $this->department_table . " d ON d.id = u.department_id
                LEFT JOIN " . $this->position_table . " p ON p.id = u.position
                LEFT JOIN " . $this->user_roles_table . " r ON r.id = u.user_roles_id";
            try {
                $statement = $this->conn->query($sqlQuery);
                $result = $statement->fetchAll(\PDO::FETCH_ASSOC);
                return $result;
            } catch (\PDOException $e) {
                exit($e->getMessage());
            }
        }
        // CREATE
        public function create_user($input){
            $cmd = "CALL `sp_add_new_employee`(:user_id, :name, :gender, :email, :phone, :address, :department, :position, :user_role, :status, :created_by, :pass, :city, :zip_code)";
            // bind data            

            try {
                $stmt = $this->conn->prepare($cmd);
                $created_by = "hhee";
                $pass = base64_encode("123456");
                $stmt->bindParam(":name", $input->name);
                $stmt->bindParam(":user_id", $input->user_id);
                $stmt->bindParam(":gender", $input->gender);
                $stmt->bindParam(":email", $input->email);
                $stmt->bindParam(":phone", $input->phone);
                $stmt->bindParam(":address", $input->address);
                $stmt->bindParam(":city", $input->city);
                $stmt->bindParam(":zip_code", $input->zip_code);
                $stmt->bindParam(":department", $input->department);
                $stmt->bindParam(":position", $input->position);
                $stmt->bindParam(":user_role", $input->role);
                $stmt->bindParam(":status", $input->status);
                $stmt->bindParam(":created_by", $created_by);
                $stmt->bindParam(":pass", $pass);
                $stmt->execute();
                return $stmt->rowCount();
            } catch (\PDOException $e) {
                exit($e->getMessage());
            }    
        }

        // READ single
        public function get_user($user){
            $sqlQuery = "SELECT u.id, u.user_id as user_id, u.name as name,u.gender, u.department_id as department_name, u.email as email, u.phone as phone, u.address as address, u.city, u.zip_code,
                u.position, u.status, u.created_by, u.created_date, u.updated_date, u.updated_by, u.updated_date, r.roles
                FROM " . $this->user_details_table . " u
                LEFT JOIN " . $this->department_table . " d ON d.id = u.department_id
                LEFT JOIN " . $this->user_roles_table . " r ON r.id = u.user_roles_id
                    WHERE 
                       u.user_id = ?
                    LIMIT 0,1";
            try{
                $stmt = $this->conn->prepare($sqlQuery);
                $stmt->bindParam(1, $user);
                $stmt->execute();
                 $dataRow = $stmt->fetch(\PDO::FETCH_ASSOC);
                return $dataRow;
            }catch (\PDOException $e) {
                exit($e->getMessage());
            }              
        }    

        // CREATE
        public function update_user($input){
            $cmd = "CALL `sp_update_user_detail`(:user_id, :name, :gender, :email, :phone, :address, :department, :position, :user_role, :status, :update_by, :city, :zip_code)";
            // bind data            

            try {
                $stmt = $this->conn->prepare($cmd);
                $stmt->bindParam(":name", $input->name);
                $stmt->bindParam(":user_id", $input->user_id);
                $stmt->bindParam(":gender", $input->gender);
                $stmt->bindParam(":email", $input->email);
                $stmt->bindParam(":phone", $input->phone);
                $stmt->bindParam(":address", $input->address);
                $stmt->bindParam(":city", $input->city);
                $stmt->bindParam(":zip_code", $input->zip_code);
                $stmt->bindParam(":department", $input->department);
                $stmt->bindParam(":position", $input->position);
                $stmt->bindParam(":user_role", $input->role);
                $stmt->bindParam(":status", $input->status);
                $stmt->bindParam(":update_by", $update_by);;
                $stmt->execute();
                return $stmt->rowCount();
            } catch (\PDOException $e) {
                exit($e->getMessage());
            }    
        }

        // DELETE
        function deleteEmployee(){
            $sqlQuery = "DELETE FROM " . $this->db_table . " WHERE id = ?";
            $stmt = $this->conn->prepare($sqlQuery);
        
            $this->id=htmlspecialchars(strip_tags($this->id));
        
            $stmt->bindParam(1, $this->id);
        
            if($stmt->execute()){
                return true;
            }
            return false;
        }
    }
?>