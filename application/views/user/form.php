
<?php 
//print_r($_record);
//exit();
if($_action=='update'){ ?>
    
    <?php

    $_name          = $_record[0]['user_name'];
    $_user_sn       = $_record[0]['user_sn'];
    $_userEmail     = $_record[0]['user_email'];
    $_username      = $_record[0]['username'];

}//end if
else{
    
    $_name      = '';
    $_user_sn   = '';
    $_userEmail = '';
    $_username  = '';
}
?>

<!-- BEGIN PAGE CONTAINER-->
<div class="page-content">
    <div class="content">

        <!-- BEGIN PAGE TITLE -->
        <div class="page-title">
            <i class="fa fa-user"></i> <h3> <?php echo $_page_title;?></h3>
        </div>
        <!-- END PAGE TITLE -->

        <!-- BEGIN PlACE PAGE CONTENT HERE -->

        <div class="row">
            <div class="col-md-12">
                <div class="grid simple horizontal green">
                    <div class="grid-title">
                        <?php echo $_action=='add'?'Add New User':'Edit User';?>
                    </div>
                    <div class="grid-body">

                        <?php
                        if(isset($_error)){ ?>
                            <div class="alert alert-warning fade in">
                                <button data-dismiss="alert" class="close close-sm" type="button">
                                    <i class="fa fa-times"></i>
                                </button>
                                <strong>Warning!</strong><br>
                                <?php echo $_error;?>
                            </div>
                            <?php

                            $_name      = $_record[0]['user_name'];
                            $_user_sn    = $_record[0]['user_sn'];
                            $_userEmail = $_record[0]['user_email'];;

                        }//
                        ?>

                        <form class="" role="form" method="POST"
                              action="<?php echo base_url().'user/save';?>" >
                            <input type="hidden" id="_action" name="_action" value="<?php echo $_action;?>"/>
                            <?php if($_action=='update'){ ?>
                                <input type="hidden" id="_sn" name="_sn" value="<?php echo $_sn;?>"/>
                            <?php
                            }?>
                            <div class="row">
                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label for="inputUserName" class="form-label">Display Name *</label>
                                        <div class="input-with-icon right">
                                            <input type="text" class="form-control" id="inputUserName" maxlength="250"
                                                   name="inputUserName" placeholder="Display Name" value="<?php echo $_name;?>" required="">
                                        </div>
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label for="inputUsername" class="form-label">Username *</label>
                                        <span class="help">Username will be used to login</span>
                                        <div class="input-with-icon right">
                                            <input type="text" class="form-control" id="inputUsername" maxlength="10"
                                                   name="inputUsername" placeholder="Username" value="<?php echo $_username;?>" required=""
                                                    <?php echo $_action=='update'?'disabled':'';?>>
                                        </div>
                                    </div>
                                </div>
                            </div>

                            <div class="row">
                                <div class="col-md-6">
                                    <div class="form-group">
                                        <div class="form-group">
                                            <label for="inputOutlet" class="form-label">Email Address</label>
                                            <span class="help">User Email Address</span>
                                            <div class="input-with-icon right">
                                                <input type="email" class="form-control" id="inputUserEmail" maxlength="50"
                                                       name="inputUserEmail" placeholder="User Email" value="<?php echo $_userEmail;?>">
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <div class="col-md-6">
                                </div>
                            </div>
                            <div class="row">
                                <div class="col-sm-6 col-lg-10 col-md-6">
                                </div>
                                <div class="col-sm-6 col-lg-2 col-md-6">
                                    <div class="form-group">

                                            <button type="submit" class="finish btn-block btn btn-primary">
                                                <i class='fa fa-user-plus'></i> <?php echo ucfirst($_action);?> User
                                            </button>
                                    </div>

                                </div>

                            </div>
                        </form>

                    </div>
                    <div class="gird-footer">

                    </div>
                </div><!--grid-->
            </div>
        </div>


        <div class="row">
            <div class="col-md-12">
                    <div class="grid vertical yellow simple">
                        <div class="grid-title">
                            <i class="fa fa-unlock-alt"></i>  Change Password
                        </div>
                        <div id="changePassword" class="grid-body">
                            <div class='row'>
                                <div class='col-sm-4'>

                                        <div class="form-group">
                                            <label for="newPassword" class="form-label">New Password</label>
                                            <div class="input-with-icon right">
                                                <input type="password" class="form-control" id="newPassword"  value=""
                                                       name="newPassword" placeholder="Password"  maxlength="20">
                                            </div>
                                        </div>
                                </div>
                                <div class="col-sm-4">
                                    <div class="form-group">
                                        <label for="confirmPassword" class="form-label">Re New Password</label>
                                        <div class="input-with-icon right">
                                            <input type="password" class="form-control" id="confirmPassword"  value=""
                                                   name="confirmPassword" placeholder="Re Password" maxlength="20">
                                        </div>
                                    </div>
                                </div>
                                <div class="col-sm-4">
                                    <div class="form-group">
                                        <label for="up_re_new_password" class="form-label"></label>
                                        <div class="input-with-icon right">
                                            <button type="button" class="btn btn-sm btn-cons btn-default btn-block" id='change_password'
                                                style="margin-top: 7px;" disabled>
                                                Change Password</button>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="row">
                                <div class='col-sm-12'>
                                    <div class="alert_error">

                                    </div>
                                    <div class="alert_success">

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
<!-- END PAGE CONTAINER -->
<?php /*

<section class="panel">
    <header class="panel-heading clearfix">
        <?php echo $_action=='add'?'Add New User':'Edit User';?>
    </header>
    <div class="panel-body">


    </div>
</section>

<section class="panel panel-warning">
    <header class="panel-heading clearfix"><i class="fa fa-unlock-alt"></i> Change Password</header>
    <div class="panel-body">

        <div class='row'>
            <div class='col-sm-6'>
                <div class='form-horizontal'>
                  <div class="form-group">
                      <label for="up_new_password" class="col-md-4 control-label">New Password</label>
                      <div class="col-md-8">
                          <input type="password" class="form-control" id="up_new_password"  value=""
                                 name="up_new_password" placeholder="Password"  maxlength="20">
                      </div>
                  </div>            
                  <div class="form-group">
                      <label for="up_re_new_password" class="col-md-4 control-label">Re New Password</label>
                      <div class="col-md-8">
                          <input type="password" class="form-control" id="up_re_new_password"  value=""
                                 name="up_re_new_password" placeholder="Re Password" maxlength="20">
                      </div>
                  </div>            
                  <div class="form-group">
                      <label for="up_re_new_password" class="col-md-4 control-label"></label>
                      <div class="col-md-8">
                          <button type="button" class="btn btn-sm btn-default" id='change_password'>
                              <i class='fa fa-lock'></i> Change Password</button>
                      </div>
                  </div>            
                  </div>  
            </div>
            <div class='col-sm-6'>      
              <div class="error" style="display: none;">
                  <div class="alert alert-warning alert-dismissable" style="margin-bottom: 0px;">
                    <button type="button" class="close" data-dismiss="alert" aria-hidden="true">&times;</button>
                    <p id="error_message_password"></p>
                    
                  </div>
              </div>
                <div class="success" style="display: none;">
                  <div class="alert alert-success alert-dismissable" style="margin-bottom: 0px;">
                    <button type="button" class="close" data-dismiss="alert" aria-hidden="true">&times;</button>
                    <strong>Congratulations!</strong> Password updated successfully.
                    
                  </div>
              </div>
            </div>
        </div>

    </div>
</section>

*/?>