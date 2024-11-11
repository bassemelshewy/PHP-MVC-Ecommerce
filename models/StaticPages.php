<?php

class StaticPages
{
    private $conn;
    private $table = 'static_pages';
    private $id;
    private $name;
    private $slug;
    private $content;
    private $user_id;
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
    
    public function setName($name)
    {
        $this->name = $name;
    }

    public function setSlug($slug)
    {
        $this->slug = $slug;
    }
    
    public function setContent($content)
    {
        $this->content = $content;
    }

    public function setUserId($user_id)
    {
        $this->user_id = $user_id;
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
    
    public function getName()
    {
        return $this->name;
    }

    public function getSlug()
    {
        return $this->slug;
    }

    public function getContent()
    {
        return $this->content;
    }

    public function getUserId()
    {
        return $this->user_id;
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
            $name = $this->getName();
            $slug = $this->getSlug();
            $content = $this->getContent();
            $user_id = $this->getUserId();
            

            $query = "INSERT INTO $this->table (name, slug, content, user_id) VALUES (?, ?, ?, ?)";
            $stmt = $this->conn->prepare($query);
            $stmt->bind_param("sssi", $name, $slug, $content, $user_id);
            if ($stmt->execute()) {
                return true;
            } else {
                die('Failed to create this page');
            }
        } catch (Exception $e) {
            echo "Something went wrong ";
            return false;
        }
    }

    public function index()
    {
        try {
            $query = "SELECT s.*, u.name AS user_name FROM $this->table s
                    JOIN users u ON s.user_id = u.id 
                    ORDER BY s.id";
            $stmt = $this->conn->query($query);
            // die($stmt->error)
            return $stmt->fetch_all(MYSQLI_ASSOC);
        } catch (Exception $e) {
            echo "Something went wrong " . $e->getMessage();
            return false;
        }
    }

    public function find()
    {
        try {
            $column = $this->getColumn();
            $value = $this->getValue();

            $validColumns = ['id', 'slug', 'user_id'];
            if (!in_array($column, $validColumns)) {
                die('Invalid column');
            }

            $query = "SELECT * FROM $this->table WHERE $column = ?";
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
            $name = $this->getName();
            $slug = $this->getSlug();
            $content = $this->getContent();
            $user_id = $this->getUserId();

            $query = "UPDATE $this->table SET  name=?, slug=?, content=?, user_id=?, updated_at=NOW() WHERE id = ?";

            $stmt = $this->conn->prepare($query);
            $stmt->bind_param("sssii", $name, $slug, $content, $user_id, $id);

            if ($stmt->execute()) {
                return true;
            } else {
                die('Failed to update this data');
            }
        } catch (Exception $e) {
            echo "Something went wrong ";
            return false;
        }
    }
}
