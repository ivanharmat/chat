<div class="navbar navbar-fixed-top">
    <div class="navbar-inner">
        <div class="container">
            <a class="btn btn-navbar" data-toggle="collapse" data-target=".navbar-responsive-collapse">
                <span class="icon-bar"></span>
                <span class="icon-bar"></span>
                <span class="icon-bar"></span>
            </a>
            <a class="brand" href="/"><i class="icon-smile"></i> <?php echo APP_NAME;?></a>
            <div class="nav-collapse collapse navbar-responsive-collapse">
                <ul class="nav pull-right">
                    <li class="dropdown">
                    <button class="btn btn-custom-purple dropdown-toggle" data-toggle="dropdown">
                        <i class="icon-user"></i> 
                        Hi, <?php echo ($this->session->userdata('client_logged_in') === TRUE) ? $common['user']['name']: 'guest';?> 
                        <?php if($this->session->userdata('client_logged_in') === TRUE):?>
                        <i class="icon-chevron-down"></i>
                    	<?php endif;?>
                    </button>
                    	<?php if($this->session->userdata('client_logged_in') === TRUE):?>
                        <ul class="dropdown-menu"> 
                            <li><a href="/logout"><i class="icon-off"></i> Logout</a></li>
                        </ul>
                        <?php endif;?>
                    </li>
                </ul>
            </div><!-- /.nav-collapse -->
        </div>
    </div><!-- /navbar-inner -->
</div>
<div class="container" id="main_page">
<input type="hidden" id="client_logged_in" value="<?php echo $client_logged_in;?>">