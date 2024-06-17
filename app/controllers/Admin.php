<?php

require_once 'app/core/Controller.php';

class Admin extends Controller
{
    protected $commonModel;

    public function __construct()
    {
        $this->commonModel = $this->model('Common');
    }
    // Handling edit operations
    private function handleEditOperations(string $table, string $redirectPage, string $message): void
    {
        if (isset($_GET['type']) && $_GET['type'] !== '') {
            $operationType = $_GET['type'];

            if ($operationType === 'status') {
                $operation = $_GET['operation'] ?? '';
                $id = $_GET['id'] ?? '';
                $status = ($operation === 'active') ? '1' : '0';

                $this->commonModel->updateStatus($id, $status, $table);
            }

            if ($operationType === 'delete') {
                $id = $_GET['id'] ?? '';

                if ($this->commonModel->deleteRecord($id, $table)) {
                    $_SESSION['message'] = $message;
                }
            }

            header("Location: $redirectPage");
            exit();
        }

         $result = $this->commonModel->collectData($table);
        include_once "app/views/admin/{$redirectPage}.php";
    }

    public function editBlog(): void
    {
        $result = $this->commonModel->collectData('blog'); // Fetch blog data
        $this->handleEditOperations('blog', 'editBlog', "Blog deleted successfully!", $result); // Pass $result to the handler
    }
    
    public function editCategory(): void
    {
        $this->handleEditOperations('categories', 'editCategory', "Blog category deleted successfully!");
    }
}
