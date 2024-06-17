<?php
require_once 'app/core/Controller.php';

class Login extends Controller
{
    protected $commonModel;
    private $userModel;

    public function __construct()
    {
        $this->commonModel = $this->model('Common');
        $this->userModel = $this->model('User');
    }

    // Register user method
    public function register()
    {
        $error = '';
        if (isset($_POST["regist"])) {
            $fname = $_POST["fname"];
            $lname = $_POST["lname"];
            $email = $_POST["email"];
            $password = $_POST["password"];
            if (empty($email)) {
                $error = "Email is required.";
            } elseif (empty($password) || !preg_match('/[A-Z]/', $password) || !preg_match('/[a-z]/', $password) || strlen($password) < 6) {
                $error = "Password must contain at least one uppercase letter, one lowercase letter, and be at least 6 characters long.";
            } else {

                if ($this->commonModel->checkEmailExists($email)) {
                    $error = "Please enter another email. It already exists.";
                } else {
                    $data = array(
                        'firstname' => $fname,
                        'lastname' => $lname,
                        'email' => $email,
                        'password' => md5($password)
                    );

                    if ($this->commonModel->insertData('users', $data)) {
                        ?>
                        <script>
                            alert("Registration successful. You can now login.");
                            window.location.replace("<?php echo BASE_URL; ?>/Login/login");
                        </script>
                        <?php
                    } else {
                        $error = "Registration failed. Please try again later.";
                    }
                }
            }
        }
        $this->view('register', ['error' => $error]);
    }
    //handle login method
    public function login()
    {
        $error = '';
        if (isset($_POST['submit'])) {
            $email = $_POST['email'];
            $password = $_POST['password'];

            $user = $this->userModel->loginUser($email, $password);

            if ($user) {
                session_start();
                $_SESSION['ID'] = $user['id'];
                $_SESSION['IS_LOGIN'] = 'yes';

                // defiened admin
                if ($user['email'] == "divya@nitsantech.com" && $user['password'] == "905be71dbaa36d071ea83d9a5d2a8c80") {
                    header("Location: /blog-site-mvc
                    /Login/dashboard");
                    exit();
                } else {
                    header("Location: /blog-site-mvc/BlogList/userpage");
                    exit();
                }
            } else {
                $error = 'Please enter correct login details.';
            }
        }
        $this->view('login', ['error' => $error]);
    }
    //dashboard view
    public function dashboard()
    {
        $this->view('admin/dashboard');
    }
    public function logout()
    {
        $this->view('logout');
    }
}
?>