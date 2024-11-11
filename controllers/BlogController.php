<?php
namespace controllers;

require_once __DIR__ . '/../config/Database.php';
require_once __DIR__ . '/../models/Blog.php';

class BlogController
{
    private $db;
    private $blog;

    public function __construct()
    {
        $this->db = (new \Database())->getConnection();
        $this->blog = new \Blog($this->db);
    }

    public function find($value, $column = 'id')
    {
        $this->blog->setColumn($column);
        $this->blog->setValue($value);
        return $this->blog->find();
    }

    public function create($title, $content, $category_id, $image)
    {
        try {
            $uploadedimage = $this->ImageUpload($image);
            $user_id = $_SESSION['userId'];

            $this->blog->setTitle($title);
            $this->blog->setContent($content);
            $this->blog->setCategoryId($category_id);
            $this->blog->setUserId($user_id);
            $this->blog->setImage($uploadedimage);


            return $this->blog->create();
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
        return $this->blog->index();
    }

    public function delete($id)
    {
        try {
            $blog = $this->find($id);
            if (!$blog) {
                die('Blog ID does not exist');
            }
            $this->blog->setId($id);
            $deletedBlog = $this->blog->delete();

            if ($deletedBlog) {
                $image =  $_SERVER['DOCUMENT_ROOT'] . '/assets/images/uploads/blogs/' . $blog['image'];

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

    public function update($id, $title, $content, $category_id, $image = null)
    {
        try {
            $blog = $this->find($id);

            if (!$blog) {
                die('Blog ID does not exist');
            }
            
            $this->blog->setId($id);
            $this->blog->setTitle($title);
            $this->blog->setContent($content);
            $this->blog->setCategoryId($category_id);
            $user_id = $_SESSION['userId'];
            $this->blog->setUserId($user_id);

            if (!empty($image['name'])) {
                $imagePath =  $_SERVER['DOCUMENT_ROOT'] . '/assets/images/uploads/blogs/' . $blog['image'];

                // die($image);
                if (file_exists($imagePath)) {
                    unlink($imagePath);
                }

                $uploadedimage = $this->ImageUpload($image);
                $this->blog->setImage($uploadedimage);
            }

            return $this->blog->update();
        } catch (\Exception $e) {
            echo "Something went wrong ";
            return false;
        }
    }
}
