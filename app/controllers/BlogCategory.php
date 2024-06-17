<?php
require_once 'app/core/Controller.php';

class BlogCategory extends Controller
{
    private $commonModel;

    public function __construct()
    {
        $this->commonModel = $this->model('Common');
    }

    // Add new blog category 
    public function addCategory(): void
    {
        $error = '';
        if (isset($_POST['addcategory'])) {
            $title = $_POST['title'];
            $description = $_POST['description'];  // Corrected variable name to match the form field name
            $value = ['title' => $title, 'description' => $description];

            $data = $this->commonModel->insertData('categories', $value);
            if ($data) {
                echo '<script>
                    alert("New Blog Category Added Successfully!");
                    window.location.replace("' . BASE_URL . '/BlogList/userpage");
                    </script>';
                exit;
            } else {
                $error = "Please Enter Correct Details";
            }
        }
        $this->view('add_category', ['error' => $error]);
    }
}
?>
