<?php

if(isset($_menu_active)==false){
    $_menu_active='';
}


?>

<div id="main-menu" class="page-sidebar">
    <div class="scroll-wrapper page-sidebar-wrapper scrollbar-dynamic" style="position: relative;"><div id="main-menu-wrapper" class="page-sidebar-wrapper scrollbar-dynamic scroll-content scroll-scrolly_visible" style="margin-bottom: 0px; margin-right: 0px; height: 282px;">
            <!-- BEGIN MINI-PROFILE -->
            <div class="user-info-wrapper">

                <?php /*
                <div class="profile-wrapper">
                    <img width="69" height="69" data-src-retina="<?php echo base_url().'assets/barebone/';?>assets/img/profiles/avatar2x.jpg"
                         data-src="<?php echo base_url().'assets/barebone/';?>assets/img/profiles/avatar.jpg" alt=""
                         src="<?php echo base_url().'assets/barebone/';?>assets/img/profiles/avatar.jpg">
                </div>

                <div class="user-info">
                    <div class="greeting">Welcome</div>
                    <div class="username"><?php echo $this->session->userdata('u_first_name');?> <span class="small"><?php echo $this->session->userdata('u_last_name');?></span></div>
                </div>*/?>
            </div>
            <!-- END MINI-PROFILE -->
            <!-- BEGIN SIDEBAR MENU -->
<!--            <p class="menu-title">BROWSE<span class="pull-right"><a href="javascript:;"><i class="fa fa-refresh"></i></a></span></p>-->
            <ul>
                <!-- BEGIN SELECTED LINK -->
                <li class="start <?php echo $_menu_top=='dash'?'active':'';?>">
                    <a href="<?php echo base_url().'dashboard';?>">
                        <i class="icon-custom-home"></i>
                        <span class="title">Dashboard</span>
                        <span class="selected"></span>
<!--                        <span class="badge badge-important pull-right">5</span>-->
                    </a>
                </li>
                <!-- END SELECTED LINK -->

<!--                Reservation-->
                <li  class="<?php echo $_menu_top=='reservation'?'active':'';?>">
                    <a href="javascript:;">
                        <i class="fa fa-book"></i>
                        <span class="title">Reservation</span>
                        <span class="arrow"></span>
                    </a>
                    <ul class="sub-menu">
<!--                        <li><a href="#"><i class="fa fa-file"></i> Add new</a></li>-->
                        <li class="<?php echo $_menu_active=='reservation_add'?'active':'';?>">
                            <a href="<?php echo base_url().'reservation/form';?>"><i class="fa fa-file"></i> Add New</a></li>
                        <li><a href="<?php echo base_url().'reservation/index';?>"><i class="fa fa-archive"></i> Show all</a></li>
                    </ul>
                </li>
<!--                End Reservation-->

<!--                Customers-->
                <li class="<?php echo $_menu_top=='customer'?'active':'';?>">
                    <a href="javascript:;">
                        <i class="fa fa-users"></i>
                        <span class="title">Customers</span>
                        <span class="arrow"></span>
                    </a>
                    <ul class="sub-menu">
                        <!--                        <li><a href="#"><i class="fa fa-file"></i> Add new</a></li>-->
<!--                        <li><a href="#"><i class="fa fa-file"></i> Add New</a></li>-->
                        <li class="<?php echo $_menu_active=='customer_list'?'active':'';?>" >
                            <a href="<?php echo base_url().'customer/all';?>"><i class="fa fa-archive"></i> Show all</a></li>
                        <li class="<?php echo $_menu_active=='customer_sync'?'active':'';?>" >
                            <a href="<?php echo base_url().'customer/sync_form';?>"><i class="fa fa-refresh"></i> Sync</a></li>
                    </ul>
                </li>
<!--                End Customers-->

<!--                Users-->
                <li class="<?php echo $_menu_top=='user'?'active':'';?>">
                    <a href="javascript:;">
                        <i class="fa fa-user"></i>
                        <span class="title">Users</span>
                        <span class="arrow"></span>
                    </a>
                    <ul class="sub-menu">
                        <li class="<?php echo $_menu_active=='user_add'?'active':'';?>">
                            <a href="<?php echo base_url().'user/new';?>"><i class="fa fa-user"></i> Add new</a></li>
                        <li class="<?php echo $_menu_active=='user_list'?'active':'';?>" >
                            <a href="<?php echo base_url().'user/all';?>"><i class="fa fa-list"></i> Show all</a></li>
                    </ul>
                </li>
<!--                End Contacts-->

                <?php /*

                <!-- BEGIN ONE LEVEL MENU -->
                <li class="">
                    <a href="javascript:;">
                        <i class="icon-custom-ui"></i>
                        <span class="title">Link 4</span>
                        <span class="arrow"></span>
                    </a>
                    <ul class="sub-menu">
                        <li><a href="#">Sub Link 1</a></li>
                    </ul>
                </li>
                <!-- END ONE LEVEL MENU -->
                <!-- BEGIN TWO LEVEL MENU -->
                <li class="">
                    <a href="javascript:;">
                        <i class="fa fa-folder-open"></i>
                        <span class="title">Link 5</span>
                        <span class="arrow"></span>
                    </a>
                    <ul class="sub-menu">
                        <li><a href="javascript:;">Sub Link 1</a></li>
                        <li>
                            <a href="javascript:;"><span class="title">Sub Link 2</span><span class="arrow "></span></a>
                            <ul class="sub-menu">
                                <li><a href="javascript:;">Sub Link 1</a></li>
                            </ul>
                        </li>
                    </ul>
                </li>
                <!-- END TWO LEVEL MENU -->
                */?>


<!--                Signout-->
                <li class="">
                    <a href="<?php echo base_url().'user/signout';?>" title="Signout">
                        <i class="fa fa-power-off"></i>
                        <span class="title">Signout</span>
                    </a>
                </li>


            </ul>
            <!-- END SIDEBAR MENU -->
            <?php /*
            <!-- BEGIN SIDEBAR WIDGETS -->
            <div class="side-bar-widgets">
                <!-- BEGIN FOLDER WIDGET -->
                <p class="menu-title">FOLDER<span class="pull-right"><a class="create-folder" href="#"><i class="icon-plus"></i></a></span></p>
                <ul class="folders">
                    <li><a href="#"><div class="status-icon green"></div>Task 1</a></li>
                    <!-- BEGIN HIDDEN INPUT BOX (FOR ADD FOLDER LINK) -->
                    <li style="display:none" class="folder-input">
                        <input type="text" id="folder-name" name="" class="no-boarder folder-name" placeholder="Name of folder">
                    </li>
                    <!-- END HIDDEN INPUT BOX (FOR ADD FOLDER LINK) -->
                </ul>
                <!-- END FOLDER WIDGET -->

                <!-- BEGIN PROJECTS WIDGET -->
                <p class="menu-title">PROJECTS</p>
                <!-- BEGIN EXAMPLE 1 -->
                <div class="status-widget">
                    <div class="status-widget-wrapper">
                        <div class="title">Project Title<a class="remove-widget" href="#"><i class="icon-custom-cross"></i></a></div>
                        <p>Project Description</p>
                    </div>
                </div>
                <!-- END EXAMPLE 1 -->
                <!-- END PROJECTS WIDGET -->

            </div>
            */?>
            <div class="clearfix"></div>
            <!-- END SIDEBAR WIDGETS -->
        </div><div class="scroll-element scroll-x scroll-scrolly_visible"><div class="scroll-element_outer">    <div class="scroll-element_size"></div>    <div class="scroll-element_track"></div>    <div class="scroll-bar" style="width: 89px;"></div></div></div><div class="scroll-element scroll-y scroll-scrolly_visible"><div class="scroll-element_outer">    <div class="scroll-element_size"></div>    <div class="scroll-element_track"></div>    <div class="scroll-bar" style="height: 141px; top: 0px;"></div></div></div></div>
</div>