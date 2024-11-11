<?php
namespace Controllers;

require_once __DIR__ . '/../config/Database.php';
require_once __DIR__ . '/../models/Product.php';

class ProductController
{
    private $db;
    private $product;

    public function __construct()
    {
        $this->db = (new \Database())->getConnection();
        $this->product = new \Product($this->db);
    }

    public function find($value, $column = 'id')
    {
        $this->product->setColumn($column);
        $this->product->setValue($value);
        return $this->product->find();
    }

    public function create($name, $description, $category_id, $price, $image)
    {
        try {
            $uploadedimage = $this->ImageUpload($image);

            $this->product->setName($name);
            $this->product->setDescription($description);
            $this->product->setCategoryId($category_id);
            $this->product->setPrice($price);
            $this->product->setImage($uploadedimage);


            return $this->product->create();
        } catch (\Exception $e) {
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

            $uploadDir = $_SERVER['DOCUMENT_ROOT'] . '/assets/images/uploads/blogs/';
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
        } catch (\Exception $e) {
            echo "Something went wrong ";
            return false;
        }
    }

    public function index()
    {
        return $this->product->index();
    }

    public function delete($id)
    {
        try {
            $product = $this->find($id);
            if (!$product) {
                die('Product ID does not exist');
            }
            $this->product->setId($id);
            $deletedProduct = $this->product->delete();
            // $deletedProduct = true;

            if ($deletedProduct) {
                $image =  $_SERVER['DOCUMENT_ROOT'] . '/assets/images/uploads/products/' . $product['image'];

                // die($image);
                if (file_exists($image)) {
                    unlink($image);
                }
                return true;
            }
        } catch (\Exception $e) {
            echo "Something went wrong ";
            return false;
        }
    }

    public function update($id, $name, $description, $category_id, $price, $image = null)
    {
        try {
            $product = $this->find($id);

            // die(var_dump($product));
            if (!$product) {
                die('Product ID does not exist');
            }

            $this->product->setId($id);
            $this->product->setName($name);
            $this->product->setDescription($description);
            $this->product->setCategoryId($category_id);
            $this->product->setPrice($price);

            if (!empty($image['name'])) {
                $imagePath =  $_SERVER['DOCUMENT_ROOT'] . '/assets/images/uploads/products/' . $product['image'];

                // die($image);
                if (file_exists($imagePath)) {
                    unlink($imagePath);
                }

                $uploadedimage = $this->ImageUpload($image);
                $this->product->setImage($uploadedimage);
            }

            return $this->product->update();
        } catch (\Exception $e) {
            echo "Something went wrong ";
            return false;
        }
    }

}
