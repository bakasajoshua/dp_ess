<body class="login">
    <div class="container login">
        <div class="row">
            <div id="login_panel" class="col-xs-12 col-sm-5 col-md-3">
                <div>
                    <svg>
                        <circle r="65" cx="65" cy="65" />
                        <text x="65" y="80">ESS.</text>
                    </svg>
                </div>
                <div>
                    <p id="error"  style="padding-top: 5%;"><em>Error:</em> The Username or Password is incorrect.</p>
                    <h2 style="padding:0%; color:#fff;"><center>Reset Password</center></h2>
                    <form id="resetPassForm">
                        <input type="text" placeholder="Employee ID (KP/000)" id="empNo" name="empNo" style="text-transform:uppercase" required>

                        <input type="submit" value="Reset Password">
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
            <span>Powered By</span>
            <img src="<?php echo base_url('assets/img/dp-white-logo.png'); ?>" alt="Dataposit logo">
        </div>
    </div>
</body>
<center>
    <img src="<?php echo base_url('assets/img/brand/Dataposit 2016 logo white.png') ?>" style="height:10%; width:10%;">
</center>
