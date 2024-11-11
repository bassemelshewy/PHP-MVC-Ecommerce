<?php

class OrderItem
{
    private $conn;
    private $table = 'order_items';
    private $id;
    private $user_id;
    private $order_id;
    private $product_id;
    private $price;
    private $quantity;
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

    public function setUserId($user_id)
    {
        $this->user_id = $user_id;
    }

    public function setorderId($order_id)
    {
        $this->order_id = $order_id;
    }

    public function setProductId($product_id)
    {
        $this->product_id = $product_id;
    }
    
    public function setPrice($price)
    {
        $this->price = $price;
    }

    public function setQuantity($quantity)
    {
        $this->quantity = $quantity;
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

    public function getUserId()
    {
        return $this->user_id;
    }

    public function getorderId()
    {
        return $this->order_id;
    }

    public function getProductId()
    {
        return $this->product_id;
    }

    public function getPrice()
    {
        return $this->price;
    }

    public function getQuantity()
    {
        return $this->quantity;
    }

    public function getColumn()
    {
        return $this->column;
    }

    public function getValue()
    {
        return $this->value;
    }

    public function index(){
        try {
            $orderId = $this->getOrderId();
    
            $query = "SELECT oi.quantity, oi.price,
                        p.id AS product_id,
                        p.name AS product_name,
                        p.image AS product_image, 
                        u.name AS user_name, 
                        u.email AS user_email 
                        FROM $this->table oi 
                        JOIN products p ON oi.product_id = p.id
                        JOIN orders o ON oi.order_id = o.id
                        JOIN users u ON o.user_id = u.id";
    
            if($orderId){
                $query .= " WHERE oi.order_id = ?";
            }
    
            $query .= " ORDER BY oi.id DESC";
    
            $stmt = $this->conn->prepare($query);
    
            if($orderId){
                $stmt->bind_param("i", $orderId);
            }
    
            $stmt->execute();
            $result = $stmt->get_result();
    
            if(!$result){
                die("Couldn't execute query");
            }
    
            return $result->fetch_all(MYSQLI_ASSOC);
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

            $validColumns = ['id', 'order_id'];
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


    //////////////front//////////////

    public function viewOrderItems(){
        try {
            $orderId = $this->getOrderId();

            $query = "SELECT oi.price,
                        c.name AS category_name, 
                        p.id AS product_id,
                        p.name AS product_name,
                        p.image AS product_image
                        FROM $this->table oi 
                        JOIN products p ON oi.product_id = p.id
                        JOIN categories c ON p.category_id = c.id
                        WHERE oi.order_id = ?";

            $stmt = $this->conn->prepare($query);
            $stmt->bind_param('i', $orderId);
            $stmt->execute();

            $results = $stmt->get_result();

            if(!$results){
                die("Couldn't execute query");
            }

            return $results->fetch_all(MYSQLI_ASSOC);
        } catch (Exception $e) {
            echo "Something went wrong ";
            return false;
        }
    }

}
