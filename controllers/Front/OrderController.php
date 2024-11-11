<?php

namespace controllers\front;

require_once __DIR__ . '/../../config/Database.php';
require_once __DIR__ . '/../../models/Order.php';

class OrderController
{
    private $db;
    private $order;

    public function __construct()
    {
        $this->db = (new \Database())->getConnection();
        $this->order = new \Order($this->db);
    }

    public function checkOut($userId, $cart)
    {
        try {
            $this->order->setUserId($userId);
            $this->order->setCart($cart);

            $orderId = $this->order->checkOut();

            setcookie('cart', "", time() - 3600);
            return $orderId;
        } catch (\Exception $e) {
            die("Something went wrong");
        }
    }

    public function getUserOrders($user_id){
        try{
            $this->order->setUserId($user_id);
            
            return $this->order->getUserOrders();
        } catch (\Exception $e) {
            die("Something went wrong");
        }
    }
}
