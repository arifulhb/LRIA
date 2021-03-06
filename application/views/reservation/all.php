
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
                                <th>Status</th>
                                <th>Customer</th>
                                <th>Phone</th>
                                <th>Pax</th>
                                <th>Table</th>
                                <th>Note</th>
                                <th>Date & Time</th>

                                <th>Added By</th>
                                <th>Reservation Date</th>
                            </tr>
                            </thead>
                            <tbody>
                            <?php
                            foreach($_list as $row){ ?>
                                <tr>
                                    <td>
                                        <?php echo $row['cust_is_repeat']==true?"<label class='label label-default'>Old</label>":"<label class='label label-success'>New</label>";?>
                                    </td>
                                    <td><?php echo $row['cust_firstname'].' '.$row['cust_lastname'];?></td>
                                    <td><?php echo $row['cust_phone_no'];?></td>
                                    <td><?php echo $row['rsrv_pax'];?></td>
                                    <td><?php echo $row['tableName']." - <em>".$row['floorName']."</em>";?></td>
                                    <td><?php echo $row['rsrv_note'];?></td>
                                    <td><?php echo date("D, d M, Y h:i a",strtotime($row['rsrv_date']));?></td>
                                    <td><?php echo $row['user_name'];?></td>
                                    <td><?php echo date("M d, Y h:i:s a",strtotime($row['rcreate_date']));?></td>

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
