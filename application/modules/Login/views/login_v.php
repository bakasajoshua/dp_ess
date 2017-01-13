<body class="login">
    <div class="container login">
        <div class="row">
            <div id="login_panel" class="col-xs-12 col-sm-5 col-md-3">
                <div>
                    <svg>
                        <circle r="65" cx="65" cy="65" />
                        <text x="65" y="80">Hello.</text>
                    </svg>
                </div>
                <div>
                    <p id="error" style="padding: 5% 0% 0% 0%;"><em>Error:</em> The Username or Password is incorrect.</p>
                    <h2 style="padding:0%; color:#fff;"><center>Login</center></h2>
                    <form id="loginForm">
                        <em>Username</em>
                        <input type="text" placeholder="Username" id="usernameLogin" name="userLogin" required>
                        <em>Employee ID (KP/000)</em>
                        <input type="text" name="id" placeholder="Employee ID (KP/000)" id="navCodeLogin" name="navCodeLogin" style="text-transform:uppercase" required>
                        <em>Password</em>
                        <input type="password" name="password" placeholder="Password" id="passwordLogin" name="passLogin">
                        <div id="ftlcodeContainer">
                            <em>First Time Login Code</em>
                            <input type="password" placeholder="First Time Login Code" id="ftlcode" name="ftlcode">
                        </div>
                        <input type="submit" value="Login" id="loginUser">
                    </form>
                    <p>
                        <a href="<?php echo base_url('Login/register'); ?>">Register</a>
                    </p>
                    <p>
                        <a href="<?php echo base_url('admin/LoginAdmin'); ?>">Login as administrator</a>
                    </p>
                    <p>
                        <a href="<?php echo base_url('Login/forgotpass'); ?>">Forgot Password?</a>
                    </p>

                    <p class="powered-by">
                        <a href="http://dataposit.co.ke">Powered by DataposIT ©<?php echo date('Y'); ?></a>
                    </p>
                </div>
            </div>
        </div>
        <div class="powered-by">
            <span>Powered By</span>
            <img src="<?php echo base_url('assets/img/dp-white-logo.png'); ?>" alt="Dataposit logo">
        </div>
    </div>
</body>
<center>
    <img src="<?php echo base_url('assets/img/brand/Dataposit 2016 logo white.png') ?>" style="height:10%; width:10%;">
</center>

