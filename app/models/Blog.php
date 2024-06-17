<?php
require_once 'app/models/Common.php';
class Blog extends Common
{
    public function insertBlog($data, $tableName)
    {
        $dataEscaped = [];
        foreach ($data as $key => $value) {
            if ($value !== null) {
                $dataEscaped[$key] = mysqli_real_escape_string($this->connection, $value);
            }
        }
        $columns = implode(", ", array_keys($dataEscaped));
        $values = implode("', '", array_values($dataEscaped));
        $sql = "INSERT INTO $tableName ($columns) VALUES ('$values')";
        if ($this->connection->query($sql) === TRUE) {
            return $this->connection->insert_id;
        } else {
            return false;
        }
    }

    //inser blog category while adding blog
    public function insertBlogCategory($blog_id, $category_id)
    {
        $data = [
            'blog_id' => $this->connection->real_escape_string($blog_id),
            'category_id' => $this->connection->real_escape_string($category_id)
        ];

        // Use the insertData function to insert the new blog category
        return $this->insertData('blog_categories', $data);
    }
    public function close()
    {
        $this->connection->close();
    }
    public function getBlogDescription($blogId)
    {
        return $this->fetchData('blog', '*', 'id', $blogId);
    }

}

?>