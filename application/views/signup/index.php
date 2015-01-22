
<?php
$errors  = $this->session->flashdata('errors');


if( strlen($errors)>0){
    $data  = $this->session->flashdata('data');

    $first_name = $data['user_first_name'];
    $last_name  = $data['user_last_name'];
    $email      = $data['user_email'];
}//end if
else{
    $first_name = '';
    $last_name  ='';
    $email      = '';
}

?>

    <div class="row m-n">
        <div class="col-md-12 m-t-lg">
            <section class="panel">
                <header class="panel-heading bg bg-primary text-center">
                    Sign up
                </header>
                <form action="<?php echo base_url().'signup/user_registration';?>" class="panel-body"
                        method="post">
                    <div class="form-group">
                        <label class="control-label">First name</label>
                        <input type="text" placeholder="First Name" class="form-control" required=""
                                name="user_first_name" value="<?php echo $first_name;?>">
                    </div>
                    <div class="form-group">
                        <label class="control-label">Last name</label>
                        <input type="text" placeholder="Last Name" class="form-control" required=""
                                name = "user_last_name" value="<?php echo $last_name;?>">
                    </div>
                    <div class="form-group">
                        <label class="control-label">Your email address</label>
                        <input type="email" placeholder="email@domain.com" class="form-control" required=""
                                name = "user_email" value="<?php echo $email;?>">
                    </div>
                    <div class="form-group">
                        <label class="control-label">Type a password</label>
                        <input type="password" id="inputPassword" placeholder="Password" class="form-control" required=""
                                name = "user_password">
                    </div>
                    <div class="form-group">
                        <label class="control-label">Confirm password</label>
                        <input type="password" id="inputConfirmPassword" placeholder="Confirm Password" class="form-control" required=""
                               name = "user_repassword">
                    </div>
                    <div class="checkbox">
                        <label>
                            <input type="checkbox" name="inputAgreement" required=""> Agree the <a href="#">terms and policy</a>
                        </label>
                    </div>
                    <button type="submit" class="btn btn-info">Sign up</button>
                    <div class="line line-dashed"></div>
                    <p class="text-muted text-center"><small>Already have an account?</small></p>
                    <a href="<?php echo base_url().'signin';?>" class="btn btn-white btn-block">Sign in</a>
                </form>
            </section>
        </div>
    </div>
