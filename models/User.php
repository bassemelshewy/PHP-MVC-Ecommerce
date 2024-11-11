<?php 

class User{
    private $conn;
    private $table = 'users';
    private $id;
    private $name;
    private $email;
    private $password;
    private $role;
    private $column;
    private $value;

    public function __construct($conn){
        $this->conn = $conn;
    }

    public function setId($id)
    {
        $this->id = $id;
    }

    public function setName($name)
    {
        $this->name = $name;
    }

    public function setEmail($email)
    {
        $this->email = $email;
    }

    public function setPassword($password)
    {
        $this->password = $password;
    }

    public function setRole($role){
        $this->role = $role;
    }

    public function setColumn($column)
    {
        $this->column = $column;
    }

    public function setValue($value)
    {
        $this->value = $value;
    }

    public function getId(){
        return $this->id;
    }

    public function getName(){
        return $this->name;
    }

    public function getEmail(){
        return $this->email;
    }

    public function getPassword(){
        return $this->password;
    }

    public function getRole(){
        return $this->role;
    }   

    public function getColumn()
    {
        return $this->column;
    }

    public function getValue()
    {
        return $this->value;
    }

    public function find()
    {
        try {
            $column = $this->getColumn();
            $value = $this->getValue();

            $validColumns = ['id', 'email'];
            if (!in_array($column, $validColumns)) {
                die('Invalid column');
            }

            $query = "SELECT * FROM $this->table WHERE $column = ?";
            $stmt = $this->conn->prepare($query);
            $stmt->bind_param(is_numeric($value) ? "i" : "s", $value);
            $stmt->execute();
            $result = $stmt->get_result();

            if ($result->num_rows > 0) {
                return $result->fetch_assoc();
            }

            return null;
        } catch (Exception $e) {
            echo "Something went wrong";
            return false;
        }
    }

    public function register(){
        try{
            $name = $this->getName();
            $email = $this->getEmail();
            $password = password_hash($this->getPassword(), PASSWORD_DEFAULT);

            // return var_dump($email);
            $query = "INSERT INTO $this->table (name, email, password) VALUES (?, ?, ?)";
            $stmt = $this->conn->prepare($query);
            $stmt->bind_param("sss", $name, $email, $password);

            if ($stmt->execute()) {
                return true;
            } else {
                die('Failed to register user');
            }
        }catch (Exception $e){
            echo "Something went wrong";
            return false;
        }
    }

    public function login(){
        try{
            $email = $this->getEmail();
            $password = $this->getPassword();

            $query = "SELECT * FROM  $this->table  WHERE email = ?";
            $stmt = $this->conn->prepare($query);
            $stmt->bind_param("s", $email);

            if ($stmt->execute()) {
                $result = $stmt->get_result();
                $user = $result->fetch_assoc();

                if($user && password_verify($password, $user['password'])){
                    return $user;
                }
                return false;
            } else {
                die('Failed to Login');
            }
            
        }catch (Exception $e){
            echo "Something went wrong";
            return false;
        }
    }

    public function index() {
        try {
            $query = "SELECT * FROM $this->table";
            $stmt = $this->conn->query($query);

            return $stmt->fetch_all(MYSQLI_ASSOC);
        }catch (Exception $e){
            echo "Something went wrong";
            return false;
        }
    }

    public function update(){
        try{
            $id = $this->getId();
            $name = $this->getName();
            $email = $this->getEmail();
            $password = $this->getPassword();
            $role = $this->getRole();

            $query = "UPDATE $this->table SET name = ?, email = ?, role = ?, updated_at=NOW()";
            
            if(!empty($password)){
                $password = password_hash($password, PASSWORD_DEFAULT);
                $query .= ", password = ?";
            }
            $query .= " WHERE id = ?";

            $stmt = $this->conn->prepare($query);
            if (!empty($password)) {
                $stmt->bind_param("ssssi", $name, $email, $role, $password, $id);
            }else{
                $stmt->bind_param("sssi", $name, $email, $role, $id);
            }

            if ($stmt->execute()) {
                return true;
            } else {
                die('Failed to update');
            }
        }catch (Exception $e){
            echo "Something went wrong";
            return false;
        }
    }

    public function delete(){
        try {
            $id = $this->getId();

            $query = "DELETE FROM $this->table WHERE id = ?";
            $stmt = $this->conn->prepare($query);
            $stmt->bind_param("i", $id);
            if ($stmt->execute()) {
                return true;
            } else {
                die('Failed to delete');
            }
        } catch (Exception $e) {
            echo "Something went wrong";
            return false;
        }
    }
}