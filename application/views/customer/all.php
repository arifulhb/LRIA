
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
                    <div class="grid-title no-border">
                        <h4>Customer List</h4>
                    </div>
                    <div class="grid-body no-border">
                        <table class="table table-bordered no-more-tables table-responsive table-hover">
                            <thead>
                            <tr>

                                <th>Firstname</th>
                                <th>Lastname</th>
                                <th>Phone</th>
                                <th>Email</th>
                                <th>Added By</th>
                                <th>Create Date</th>
                                <th>Action</th>
                            </tr>
                            </thead>
                            <tbody>
                            <?php
                            foreach($_list as $row){ ?>
                                <tr id="row_<?php echo $row['cust_oid'];?>">
                                    <td class="firstname"><?php echo $row['cust_firstname'];?></td>
                                    <td class="lastname"><?php echo $row['cust_lastname'];?></td>
                                    <td class="telephone"><?php echo $row['cust_phone_no'];?></td>
                                    <td class="email-body">
                                        <?php echo substr($row['cust_email'],-11)=="noemail.net"?"":$row['cust_email'];?>

                                    </td>
                                    <td class="username"><?php echo $row['user_name'];?></td>
                                    <td class="createdate"><?php echo $row['create_date'];?></td>
                                    <td>
                                        <div class="btn-group btn-group-xs" role="group">

                                            <?php if(strlen($row['cust_oid'])>0){ ?>
                                                        <button type="button" class="btn btn-xs btn-default btn-sync"
                                                        value="<?php echo $row['cust_oid'];?>"><i class="fa fa-refresh"></i> Sync</button>
                                                <?php
                                            }//end if
                                            ?>
<!--                                            <button type="button" class="btn btn-xs btn-default btn-remove"-->
<!--                                                    value="--><?php //echo $row['cust_sn'];?><!--"><i class="fa fa-trash"></i> Remove</button>-->
                                        </div>
                                    </td>

                                </tr>

                            <?php
                            }//end foreach

                            ?>
                            </tbody>
                        </table>
                        <div class="text-center">
                            <?php echo $this->pagination->create_links();?>
                        </div>

                    </div>
                </div>

            </div>
        </div>

        <!-- END PLACE PAGE CONTENT HERE -->
    </div>
</div>
