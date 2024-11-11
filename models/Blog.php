<?php

class Blog
{
    private $conn;
    private $table = 'blogs';
    private $id;
    private $title;
    private $content;
    private $category_id;
    private $user_id;
    private $image;
    private $column;
    private $value;

    public function __construct($conn)
    {
        $this->conn = $conn;
    }

    public function setId($id)
    {
        $this->id = $id;
    }

    public function setTitle($title)
    {
        $this->title = $title;
    }

    public function setContent($content)
    {
        $this->content = $content;
    }

    public function setCategoryId($category_id)
    {
        $this->category_id = $category_id;
    }

    public function setUserId($user_id)
    {
        $this->user_id = $user_id;
    }

    public function setImage($image)
    {
        $this->image = $image;
    }

    public function setColumn($column)
    {
        $this->column = $column;
    }

    public function setValue($value)
    {
        $this->value = $value;
    }

    public function getId()
    {
        return $this->id;
    }

    public function getTitle()
    {
        return $this->title;
    }

    public function getContent()
    {
        return $this->content;
    }

    public function getCategoryId()
    {
        return $this->category_id;
    }

    public function getUserId()
    {
        return $this->user_id;
    }

    public function getImage()
    {
        return $this->image;
    }
    public function getColumn()
    {
        return $this->column;
    }

    public function getValue()
    {
        return $this->value;
    }

    public function create()
    {
        try {
            $title = $this->getTitle();
            $content = $this->getContent();
            $category_id = $this->getCategoryId();
            $user_id = $this->getUserId();
            $image = $this->getImage();

            $query = "INSERT INTO $this->table (title, content, category_id, user_id, image) VALUES (?,?,?,?,?)";
            $stmt = $this->conn->prepare($query);
            $stmt->bind_param("ssiis", $title, $content, $category_id, $user_id, $image);
            if ($stmt->execute()) {
                return true;
            } else {
                die('Failed to create blog');
            }
        } catch (Exception $e) {
            echo "Something went wrong ";
            return false;
        }
    }

    public function index()
    {
        try {
            $query = "SELECT b.*, c.name AS category_name, u.name AS user_name
                    FROM $this->table b
                    JOIN categories c ON b.category_id = c.id
                    JOIN users u ON b.user_id = u.id 
                    ORDER BY b.id";
            $stmt = $this->conn->query($query);
            return $stmt->fetch_all(MYSQLI_ASSOC);
        } catch (Exception $e) {
            echo "Something went wrong ";
            return false;
        }
    }

    public function find()
    {
        try {
            $column = $this->getColumn();
            $value = $this->getValue();

            $validColumns = ['id', 'title', 'category_id'];
            if (!in_array($column, $validColumns)) {
                die('Invalid column');
            }

            $query = "SELECT b.*, c.name AS category_name, u.name AS user_name
                    FROM $this->table b
                    JOIN categories c ON b.category_id = c.id
                    JOIN users u ON b.user_id = u.id 
                    WHERE b.$column = ? LIMIT 1";
            $stmt = $this->conn->prepare($query);
            $stmt->bind_param(is_numeric($value) ? "i" : "s", $value);
            $stmt->execute();
            $result = $stmt->get_result();

            if ($result->num_rows > 0) {
                return $result->fetch_assoc();
            }

            return null;
        } catch (Exception $e) {
            echo "Something went wrong ";
            return false;
        }
    }
    public function delete()
    {
        try {
            $id = $this->getId();

            $query = "DELETE FROM  $this->table  WHERE id=?";
            $stmt = $this->conn->prepare($query);
            $stmt->bind_param("i", $id);
            return $stmt->execute();
        } catch (Exception $e) {
            echo "Something went wrong ";
            return false;
        }
    }

    public function update()
    {
        try {
            $id = $this->getId();
            $title = $this->getTitle();
            $content = $this->getContent();
            $category_id = $this->getCategoryId();
            $user_id = $this->getUserId();
            $image = $this->getImage();

            $query = "UPDATE $this->table SET title=?, content=?, category_id=?, user_id=?, updated_at=NOW()";

            if ($image !== null) {
                $query .= ", image=?";
            }

            $query .= " WHERE id=?";

            $stmt = $this->conn->prepare($query);
            if ($image !== null) {
                $stmt->bind_param("ssiisi", $title, $content, $category_id, $user_id, $image, $id);
            } else {
                $stmt->bind_param("ssiii", $title, $content, $category_id, $user_id, $id);
            }

            if ($stmt->execute()) {
                return true;
            } else {
                die('Failed to update blog');
            }
        } catch (Exception $e) {
            echo "Something went wrong ";
            return false;
        }
    }

    //////////////////front//////////////////

    public function viewLimit(){
        try {
            $limit = 3;
            $query = "SELECT b.*, c.name AS category_name
                    FROM $this->table b
                    JOIN categories c ON b.category_id = c.id
                    ORDER BY b.created_at DESC LIMIT ?";
            $stmt = $this->conn->prepare($query);
            $stmt->bind_param("i", $limit);
            $stmt->execute();
            $result = $stmt->get_result();
            return $result->fetch_all(MYSQLI_ASSOC);
        } catch (Exception $e) {
            echo "Something went wrong ";
            return false;
        }
    }
}
