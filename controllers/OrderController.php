<?php
namespace controllers;

require_once __DIR__ . '/../config/Database.php';
require_once __DIR__ . '/../models/Order.php';

class OrderController
{
    private $db;
    private $order;

    public function __construct()
    {
        $this->db = (new \Database())->getConnection();
        $this->order = new \Order($this->db);
    }

    public function find($value, $column = 'id')
    {
        $this->order->setColumn($column);
        $this->order->setValue($value);
        return $this->order->find();
    }

    public function index()
    {
        return $this->order->index();
    }

    public function delete($id)
    {
        try {
            $order = $this->find($id);
            if (!$order) {
                die('Order ID does not exist');
            }
            $this->order->setId($id);
            $this->order->delete();
        } catch (\Exception $e) {
            echo "Something went wrong ";
            return false;
        }
    }

    public function update($id, $status)
    {
        try {
            $order = $this->find($id);

            if (!$order) {
                die('Order ID does not exist');
            }

            $this->order->setId($id);
            $this->order->setStatus($status);

            return $this->order->update();
        } catch (\Exception $e) {
            echo "Something went wrong ";
            return false;
        }
    }
}
