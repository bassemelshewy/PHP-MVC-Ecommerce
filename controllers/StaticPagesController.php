<?php

require_once __DIR__ . '/../config/Database.php';
require_once __DIR__ . '/../models/StaticPages.php';

class StaticPagesController
{
    private $db;
    private $staticPage;

    public function __construct()
    {
        $this->db = (new Database())->getConnection();
        $this->staticPage = new StaticPages($this->db);
    }

    public function create($name, $slug, $content)
    {
        try {
            $this->staticPage->setName($name);
            $this->staticPage->setSlug($slug);
            $this->staticPage->setContent($content);
            $user_id = $_SESSION['userId'];
            $this->staticPage->setUserId($user_id);

            return $this->staticPage->create();
        } catch (Exception $e) {
            echo "Something went wrong" ;
            return false;
        }
    }

    public function index()
    {
        return $this->staticPage->index();
    }

    public function delete($id)
    {
        try {
            if (!$this->find($id)) {
                die('This page ID does not exist');
            }

            $this->staticPage->setId($id);

            return $this->staticPage->delete();
        } catch (Exception $e) {
            echo "Something went wrong ";
            return false;
        }
    }

    public function find($value, $column = 'id')
    {
        $this->staticPage->setColumn($column);
        $this->staticPage->setValue($value);
        return $this->staticPage->find();
    }

    public function update($id, $name, $slug, $content)
    {
        try {
            if (!$this->find($id)) {
                die('This page ID does not exist');
            }

            $this->staticPage->setId($id);
            $this->staticPage->setName($name);
            $this->staticPage->setSlug($slug);
            $this->staticPage->setContent($content);
            $user_id = $_SESSION['userId'];
            $this->staticPage->setUserId($user_id);

            return $this->staticPage->update();
        } catch (Exception $e) {
            echo "Something went wrong ";
            return false;
        }
    }
}
