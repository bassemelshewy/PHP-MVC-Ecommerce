<?php

class Category
{
    private $conn;
    private $table = 'categories';
    private $id;
    private $name;
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

    public function getName()
    {
        return $this->name;
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

            $query = "INSERT INTO $this->table (name) VALUES (?)";
            $stmt = $this->conn->prepare($query);
            $stmt->bind_param("s", $name);
            if ($stmt->execute()) {
                return true;
            } else {
                die('Failed to create category');
            }
        } catch (Exception $e) {
            echo "Something went wrong ";
            return false;
        }
    }

    public function index()
    {
        try {
            $query = "SELECT * FROM $this->table ORDER BY created_at DESC";
            $stmt = $this->conn->query($query);
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

            $validColumns = ['id', 'name'];
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
            if ($stmt->execute()) {
                return true;
            } else {
                die('Failed to delete category');
            }
        } catch (Exception $e) {
            echo "Something went wrong ";
            return false;
        }
    }

    public function update()
    {
        try {
            $name = $this->getName();
            $id = $this->getId();

            $query = "UPDATE $this->table SET name=?, updated_at=NOW() WHERE id=?";
            $stmt = $this->conn->prepare($query);
            $stmt->bind_param("si", $name, $id);
            if ($stmt->execute()) {
                return true;
            } else {
                die('Failed to update category');
            }
        } catch (Exception $e) {
            echo "Something went wrong ";
            return false;
        }
    }




    ///////front/////
    public function viewLimit()
    {
        try {
            $limit = 6;
            $query = "SELECT * FROM $this->table LIMIT ?";
            $stmt = $this->conn->prepare($query);
            $stmt->bind_param("i", $limit);
            $stmt->execute();
            $result = $stmt->get_result();
            return $result->fetch_all(MYSQLI_ASSOC);
        } catch (Exception $e) {
            echo "Something went wrong ";
            return false;
        }
    }



}
