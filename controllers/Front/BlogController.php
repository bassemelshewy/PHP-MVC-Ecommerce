<?php
namespace controllers\front;

require_once __DIR__ . '/../../config/Database.php';
require_once __DIR__ . '/../../models/Blog.php';

class BlogController
{
    private $db;
    private $blog;

    public function __construct()
    {
        $this->db = (new \Database())->getConnection();
        $this->blog = new \Blog($this->db);
    }

    

    public function viewAll()
    {
        return $this->blog->index();
    }

    public function viewLimit(){
        return $this->blog->viewLimit();
    }

}