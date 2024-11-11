<?php

class ContactUs
{
    private $conn;
    private $table = 'contacts';
    private $id;
    private $name;
    private $email;
    private $message;
    private $user_id;
    private $column;
    private $value;

    public function __construct($conn)
    {
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

    public function setMessage($message)
    {
        $this->message = $message;
    }

    public function setColumn($column)
    {
        $this->column = $column;
    }

    public function setValue($value)
    {
        $this->value = $value;
    }

    public function getId()
    {
        return $this->id;
    }

    public function getName(){
        return $this->name;
    }

    public function getEmail(){
        return $this->email;
    }

    public function getMessage()
    {
        return $this->message;
    }

    public function getColumn()
    {
        return $this->column;
    }

    public function getValue()
    {
        return $this->value;
    }

    public function create()
    {
        try {
            $name = $this->getName();
            $email = $this->getEmail();
            $message = $this->getMessage();
            

            $query = "INSERT INTO $this->table (name, email, message) VALUES (?, ?,?)";
            $stmt = $this->conn->prepare($query);
            $stmt->bind_param("sss", $name, $email, $message);
            if ($stmt->execute()) {
                return true;
            } else {
                die('Failed to send this message');
            }
        } catch (Exception $e) {
            echo "Something went wrong ";
            return false;
        }
    }

    public function index()
    {
        try {
            $query = "SELECT * FROM $this->table
                    ORDER BY created_at DESC";
            $stmt = $this->conn->query($query);
            // die($stmt->error)
            return $stmt->fetch_all(MYSQLI_ASSOC);
        } catch (Exception $e) {
            echo "Something went wrong ";
            return false;
        }
    }

    public function find()
    {
        try {
            $column = $this->getColumn();
            $value = $this->getValue();

            $validColumns = ['id', 'user_id'];
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
            echo "Something went wrong ";
            return false;
        }
    }


    public function delete()
    {
        try {
            $id = $this->getId();

            $query = "DELETE FROM  $this->table  WHERE id=?";
            $stmt = $this->conn->prepare($query);
            $stmt->bind_param("i", $id);
            return $stmt->execute();
        } catch (Exception $e) {
            echo "Something went wrong ";
            return false;
        }
    }

}
