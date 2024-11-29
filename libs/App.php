


<?php 

    class App {

        public $host = HOST;
        public $dbname = DBNAME;
        public $user = USER;
        public $pass = PASS;
        
        public $link;

        public function __construct(){
            $this->connect();
            $this->update_ords();
            
        }
        public function selectAllCarrito($query){
            $rows = $this->link->query($query);
            $rows->execute();

            $allRows = $rows->fetchAll(PDO::FETCH_OBJ);

            // Cambiar el comportamiento para devolver un array vacío en lugar de false si no hay resultados
            return $allRows ? $allRows : []; 
        }
        public function selectAllBloqueados($query){
            $rows = $this->link->query($query);
            $rows->execute();

            $allRows = $rows->fetchAll(PDO::FETCH_OBJ);

            // Cambiar el comportamiento para devolver un array vacío en lugar de false si no hay resultados
            return $allRows ? $allRows : []; 
        }

        public function selectAllOrdenes($query){
            $rows = $this->link->query($query);
            $rows->execute();

            $allRows = $rows->fetchAll(PDO::FETCH_OBJ);

            // Cambiar el comportamiento para devolver un array vacío en lugar de false si no hay resultados
            return $allRows ? $allRows : []; 
        }


        public function update_ords(){
            $query_ord = "UPDATE orden SET estado = 'Sin devolver' WHERE fecha_devolucion < CURRENT_DATE AND fecha_devolucion IS NOT NULL";
            $rows = $this->link->query($query_ord);
            $rows->execute();
            $query_ord_ret = "UPDATE orden SET estado = 'Plazo vencido' WHERE fecha_retiro < CURRENT_DATE AND estado = 'Sin retirar' AND fecha_devolucion IS NULL";
            $rows_2 = $this->link->query($query_ord_ret);
            $rows_2->execute();
            $query_update_lib = "UPDATE libro SET disponible = 1 WHERE id_libro IN ( SELECT ol.id_libro FROM orden o JOIN orden_libro ol ON o.id_orden = ol.id_orden WHERE o.estado = 'Plazo vencido' )";
            $rows_3 = $this->link->query($query_update_lib);
            $rows_3->execute();
            $query_bloq_user = "INSERT INTO bloqueo (DNI) SELECT u.DNI
            FROM usuario u JOIN orden o ON u.DNI = o.DNI WHERE o.estado = 'Sin devolver' 
            AND NOT EXISTS ( SELECT 1 FROM bloqueo b WHERE b.DNI = u.DNI)";
            $rows_1 = $this->link->query($query_bloq_user);
            $rows_1->execute();
        }

        public function connect(){
            $this->link = new PDO("mysql:host=".$this->host.";dbname=".$this->dbname."", $this->user, $this->pass);

            if($this->link){
                
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

            $singleRow = $row->fetch(PDO::FETCH_OBJ);

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

        public function select_all_like($query, $like_val){
            $like_val = "%".$like_val."%";
            $stmt = $this->link->prepare($query);
            $stmt->bindParam(1, $like_val, PDO::PARAM_STR);
            $stmt->execute();
            

            $allRows = $stmt->fetchAll(PDO::FETCH_OBJ);

            if($allRows){
                return $allRows;

            } else{
                return false;
            }


        }
        public function insertPrest($dni,$desde,$hasta,$id_libro) {
            $codigo_nuevo = $this->generar_codigo_orden();
            $query_new_ord = "INSERT INTO orden (DNI, estado, codigo_reserva,fecha_retiro,fecha_devolucion) VALUES ($dni, 'En curso', '$codigo_nuevo',  '$desde','$hasta')";
          
    
           
 
            
            $insert_new_ord = $this->link->prepare($query_new_ord);
            $insert_new_ord->execute();
            $id_orden = $this->link->lastInsertId();

            
    
           

           

            
                $query_new_ord_lib = "INSERT INTO orden_libro (id_orden, id_libro) VALUES ($id_orden, $id_libro)";

                $insert_new_ord_libro = $this->link->prepare($query_new_ord_lib);
                $insert_new_ord_libro->execute();
            
           

           

            return $codigo_nuevo;
    

            
        }

        public function insertOrder($dni) {
            $codigo_nuevo = $this->generar_codigo_orden();
            $fecharetiro = date('Y-m-d', strtotime('+14 days'));
            
            $query_count_libs = "SELECT COUNT(c.id_libro) AS cantidad_libros FROM carrito c INNER JOIN usuario u ON c.id_usuario = u.DNI WHERE u.DNI = '$dni'";
            $count_carr_libs = $this->link->prepare($query_count_libs);
            $count_carr_libs->execute();

            $carr_cant_libs = $count_carr_libs->fetch(PDO::FETCH_ASSOC);

            $cant_libs = $carr_cant_libs['cantidad_libros'];

            $query_new_ord = "INSERT INTO orden (DNI, estado, codigo_reserva, fecha_retiro, cantidad) VALUES ($dni, 'Sin retirar', '$codigo_nuevo',  '$fecharetiro', $cant_libs)";
          
            
            
            $query_all_carr = "SELECT l.* FROM carrito c INNER JOIN libro l ON c.id_libro = l.id_libro WHERE c.id_usuario = '$dni'";
            

            $insert_new_ord = $this->link->prepare($query_new_ord);
            $insert_new_ord->execute();
            $id_orden = $this->link->lastInsertId();

            
            
            $rows = $this->link->prepare($query_all_carr);
            $rows->execute();

            $lista_libros_carr = $rows->fetchAll(PDO::FETCH_OBJ);

            
            
            

            foreach($lista_libros_carr as $libro_carr){

                

                $query_new_ord_lib = "INSERT INTO orden_libro (id_orden, id_libro) VALUES ($id_orden, $libro_carr->id_libro)";

                $insert_new_ord_libro = $this->link->prepare($query_new_ord_lib);
                $insert_new_ord_libro->execute();
            }

            return $codigo_nuevo;
    

            
        }

        public function reserv_now($dni,$id_libro){
            $codigo_nuevo = $this->generar_codigo_orden();
            $fecharetiro = date('Y-m-d', strtotime('+14 days'));
            $query_new_ord = "INSERT INTO orden (DNI, estado, codigo_reserva, fecha_retiro) VALUES ($dni, 'Sin retirar', '$codigo_nuevo',  '$fecharetiro')";
            $insert_new_ord = $this->link->prepare($query_new_ord);
            $insert_new_ord->execute();
            $id_orden = $this->link->lastInsertId();


            $query_new_ord_lib = "INSERT INTO orden_libro (id_orden, id_libro) VALUES ($id_orden, $id_libro)";

                $insert_new_ord_libro = $this->link->prepare($query_new_ord_lib);
                $insert_new_ord_libro->execute();
            
                return $codigo_nuevo;

        }
        
      

        public function update($query){

           
                $update_record = $this->link->prepare($query);
                $update_record->execute();

               
            
        }

        public function update_lib($id_libro,$titulo,$autor,$editorial,$anio,$idioma, 
        $ISBN, $ISSN,$descriptor_primario,$descriptor_secundario,$numero_edicion,$ubicacion,$cantidad_ejemplares){


            $id_libro = (int)$id_libro;
            $editorial = (int)$editorial;
            $anio = (int)$anio;
            $numero_edicion = (int)$numero_edicion;
            $cantidad_ejemplares = (int)$cantidad_ejemplares;

            // Asegurar que el resto sean cadenas
            $titulo = (string)$titulo;
            $autor = (string)$autor;
            $idioma = (string)$idioma;
            $ISBN = (string)$ISBN;
            $ISSN = (string)$ISSN;
            $descriptor_primario = (string)$descriptor_primario;
            $descriptor_secundario = (string)$descriptor_secundario;
            $ubicacion = (string)$ubicacion;

            $sql = "UPDATE libro SET 
            titulo = :titulo, 
            autor = :autor, 
            id_editorial = :editorial, 
            anio_edicion = :anio, 
            idioma = :idioma, 
            ISBN = :ISBN, 
            ISSN = :ISSN, 
            descriptor_primario = :descriptor_primario, 
            descriptor_secundario = :descriptor_secundario, 
            numero_edicion = :numero_edicion, 
            ubicacion = :ubicacion,
            cantidad_ejemplares = :cantidad_ejemplares
            WHERE id_libro = :id_libro";
    
            try {
                // Preparar la consulta
                $stmt = $this->link->prepare($sql);
        
                // Vincular los valores
                $stmt->bindValue(':id_libro', $id_libro, PDO::PARAM_INT);
                $stmt->bindValue(':titulo', $titulo, PDO::PARAM_STR);
                $stmt->bindValue(':autor', $autor, PDO::PARAM_STR);
                $stmt->bindValue(':editorial', $editorial, PDO::PARAM_INT);
                $stmt->bindValue(':anio', $anio, PDO::PARAM_INT);
                $stmt->bindValue(':idioma', $idioma, PDO::PARAM_STR);
                $stmt->bindValue(':ISBN', $ISBN, PDO::PARAM_STR);
                $stmt->bindValue(':ISSN', $ISSN, PDO::PARAM_STR);
                $stmt->bindValue(':descriptor_primario', $descriptor_primario, PDO::PARAM_STR);
                $stmt->bindValue(':descriptor_secundario', $descriptor_secundario, PDO::PARAM_STR);
                $stmt->bindValue(':numero_edicion', $numero_edicion, PDO::PARAM_INT);
                $stmt->bindValue(':ubicacion', $ubicacion, PDO::PARAM_STR);
                $stmt->bindValue(':cantidad_ejemplares', $cantidad_ejemplares, PDO::PARAM_INT);
        
                // Ejecutar la consulta
                $stmt->execute();
                header("location: "."modif_libro_preview.php"."");
               
            } catch (PDOException $e) {
                // Manejar el error
                echo "Error: " . $e->getMessage();
            }

        }

        public function delete_book($id_libro,$id_orden){

            
            $query_delete_fav = "DELETE FROM favoritos WHERE id_libro = $id_libro";
            $delete_record = $this->link->query($query_delete_fav);
            $delete_record->execute();
            $query_orden_libro = "DELETE FROM orden_libro WHERE id_libro = $id_libro";
            $delete_record_2 = $this->link->query($query_orden_libro);
            $delete_record_2->execute();


            $query_carr_delete = "DELETE FROM carrito WHERE id_libro = $id_libro";
            $delete_record_3 = $this->link->query($query_carr_delete);
            $delete_record_3->execute();
            $query_delete_ord = "DELETE FROM orden WHERE cantidad < 2 AND id_orden = $id_orden";
            $delete_record_5 = $this->link->query($query_delete_ord);
            $delete_record_5->execute();
            $query_delete_libro = "DELETE FROM libro WHERE id_libro = $id_libro";
            $delete_record_4 = $this->link->query($query_delete_libro);
            $delete_record_4->execute();
            
            header("location: "."eliminar_libro_preview.php"."");

            

        }

        public function delete_book_sin_ord($id_libro){

            
            $query_delete_fav = "DELETE FROM favoritos WHERE id_libro = $id_libro";
            $delete_record = $this->link->query($query_delete_fav);
            $delete_record->execute();
           


            $query_carr_delete = "DELETE FROM carrito WHERE id_libro = $id_libro";
            $delete_record_3 = $this->link->query($query_carr_delete);
            $delete_record_3->execute();
           
            $query_delete_libro = "DELETE FROM libro WHERE id_libro = $id_libro";
            $delete_record_4 = $this->link->query($query_delete_libro);
            $delete_record_4->execute();
            
            header("location: "."eliminar_libro_preview.php"."");

            

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
                    
                    header("location: ".$path."");
                   
                }
            }else{
                return false;
            }


        }

        public function login_admin($query, $data, $path){

            $login_admin = $this->link->query($query);
            $login_admin->execute();

            $fetch = $login_admin->fetch(PDO::FETCH_ASSOC);

            if($login_admin->rowCount() > 0){
                
                if($data['password'] == $fetch['password']){

                   
                   
                    
                    
                    $_SESSION['DNI'] = $fetch['DNI'];
                    header("location: ".$path."");
                   
                }
            }else{
                return false;
            }


        }
        public function checkEmailExists($queryc){

            $stmt = $this->link->query($queryc);
           
            $stmt->execute(); 
            
            if($stmt->rowCount() > 0){
                

                
                return true;
                
            }else{
                
                return false;
            }
           
        }

        public function lastInserted($query){
            $stmt = $this->link->query($query);
            
            if ($stmt) {
                // Obtener el último ID insertado
                $lastInserted = $this->link->lastInsertId();
        
                // Mostrar el último ID insertado
                echo "El ID del último registro insertado es: " . $lastInserted;
                return $lastInserted;
            } else {
                echo "Error en la consulta: " . $this->link->errorInfo()[2];
            }

        }

        public function startingSession(){
            session_start();
        }

        public function validateSession($path_search){
            
            if(isset($_SESSION['email'])){
                echo "<script>window.location.href='".$path_search."' </script>";
            }
        }

        public function generar_codigo_orden(){
            $longitudLetras = 3; 
            $longitudNumeros = 3;
            $letras = 'ABCDEFGHIJKLMNOPQRSTUVWXYZ';
            $numeros = '0123456789';
            $codigo = '';
            for ($i = 0; $i < $longitudLetras; $i++) { $codigo .= $letras[rand(0, strlen($letras) - 1)]; }
            for ($i = 0; $i < $longitudNumeros; $i++) { $codigo .= $numeros[rand(0, strlen($numeros) - 1)]; }
            return $codigo;
        }
        
    }


 
