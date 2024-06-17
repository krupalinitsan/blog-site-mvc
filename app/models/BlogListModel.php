<?php

require_once 'app/models/Common.php';
class blogListModel extends Common
{

    public function getLatestBlogs($limit = 5)
    {
        $sql = "SELECT b.id, b.author_id, b.title, b.short_desc, b.description, b.image, b.date, b.status, b.tags 
                  FROM blog b 
                  WHERE b.status = 1 
                  ORDER BY b.date DESC
                  LIMIT $limit";
        $result = $this->connection->query($sql);
        return $result;
    }

    //get active catogories
    public function getActiveCategories()
    {
        $sql = "SELECT * FROM categories WHERE status = 1";
        $result = $this->connection->query($sql);
        return $result;
        //  return $this->fetchData('categories', '*', 'status', 1);

    }

    //get serach data
    public function getSerachData($search, $categoryId = null)
    {
        $sql = "SELECT blog.*, users.firstname 
            FROM blog 
            JOIN users ON blog.author_id = users.id";

        // Build WHERE clause based on search and category filters
        $whereClause = " WHERE 1";

        if (!empty($search)) {
            $whereClause .= " AND (title LIKE '%$search%' OR tags LIKE '%$search%' OR firstname LIKE '%$search%')";
        }

        if (!empty($categoryId)) {
            $whereClause .= " AND EXISTS (
                            SELECT 1 
                            FROM blog_categories bc 
                            WHERE bc.blog_id = blog.id 
                            AND bc.category_id = $categoryId
                        )";
        }

        $sql .= $whereClause;
        $sql .= " LIMIT 0, 25";

        return $this->connection->query($sql);
    }

    // blogs by categories
    public function getBlogsByCategory($categoryId)
    {
        $sql = "SELECT b.id, b.author_id, b.title, b.short_desc, b.description, b.image, b.date, b.status, b.tags, bc.category_id 
        FROM blog b INNER JOIN blog_categories bc ON b.id = bc.blog_id WHERE bc.category_id = $categoryId AND b.status = 1";
        $result = $this->connection->query($sql);
        return $result;
    }

    //inser comment 
    public function insertComment($tableName, $commentData)
    {
        return $this->insertData($tableName, $commentData);
    }

    public function getAllComments($postId)
    {

        // $sql = "SELECT * FROM comments WHERE post_id = $postId ORDER BY created_at ASC";
        // return $this->connection->query($sql);
        $sql = "SELECT c.*, b.title AS blog_title, u.firstname AS author_firstname, u.lastname AS author_lastname , u.email AS author_email
        FROM comments c
        INNER JOIN blog b ON c.post_id = b.id
        INNER JOIN users u ON b.author_id = u.id
        WHERE c.post_id = $postId
        ORDER BY c.created_at desc";

        $result = $this->connection->query($sql);
        return $result;

    }

    public function countComment($postId)
    {
        $sql = "SELECT COUNT(*) as comment_count FROM comments WHERE post_id = $postId";
        return $this->connection->query($sql);
    }
}