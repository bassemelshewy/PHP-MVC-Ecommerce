<?php
namespace controllers;

require_once __DIR__ . '/../config/Database.php';
require_once __DIR__ . '/../models/Category.php';

class CategoryController
{
    private $db;
    private $category;

    public function __construct()
    {
        $this->db = (new \Database())->getConnection();
        $this->category = new \Category($this->db);
    }

    public function create($name)
    {
        try {
            if ($this->find($name, 'name')) {
                die('Category name already exists');
            }

            $this->category->setName($name);

            return $this->category->create();
        } catch (\Exception $e) {
            echo "Something went wrong ";
            return false;
        }
    }

    public function index()
    {
        return $this->category->index();
    }

    public function delete($id)
    {
        try {
            if (!$this->find($id)) {
                die('Category ID does not exist');
            }

            $this->category->setId($id);

            return $this->category->delete();
        } catch (\Exception $e) {
            echo "Something went wrong ";
            return false;
        }
    }

    public function find($value, $column = 'id')
    {
        $this->category->setColumn($column);
        $this->category->setValue($value);
        return $this->category->find();
    }

    public function update($id, $name)
    {
        try {
            if (!$this->find($id)) {
                die('Category ID does not exist');
            }

            $categoryName = $this->find($name, 'name');

            if ($categoryName && $categoryName['id'] != $id) {
                die('Category name already exists');
            }

            $this->category->setId($id);
            $this->category->setName($name);

            return $this->category->update();
        } catch (\Exception $e) {
            echo "Something went wrong ";
            return false;
        }
    }

    
}
