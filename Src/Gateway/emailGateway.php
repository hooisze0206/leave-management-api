<?php
namespace Src\Gateway;
use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\SMTP;
use PHPMailer\PHPMailer\Exception;

header("Access-Control-Allow-Origin: http://localhost:3000");
header("Content-Type: application/json; charset=UTF-8");


    class emailGateway{
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

        public function forgot_password_email($data){
            // bind data            
            try {
                $detail = json_decode($data);
                $email = $detail->email;
                $user_id = $detail->user_id;
                $password = $detail->password;
   
                $title = 'JustApply: Password Reset Successful';
                $body = "<div>
                    <h2>Password Reset</h2>
                    <p>Hi ".$user_id.",</p>
                    <p>We have receipt your forgot password request. Below are the password reset information.</p>
                    <table border = 1 style=\\\"border-collapse: collapse;\\\">
                        <tr><td>User ID</td><td>".$user_id."</td></tr>
                        <tr><td>New Password</td><td>".$password."</td></tr>
                    </table>
                    <p>You can now using above User ID and New Password to login. Thank You.</P>
                    <br><br>
                    <span>Best Regards, <br>JustApply</span>
                </div>";

                $data = json_encode(array('title' => $title, 'body' =>$body, 'recipient' => $email));
                $result = $this->send_email($data);
                return $data;
                
            } catch (\PDOException $e) {
                return $e->getMessage();
                exit($e->getMessage());
            }    
        }

        public function get_user_email($user){
            $cmd = "SELECT name, email
                    FROM user_details where user_id = :user_id";

            try{
                $stmt = $this->conn->prepare($cmd);
                $stmt->bindParam(":user_id", $user);
                $stmt->execute();
                $res = $stmt->fetch(\PDO::FETCH_ASSOC);

                return $res;
            }catch (\PDOException $e) {
                return $e->getMessage();
                exit($e->getMessage());
            }  
                    
        }

        public function get_manager_detail($user){
            $cmd = "CALL `sp_get_manager_details`(:user_id)";

            try{
                $stmt = $this->conn->prepare($cmd);
                $stmt->bindParam(":user_id", $user);
                $stmt->execute();
                $res = $stmt->fetch(\PDO::FETCH_ASSOC);

                return $res;
            }catch (\PDOException $e) {
                return $e->getMessage();
                exit($e->getMessage());
            }  
                    
        }

        public function leave_request_email($detail){
            
            // bind data            
            try {
                $user_id = $detail->user_id;
                $res = $this->get_user_email($user_id);
                $email = array();
                $email[0] = $res['email']; 
                $email[1] = "heehooisze@gmail.com";

                $leave_id = $detail->leave_id;               
                $leave_type = $detail->leave_type;
                $day = $detail->day;
                $start_date = $detail->start_date;
                $end_date = $detail->end_date;
                $amount = $detail->amount;
                $status = "Pending";
   
                $title = 'JustApply: New Leave Application';
                $body = "<div>
                            <h2>New Leave Application</h2>
                            <p>Hi Admin,</p>
                            <p>".$user_id." has apply for ".$leave_type." and awaiting from your approval. Below are the request details.</p>
                            <br>
                            <h4>Details:</h4>
                            <table border = 1 style=\\\"border-collapse: collapse;\\\">
                                <tr><td>Leave ID</td><td>".$leave_id."</td></tr>
                                <tr><td>Employee</td><td>".$user_id."</td></tr>
                                <tr><td>Leave Type</td><td>".$leave_type."</td></tr>
                                <tr><td>From Date</td><td>".$start_date."</td></tr>
                                <tr><td>To Date</td><td>".$end_date."</td></tr>
                                <tr><td>Day(s)</td><td>".$amount."</td></tr>
                                <tr><td>Status</td><td>".$status."</td></tr>
                            </table>
                            <br><br>
                            <span>Best Regards, <br>JustApply</span>
                        </div>";

                $data = json_encode(array('title' => $title, 'body' =>$body, 'recipient' => $email));
                $result = $this->send_email($data);
                return $data;
                
            } catch (\PDOException $e) {
                return $e->getMessage();
                exit($e->getMessage());
            }    
        }

        public function admin_approval_email($detail){
            // bind data            
            try {
                $user_id = $detail->user_id;

                $email = array();
                $manager = $this->get_manager_detail($user_id);
                $user = $this->get_user_email($user_id);
                $email[0] = $manager['email']; 
                $email[1] = $user['email'];
                $manager_name = $manager['name']; 

                $leave_id = $detail->leave_id;               
                $leave_type = $detail->leave_type;
                $start_date = $detail->start_date;
                $end_date = $detail->end_date;
                $amount = $detail->amount;
                $status = "Pending";
   
                $title = 'JustApply: New Leave Application';
                $body = "<div>
                            <h2>New Leave Application</h2>
                            <p>Hi ".$manager_name.", </p>
                            <p>Admin has been approved ".$leave_id." leave request. Currently is pending from your approval. Below are the request details.</p>
                            <br>
                            <h4>Details:</h4>
                            <table border = 1 style=\\\"border-collapse: collapse;\\\">
                                <tr><td>Leave ID</td><td>".$leave_id."</td></tr>
                                <tr><td>Employee</td><td>".$user_id."</td></tr>
                                <tr><td>Leave Type</td><td>".$leave_type."</td></tr>
                                <tr><td>From Date</td><td>".$start_date."</td></tr>
                                <tr><td>To Date</td><td>".$end_date."</td></tr>
                                <tr><td>Day(s)</td><td>".$amount."</td></tr>
                                <tr><td>Status</td><td>".$status."</td></tr>
                            </table>
                            <br><br>
                            <span>Best Regards, <br>JustApply</span>
                        </div>";

                $data = json_encode(array('title' => $title, 'body' =>$body, 'recipient' => $email));
                $result = $this->send_email($data);
                return $data;
                
            } catch (\PDOException $e) {
                return $e->getMessage();
                exit($e->getMessage());
            }    
        }

        public function leave_approval_email($detail){
            // bind data            
            try {
                $user_id = $detail->user_id;

                $email = array();
                $user = $this->get_user_email($user_id);
                $email[0] = $user['email'];
                $user_name = $user['name'];

                $leave_id = $detail->leave_id;               
                $leave_type = $detail->leave_type;
                $start_date = $detail->start_date;
                $end_date = $detail->end_date;
                $amount = $detail->amount;
                $status = "Approved";
   
                $title = 'JustApply: Leave Application Approved';
                $body = "<div>
                            <h2>Leave Application Approved</h2>
                            <p>Hi ".$user_name.", </p>
                            <p>Congrats, your leave request - ".$leave_id." has been approved. Below are the request details.</p>
                            <br>
                            <h4>Details:</h4>
                            <table border = 1 style=\\\"border-collapse: collapse;\\\">
                                <tr><td>Leave ID</td><td>".$leave_id."</td></tr>
                                <tr><td>Employee</td><td>".$user_id."</td></tr>
                                <tr><td>Leave Type</td><td>".$leave_type."</td></tr>
                                <tr><td>From Date</td><td>".$start_date."</td></tr>
                                <tr><td>To Date</td><td>".$end_date."</td></tr>
                                <tr><td>Day(s)</td><td>".$amount."</td></tr>
                                <tr><td>Status</td><td>".$status."</td></tr>
                            </table>
                            <br><br>
                            <span>Best Regards, <br>JustApply</span>
                        </div>";

                $data = json_encode(array('title' => $title, 'body' =>$body, 'recipient' => $email));
                $result = $this->send_email($data);
                return $data;
                
            } catch (\PDOException $e) {
                return $e->getMessage();
                exit($e->getMessage());
            }    
        }

        public function leave_reject_email($detail){
            // bind data            
            try {
                $user_id = $detail->user_id;

                $email = array();
                $user = $this->get_user_email($user_id);
                $email[0] = $user['email'];
                $user_name = $user['name'];

                $leave_id = $detail->leave_id;               
                $leave_type = $detail->leave_type;
                $start_date = $detail->start_date;
                $end_date = $detail->end_date;
                $amount = $detail->amount;
                $status = "Approved";
   
                $title = 'JustApply: Leave Application Rejected';
                $body = "<div>
                            <h2>Leave Application Rejected</h2>
                            <p>Hi ".$user_name.", </p>
                            <p>Sorry, your leave request - ".$leave_id." has been rejected. Below are the request details.</p>
                            <br>
                            <h4>Details:</h4>
                            <table border = 1 style=\\\"border-collapse: collapse;\\\">
                                <tr><td>Leave ID</td><td>".$leave_id."</td></tr>
                                <tr><td>Employee</td><td>".$user_id."</td></tr>
                                <tr><td>Leave Type</td><td>".$leave_type."</td></tr>
                                <tr><td>From Date</td><td>".$start_date."</td></tr>
                                <tr><td>To Date</td><td>".$end_date."</td></tr>
                                <tr><td>Day(s)</td><td>".$amount."</td></tr>
                                <tr><td>Status</td><td>".$status."</td></tr>
                            </table>
                            <br><br>
                            <span>Best Regards, <br>JustApply</span>
                        </div>";

                $data = json_encode(array('title' => $title, 'body' =>$body, 'recipient' => $email));
                $result = $this->send_email($data);
                return $data;
                
            } catch (\PDOException $e) {
                return $e->getMessage();
                exit($e->getMessage());
            }    
        }

        // LOGIN
        public function send_email($data){

            $detail = json_decode($data);
            $mail = new PHPMailer();
            try {
                // $mail->SMTPDebug  = 1;  
                $mail->IsSMTP();
                $mail->SMTPAuth   = TRUE;
                $mail->SMTPSecure = "tls";
                $mail->Port       = 587;
                $mail->Host       = "smtp.gmail.com";
                $mail->Username   = "Justapply409@gmail.com";
                $mail->Password   = "";
            // Set the sender, recipient, subject, and body of the message
                $mail->setFrom('Justapply409@gmail.com');
                foreach( $detail->recipient as $value ) {
                    $mail->addAddress($value);
                }
                 
                $mail->isHTML(true);
                $mail->Subject = $detail->title;
                $mail->Body = $detail->body;
                $mail->AltBody = 'This is the body in plain text for non-HTML mail clients';
                $mail->send();

                if(!$mail->send()) {
                    $result =  'Mailer Error: ' . $mail->ErrorInfo;
                    return $result;
                }

                $result = 'Message has been sent';
                return $result;
            } catch (\PDOException $e) {
                exit($e->getMessage());
            }    
        }
 

        public function leave_application_template(){
            $title = 'Leave Management System: New Leave Application';
            $body = '<div>
                        <h2>New Leave Application</h2>
                        <h4>Details:</h4>
                        <table border = "1" style="border-collapse: collapse;">
                            <tr><td>Employee</td><td>Hee Hooi Sze</td></tr>
                            <tr><td>Leave Type</td><td>Annual Leave</td></tr>
                            <tr><td>From Date</td><td>2023-08-21</td></tr>
                            <tr><td>To Date</td><td>2023-08-23</td></tr>
                            <tr><td>Day(s)</td><td>3</td></tr>
                            <tr><td>Status</td><td>Open</td></tr>
                        </table>
                        <br><br>
                        <span>Best Regards, <br>Leave Management System</span>
                    </div>';
            return json_encode(array('title' => $title, 'body' =>$body));
        }

        public function new_employee_template(){
            $title = 'Leave Management System: Welcome to MyCompany';
            $body = '<div>
                        Dear HOOI SZE ,
                        <p>We are thrilled you have become part of our company and delighted to give you important information. This information will help you to get ready for an exciting first day at MyCompany.</p>
                        <p>Below are the information to access the Leave Management System:</p>
                        <table border = "1" style="border-collapse: collapse;">
                            <tr><td>Start Date</td><td>2023-08-21</td></tr>
                            <tr><td>User Id</td><td>hooisze</td></tr>
                            <tr><td>Password</td><td>MTIzNDU2</td></tr>
                        </table>
                        <br>
                        <p>Feel free to change your password when you first access the website.</p>
                        <p>We look forward to welcoming you to MyCompany and here’s wishing you an exciting and fulfilling job with us!</p>
                        <span>Best Regards, <br>Leave Management System</span>
                    </div>';
            return json_encode(array('title' => $title, 'body' =>$body));
        }
       
    }
?>