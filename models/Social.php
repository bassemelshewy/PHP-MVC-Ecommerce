<?php

class Social
{
    private $conn;
    private $table = 'socials';
    private $id;
    private $name;
    private $url;
    private $icon;
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

    public function setUrl($url)
    {
        $this->url = $url;
    }

    public function setIcon($icon)
    {
        $this->icon = $icon;
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

    public function getUrl()
    {
        return $this->url;
    }

    public function getIcon()
    {
        return $this->icon;
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
            $url = $this->getUrl();
            $icon = $this->getIcon();
            $user_id = $this->getUserId();

            $query = "INSERT INTO $this->table (name, url, user_id, icon) VALUES (?,?,?,?)";
            $stmt = $this->conn->prepare($query);
            $stmt->bind_param("ssis", $name, $url, $user_id, $icon);
            if ($stmt->execute()) {
                return true;
            } else {
                die('Failed to create social account');
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

            $validColumns = ['id', 'name', 'user_id'];
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
            $url = $this->getUrl();
            $user_id = $this->getUserId();
            $icon = $this->getIcon();

            $query = "UPDATE $this->table SET name=?, url=?, user_id=?, updated_at=NOW()";

            if ($icon !== null) {
                $query .= ", icon=?";
            }

            $query .= " WHERE id=?";

            $stmt = $this->conn->prepare($query);
            if ($icon !== null) {
                $stmt->bind_param("ssisi", $name, $url, $user_id, $icon, $id);
            } else {
                $stmt->bind_param("ssii", $name, $url, $user_id, $id);
            }

            if ($stmt->execute()) {
                return true;
            } else {
                die('Failed to update social account');
            }
        } catch (Exception $e) {
            echo "Something went wrong ";
            return false;
        }
    }
}
