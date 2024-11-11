<?php
namespace controllers;

require_once __DIR__ . '/../config/Database.php';
require_once __DIR__ . '/../models/OrderItem.php';

class OrderItemsController
{
    private $db;
    private $orderItem;

    public function __construct()
    {
        $this->db = (new \Database())->getConnection();
        $this->orderItem = new \orderItem($this->db);
    }

    public function find($value, $column = 'id')
    {
        $this->orderItem->setColumn($column);
        $this->orderItem->setValue($value);
        return $this->orderItem->find();
    }

    public function index($orderId = null)
    {
        $this->orderItem->setorderId($orderId);
        return $this->orderItem->index();
    }

}
