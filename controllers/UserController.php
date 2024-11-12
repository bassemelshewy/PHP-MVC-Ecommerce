<?php 

require_once __DIR__ . '/../config/Database.php';
require_once __DIR__ . '/../models/User.php';

class UserController{

    private $db;
    private $user;

    public function __construct()
    {
        $this->db = (new Database())->getConnection();
        $this->user = new User($this->db);
    }
    
    public function find($value, $column = 'id')
    {
        $this->user->setColumn($column);
        $this->user->setValue($value);
        return $this->user->find();
    }

    public function register($name, $email, $password){
        try{
            $this->user->setName($name);
            $this->user->setEmail($email);
            $this->user->setPassword($password);

            return $this->user->register();
        } catch (Exception $e) {
            echo "Something went wrong";
            return false;
        }
    }

    public function login($email, $password){
        try{
            $this->user->setEmail($email);
            $emailExisting = $this->find($email, 'email');
            if(!$emailExisting){
                die("Could not find this user");
            }

            $this->user->setPassword($password);

            return $this->user->login();
        }catch (Exception $e) {
            echo "Something went wrong";
            return false;
        }
    }

    public function index(){
        return $this->user->index();
    }

    public function update($id, $name, $email, $role, $password=null){
        try{
            $user = $this->find($id);
            if(!$user){
                die("Could not find this user");
            }

            $userEmail = $this->find($email, 'email');

            if ($userEmail && $userEmail['id'] != $id) {
                die('This email already exists');
            }

            $this->user->setId($id);
            $this->user->setName($name);
            $this->user->setEmail($email);
            $this->user->setRole($role);

            if (!empty($password)) {
                $this->user->setPassword($password);
            }
            
            return $this->user->update();
        } catch (Exception $e) {
            echo "Something went wrong";
            return false;
        }
    }

    public function delete($id){
        try{
            $user = $this->find($id);
            if(!$user){
                die("Could not find this user");
            }

            $this->user->setId($id);
            
            return $this->user->delete();
        } catch (Exception $e) {
            echo "Something went wrong";
            return false;
        }
    }

    public function validation($name, $email, $password, $password_confirmation){
        $nameErr = $emailErr = $passwordErr = $confPasswordErr = "";
        $hasErr = false;

        if(empty($name)){
            $nameErr = "Name is required";
            $hasErr = true;
        }else if(!preg_match("/^[a-zA-Z-' ]*$/",$name)){
            $nameErr = "Only letters and white space allowed";
            $hasErr = true;
        }
        
        if (empty($email)) {
            $emailErr = "Email is required";
            $hasErr = true;
        }else if (!filter_var($email, FILTER_VALIDATE_EMAIL)){
            $emailErr = "Email is not valid";
            $hasErr = true;
        }

        $uppercase = preg_match('@[A-Z]@', $password);
        $lowercase = preg_match('@[a-z]@', $password);
        $number    = preg_match('@[0-9]@', $password);
        $specialChars = preg_match('@[^\w]@', $password);
        if (empty($password)) {
            $passwordErr = "Password is required";
            $hasErr = true;
        } else if(!$uppercase || !$lowercase || !$number || !$specialChars || strlen($password) < 8){
            $passwordErr = "Password must be at least 8 characters long and should include at least one upper case letter, 
            one number, and one special character.";
            $hasErr = true;
        }

        if (empty($password_confirmation)){
            $confPasswordErr = "Password conformation is required";
            $hasErr = true;
        }else if($password !== $password_confirmation){
            $confPasswordErr = "Passwords do not match.";
            $hasErr = true;
        }
    
        return [$hasErr, $nameErr, $emailErr, $passwordErr, $confPasswordErr];
        // if (!$hasErr) {
        //     $userController = new UserController();
        //     $user = $userController->find($email, 'email');
    
        //     if ($user) {
        //         die('User already exists');
        //     }
    
        //     if ($userController->register($name, $email, $password)) {
        //         header('Location: login.php');
        //     } else {
        //         die('User registration failed');
        //     }
        // }
    }
}