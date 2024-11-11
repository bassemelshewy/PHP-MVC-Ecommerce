<?php

require_once __DIR__ . '/../config/Database.php';
require_once __DIR__ . '/../models/Social.php';

class SocialController
{
    private $db;
    private $social;

    public function __construct()
    {
        $this->db = (new Database())->getConnection();
        $this->social = new Social($this->db);
    }

    public function find($value, $column = 'id')
    {
        $this->social->setColumn($column);
        $this->social->setValue($value);
        return $this->social->find();
    }

    public function create($name, $url, $icon)
    {
        try {
            $uploadedIcon = $this->ImageUpload($icon);

            $this->social->setName($name);
            $this->social->setUrl($url);
            $user_id = $_SESSION['userId'];
            $this->social->setUserId($user_id);
            $this->social->setIcon($uploadedIcon);


            return $this->social->create();
        } catch (Exception $e) {
            echo "Something went wrong ";
            return false;
        }
    }

    public function ImageUpload($image)
    {
        try {
            if (!isset($image) || $image['error'] !== 0) {
                die('No image uploaded or file upload error.');
            }

            // $image = $_FILES['image'];
            $imageExtenstion = strtolower(pathinfo($image['name'], PATHINFO_EXTENSION));
            $validExtension = ["png", "jpg", "jpeg"];

            if (!in_array($imageExtenstion, $validExtension)) {
                die('Invalid image format. Only PNG, JPG, and JPEG are allowed.');
            }

            if ($image['size'] > 3000000) {
                die('Image size is too large. Maximum size is 2MB.');
            }

            $uploadDir = $_SERVER['DOCUMENT_ROOT'] . '/assets/images/uploads/socialIcons/';
            if (!file_exists($uploadDir)) {
                mkdir($uploadDir, 0777, true);
            }

            $imageName = 'image_' . time() . '.' . $imageExtenstion;
            $imagePath = "{$uploadDir}{$imageName}";

            if (move_uploaded_file($image['tmp_name'], $imagePath)) {
                return $imageName;
            } else {
                die('Failed to upload image');
            }
        } catch (Exception $e) {
            echo "Something went wrong ";
            return false;
        }
    }

    public function index()
    {
        return $this->social->index();
    }

    public function delete($id)
    {
        try {
            $social = $this->find($id);
            if (!$social) {
                die('Social account ID does not exist');
            }
            $this->social->setId($id);
            $deletedSocial = $this->social->delete();
            // $deletedProduct = true;

            if ($deletedSocial) {
                $image =  $_SERVER['DOCUMENT_ROOT'] . '/assets/images/uploads/socialIcons/' . $social['icon'];

                // die($image);
                if (file_exists($image)) {
                    unlink($image);
                }
                return true;
            }
        } catch (Exception $e) {
            echo "Something went wrong ";
            return false;
        }
    }

    public function update($id, $name, $url, $icon = null)
    {
        try {
            $social = $this->find($id);

            // die(var_dump($product));
            if (!$social) {
                die('Social account ID does not exist');
            }

            $this->social->setId($id);
            $this->social->setName($name);
            $this->social->setUrl($url);
            $user_id = $_SESSION['userId'];
            $this->social->setUserId($user_id);

            if (!empty($icon['name'])) {
                $imagePath =  $_SERVER['DOCUMENT_ROOT'] . '/assets/images/uploads/socialIcons/' . $social['icon'];

                // die($image);
                if (file_exists($imagePath)) {
                    unlink($imagePath);
                }

                $uploadedIcon = $this->ImageUpload($icon);
                $this->social->setIcon($uploadedIcon);
            }

            return $this->social->update();
        } catch (Exception $e) {
            echo "Something went wrong ";
            return false;
        }
    }
}
