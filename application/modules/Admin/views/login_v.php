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
                    <h3 style="padding: 0%; color:#fff;"><center>ADMINISTRATOR'S LOGIN</center></h3>
                    <form id="adminLoginForm">
                        <input type="text" placeholder="Username" id="usernameLogin" name="usernameLogin" required>
                        <input type="text" placeholder="Employee ID (KP/000)" id="navCodeLogin" name="navCodeLogin" required style="text-transform:uppercase">
                        <input type="password" placeholder="Password" required id="passwordLogin" name="passLogin">
                    
                        <input type="submit" value="Login">
                    </form>
                    <p>
                        <a href="<?php echo base_url('Login'); ?>">Login to employee portal</a>
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
