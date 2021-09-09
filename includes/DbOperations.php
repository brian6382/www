<?php 

    class DbOperations{

        private $con; 

        function __construct(){
            require_once dirname(__FILE__) . '/DbConnect.php';
            $db = new DbConnect; 
            $this->con = $db->connect(); 
        }


              // school management system      

        public function addTeacher($fullname, $email, $contact, $id_number, $address, $status,$position,$password){
           if(!$this->isTeacherExist($fullname)){
                $stmt = $this->con->prepare("INSERT INTO teachers (fullname, email, contact, id_number, address, status,position,password) VALUES (?, ?, ?, ?, ?,?, ?, ?)");
                $stmt->bind_param("sssssiss", $fullname, $email, $contact, $id_number, $address, $status,$position,$password);
                if($stmt->execute()){
                    return USER_CREATED; 
                }else{
                    return USER_FAILURE;
                }
            }
            return USER_EXISTS; 
        }

        private function isTeacherExist($fullname){
            $stmt = $this->con->prepare("SELECT   teacher_id  FROM teachers WHERE fullname = ?");
            $stmt->bind_param("s", $fullname);
            $stmt->execute(); 
            $stmt->store_result(); 
            return $stmt->num_rows > 0;  
        }

        public function addStudent($admission_number, $fullname, $class_id, $bus_id, $pickup_location){
           if(!$this->isStudentExist($fullname)){
                $stmt = $this->con->prepare("INSERT INTO students (admission_number, fullname, class_id, bus_id, pickup_location) VALUES (?, ?, ?, ?, ?");
                $stmt->bind_param("ssiis", $admission_number, $fullname, $class_id, $bus_id, $pickup_location);
                if($stmt->execute()){
                    return USER_CREATED; 
                }else{
                    return USER_FAILURE;
                }
            }
            return USER_EXISTS; 
        }

        private function isStudentExist($fullname){
            $stmt = $this->con->prepare("SELECT   student_id  FROM students WHERE fullname = ?");
            $stmt->bind_param("s", $fullname);
            $stmt->execute(); 
            $stmt->store_result(); 
            return $stmt->num_rows > 0;  
        }  
        // class_id    class_teacher   class_name  class_nickname  
 

        public function addClass($class_teacher, $class_name, $class_nickname){
           if(!$this->isClassExist($class_name)){
                $stmt = $this->con->prepare("INSERT INTO class (class_teacher, class_name, class_nickname) VALUES (?, ?, ?");
                $stmt->bind_param("iss", $class_teacher, $class_name, $class_nickname);
                if($stmt->execute()){
                    return USER_CREATED; 
                }else{
                    return USER_FAILURE;
                }
            }
            return USER_EXISTS; 
        }

        private function isClassExist($class_name){
            $stmt = $this->con->prepare("SELECT   class_id  FROM class WHERE class_name = ?");
            $stmt->bind_param("s", $class_name);
            $stmt->execute(); 
            $stmt->store_result(); 
            return $stmt->num_rows > 0;  
        }

        public function addDrivers($fullname, $contact, $email, $id_number, $address, $passport,$status,$password){
           if(!$this->isDriverExist($fullname)){
                $stmt = $this->con->prepare("INSERT INTO drivers (fullname, contact, email, id_number, address, passport,status,password) VALUES (?, ?, ?, ?, ?,?, ?, ?)");
                $stmt->bind_param("ssssssis", $fullname, $contact, $email, $id_number, $address, $passport,$status,$password);
                if($stmt->execute()){
                    return USER_CREATED; 
                }else{
                    return USER_FAILURE;
                }
            }
            return USER_EXISTS; 
        }

        private function isDriverExist($fullname){
            $stmt = $this->con->prepare("SELECT   driver_id  FROM drivers WHERE fullname = ?");
            $stmt->bind_param("s", $fullname);
            $stmt->execute(); 
            $stmt->store_result(); 
            return $stmt->num_rows > 0;  
        }


        public function addParents($fullname, $email, $contact, $address, $profile_photo, $password){
           if(!$this->isParentExist($fullname)){
                $stmt = $this->con->prepare("INSERT INTO parents (fullname, email, contact, address, profile_photo, password) VALUES (?, ?, ?, ?, ?, ?)");
                $stmt->bind_param("ssssss", $fullname, $email, $contact, $address, $profile_photo, $password);
                if($stmt->execute()){
                    return USER_CREATED; 
                }else{
                    return USER_FAILURE;
                }
            }
            return USER_EXISTS; 
        }

        private function isParentExist($fullname){
            $stmt = $this->con->prepare("SELECT   parent_id  FROM parents WHERE fullname = ?");
            $stmt->bind_param("s", $fullname);
            $stmt->execute(); 
            $stmt->store_result(); 
            return $stmt->num_rows > 0;  
        }


        public function addRoutes($route_name, $route_description, $route_locations){
           if(!$this->isRoutesExist($route_name)){
                $stmt = $this->con->prepare("INSERT INTO routes (route_name, route_description, route_locations) VALUES (?, ?, ?)");
                $stmt->bind_param("sss", $route_name, $route_description, $route_locations);
                if($stmt->execute()){
                    return USER_CREATED; 
                }else{
                    return USER_FAILURE;
                }
            }
            return USER_EXISTS; 
        }

        private function isRoutesExist($route_name){
            $stmt = $this->con->prepare("SELECT   route_id  FROM routes WHERE route_name = ?");
            $stmt->bind_param("s", $route_name);
            $stmt->execute(); 
            $stmt->store_result(); 
            return $stmt->num_rows > 0;  
        }


        public function addBus($driver_id, $route_id, $registration_number, $bus_picture){
           if(!$this->isBusExist($registration_number)){
                $stmt = $this->con->prepare("INSERT INTO school_bus (driver_id, route_id, registration_number, bus_picture) VALUES (?, ?, ?, ?)");
                $stmt->bind_param("iiss", $driver_id, $route_id, $registration_number, $bus_picture);
                if($stmt->execute()){
                    return USER_CREATED; 
                }else{
                    return USER_FAILURE;
                }
            }
            return USER_EXISTS; 
        }

        private function isBusExist($registration_number){
            $stmt = $this->con->prepare("SELECT   bus_id  FROM school_bus WHERE registration_number = ?");
            $stmt->bind_param("s", $registration_number);
            $stmt->execute(); 
            $stmt->store_result(); 
            return $stmt->num_rows > 0;  
        }

          
                          
    

        public function getAllTeachers(){
            $stmt = $this->con->prepare("SELECT teacher_id, fullname, email, contact, id_number, address, status,position,password FROM teachers  ORDER BY RAND() DESC");
            $stmt->execute(); 
            $stmt->bind_result($teacher_id, $fullname, $email, $contact, $id_number, $address, $status,$position,$password);
            $teachers = array(); 
            while($stmt->fetch()){ 
                $teacher = array(); 
                $teacher['teacher_id'] = $teacher_id; 
                $teacher['fullname']= $fullname; 
                $teacher['email'] = $email; 
                $teacher['contact'] = $contact; 
                $teacher['id_number'] = $id_number;  
                $teacher['address'] = $address;
                $teacher['status'] = $status; 
                $teacher['position'] = $position;
                $teacher['password'] = $password; 
                

                array_push($teachers, $teacher);
            }             
            return $teachers; 
        }

        public function getAllTeachersDetailsById($teacher_id){
            $stmt = $this->con->prepare("SELECT teacher_id, fullname, email, contact, id_number, address, status,position,password FROM teachers WHERE teacher_id = ?");
            $stmt->bind_param("i", $teacher_id);
            $stmt->execute(); 
            $stmt->bind_result($teacher_id, $fullname, $email, $contact, $id_number, $address, $status,$position,$password);
            $stmt->fetch(); 
            $teacher = array(); 
            $teacher['teacher_id'] = $teacher_id; 
            $teacher['fullname']= $fullname; 
            $teacher['email']= $email; 
            $teacher['contact'] = $contact; 
            $teacher['id_number'] = $id_number; 
            $teacher['address'] = $address; 
            $teacher['status'] = $status; 
            $teacher['position'] = $position; 
            $teacher['password'] = $password; 
            return $teacher; 
        }


        public function getAllDrivers(){
            $stmt = $this->con->prepare("SELECT driver_id, fullname, contact, email, id_number, address, passport,status,password FROM drivers  ORDER BY RAND() DESC");
            $stmt->execute(); 
            $stmt->bind_result($driver_id, $fullname, $contact, $email, $id_number, $address, $passport,$status,$password);
            $drivers = array(); 
            while($stmt->fetch()){ 
                $driver = array(); 
                $driver['driver_id'] = $driver_id; 
                $driver['fullname']= $fullname; 
                $driver['contact'] = $contact; 
                $driver['email'] = $email; 
                $driver['id_number'] = $id_number;  
                $driver['address'] = $address;
                $driver['passport'] = $passport; 
                $driver['status'] = $status;
                $driver['password'] = $password; 
                

                array_push($drivers, $driver);
            }             
            return $drivers; 
        }

        public function getAllDriversDetailsById($driver_id){
            $stmt = $this->con->prepare("SELECT driver_id, fullname, contact, email, id_number, address, passport,status,password FROM drivers WHERE driver_id = ?");
            $stmt->bind_param("i", $driver_id);
            $stmt->execute(); 
            $stmt->bind_result($driver_id, $fullname, $contact, $email, $id_number, $address, $passport,$status,$password);
            $stmt->fetch(); 
            $driver = array(); 
            $driver['driver_id'] = $driver_id; 
            $driver['fullname']= $fullname; 
            $driver['contact']= $contact; 
            $driver['email'] = $email; 
            $driver['id_number'] = $id_number; 
            $driver['address'] = $address; 
            $driver['passport'] = $passport; 
            $driver['status'] = $status; 
            $driver['password'] = $password; 
            return $driver; 
        }



        public function getAllParents(){
            $stmt = $this->con->prepare("SELECT parent_id, fullname, email, contact, address, profile_photo, password FROM parents  ORDER BY RAND() DESC");
            $stmt->execute(); 
            $stmt->bind_result($parent_id, $fullname, $email, $contact, $address, $profile_photo, $password);
            $parents = array(); 
            while($stmt->fetch()){ 
                $parent = array(); 
                $parent['parent_id'] = $parent_id; 
                $parent['fullname']= $fullname; 
                $parent['email'] = $email; 
                $parent['contact'] = $contact; 
                $parent['address'] = $address;  
                $parent['profile_photo'] = $profile_photo;
                $parent['password'] = $password; 
                // $parent['status'] = $status;
                // $parent['password'] = $password; 
                

                array_push($parents, $parent);
            }             
            return $parents; 
        }

        public function getAllParentsDetailsById($parent_id){
            $stmt = $this->con->prepare("SELECT parent_id, fullname, email, contact, address, profile_photo, password FROM parents WHERE parent_id = ?");
            $stmt->bind_param("i", $parent_id);
            $stmt->execute(); 
            $stmt->bind_result($parent_id, $fullname, $email, $contact, $address, $profile_photo, $password);
            $stmt->fetch(); 
            $parent = array(); 
            $parent['parent_id'] = $parent_id; 
            $parent['fullname']= $fullname; 
            $parent['email']= $email; 
            $parent['contact'] = $contact; 
            $parent['address'] = $address; 
            $parent['profile_photo'] = $profile_photo; 
            $parent['password'] = $password; 
            return $parent; 
        }


        public function getAllRoutes(){
            $stmt = $this->con->prepare("SELECT route_id, route_name, route_description, route_locations FROM routes  ORDER BY RAND() DESC");
            $stmt->execute(); 
            $stmt->bind_result($route_id, $route_name, $route_description, $route_locations);
            $routes = array(); 
            while($stmt->fetch()){ 
                $route = array(); 
                $route['route_id'] = $route_id; 
                $route['route_name']= $route_name; 
                $route['route_description']= $route_description; 
                $route['route_locations'] = $route_locations; 
                

                array_push($routes, $route);
            }             
            return $routes; 
        }

        public function getAllRoutesDetailsById($route_id){
            $stmt = $this->con->prepare("SELECT route_id, route_name, route_description, route_locations FROM routes WHERE route_id = ?");
            $stmt->bind_param("i", $route_id);
            $stmt->execute(); 
            $stmt->bind_result($route_id, $route_name, $route_description, $route_locations);
            $stmt->fetch(); 
            $route = array(); 
            $route['route_id'] = $route_id; 
            $route['route_name']= $route_name; 
            $route['route_description']= $route_description; 
            $route['route_locations'] = $route_locations; 
            return $route; 
        }


        public function getAllSchoolBus(){
            $stmt = $this->con->prepare("SELECT bus_id, driver_id, route_id, registration_number, bus_picture FROM school_bus  ORDER BY RAND() DESC");
            $stmt->execute(); 
            $stmt->bind_result($bus_id, $driver_id, $route_id, $registration_number, $bus_picture);
            $buss = array(); 
            while($stmt->fetch()){ 
                $bus = array(); 
                $bus['bus_id'] = $bus_id; 
                $bus['driver_id']= $driver_id; 
                $bus['route_id']= $route_id; 
                $bus['registration_number'] = $registration_number; 
                $bus['bus_picture'] = $bus_picture; 
                

                array_push($buss, $bus);
            }             
            return $buss; 
        }

        public function getAllSchoolBusDetailsById($bus_id){
            $stmt = $this->con->prepare("SELECT bus_id, driver_id, route_id, registration_number, bus_picture FROM school_bus WHERE bus_id = ?");
            $stmt->bind_param("i", $bus_id);
            $stmt->execute(); 
            $stmt->bind_result($bus_id, $driver_id, $route_id, $registration_number, $bus_picture);
            $stmt->fetch(); 
            $bus = array(); 
            $bus['bus_id'] = $bus_id; 
            $bus['driver_id']= $driver_id; 
            $bus['route_id']= $route_id; 
            $bus['registration_number'] = $registration_number; 
            $bus['bus_picture'] = $bus_picture; 
            return $bus; 
        }


        public function deleteTeacher($teacher_id){
            $stmt = $this->con->prepare("DELETE FROM teachers WHERE teacher_id = ?");
            $stmt->bind_param("i", $teacher_id);
            if($stmt->execute())
                return true; 
            return false; 
        }

        public function deleteParent($parent_id){
            $stmt = $this->con->prepare("DELETE FROM parents WHERE parent_id = ?");
            $stmt->bind_param("i", $parent_id);
            if($stmt->execute())
                return true; 
            return false; 
        }


        public function updateTeacherStatusDetails($status, $teacher_id){
            $stmt = $this->con->prepare("UPDATE teachers SET status = ? WHERE teacher_id = ?");
            $stmt->bind_param("ii", $status, $teacher_id);
            if($stmt->execute()) {
                return UPDATED;
            } else {
                return NOT_UPDATED; 
            }
        }

        public function updateparentstatusDetails($status, $parent_id){
            $stmt = $this->con->prepare("UPDATE parents SET status = ? WHERE parent_id = ?");
            $stmt->bind_param("ii", $status, $parent_id);
            if($stmt->execute()) {
                return UPDATED;
            } else {
                return NOT_UPDATED; 
            }
        }




        public function getAdminByPhone($email){
            $stmt = $this->con->prepare("SELECT user_id, name, email, added_date FROM tblsuper_admin WHERE email = ?");
            $stmt->bind_param("s", $email);
            $stmt->execute(); 
            $stmt->bind_result($user_id, $name, $email, $added_date);
            $stmt->fetch(); 
            $admin = array(); 
            $admin['id'] = $user_id;
            $admin['full_name'] = $name; 
            $admin['email_address']=$email; 
            $admin['phone_number'] = "0795419063"; 
            $admin['profile_photo'] = ""; 
            $admin['role'] = ""; 
            return $admin; 
        }






        public function getAdminDetails($email)
        {
             $stmt = $this->con->prepare("SELECT user_id, name, email, added_date FROM tblsuper_admin WHERE email = ?");
            $stmt->bind_param("s", $email);
            $stmt->execute();
            $stmt->bind_result($user_id, $name, $email,$added_date);
            $users = array();
            while($stmt->fetch()){
                $user = array();
                $user['user_id'] = $user_id;
                $user['name'] = $name;
                $user['email']=$email;
                $user['added_date'] = $added_date;
                // $user['updatio_date'] = $updatio_date;

                array_push($users, $user);
            }
            return $users;
        }

        public function adminLogin($email, $password){
            if($this->isPhoneExist($email)){
                $hashed_password = $this->getAdminPasswordByPhone($email); 
                if($password == $hashed_password){
                    return USER_AUTHENTICATED;
                }else{
                    return USER_PASSWORD_DO_NOT_MATCH; 
                }
            }else{
                return USER_NOT_FOUND; 
            }
        }



        private function isIdNumberExist($username){
            $stmt = $this->con->prepare("SELECT id FROM users WHERE username = ?");
            $stmt->bind_param("s", $username);
            $stmt->execute();
            $stmt->store_result();
            return $stmt->num_rows > 0;
        }
        private function getUserPasswordById($username){
            $stmt = $this->con->prepare("SELECT password FROM users WHERE username = ?");
            $stmt->bind_param("s", $username);
            $stmt->execute();
            $stmt->bind_result($password);
            $stmt->fetch();
            return $password;
        }

        public function createProfilePic($profile_photo, $email){
            $stmt = $this->con->prepare("UPDATE tblsuper_admin SET profile_photo = ? WHERE email = ?");
            $stmt->bind_param("ss", $profile_photo, $email);
            if($stmt->execute())
                return true;
            return false;
        }

        

        private function isPhoneExist($email){
            $stmt = $this->con->prepare("SELECT user_id FROM tblsuper_admin WHERE email = ?");
            $stmt->bind_param("s", $email);
            $stmt->execute(); 
            $stmt->store_result(); 
            return $stmt->num_rows > 0;  
        }

        private function getAdminPasswordByPhone($email){
            $stmt = $this->con->prepare("SELECT password FROM tblsuper_admin WHERE email = ?");
            $stmt->bind_param("s", $email);
            $stmt->execute(); 
            $stmt->bind_result($password);
            $stmt->fetch(); 
            return $password; 
        }

        public function countTotalFloor(){
            $stmt = $this->con->prepare("SELECT fid FROM tbl_add_floor");
            $stmt->execute(); 
            $stmt->store_result(); 
            return $stmt->num_rows;  
        }

        public function countTotalUnit(){
            $stmt = $this->con->prepare("SELECT uid FROM tbl_add_unit");
            $stmt->execute(); 
            $stmt->store_result(); 
            return $stmt->num_rows;  
        }

        public function countVaccant($status){
            $stmt = $this->con->prepare("SELECT uid FROM tbl_add_unit WHERE status = ?");
            $stmt->bind_param("i", $status);
            $stmt->execute(); 
            $stmt->store_result(); 
            return $stmt->num_rows;  
        }

        public function getTotalMaintenance(){
            $stmt = $this->con->prepare("SELECT SUM(m_amount) AS total_maintenance FROM tbl_add_maintenance_cost");
            $stmt->execute(); 
            $stmt->bind_result($total_maintenance);
            $stmt->fetch(); 
            return $total_maintenance; 
        }

        public function getTotalBill(){
            $stmt = $this->con->prepare("SELECT SUM(total_amount) AS total_bill FROM tbl_add_bill");
            $stmt->execute(); 
            $stmt->bind_result($total_bill);
            $stmt->fetch(); 
            return $total_bill; 
        }

        public function getTotalRentCollected(){
            $stmt = $this->con->prepare("SELECT SUM(total_rent) AS total_rent FROM tbl_add_fair");
            $stmt->execute(); 
            $stmt->bind_result($total_rent);
            $stmt->fetch(); 
            return $total_rent; 
        }

        public function getTotalDepositCollected(){
            $stmt = $this->con->prepare("SELECT SUM(deposit) AS deposit FROM tbl_add_rent");
            $stmt->execute(); 
            $stmt->bind_result($deposit);
            $stmt->fetch(); 
            return $deposit; 
        }

        public function getTotalAdvanceBalance(){
            $stmt = $this->con->prepare("SELECT SUM(r_advance) AS r_advance FROM tbl_add_rent");
            $stmt->execute(); 
            $stmt->bind_result($r_advance);
            $stmt->fetch(); 
            return $r_advance; 
        }

        public function countTenants(){
            $stmt = $this->con->prepare("SELECT rid FROM tbl_add_rent");
            $stmt->execute(); 
            $stmt->store_result(); 
            return $stmt->num_rows;  
        }

        public function getAllAccounts(){
            $stmt = $this->con->prepare("SELECT id, account_name, account_balance, balance_as_of FROM tbl_accounts  ORDER BY id DESC");
            $stmt->execute(); 
            $stmt->bind_result($id, $account_name, $account_balance, $balance_as_of);
            $accounts = array(); 
            while($stmt->fetch()){ 
                $account = array(); 
                $account['id'] = $id; 
                $account['account_name']= $account_name; 
                $account['account_balance'] = $account_balance; 
                $account['balance_as_of'] = $balance_as_of; 

                array_push($accounts, $account);
            }             
            return $accounts; 
        }

        public function getAllFloor(){
            $stmt = $this->con->prepare("SELECT fid, floor_no, added_date FROM tbl_add_floor  ORDER BY fid DESC");
            $stmt->execute(); 
            $stmt->bind_result($fid, $floor_no, $added_date);
            $floors = array(); 
            while($stmt->fetch()){ 
                $floor = array(); 
                $floor['fid'] = $fid; 
                $floor['floor_no']= $floor_no; 
                $floor['added_date'] = $added_date; 

                array_push($floors, $floor);
            }             
            return $floors; 
        }





        


                             

        //my code

        public function addMedicine($medicine_name, $category, $expire_date,$qty,$size,$status,$remaining_date){
           if(!$this->isMedicineExist($medicine_name)){
                $stmt = $this->con->prepare("INSERT INTO doses (medicine_name, category, expire_date, qty,size, status,remaining_date) VALUES (?, ?,?,?,?,?,?)");
                $stmt->bind_param("sssssss", $medicine_name, $category, $expire_date, $qty,$size, $status,$remaining_date);
                if($stmt->execute()){
                    return USER_CREATED; 
                }else{
                    return USER_FAILURE;
                }
            }
            return USER_EXISTS; 
        }

        private function isMedicineExist($medicine_name){
            $stmt = $this->con->prepare("SELECT dose_id FROM doses WHERE medicine_name = ?");
            $stmt->bind_param("s", $medicine_name);
            $stmt->execute(); 
            $stmt->store_result(); 
            return $stmt->num_rows > 0;  
        }

        public function getAllMedicineDetailsById($dose_id){
            $stmt = $this->con->prepare("SELECT dose_id, medicine_name, category, expire_date, qty, size, status,remaining_date FROM doses WHERE dose_id = ?");
            $stmt->bind_param("i", $dose_id);
            $stmt->execute(); 
            $stmt->bind_result($dose_id, $medicine_name, $category, $expire_date,$qty,$size,$status,$remaining_date);
            $stmt->fetch(); 
            $medicine = array(); 
            $medicine['dose_id'] = $dose_id; 
            $medicine['medicine_name']= $medicine_name; 
            $medicine['category']= $category; 
            $medicine['expire_date'] = $expire_date; 
            $medicine['qty'] = $qty; 
            $medicine['size'] = $size; 
            $medicine['status'] = $status; 
            $medicine['remaining_date'] = $remaining_date; 
            return $medicine; 
        }

        public function deleteMedicine($dose_id){
            $stmt = $this->con->prepare("DELETE FROM doses WHERE dose_id = ?");
            $stmt->bind_param("i", $dose_id);
            if($stmt->execute())
                return true; 
            return false; 
        }

        public function getAllMedicine(){
            $stmt = $this->con->prepare("SELECT dose_id, medicine_name, category, expire_date, qty, size, status,remaining_date FROM doses  ORDER BY dose_id DESC");
            $stmt->execute(); 
            $stmt->bind_result($dose_id, $medicine_name, $category, $expire_date, $qty,$size,$status,$remaining_date);
            $medicines = array(); 
            while($stmt->fetch()){ 
                $medicine = array(); 
                $medicine['dose_id'] = $dose_id; 
                $medicine['medicine_name']= $medicine_name; 
                $medicine['category'] = $category; 
                $medicine['expire_date'] = $expire_date; 
                $medicine['qty'] = $qty; 
                $medicine['size'] = $size; 
                $medicine['status'] = $status; 
                $medicine['remaining_date'] = $remaining_date; 

                array_push($medicines, $medicine);
            }             
            return $medicines; 
        }

        public function updateMedicineDetails($medicine_name, $category, $expire_date, $qty,$size, $dose_id){
            $stmt = $this->con->prepare("UPDATE doses SET medicine_name = ?, category = ?, expire_date = ?, qty = ?, size = ?   WHERE dose_id = ?");
            $stmt->bind_param("sssssi", $medicine_name, $category, $expire_date, $qty, $size,  $dose_id);

            if($stmt->execute()) {
                return UPDATED;
            } else {
                return NOT_UPDATED; 
            }
        }


        public function totalMessagesExpire(){
            $stmt = $this->con->prepare("SELECT dose_id FROM doses WHERE remaining_date <= 3 ");
            // $stmt = bind_param('s',$remaining_date );
            $stmt->execute(); 
            $stmt->store_result(); 
            return $stmt->num_rows;  
        }

        public function updateStatusDetails($status, $dose_id){
            $stmt = $this->con->prepare("UPDATE doses SET status = ? WHERE dose_id = ?");
            $stmt->bind_param("si", $status, $dose_id);
            if($stmt->execute()) {
                return UPDATED;
            } else {
                return NOT_UPDATED; 
            }
        }

         public function countTotalMedicine(){
            $stmt = $this->con->prepare("SELECT dose_id FROM doses");
            $stmt->execute(); 
            $stmt->store_result(); 
            return $stmt->num_rows;  
        }

        public function countTotalDrop(){
            $stmt = $this->con->prepare("SELECT dose_id FROM doses WHERE category = 'drop'");
            // $stmt = bind_param('s',$category);
            $stmt->execute(); 
            $stmt->store_result(); 
            return $stmt->num_rows;  
        }

        public function countTotalInhalers(){
            $stmt = $this->con->prepare("SELECT dose_id FROM doses WHERE category = 'inhaler'");
            // $stmt = bind_param('s',$category);
            $stmt->execute(); 
            $stmt->store_result(); 
            return $stmt->num_rows;  
        }

        

        public function countTotalInjections(){
            $stmt = $this->con->prepare("SELECT dose_id FROM doses WHERE category = 'injection'");
            // $stmt = bind_param('s',$category);
            $stmt->execute(); 
            $stmt->store_result(); 
            return $stmt->num_rows;  
        }

        public function countTotalSuppositories(){
            $stmt = $this->con->prepare("SELECT dose_id FROM doses WHERE category = 'Suppositorie'");
            // $stmt = bind_param('s',$category);
            $stmt->execute(); 
            $stmt->store_result(); 
            return $stmt->num_rows;  
        }
        public function countTotalTopicalMedicines(){
            $stmt = $this->con->prepare("SELECT dose_id FROM doses WHERE category = 'Topical Medicine'");
            // $stmt = bind_param('s',$category);
            $stmt->execute(); 
            $stmt->store_result(); 
            return $stmt->num_rows;  
        }

        public function countTotalTopicalCapsules(){
            $stmt = $this->con->prepare("SELECT dose_id FROM doses WHERE category = 'Capsules'");
            // $stmt = bind_param('s',$category);
            $stmt->execute(); 
            $stmt->store_result(); 
            return $stmt->num_rows;  
        }

        public function countTotalTopicalTablet(){
            $stmt = $this->con->prepare("SELECT dose_id FROM doses WHERE category = 'Tablet'");
            // $stmt = bind_param('s',$category);
            $stmt->execute(); 
            $stmt->store_result(); 
            return $stmt->num_rows;  
        }

        public function countTotalTopicalLiquid(){
            $stmt = $this->con->prepare("SELECT dose_id FROM doses WHERE category = 'Liquid'");
            // $stmt = bind_param('s',$category);
            $stmt->execute(); 
            $stmt->store_result(); 
            return $stmt->num_rows;  
        }

        public function updatePassword($currentpassword, $newpassword, $username){
            $hashed_password = $this->getUserPasswordById($username);
            
            if(password_verify($currentpassword, $hashed_password)){
                
                $hash_password = password_hash($newpassword, PASSWORD_DEFAULT);
                $stmt = $this->con->prepare("UPDATE users SET password = ? WHERE username = ?");
                $stmt->bind_param("ss",$hash_password, $username);

                if($stmt->execute())
                    return PASSWORD_CHANGED;
                return PASSWORD_NOT_CHANGED;

            }else{
                return PASSWORD_DO_NOT_MATCH; 
            }
        }
        



      }

