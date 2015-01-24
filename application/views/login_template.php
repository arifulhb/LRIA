<?php echo doctype('html5'); ?>
<html lang="en">
<head>
     <title><?php
         if(isset($_page_title)){ echo $_page_title.' - '.$_site_title;}
         else{ echo $_site_title;}
         ?></title>
    <?php
        //Meta
        $meta=array(
            array('name' =>'description',   'content' => $_site_description),
            array('name' =>'Content-type', 'content' => 'text/html; charset=utf-8', 'type' => 'equiv'),
            array('name' =>'author','content'=>$_author),
            array('name'=>'viewport','content'=>'width=device-width, initial-scale=1.0'));

        //add noindex nofollow if $_noindex_meta is set
        $_noindex_meta=array('name'=>'robots','content'=>'noindex,nofollow');
        if(isset($_noindex)){
            array_push($meta,$_noindex_meta);
        }

        echo meta($meta);
    ?>


    <!-- BEGIN CORE CSS FRAMEWORK -->
<!--    <link href="--><?php //echo base_url().'assets/barebone/';?><!--assets/plugins/pace/pace-theme-flash.css" rel="stylesheet" type="text/css" media="screen"/>-->
<!--    <link href="--><?php //echo base_url().'assets/barebone/';?><!--assets/plugins/boostrapv3/css/bootstrap.min.css" rel="stylesheet" type="text/css"/>-->
        <?php echo link_tag('http://maxcdn.bootstrapcdn.com/bootstrap/3.3.2/css/bootstrap.min.css');//CDN?>

    <link href="<?php echo base_url().'assets/barebone/';?>assets/plugins/boostrapv3/css/bootstrap-theme.min.css" rel="stylesheet" type="text/css"/>
<!--    <link href="--><?php //echo base_url().'assets/barebone/';?><!--assets/plugins/font-awesome/css/font-awesome.css" rel="stylesheet" type="text/css"/>-->
<!--    <link href="--><?php //echo base_url().'assets/barebone/';?><!--assets/css/animate.min.css" rel="stylesheet" type="text/css"/>-->
    <!-- END CORE CSS FRAMEWORK -->
    <!-- BEGIN CSS TEMPLATE -->
    <link href="<?php echo base_url().'assets/barebone/';?>assets/css/style.css" rel="stylesheet" type="text/css"/>
<!--    <link href="--><?php //echo base_url().'assets/barebone/';?><!--assets/css/responsive.css" rel="stylesheet" type="text/css"/>-->
<!--    <link href="--><?php //echo base_url().'assets/barebone/';?><!--assets/css/custom-icon-set.css" rel="stylesheet" type="text/css"/>-->
    <!-- END CSS TEMPLATE -->


    <?php
        //Favicon
        /*$ficon=array('href'=>'assets/images/dog1_16.png',
                    'rel' => 'icon',
                    'type' => 'image/png');
        echo link_tag($ficon);
        ?>*/
        ?>


</head>
<body class="<?php echo isset($_page_class)?$_page_class:'';?>">

<div class="container">
    <?php echo $_content;?>
    <!-- footer -->
    <br><br>
    <footer id="footer" class="clearfix">

        <hr>
        <div class="text-center">
            <p>
                <a href="<?php echo $_company_website;?>" target="_blank"
                   title="<?php echo $_company;?>">
                    <small>Developed by <?php echo $_company;?></small><br>
                </a><small>&copy; 2013-2015</small>
            </p>
        </div>
    </footer>
</div>
<!-- END CONTAINER -->
<!-- BEGIN CORE JS FRAMEWORK-->
<!--<script src="--><?php //echo base_url().'assets/barebone/';?><!--assets/plugins/jquery-1.8.3.min.js" type="text/javascript"></script>-->
<script src="https://ajax.googleapis.com/ajax/libs/jquery/1.11.2/jquery.min.js" type="text/javascript"></script> <!--CDN-->
<!--<script src="--><?php //echo base_url().'assets/barebone/';?><!--assets/plugins/bootstrap/js/bootstrap.min.js" type="text/javascript"></script>-->
<script src="http://maxcdn.bootstrapcdn.com/bootstrap/3.3.2/js/bootstrap.min.js" type="text/javascript"></script><!--CDN-->
<!--<script src="--><?php //echo base_url().'assets/barebone/';?><!--assets/plugins/pace/pace.min.js" type="text/javascript"></script>-->
<!--<script src="--><?php //echo base_url().'assets/barebone/';?><!--assets/plugins/jquery-validation/js/jquery.validate.min.js" type="text/javascript"></script>-->
<!--<script src="--><?php //echo base_url().'assets/barebone/';?><!--assets/js/login.js" type="text/javascript"></script>-->
<!-- BEGIN CORE TEMPLATE JS -->
<!-- END CORE TEMPLATE JS -->

</body>
</html>