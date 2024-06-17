<?php
require_once 'app/core/Controller.php';

class BlogDetail extends Controller
{
    private Blog $blogModel;
    protected Common $commonModel;

    public function __construct()
    {

        $this->blogModel = $this->model('Blog');
        $this->commonModel = $this->model('Common');
    }

    // Method for adding blog 
    public function addBlog(): void
    {
        $error = '';
        if (isset($_POST['addblog'])) {
            $title = $_POST['title'];
            $short_desc = $_POST['short_desc'];
            $description = $_POST['description'];
            $category = $_POST['category'];
            // $date = $_POST['date'];
            $date = date('Y-m-d');
            $id = $_SESSION['ID'];
            $tagsArray = array_map('trim', explode(',', $_POST['tags']));
            $tagsString = implode(',', $tagsArray);
            $image = null;

            // Handle file upload
            if (!empty($_FILES["img"]["name"])) {
                $target_dir = "public/uploads/";
                $target_file = $target_dir . basename($_FILES["img"]["name"]);
                $imageFileType = strtolower(pathinfo($target_file, PATHINFO_EXTENSION));
                $allowed_types = ['jpg', 'jpeg', 'png', 'gif'];

                if (!in_array($imageFileType, $allowed_types)) {
                    $error = "Only JPG, JPEG, PNG & GIF files are allowed.";
                    $this->view('add_blog', ['error' => $error]);
                    // include 'app/views/add_blog.php';
                    return;
                }

                if (move_uploaded_file($_FILES["img"]["tmp_name"], $target_file)) {
                    $image = $target_file;
                } else {
                    $error = "Sorry, there was an error uploading your file.";
                    $this->view('add_blog', ['error' => $error]);
                    return;
                }
            }
            $data = [
                'author_id' => $id,
                'title' => $title,
                'short_desc' => $short_desc,
                'description' => $description,
                'date' => $date,
                'tags' => $tagsString,
                'image' => $image
            ];

            $blog_id = $this->blogModel->insertBlog($data, 'blog');
            if ($blog_id) {
                // Insert into `blog_categories` table
                if ($this->blogModel->insertBlogCategory($blog_id, $category)) {
                    echo "<script>
                        alert('Blog added successfully!');
                        window.location.replace('" . BASE_URL . "/BlogList/userpage');
                    </script>";
                } else {
                    $error = "Only login user can add blog";
                }
            }
        }
        $category = $this->commonModel;
        $this->view('add_blog', ['error' => $error, 'category' => $category]);
    }
    // Read more implementation 
    
}
