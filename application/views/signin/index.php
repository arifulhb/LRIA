<div class="row login-container column-seperation">
    <div class="col-md-5 col-md-offset-1"  style="height: 270px;">
        <h1><?php echo $_site_title;?></h1>
        <p><?php echo $_site_description;?></p>
            <?php /*<a href="#">Sign up Now!</a> for a webarch account,It's free and always will be..</p>*/?>

        <br>
        <p>
            <?php
            $notice         = $this->session->flashdata('notice');
            $username    = $this->session->flashdata('username');
            if(strlen($notice)>0){ ?>

            <div class="alert">
                <button class="close" data-dismiss="alert"></button>
                Warning:&nbsp; <?php echo $notice;?>
            </div>
                <?php
            }//end if
            ?>

        </p>

    </div>
    <div class="col-md-5"> <br>

        <form id="login-form" class="login-form"  method="post"
              action="<?php echo base_url().'signin/validation';?>">
            <div class="row">
                <div class="form-group col-md-10">
                    <label class="form-label">Username</label>
                    <div class="controls">
                        <div class="input-with-icon  right">
                            <i class=""></i>
                            <input type="text" name="username" id="username" class="form-control" required=""
                                placeholder="Username" autofocus="" value="<?php echo $username;?>">
                        </div>
                    </div>
                </div>
            </div>
            <div class="row">
                <div class="form-group col-md-10">
                    <label class="form-label">Password</label>
                    <span class="help"></span>
                    <div class="controls">
                        <div class="input-with-icon  right">
                            <i class=""></i>
                            <input type="password" name="signinPassword" id="txtpassword" class="form-control">
                        </div>
                    </div>
                </div>
            </div>
            <div class="row">
                <div class="control-group  col-md-10">
                    <div class="checkbox checkbox check-success"> <a href="#">Trouble login in?</a>&nbsp;&nbsp;
                        <input type="checkbox" id="checkbox1" value="1">
                        <label for="checkbox1">Keep me reminded </label>
                    </div>
                </div>
            </div>
            <div class="row">
                <div class="col-md-10">
                    <button class="btn btn-primary btn-cons pull-right" type="submit">Login</button>
                </div>
            </div>
        </form>
    </div>


</div>