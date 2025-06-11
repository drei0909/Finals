<?php
 
class database {
 
    function opencon() {
        return new PDO(
            'mysql:host=localhost;dbname=cof_shop',
            username: 'root',
            password: ''
        );
    }
 
    function signupUser($firstname, $lastname, $username, $email, $password) {
        $con = $this->opencon();
 
        try {
            $con->beginTransaction();
 
            $stmt = $con->prepare("INSERT INTO admin (admin_FN, admin_LN, admin_username, admin_email, admin_password) VALUES (?, ?, ?, ?, ?)");
            $stmt->execute([$firstname, $lastname, $username, $email, $password]);
 
            $userId = $con->lastInsertId();
            $con->commit();
 
            return $userId;
        } catch (PDOException $e) {
            $con->rollBack();
            return false;
        }
    }
     function isUsernameExists ($username) {
        $con = $this->opencon();
        $stmt = $con->prepare("SELECT COUNT(*) FROM admin WHERE admin_username = ?");
        $stmt->execute([$username]);
        $count = $stmt->fetchColumn();
        return $count > 0;
        }

        function isEmailExists ($email) {
        $con = $this->opencon();
        $stmt = $con->prepare("SELECT COUNT(*) FROM admin WHERE admin_email = ?");
        $stmt->execute([$email]);
        $count = $stmt->fetchColumn();
        return $count > 0;
        }

    function loginUser($username, $password) {
    $con = $this->opencon();
    $stmt = $con->prepare("SELECT * FROM admin WHERE admin_username = ?");
    $stmt->execute([$username]);
    $user = $stmt->fetch(PDO::FETCH_ASSOC);
    if ($user && password_verify($password, $user['admin_password'])) {
    return $user;
    }

    return false;
}
 
 function addStudent($firstname, $lastname, $email, $admin_id) {

 

 $con = $this->opencon();

 try {
            $con->beginTransaction();
 
            $stmt = $con->prepare("INSERT INTO students (student_FN, student_LN, student_email, admin_id) VALUES (?, ?, ?, ?)");
            $stmt->execute([$firstname, $lastname, $email, $admin_id]);
 
            $userId = $con->lastInsertId();
            $con->commit();
 
            return $userId;
        } catch (PDOException $e) {
            $con->rollBack();
            return false;
        }
    }

    function addCourse($course_name, $admin_id) {

 

 $con = $this->opencon();

 try {
            $con->beginTransaction();
 
            $stmt = $con->prepare("INSERT INTO courses (course_name, admin_id) VALUES (?, ?)");
            $stmt->execute([$course_name, $admin_id]);
 
            $userId = $con->lastInsertId();
            $con->commit();
 
            return $userId;
        } catch (PDOException $e) {
            $con->rollBack();
            return false;
        }
    }

    function getStudents() {
    $con = $this->opencon();
    return $con->query("SELECT * FROM students")->fetchAll();

    }

    function getStudentByID($student_id) {
        $con = $this->opencon();
        $stmt = $con->prepare("SELECT * FROM students WHERE student_id = ?");
        $stmt->execute([$student_id]);
        return $stmt->fetch(PDO::FETCH_ASSOC);
    }

    function updateStudent($firstname, $lastname, $email, $student_id){    
            
        try {
            $con = $this->opencon();
            $con->beginTransaction();

            $query = $con->prepare("UPDATE students SET student_FN = ?, student_LN = ?, student_email = ? WHERE student_id = ?");
            $query->execute([$firstname, $lastname, $email, $student_id]);
 
            $con->commit();
 
            return true;
        } catch (PDOException $e) {
            $con->rollBack();
            return false;

        }
    }
}
?>