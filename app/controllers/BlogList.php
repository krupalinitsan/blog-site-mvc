<?php
require_once 'app/core/Controller.php';

class BlogList extends Controller
{
    private $blogListModel;
    protected Common $commonModel;

    public function __construct()
    {
        $this->blogListModel = $this->model('blogListModel');
        $this->commonModel = $this->model('Common');
    }

    public function userpage()
    {
        if (isset($_POST['submit'])) {
            $categoryId = $_POST['id'];
            $search = $_POST['search'];

            if (!empty($search) && !empty($categoryId)) {
                $blogs = $this->blogListModel->getSerachData($search, $categoryId);
            } elseif (!empty($search)) {
                $blogs = $this->blogListModel->getSerachData($search);
            } elseif (!empty($categoryId)) {
                $blogs = $this->blogListModel->getBlogsByCategory($categoryId);
            } else {
                $blogs = $this->blogListModel->getLatestBlogs();
            }
        } else {
            $blogs = $this->blogListModel->getLatestBlogs();
        }

        $categories = $this->blogListModel->getActiveCategories();
        $data = $this->commonModel;

        $this->view('blog-list', ['blogs' => $blogs, 'categories' => $categories, 'data' => $data]);
    }

    public function viewBlogDetails()
    {
        $message = '';
        if (isset($_GET['id'])) {
            $blogId = (int) $_GET['id'];
            $result = $this->commonModel->getTable($blogId, 'blog');
            if ($result->num_rows > 0) {
                $blog = $result->fetch_assoc();
            }
        }

        if (isset($_POST['post_comment'])) {
            $message = $this->handleComment($blogId, $_POST);
        }

        if (isset($_POST['reply_comment'])) {
            $message = $this->handleReply($blogId, $_POST);
        }

        $comments = $this->blogListModel->getAllComments($blogId)->fetch_all(MYSQLI_ASSOC);

        $data = $this->blogListModel;
        $this->view('blog_details', ['blog' => $blog, 'comments' => $comments, 'data' => $data, 'message' => $message]);
    }

    private function handleComment($blogId, $postData)
    {
        $name = $postData['name'];
        $email = $postData['email'];
        $comment = trim($postData['comment']);
        $reply_of = $postData['reply_of'] ?? 0;

        $commentData = array(
            'name' => $name,
            'email' => $email,
            'comment' => $comment,
            'post_id' => $blogId,
            'created_at' => date("Y-m-d H:i:s"),
            'reply_of' => $reply_of,
        );

        if ($this->blogListModel->insertComment('comments', $commentData)) {
            $to = "krupalib2003@gmail.com";
            $subject = "You got a comment";
            $messageContent = "Hello user, you got a comment on blog: ";
            $from = "krupali.nitsan@gmail.com";
            $headers = "From: $from";

            if (mail($to, $subject, $messageContent, $headers)) {
                return 'Comment has been sent successfully. Email notification sent.';
            } else {
                return 'Comment has been sent successfully. Failed to send email notification.';
            }
        } else {
            return 'Failed to add the comment.';
        }
    }

    private function handleReply($blogId, $postData)
    {
        $name = $postData['name'];
        $email = $postData['email'];
        $comment = trim($postData['comment']);
        $reply_of = $postData['reply_of'] ?? 0;

        $replyData = array(
            'name' => $name,
            'email' => $email,
            'comment' => $comment,
            'post_id' => $blogId,
            'created_at' => date("Y-m-d H:i:s"),
            'reply_of' => $reply_of,
        );

        if ($this->blogListModel->insertComment('comments', $replyData)) {
            return 'Reply has been sent successfully.';
        } else {
            return 'Failed to add the reply.';
        }
    }
}
?>