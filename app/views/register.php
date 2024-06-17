<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <title>Login</title>
    <link href="../public/admin_assets/vendor/font-awesome-4.7/css/font-awesome.min.css" rel="stylesheet" media="all">
    <link href="../public/admin_assets/css/font-face.css" rel="stylesheet" media="all">
    <link href="../public/admin_assets/vendor/font-awesome-5/css/fontawesome-all.min.css" rel="stylesheet" media="all">
    <link href="../public/admin_assets/vendor/mdi-font/css/material-design-iconic-font.min.css" rel="stylesheet"
        media="all">
    <link href="../public/admin_assets/vendor/bootstrap-4.1/bootstrap.min.css" rel="stylesheet" media="all">
    <link href="../public/admin_assets/css/theme.css" rel="stylesheet" media="all">

</head>

<body class="animsition">
    <div class="page-wrapper">
        <div class="page-content--bge5">
            <div class="container">

                <div class="login-wrap">
                    <div class="login-content">
                        <?php if ($error): ?>
                            <div class="alert alert-danger mt-3" role="alert">
                                <?php echo $error; ?>
                            </div>
                        <?php endif; ?>
                        <div class="login-form">
                            <form action="" method="post" name="ReisterForm">
                                <div class="form-group">
                                    <label>firstname</label>
                                    <input class="au-input au-input--full" type="text" name="fname"
                                        placeholder="Firstname " id="fname">
                                </div>
                                <div class="form-group">
                                    <label>lastname</label>
                                    <input class="au-input au-input--full" type="text" name="lname"
                                        placeholder="Lastname" id="lname">
                                </div>
                                <div class="form-group">
                                    <label>Email Address</label>
                                    <input class="au-input au-input--full" type="email" name="email" placeholder="Email"
                                        required id="email">
                                    <span class="error text-danger" id="emailError"></span>
                                </div>
                                <div class="form-group">
                                    <label>Password</label>
                                    <input class="au-input au-input--full" type="password" name="password"
                                        placeholder="Password" required id="password">
                                    <span class="error text-danger" id="passwordError"></span>
                                </div>
                                <button class="au-btn au-btn--block au-btn--green m-b-20" name="regist"
                                    type="submit">sign in</button>
                                    <div>
                                    <center> Already have an account ?<a href="<?= constant('BASE_URL') ?>/Login/login">Login
                                            now</a></center>
                                </div>
                            </form>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <script src="./public/admin_assets/vendor/jquery-3.2.1.min.js"></script>
    <script src="./public/admin_assets/vendor/wow/wow.min.js'"></script>
    <script src="./public/admin_assets/vendor/bootstrap-4.1/popper.min.js"></script>
    <script src="./public/admin_assets/vendor/bootstrap-4.1/bootstrap.min.js"></script>
    <script src="./public/admin_assets/js/main.js"></script>
</body>
</html>