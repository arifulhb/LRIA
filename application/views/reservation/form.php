<!-- BEGIN PAGE CONTAINER-->
<div class="page-content">
    <div class="content">
        <?php
        $this->load->view('inc/notification');

        ?>
        <!-- BEGIN PAGE TITLE -->
        <div class="page-title">
            <h3 id="page_title"><?php echo $_page_title;?></h3>
        </div>
        <!-- END PAGE TITLE -->


        <!-- BEGIN PlACE PAGE CONTENT HERE -->

        <div id="reservationModal">
            <div class="row">

                <div class="col-sm-6">
                    <div class="grid simple green horizontal ">
                        <div class="grid-title">Customer <label class="label pull-right" id="searchResult"></label></div>
                        <div class="grid-body">
                            <div class="row">

                                <div class="input-group">
                                <span class="input-group-addon primary">
                                            <span class="arrow"></span>
                                            <i id="icon-search" class="fa fa-search" title="Ctrl + Alt + f to search"></i>
                                       </span>
                                    <input type="text" class="form-control  ui-autocomplete-input" id="searchCustomer" name="searchCustomer"
                                           placeholder="Search Customer" accesskey="f" title="Ctrl + Alt + f to search">

                                    <!--                                    Customer id-->
                                    <input type="hidden" id="lira_customer_sn" name="lira_customer_sn">
                                    <input type="hidden" id="cust_ls_oid" name="cust_ls_oid">
                                </div>
                            </div>

                                <br>
                             <div id="addCustomer" style="display: none" >

                                 <form class="form-horizontal">



                                 <div class="row">
                                     <div class="col-sm-6">
                                         <div id="firstname-group" class="form-group">
                                             <label for="cust_firstname" class="col-sm-3 control-label">First Name</label>
                                                 <div class="transparent col-lg-9 col-md-9 " id="">
                                                     <input type="text" id="cust_firstname" name="cust_firstname"
                                                            class="form-control" placeholder="First Name" required=""
                                                            maxlength="50">
                                                 </div>
                                         </div>
                                     </div><!--end col-sm-6-->

                                     <div class="col-sm-6">
                                         <div id="lastname-group" class="form-group">
                                             <label for="cust_lastname" class="col-sm-3 control-label">Last Name</label>
                                                 <div class="col-md-9 col-lg-9 no-padding">
                                                     <input type="text" id="cust_lastname" name="cust_lastname"
                                                            class="form-control" placeholder="Last Name" required=""
                                                            maxlength="50">
                                                 </div>
                                         </div>
                                     </div><!--end col-sm-6-->
                                 </div>



                                 <div class="row">

                                         <div class="col-sm-6">
                                             <div id="handphone-group" class="form-group">
                                                 <label for="cust_handphone" class="col-sm-3 control-label">H/P</label>

                                                     <div class="col-lg-9 col-md-9 " id="">
                                                         <input type="text" id="cust_handphone" name="cust_handphone"
                                                                class="form-control" placeholder="Handphone" required=""
                                                                maxlength="50">
                                                     </div>
                                             </div>
                                         </div>

                                         <div class="col-sm-6">
                                             <div id="email-group" class="form-group">
                                                 <label for="cust_email" class="col-sm-3 control-label">Email</label>

                                                 <div class="col-lg-9 col-md-9  no-padding">
                                                     <input type="email" id="cust_email" name="cust_email"
                                                            class="form-control" placeholder="Email"
                                                            maxlength="50">
                                                 </div>
                                             </div>
                                         </div>

                                     </div><!--endrow-->

                                </form>
                             </div><!--end add customer-->

                            <div id="showCustomer" >

                                <form class="form-horizontal1">

                                    <div class="row">
                                        <div class="col-sm-6">
                                            <div class="form-group">
                                                <label for="" class="col-sm-3  no-padding control-label">First Name</label>
                                                <div class="col-sm-9  no-padding">

                                                    <div class="input-group transparent col-lg-12 col-md-12" id="">
                                                        <label class="form-control" id="l_cust_firstname"></label>

                                                    </div>
                                                </div>
                                            </div>

                                        </div>

                                        <div class="col-sm-6">
                                            <div class="form-group">

                                                <label for="l_cust_lastname" class="col-sm-3  no-padding control-label">Last Name</label>
                                                <div class="col-sm-9  no-padding">
                                                    <div class="input-group col-md-12 col-lg-12">
                                                        <label class="form-control" id="l_cust_lastname"></label>
                                                    </div>
                                                </div>

                                            </div>
                                        </div>

                                    </div><!--end row-->
                                    <br>
                                    <div class="row">
                                        <div class="col-sm-6">
                                            <div class="form-group">
                                                <label for="" class="col-sm-3 no-padding control-label">H/P</label>
                                                <div class="col-sm-9 no-padding">

                                                    <div class="input-group transparent col-lg-12 col-md-12 " id="">
                                                        <label class="form-control" id="l_cust_handphone"></label>

                                                    </div>
                                                </div>

                                            </div>
                                        </div>
                                        <div class="col-sm-6">
                                            <div class="form-group">

                                                <label for="l_cust_email" class="col-sm-3 no-padding control-label">Email</label>
                                                <div class="col-sm-9 no-padding">
                                                    <div class="input-group col-md-12 col-lg-12 no-padding">
                                                        <label class="form-control" id="l_cust_email"></label>
                                                    </div>
                                                </div>

                                            </div>
                                        </div>
                                    </div> <!--end row-->
                                </form>
                            </div><!--end showcustomer-->


                        </div>
                    </div>
                </div>
                <div class="col-sm-6">
                    <div class="grid simple green horizontal ">
                        <div class="grid-title">Reservation <div id="reservationNotification" class="pull-right"></div></div>
                        <div class="grid-body">
                            <div class="row">

                                <div class="col-sm-6">
                                    <div id="time-group" class="form-group">
                                        <label for="rtime" class="col-sm-2 no-padding control-label">Time</label>
                                        <div class="col-sm-10 no-padding">
                                            <div class="input-group col-md-12 rclockpicker" id="">
                                                <span class="input-group-addon ">
                                                   <i id="icon-clock" class="fa fa-clock-o"></i>
                                                  </span>
                                                <input type="text" id="rtime" class="form-control" placeholder="Pick a time">
                                            </div>
                                        </div>

                                    </div>

                                </div>

                                <div class="col-sm-6">
                                    <div id="date-group" class="form-group">
                                        <label for="rdate" class="col-sm-2 no-padding control-label">Date</label>
                                        <div class="col-sm-10 no-padding">
                                            <div class="input-group date col-md-12 col-lg-12 no-padding">
                                                <span class="input-group-addon">
                                                    <i class="fa fa-calendar"></i>
                                                </span>
                                                <input type="text" class="form-control" id="rdate" value="<?php echo date("d/m/Y",strtotime("today"));?>">
                                            </div>
                                        </div>

                                    </div>
                                </div>

                            </div><!--endrow-->
                            <br>
                            <div class="row">
                                <div class="col-lg-6">
                                    <div id="pax-group" class="form-group">

                                        <label for="rpax" class="col-sm-2 no-padding control-label">Pax</label>
                                        <div class="col-sm-10 no-padding">
                                            <div class="input-group success date col-md-12 col-lg-12 no-padding">
                                                <span class="input-group-addon">
                                                    <i id="icon_pax" class="fa fa-user-plus"></i>
                                                </span>
                                                <input type="number" id="rpax" name="rpax" placeholder="Number of Pax"
                                                       value="2" class="form-control">

                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <div class="col-lg-6">
                                    <div id="table-group" class="form-group">
                                        <label for="rtable" class="col-sm-2 no-padding control-label">Table</label>
                                        <div class="col-sm-10 no-padding">
                                            <div class="input-group col-lg-12">
                                                <span class="input-group-addon">
                                                    <i id="icon_table" class="fa fa-plus"></i>
                                                </span>
                                                <select class="form-control col-lg-12" id="floor_tables" disabled="DISABLED">
                                                    <option value="loading">Loading...</option>
                                                </select>
                                            </div>

                                        </div>
                                    </div>
                                </div>

                            </div>
                            <br>
                            <div class="row">
                                <div class="form-group">
                                    <label for="rnote" class="col-sm-1 control-label">Note</label>
                                    <div class="col-sm-11">
                                        <div class="input-append success date col-md-12 col-lg-12 no-padding">
                                            <textarea id="rnote" name="rnote" class="form-control"></textarea>
                                        </div>
                                    </div>
                                </div>
                            </div>

                            <!--                                Date: <div id="dp51" data-date="12-02-2013" data-date-format="dd-mm-yyyy"></div>-->

                        </div>
                    </div>
                </div>
            </div>

<!--            Control-->

            <div class="row">
                <div class="col-sm-2">
                    <button type="button" class="btn btn-xs btn-block" id="btnNewCustomer" accesskey="n"
                        title="Ctrl + Alt + a for new Customer">
                        <i class="fa fa-file"></i> <span class="accesskey">N</span>ew Customer
                    </button>
                </div>
                <div class="col-sm-2">
<!--                    <button type="button" class="btn btn-xs btn-block" id="btnNewReservation"  accesskey="r"-->
<!--                            title="Ctrl + Alt + r for New Reservation">-->
<!--                        <i class="fa fa-book"></i> New <span class="accesskey">R</span>eservation-->
<!--                    </button>-->
                </div>
                <div class="col-sm-6">
<!--                    <button type="button" class="btn btn-xs btn-block btn-warning" id="btnGetSlots">-->
<!--                        <i class="fa fa-archive"></i> getSlots-->
<!--                    </button>-->
                </div>
                <div class="col-sm-2">
                    <button type="button" class="btn btn-sm btn-primary btn-block" id="btnSave" accesskey="s"
                            title="Ctrl + Alt + s for Save">
                        <i class="fa fa-save"></i> <span class="accesskey">S</span>ave
                    </button>
                </div>
            </div>

        </div>



        <!-- END PLACE PAGE CONTENT HERE -->
    </div>
</div>