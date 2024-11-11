<?php 

namespace controllers\front;

require_once __DIR__ . '/../../config/Database.php';
require_once __DIR__ . '/../../models/OrderItem.php';

class OrderItemsController
{
    private $db;
    private $orderItem;

    public function __construct()
    {
        $this->db = (new \Database())->getConnection();
        $this->orderItem = new \OrderItem($this->db);
    }

    public function viewOrderItems($order_id){
        $this->orderItem->setorderId($order_id);
        return $this->orderItem->viewOrderItems();
    }

}