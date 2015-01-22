
<!-- BEGIN PAGE CONTAINER-->
<div class="page-content">
    <div class="content">
        <?php
        $this->load->view('inc/notification');

        ?>
        <!-- BEGIN PAGE TITLE -->
        <div class="page-title">
            <?php
            $title = explode(" ",$_page_title);
            ?>
            <h3><span class="semi-bold"><?php echo $title[0];?></span> <?php echo isset($title[1])?$title[1]:"";?></h3>
        </div>
        <!-- END PAGE TITLE -->

        <!-- BEGIN PlACE PAGE CONTENT HERE -->
        <div class="row">
            <div class="col-lg-12 col-md-12 col-sm-12">

                <div class="grid simple">
                    <div class="grid-title">
                        <h4>Sync with Lightspeed </h4>
                    </div>
                    <div class="grid-body">

                        <div class="row">
                            <div class="col-sm-2">
                                <button id="btnSync" type="button" class="btn btn-primary btn-block"
                                    ><i id="icon_sync" class="fa fa-cog"></i> Sync</button>
                            </div>
                            <div class="col-sm-10" id="sync_process">
                                <div class="text-center">
                                    <h2 id="sync_title" style="display: none"><i class="fa fa-spinner fa-spin"></i> Syncing Customers</h2>
                                    <h4 id="sync_status"></h4>
                                </div>

                                    <div id="sync_list">
                                        <ol class="">
                                        </ol>
                                    </div>
                            </div>
                        </div>


                    </div>
                </div>

            </div>
        </div>

        <!-- END PLACE PAGE CONTENT HERE -->
    </div>
</div>
