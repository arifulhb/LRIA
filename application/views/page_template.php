<?php 
echo doctype('html5'); ?>
<html lang="en">
<head>
     <title>
    <?php     
         if(isset($_page_title)){ echo $_page_title.' - '.$_site_title;}
         else{ echo $_site_title;}?>
     </title>
    <?php
        //Meta
        $meta=array(
            array('name' =>'description',   'content' => $_site_description),
            array('name' =>'Content-type', 'content' => 'text/html; charset=utf-8', 'type' => 'equiv'),
            array('name' =>'author','content'=>$_author),
            array('name'=>'viewport','content'=>'width=device-width, initial-scale=1.0,maximum-scale=1'));

        $_noindex_meta=array('name'=>'robots','content'=>'noindex,nofollow');
        if(isset($_noindex)){
            array_push($meta,$_noindex_meta);
        }
        //Cache control
        $_pragma=array('type' => 'equiv','name'=>'Pragma','content'=>'no-cache');
        $_expire=array('type' => 'equiv','name'=>'Expires','content'=>'-1');
        
        array_push($meta, $_pragma);
        array_push($meta, $_expire);
        
        echo meta($meta);

        //Bootstrap
//        echo link_tag('assets/plugins/bootstrap/css/bootstrap.css');
//        echo link_tag('assets/plugins/bootstrap/css/bootstrap-reset.css');
                        
//      Loading Font-Awesome
//        echo link_tag('assets/plugins/font-awesome/css/font-awesome.css');

//      Webarch Plugin
//        echo link_tag('assets/barebone/assets/plugins/pace/pace-theme-flash.css');
        echo link_tag('assets/barebone/assets/plugins/jquery-scrollbar/jquery.scrollbar.css');
        echo link_tag('assets/barebone/assets/plugins/boostrapv3/css/bootstrap.min.css');
        echo link_tag('assets/barebone/assets/plugins/boostrapv3/css/bootstrap-theme.min.css');
        echo link_tag('assets/barebone/assets/plugins/font-awesome/css/font-awesome.css');


//      Webarch CSS
        echo link_tag('assets/barebone/assets/css/animate.min.css');
        echo link_tag('assets/barebone/assets/css/style.css');
        echo link_tag('assets/barebone/assets/css/responsive.css');
        echo link_tag('assets/barebone/assets/css/custom-icon-set.css');


        echo link_tag('assets/barebone/assets/plugins/bootstrap-datepicker/css/datepicker.min.css');
        echo link_tag('assets/barebone/assets/plugins/boostrap-clockpicker/bootstrap-clockpicker.min.css');
        echo link_tag('assets/barebone/assets/plugins/boostrap-clockpicker/jquery-clockpicker.min.css');
        echo link_tag('assets/barebone/assets/plugins/bootstrap-timepicker/css/bootstrap-timepicker.min.css');

        echo link_tag('assets/barebone/assets/plugins/jquery-notifications/css/messenger.min.css');
        echo link_tag('assets/barebone/assets/plugins/jquery-notifications/css/location-sel.min.css');
//        echo link_tag('assets/barebone/assets/plugins/jquery-notifications/css/messenger-theme-future.min.css');
        echo link_tag('assets/barebone/assets/plugins/jquery-notifications/css/messenger-theme-flat.min.css');


//      Koronio Custom
        echo link_tag('assets/css/custom.css');
        
        //echo link_tag('assets/css/landing.css');
        
        //JQUERY
        echo link_tag('http://code.jquery.com/ui/1.10.3/themes/smoothness/jquery-ui.css');
        
        //Google Font
//       $open_sans=array('href'=>'http://fonts.googleapis.com/css?family=Open+Sans:300italic,400italic,600italic,700italic,400,300,700,600',
//                    'rel' => 'stylesheet',
//                    'type' => 'text/css');
//        echo link_tag($open_sans);
        
        /*
        //Favicon
        $ficon=array('href'=>'assets/images/dog1_16.png',
                    'rel' => 'icon',
                    'type' => 'image/png');
        echo link_tag($ficon);

    ?>
    <!--favicon-->
    <link rel="icon" type="image/x-icon" sizes="32x32"
          href="<?php echo base_url(); ?>assets/img/favicon/favicon.png" />
    */?>
<?php /*
    <!--requirejs-->
    <script type="application/javascript"
            src="<?php echo base_url();?>assets/js/require.js?v1.2"
            data-main="<?php echo base_url();?>assets/js/app"></script>

    */?>
</head>

<body class="<?php echo isset($_page_class)?$_page_class:'';?>">

    <?php
    // Leftnav
    $this->load->view('inc/top_nav');
    ?>

    <div class="page-container row-fluid">

        <?php
        //HEADER
            $this->load->view('inc/left_nav');


        echo $_content;

        //SIDE
//            $this->load->view('inc/right_nav');
        ?>

    </div>


     <?php
//     Reservation Modal

//     $this->load->view("reservation/form");

//    PROFILER

    //<script>require(['page/page_template']);</script>
    //$this->output->enable_profiler(TRUE);
    ?>

    <!-- BEGIN CORE JS FRAMEWORK-->
    <script src="<?php echo base_url().'assets/barebone/';?>assets/plugins/jquery-1.8.3.min.js" type="text/javascript"></script>
    <script src="<?php echo base_url().'assets/barebone/';?>assets/plugins/jquery-ui/jquery-ui-1.10.1.custom.min.js" type="text/javascript"></script>
    <script src="<?php echo base_url().'assets/barebone/';?>assets/plugins/boostrapv3/js/bootstrap.min.js" type="text/javascript"></script>
    <script src="<?php echo base_url().'assets/barebone/';?>assets/plugins/breakpoints.js" type="text/javascript"></script>
    <script src="<?php echo base_url().'assets/barebone/';?>assets/plugins/jquery-unveil/jquery.unveil.min.js" type="text/javascript"></script>
    <script src="<?php echo base_url().'assets/barebone/';?>assets/plugins/jquery-block-ui/jqueryblockui.js" type="text/javascript"></script>
    <!-- END CORE JS FRAMEWORK -->



    <!-- BEGIN CORE TEMPLATE JS -->
    <script src="<?php echo base_url().'assets/barebone/';?>assets/js/core.js" type="text/javascript"></script>


    <!-- BEGIN PAGE LEVEL JS -->
    <script src="<?php echo base_url().'assets/barebone/';?>assets/plugins/jquery-scrollbar/jquery.scrollbar.min.js" type="text/javascript"></script>
    <script src="<?php echo base_url().'assets/barebone/';?>assets/plugins/pace/pace.min.js" type="text/javascript"></script>
    <script src="<?php echo base_url().'assets/barebone/';?>assets/plugins/jquery-numberAnimate/jquery.animateNumbers.js" type="text/javascript"></script>

    <!--    Date & Clock Picker-->
    <script src="<?php echo base_url().'assets/barebone/';?>assets/plugins/bootstrap-datepicker/js/bootstrap-datepicker.min.js" type="text/javascript"></script>
    <script src="<?php echo base_url().'assets/barebone/';?>assets/plugins/boostrap-clockpicker/jquery-clockpicker.min.js" type="text/javascript"></script>
    <script src="<?php echo base_url().'assets/barebone/';?>assets/plugins/boostrap-clockpicker/bootstrap-clockpicker.min.js" type="text/javascript"></script>
    <script src="<?php echo base_url().'assets/barebone/';?>assets/plugins/bootstrap-timepicker/js/bootstrap-timepicker.min.js" type="text/javascript"></script>
    <!-- END PAGE LEVEL PLUGINS -->

<!--    Notification-->

    <script src="<?php echo base_url().'assets/barebone/';?>assets/plugins/jquery-notifications/js/messenger.min.js" type="text/javascript"></script>
    <script src="<?php echo base_url().'assets/barebone/';?>assets/plugins/jquery-notifications/js/messenger-theme-flat.min.js" type="text/javascript"></script>
<!--    End Notification-->

    <?php /*
    <script src="<?php echo base_url().'assets/barebone/';?>assets/js/chat.js" type="text/javascript"></script>
    <script src="<?php echo base_url().'assets/barebone/';?>assets/js/demo.js" type="text/javascript"></script>
    */?>

<!--    App Specific js-->
    <script src="<?php echo base_url().'assets/js/lira.js';?>" type="text/javascript"></script>
 <!-- END CORE TEMPLATE JS -->


</body>
</html>