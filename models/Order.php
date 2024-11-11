<?php

class Order
{
    private $conn;
    private $table = 'orders';
    private $id;
    private $status;
    private $user_id;
    private $cart;
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

    public function setStatus($status)
    {
        $this->status = $status;
    }

    public function setUserId($user_id)
    {
        $this->user_id = $user_id;
    }
    
    public function setCart($cart)
    {
        $this->cart = $cart;
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

    public function getStatus()
    {
        return $this->status;
    }

    public function getUserId()
    {
        return $this->user_id;
    }

    public function getCart()
    {
        return $this->cart;
    }

    public function getColumn()
    {
        return $this->column;
    }

    public function getValue()
    {
        return $this->value;
    }


    public function index()
    {
        try {
            $query = "SELECT o.*, u.name AS user_name, u.email As user_email FROM $this->table o
                    JOIN users u ON o.user_id = u.id 
                    ORDER BY o.created_at DESC";
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

    public function update()
    {
        try {
            $id = $this->getId();
            $status = $this->getStatus();

            $query = "UPDATE $this->table SET  status=?, updated_at=NOW() WHERE id = ?";

            $stmt = $this->conn->prepare($query);
            $stmt->bind_param("si", $status, $id);

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


    //////////////front//////////////

    public function getProductPrice($id){
        try{
            $query = "SELECT price FROM products WHERE id = ?";
            $stmt = $this->conn->prepare($query);
            $stmt->bind_param('i', $id);
            $stmt->execute();

            $result = $stmt->get_result();
            $row = $result->fetch_assoc();
            return $row['price'];
        }catch (\Exception $e) {
            die("Something went wrong");
        }
    }

    public function checkOut(){
        $cart = $this->getCart();
        $userId = $this->getUserId();

        $this->conn->begin_transaction();

        try{

            $total = 0;
            foreach ($cart as $item){
                $productPrice = $this->getProductPrice($item['product_id']);
                // die(var_dump($productPrice, $item['quantity']));
                $subTotal = $item['quantity'] * $productPrice;
                $total += $subTotal;
            }

            $query1 = "INSERT INTO $this->table (user_id, total_price) VALUES (?, ?)";
            $stmt1 = $this->conn->prepare($query1);
            $stmt1->bind_param('id', $userId, $total);
            $stmt1->execute();

            $orderId = $stmt1->insert_id;

            $query2 = "INSERT INTO order_items (order_id, product_id, quantity, price) VALUES (?, ?, ?, ?)";
            foreach ($cart as $item){
                $cart_product_id = $item['product_id'];
                $cart_quentity = $item['quantity'];
                $productPrice = $this->getProductPrice($cart_product_id);
                
                $stmt2 = $this->conn->prepare($query2);
                $stmt2->bind_param('iiid', $orderId, $cart_product_id, $cart_quentity, $productPrice);
                $stmt2->execute();

                $query3 = "UPDATE products SET count_selling = count_selling + ? WHERE id = ?";
                $stmt3 = $this->conn->prepare($query3);
                $stmt3->bind_param('ii', $cart_quentity, $cart_product_id);
                $stmt3->execute();
            }

            $this->conn->commit();

            return $orderId;
        } catch (\Exception $e) {
            $this->conn->rollback();
            die("Something went wrong");
        }

    }

    public function getUserOrders(){
        try{
            $userId = $this->getUserId();

            $query = "SELECT o.* FROM $this->table o
                    JOIN users u ON o.user_id = u.id
                    WHERE u.id = ? 
                    ORDER BY o.created_at DESC";

            $stmt = $this->conn->prepare($query);
            $stmt->bind_param('i', $userId);
            $stmt->execute();

            $results = $stmt->get_result();
            if(!$results){
                die("Failed to execute");
            }
            return $results->fetch_all(MYSQLI_ASSOC);
        }catch (\Exception $e){
            die("Something went wrong");
        }
    }
}
