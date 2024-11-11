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
}