<?php
namespace controllers\front;

require_once __DIR__ . '/../../config/Database.php';
require_once __DIR__ . '/../../models/Category.php';

class CategoryController
{
    private $db;
    private $category;

    public function __construct()
    {
        $this->db = (new \Database())->getConnection();
        $this->category = new \Category($this->db);
    }

    

    public function viewAll()
    {
        return $this->category->index();
    }

    public function viewLimit(){
        return $this->category->viewLimit();
    }
}