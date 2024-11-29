


<?php 

    class App {

        public $host = HOST;
        public $dbname = DBNAME;
        public $user = USER;
        public $pass = PASS;
        
        public $link;

        public function __construct(){
            $this->connect();
            
        }

        public function connect(){
            $this->link = new PDO("mysql:host=".$this->host.";dbname=".$this->dbname."", $this->user, $this->pass);

            if($this->link){
                echo "la conexion con la db fue exitosa";
            }
        }

        public function selectAll($query){

            $rows = $this->link->query($query);
            $rows->execute();

            $allRows = $rows->fetchAll(PDO::FETCH_OBJ);

            if($allRows){
                return $allRows;

            } else{
                return false;
            }

        }

        public function selectOne($query){

            $row = $this->link->query($query);
            $row->execute();

            $singleRow = $row->fetchAll(PDO::FETCH_OBJ);

            if($singleRow){
                return $singleRow;

            } else{
                return false;
            }

        }

        public function insert($query, $arr, $path){

            if($this->validate($arr) == "vacio"){
                echo "<script>alert('una o mas ingresos estan vacios')</script>";

            }else{
                $insert_record = $this->link->prepare($query);
                $insert_record->execute($arr);

                header("location: ".$path."");
            }
        }


        public function update($query, $arr, $path){

            if($this->validate($arr) == "vacio"){
                echo "<script>alert('una o mas ingresos estan vacios')</script>";

            }else{
                $update_record = $this->link->prepare($query);
                $update_record->execute($arr);

                header("location: ".$path."");
            }
        }

        public function delete($query, $path){

           
                $delete_record = $this->link->query($query);
                $delete_record->execute();

                header("location: ".$path."");
            
        }

        public function validate($arr){
            if(in_array("", $arr)){
                echo "vacio";
            }
        }

        public function register($query, $arr, $path){

            if($this->validate($arr) == "vacio"){
                echo "<script>alert('una o mas ingresos estan vacios')</script>";

            }else{
                $register_user = $this->link->prepare($query);
                $register_user->execute($arr);

                header("location: ".$path."");
            }
        }

        public function login($query, $data, $path){

            $login_user = $this->link->query($query);
            $login_user->execute();

            $fetch = $login_user->fetch(PDO::FETCH_ASSOC);

            if($login_user->rowCount() > 0){

                if(password_verify($data['password'], $fetch['password'])){

                   
                   
                    
                    $_SESSION['email'] = $fetch['email'];
                    header("location: ".APPURL."");
                   
                }
            }


        }
        public function checkEmailExists($queryc){

            $stmt = $this->link->query($queryc);
           
            $stmt->execute();
            

            if($stmt->rowCount() > 0){
                
                echo "ya existe un mail";
                exit;
            }
           
        }

        public function startingSession(){
            session_start();
        }

        public function validateSession($path){
            
            if(isset($_SESSION['id'])){
                header("location: ".$path."");
            }
        }
    }


 
