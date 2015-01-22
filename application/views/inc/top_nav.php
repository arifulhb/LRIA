<div class="header navbar navbar-inverse">
    <!-- BEGIN TOP NAVIGATION BAR -->
    <div class="navbar-inner">
        <!-- BEGIN NAVIGATION HEADER -->
        <div class="header-seperation">
            <!-- BEGIN MOBILE HEADER -->
            <ul style="display:none" id="main-menu-toggle-wrapper" class="nav pull-left notifcation-center">
                <li class="dropdown">
                    <a class="" href="#main-menu" id="main-menu-toggle">
                        <div class="iconset top-menu-toggle-white"></div>
                    </a>
                </li>
            </ul>
            <!-- END MOBILE HEADER -->
            <!-- BEGIN LOGO -->
            <a href="<?php echo base_url();?>" title="<?php echo $_site_title;?>">
                <img class="logo" src="<?php echo base_url().'assets/images/logo.png';?>">
            </a>
            <!-- END LOGO -->

        </div>
        <!-- END NAVIGATION HEADER -->
        <!-- BEGIN CONTENT HEADER -->
        <div class="header-quick-nav">
            <!-- BEGIN HEADER LEFT SIDE SECTION -->
            <div class="pull-left">
                <!-- BEGIN SLIM NAVIGATION TOGGLE -->
                <ul class="nav quick-section">
                    <li class="quicklinks">
                        <a id="layout-condensed-toggle" class="" href="#">
                            <div class="iconset top-menu-toggle-dark"></div>
                        </a>
                    </li>
                </ul>
                <!-- END SLIM NAVIGATION TOGGLE -->
                <!-- BEGIN HEADER QUICK LINKS -->
                <ul class="nav quick-section">
                    <li class="quicklinks"><span class="h-seperate"></span></li>
<!--                    <li class="quicklinks"><a class="" href="#"><div class="iconset top-reload"></div></a></li>-->
<!--                    <li class="quicklinks"><span class="h-seperate"></span></li>-->
                    <li class="quicklinks">
                        <a class="new_reservation btn btn-link btn-small" href="<?php echo base_url().'reservation/form';?>"
                            title="New Reservation">
                            <i class="fa fa-book"></i> New Reservation </a>
                    </li>
                    <li class="quicklinks"><span class="h-seperate"></span></li>
                    <!-- BEGIN SEARCH BOX -->
<!--                    <li class="m-r-10 input-prepend inside search-form no-boarder">-->
<!--                        <span class="add-on"><span class="iconset top-search"></span></span>-->
<!--                        <input type="text" style="width:250px;" placeholder="Search Dashboard" class="no-boarder" name="">-->
<!--                    </li>-->
                    <!-- END SEARCH BOX -->
                </ul>
                <!-- BEGIN HEADER QUICK LINKS -->
            </div>
            <!-- END HEADER LEFT SIDE SECTION -->


            <!-- BEGIN HEADER RIGHT SIDE SECTION -->
            <div class="pull-right">
                <div class="chat-toggler">
                    <!-- BEGIN NOTIFICATION CENTER -->
<!--                    <a data-original-title="Notifications" data-toggle="dropdown" data-content="" data-placement="bottom"-->
<!--                       id="my-task-list" class="dropdown-toggle" href="#">-->
                    <a id="my-task-list" href="#" title="">
                        <div class="user-details">
                            <div class="username">
                                <span class="bold">&nbsp;<?php echo $this->session->userdata('u_first_name');?></span>
                            </div>
                        </div>
<!--                        <div class="iconset top-down-arrow"></div>-->
                    </a>

                    <!-- BEGIN PROFILE PICTURE -->
                    <div class="profile-pic">
                        <img width="35" height="35"
                             data-src-retina="<?php echo base_url().'assets/images/avatar_default.jpg';?>"
                             data-src="<?php echo base_url().'assets/images/avatar_default.jpg';?>" alt=""
                             src="<?php echo base_url().'assets/images/avatar_default.jpg';?>">
                    </div>
                    <!-- END PROFILE PICTURE -->
                </div>

                <!-- BEGIN HEADER NAV BUTTONS -->
                <ul class="nav quick-section">
                    <!-- BEGIN SETTINGS -->
                    <li class="quicklinks">
                        <a id="user-options" href="#" class="dropdown-toggle pull-right" data-toggle="dropdown"
                            title="Settings">
                            <div class="iconset top-settings-dark"></div>

                        </a>
                        <ul aria-labelledby="user-options" role="menu" class="dropdown-menu pull-right">
<!--                            <li><a href="#"><i class="fa fa-cogs"></i> Account</a></li>-->
<!--                            <li><a href="#"><i class="fa fa-newspaper-o"></i> My Subscriptioin</a></li>-->

<!--                            <li><a href="#">Billing</a></li>-->
<!--                            <li><a href="#">Badge Link&nbsp;&nbsp;<span class="badge badge-important animated bounceIn">2</span></a></li>-->
                            <li class="divider"></li>
                            <li><a href="<?php echo base_url().'user/signout';?>" title="Signout">
                                    <i class="fa fa-power-off"></i>&nbsp;&nbsp;Signout</a></li>
                        </ul>
                    </li>

                    <!-- END CHAT SIDEBAR TOGGLE -->
                </ul>
                <!-- END HEADER NAV BUTTONS -->
            </div>
            <!-- END HEADER RIGHT SIDE SECTION -->
        </div>
        <!-- END CONTENT HEADER -->
    </div>
    <!-- END TOP NAVIGATION BAR -->
</div>