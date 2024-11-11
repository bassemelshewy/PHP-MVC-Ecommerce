<?php

require_once __DIR__ . '/../config/Database.php';
require_once __DIR__ . '/../models/ContactUs.php';

class ContactUsController
{
    private $db;
    private $contactUs;

    public function __construct()
    {
        $this->db = (new Database())->getConnection();
        $this->contactUs = new ContactUs($this->db);
    }

    public function create($name, $email, $message)
    {
        try {

            $this->contactUs->setName($name);
            $this->contactUs->setEmail($email);
            $this->contactUs->setMessage($message);

            return $this->contactUs->create();
        } catch (Exception $e) {
            echo "Something went wrong" ;
            return false;
        }
    }

    public function index()
    {
        return $this->contactUs->index();
    }

    public function delete($id)
    {
        try {
            if (!$this->find($id)) {
                die('This message ID does not exist');
            }

            $this->contactUs->setId($id);

            return $this->contactUs->delete();
        } catch (Exception $e) {
            echo "Something went wrong ";
            return false;
        }
    }

    public function find($value, $column = 'id')
    {
        $this->contactUs->setColumn($column);
        $this->contactUs->setValue($value);
        return $this->contactUs->find();
    }

}
