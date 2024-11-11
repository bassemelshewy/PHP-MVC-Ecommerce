<?php

class Product
{
    private $conn;
    private $table = 'products';
    private $id;
    private $name;
    private $description;
    private $category_id;
    private $price;
    private $image;
    private $column;
    private $value;
    private $search;

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

    public function setDescription($description)
    {
        $this->description = $description;
    }

    public function setCategoryId($category_id)
    {
        $this->category_id = $category_id;
    }

    public function setPrice($price)
    {
        $this->price = $price;
    }

    public function setImage($image)
    {
        $this->image = $image;
    }

    public function setColumn($column)
    {
        $this->column = $column;
    }

    public function setValue($value)
    {
        $this->value = $value;
    }

    public function setSearch($search){
        $this->search = $search;
    }

    public function getId()
    {
        return $this->id;
    }

    public function getName()
    {
        return $this->name;
    }

    public function getDescription()
    {
        return $this->description;
    }

    public function getCategoryId()
    {
        return $this->category_id;
    }

    public function getPrice()
    {
        return $this->price;
    }

    public function getImage()
    {
        return $this->image;
    }
    public function getColumn()
    {
        return $this->column;
    }

    public function getValue()
    {
        return $this->value;
    }

    public function getSearch(){
        return $this->search;
    }
    public function create()
    {
        try {
            $name = $this->getName();
            $description = $this->getDescription();
            $category_id = $this->getCategoryId();
            $price = $this->getPrice();
            $image = $this->getImage();

            $query = "INSERT INTO $this->table (name, description, category_id, price, image) VALUES (?,?,?,?,?)";
            $stmt = $this->conn->prepare($query);
            $stmt->bind_param("ssids", $name, $description, $category_id, $price, $image);
            if ($stmt->execute()) {
                return true;
            } else {
                die('Failed to create product');
            }
        } catch (Exception $e) {
            echo "Something went wrong ";
            return false;
        }
    }

    public function index()
    {
        try {
            $query = "SELECT p.*, c.name AS category_name FROM $this->table p
                    JOIN categories c ON p.category_id = c.id 
                    ORDER BY p.id";
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

            $validColumns = ['id', 'name', 'category_id'];
            if (!in_array($column, $validColumns)) {
                die('Invalid column');
            }

            $query = "SELECT p.*, c.name AS category_name FROM $this->table p 
                    JOIN categories c ON p.category_id = c.id
                    WHERE p.$column = ? LIMIT 1";
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

    public function update()
    {
        try {
            $id = $this->getId();
            $name = $this->getName();
            $description = $this->getDescription();
            $category_id = $this->getCategoryId();
            $price = $this->getPrice();
            $image = $this->getImage();

            $query = "UPDATE $this->table SET name=?, description=?, category_id=?, price=?, updated_at=NOW()";

            if ($image !== null) {
                $query .= ", image=?";
            }

            $query .= " WHERE id=?";

            $stmt = $this->conn->prepare($query);
            if ($image !== null) {
                $stmt->bind_param("ssidsi", $name, $description, $category_id, $price, $image, $id);
            } else {
                $stmt->bind_param("ssidi", $name, $description, $category_id, $price, $id);
            }

            if ($stmt->execute()) {
                return true;
            } else {
                die('Failed to update product');
            }
        } catch (Exception $e) {
            echo "Something went wrong ";
            return false;
        }
    }


    //////////front/////////
    public function getJustArrived()
    {
        try {
            $limit = 6;
            $query = "SELECT p.*, c.name AS category_name FROM $this->table p 
                    JOIN categories c ON p.category_id = c.id
                    ORDER BY p.created_at DESC LIMIT ?";
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

    public function viewAll(){
        try {
            $categoryId = $this->getCategoryId();
            $search = $this->getSearch();

            $query = "SELECT p.*, c.name AS category_name FROM $this->table p 
                    JOIN categories c ON p.category_id = c.id";

            $whereClause = "";

            if($categoryId){
                $whereClause .= " WHERE p.category_id = $categoryId";
            }

            if($search){
                if($whereClause){
                    $whereClause .= " AND";
                }else{
                    $whereClause .= " WHERE";
                }
                $whereClause .= " p.name LIKE '%" . $this->conn->real_escape_string($search) . "%'";
            }

            if($whereClause){
                $query .= $whereClause;
            }

            // die($query);
            $result = $this->conn->query($query);

            if(!$result){
                die("Couldn't execute query");
            }

            return $result->fetch_all(MYSQLI_ASSOC);
        } catch (Exception $e) {
            echo "Something went wrong ";
            return false;
        }
    }

    public function getBestSelling(){
        try{
            $limit = 6;
            $query = "SELECT p.*, c.name AS category_name FROM $this->table p
                        JOIN categories c ON p.category_id = c.id 
                        ORDER BY p.count_selling DESC LIMIT ?";
            $stmt = $this->conn->prepare($query);
            $stmt->bind_param('i', $limit);
            if($stmt->execute()){
                $result = $stmt->get_result();
                return $result->fetch_all(MYSQLI_ASSOC);
            }else{
                die('Failed to execution');
            }
        }catch (Exception $e){
            die("Something went wrong");
        }
    }
}
