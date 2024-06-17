<?php

class Common extends Database
{
    protected $connection;
    protected $db;

    public function __construct()
    {
        $this->db = new parent();
        $this->connection = $this->db->dbconnect();
    }
    public function collectData($tablename)
    {
        $sql = "SELECT * FROM $tablename";
        return $this->connection->query($sql);

    }
    public function updateStatus($id, $status, $tableName)
    {
        $sql = "UPDATE $tableName SET status = '$status' WHERE id = '$id'";
        return $this->connection->query($sql);
    }

    public function deleteRecord($id, $tableName)
    {

        $sql = "DELETE FROM " . $tableName . " WHERE id = '$id'";
        return $this->connection->query($sql);
    }

    public function getTable($blogId, $tableName)
    {
        $sql = "SELECT * FROM $tableName WHERE id = $blogId AND status = 1";
        return $this->connection->query($sql);
    }
    public function getDataById($id, $tableName)
    {
        $sql = "SELECT * FROM $tableName  WHERE id = $id";
        return $this->connection->query($sql)->fetch_assoc();
    }
    public function insertData($tableName, $data)
    {
        $keys = implode(',', array_keys($data));
        $values = implode("','", array_values($data));

        $sql = "INSERT INTO " . $tableName . "(" . $keys . ") VALUES ('" . $values . "')";
        return $this->connection->query($sql);

    }
    public function update($table, $data, $compareField, $compareValue)
    {
        $sql = "UPDATE " . $table . " SET ";
        foreach ($data as $key => $val) {

            $sql .= (next($data)) ? $key . " ='" . $val . "', " : $key . " ='" . $val . "' ";
        }
        $sql .= "WHERE " . $compareField . " = " . $compareValue;
    }
    public function fetchData($table, $field = '', $fieldToCompare = '', $id = '')
    {
        if ($fieldToCompare && $id) {
            $sql = "SELECT * FROM " . $table . " WHERE " . $fieldToCompare . " = '" . $this->connection->real_escape_string($id) . "'";
            return $this->connection->query($sql)->fetch_assoc();
        } else {
            if ($field) {
                $sql = "SELECT " . $field . " FROM " . $table;
                return $this->connection->query($sql);
            } else {
                $sql = "SELECT * FROM " . $table;
                $res = $this->connection->query($sql);
                $data = array();
                if (mysqli_num_rows($res) > 0) {
                    while ($row = mysqli_fetch_assoc($res)) {
                        $data[] = $row;
                    }
                }
                return $data;
            }
        }
    }
    public function updateUser($id, $fname, $lname, $email, $password, $image = null)
    {
        // Base SQL update statement
        // $pass = md5($password);
        // $passwd = trim($pass);
        $sql = "UPDATE users SET firstname='$fname', lastname='$lname', email='$email', password='$password'";

        // Append image update if provided
        if ($image !== null) {
            $sql .= ", image='$image'";
        }
        $sql .= " WHERE id='$id'";
        return $this->connection->query($sql);
    }

    // public function updateUser($id, $fname, $lname, $email, $password, $image = null)
    // {
    //     // Base SQL update statement
    //     $sql = "UPDATE users SET firstname='$fname', lastname='$lname', email='$email'";

    //     // Append password update if provided
    //     if (!empty($password)) {
    //         $passwd = md5(trim($password));
    //         $sql .= ", password='$passwd'";
    //     }

    //     // Append image update if provided
    //     if ($image !== null) {
    //         $sql .= ", image='$image'";
    //     }

    //     $sql .= " WHERE id='$id'";
    //     return $this->connection->query($sql);
    // }

    public function checkEmailExists($email)
    {
        $escaped_email = $this->connection->real_escape_string($email);
        $sql = "SELECT COUNT(*) as count FROM users WHERE email = '$escaped_email'";
        $result = $this->connection->query($sql);
        $row = $result->fetch_assoc();
        $count = $row['count'];

        return $count > 0;
    }
}
