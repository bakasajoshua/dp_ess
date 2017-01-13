<body class="sign_up">
    <div class="container sign_up">
        <div class="row">
            <div id="sign_up_panel" class="col-xs-12 col-sm-5 col-md-3">
                <div>
                    <svg>
                        <circle r="65" cx="65" cy="65" />
                        <text x="65" y="75">ESS.</text>
                    </svg>
                </div>
                <div>
                    <p id="error"  style="padding-top: 5%;"><em>Error:</em> The Username or Password is incorrect.</p>
                    <h3 style="padding:0%; color:#fff;"><center>Register</center></h3>
                    <form id='signupForm'>                        
                        <em>Username:</em>
                        <input type="text" placeholder="Username" id="username" name="user" required>
                        <em>Employee ID (KP/000):</em>
                        <input type="text"placeholder="Employee ID (KP/000)" id="navCode" name="navCode" required style="text-transform:uppercase">
                        <em>Password:</em>
                        <input type="password" placeholder="Password" required name="pass" id="pass">
                        <em>Confirm Password:</em>
                        <input type="password" placeholder="Confirm Password" required name="pass1" id="pass1">
                        
                        <input type="submit" value="Sign Up" id="createUser">
                    </form>
                    <p>
                        <a href="<?php echo base_url('Login/login'); ?>">Login</a>
                    </p>
                    <p class="powered-by">
                        <a href="http://dataposit.co.ke">Powered by DataposIT ©<?php echo date('Y'); ?></a>
                    </p>
                </div>
            </div>
        </div>
        <div class="powered-by">
            <img src="<?php echo base_url('assets/img/dp-white-logo.png'); ?>" alt="Dataposit logo">
        </div>
        <!-- Popover -->
    </div>
</body>
<center>
    <img src="<?php echo base_url('assets/img/brand/Dataposit 2016 logo white.png') ?>" style="height:10%; width:10%;">
</center>