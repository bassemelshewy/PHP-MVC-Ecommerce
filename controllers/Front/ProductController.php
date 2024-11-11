<?php
namespace controllers\front;

require_once __DIR__ . '/../../config/Database.php';
require_once __DIR__ . '/../../models/Product.php';

class ProductController
{
    private $db;
    private $product;
    
    public function __construct()
    {
        $this->db = (new \Database())->getConnection();
        $this->product = new \Product($this->db);
    }

    public function getJustArrived(){
        return $this->product->getJustArrived();
    }
    
    public function viewAll($category_id = null, $search= null){
        try{
            $this->product->setCategoryId($category_id);
            $this->product->setSearch($search);

            return $this->product->viewAll();
        } catch (\Exception $e) {
            echo "Something went wrong ";
            return false;
        }
    }

    public function getBestSelling(){
        return $this->product->getBestSelling();
    }
}