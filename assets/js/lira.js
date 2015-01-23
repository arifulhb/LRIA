$(document).ready(function(){

    var app_path =  window.location.origin;

    Messenger.options = {
        extraClasses: 'messenger-fixed messenger-on-top messenger-on-right',
        theme: 'flat'
    }

    /*CHANGE PASSWORD*/
    var changePass = $('#changePassword').length;

    if(changePass>0){

        $("#newPassword, #confirmPassword").bind('focusout keypress',function(){

            var cpass = $("#newPassword").val();
            var rpass = $("#confirmPassword").val();

            if(cpass=='' || rpass ==''){

                $('#change_password').attr('DISABLED','DISABLED');
            }else{
                $('#change_password').removeAttr('DISABLED');
            }
        });


        $('#change_password').click(function(){

            var user_sn = $("_sn").val();
            var cpass = $("#newPassword").val();
            var rpass = $("#confirmPassword").val();

            if(cpass=='' || rpass ==''){
                alert("Please Enter Password");
                $('#newPassword').focus();
                return 0;
            }

            $.ajax({
                type: "POST",
                url:app_path+'/user/cpvalidation',
                processData:false,
                data:'user_sn='+user_sn+'&newPassword='+cpass+'&confirmPassword='+rpass,
                success:function(_result){

                    var result = JSON.parse(_result);

                    if(result.status==true){
                        var alert = '<div class="alert alert-success">';
                            alert += '<button data-dismiss="alert" class="close"></button>';
                            alert += '<strong>Success:</strong> Password is updated.';
                            alert += '</div>';

                        $('.alert_success').append(alert);
                        $('.alert_success').css('display','block');

                    }
                    else if (result.status==false){

                        var alert = '<div class="alert alert-warning">';
                        alert += '<button data-dismiss="alert" class="close"></button>';
                        alert += '<strong>Validation Error:</strong> '+result.error;
                        alert += '</div>';

                        $('.alert_error').append(alert);
                        $('.alert_error').css('display','block');
                    }
                    //console.log(result);
                },
                error:function(_error){
                    var error = JSON.parse(_error);
                    alert(error);
                }

            });

        });

    }//end changepass


    /* RESERVATION */

    var reservationModal = $("#reservationModal").length;

    if(reservationModal>0){


        $("#btnSave").html("<i class='"+"fa fa-book"+"'></i> New Reservation");

        //
        //Messenger().post({
        //    message: "This is error",
        //    type: 'error',
        //    hideAfter: 20,
        //    showCloseButton: true
        //});

        //Time pickers
        $('.rclockpicker').clockpicker({
            autoclose: true,
            'default': 'now'
        });


        $('#icon_table').removeClass("fa-plus");
        $('#icon_table').addClass("fa-spinner fa-spin");
        $.ajax({
            type: "POST",
            url: app_path+'/reservation/ajax_getFloors/',
            //data: 'keyword='+$("#searchCustomer").val(),
            success: function(response) {
                //console.log("Response: "+response);

                var data = JSON.parse(response);
                var str ='';

                var mainObject = $.map(data, function(floor, index) {


                    str += "<optgroup label='"+floor.name+"' data-floor-id='"+floor.oid+"'>";

                        var tableObject = $.map(floor.tables, function(tableValue, tableIndex){

                            str += "<option value='"+tableValue.oid+"'>"+tableValue.name+"</option>";

                        });

                    str+="</optgroup>";

                });

                $("#floor_tables option[value='loading']").remove();
                $('#floor_tables').append(str);
                //console.log('str: '+str);

                $('#floor_tables').prop('disabled',false);
                $('#icon_table').addClass("fa-plus");
                $('#icon_table').removeClass("fa-spinner fa-spin");
                //console.log("data: "+data);
            },
            error:function(_error){
                $('#icon_table').addClass("fa-plus");
                $('#icon_table').removeClass("fa-spinner fa-spin");
                console.log("Error: "+_error);
            }

        });

        //Date picker
        $('#rdate').datepicker({
            format: 'dd/mm/yyyy'
        });

    //    Customer Search Autocomplete

        $('#searchCustomer').autocomplete({

            source:function(request, response){
                $('#lira_customer_sn').val('');
                $('#icon-search').removeClass("fa-search");
                $('#icon-search').addClass("fa-spinner fa-spin");

                $.ajax({
                    type: "POST",
                    url: app_path+'/customer/ajax_search/'+$("#searchCustomer").val(),
                    data: 'keyword='+$("#searchCustomer").val(),
                    success: function(data ) {

                        $('#icon-search').addClass("fa-search");
                        $('#icon-search').removeClass("fa-spinner fa-spin");

                        //console.log('ajax success: '+data);
                        //response(data);

                        response( $.map( JSON.parse(data), function( value, key ) {

                            //console.log("item: "+key +" value: "+value.cust_firstname);

                                return {

                                    label:          value.cust_firstname + " " + value.cust_lastname + " ("+value.cust_phone_no+")",
                                    value:          value.cust_lastname,
                                    cust_firstname:  value.cust_firstname,
                                    cust_lastname:  value.cust_lastname,
                                    cust_oid:       value.cust_oid,
                                    cust_email:     value.cust_email,
                                    cust_phone:     value.cust_phone_no,
                                    ////cust_license_date: (item.cust_license_date===null?'':item.cust_license_date),
                                    key  : value.cust_sn
                                }

                        }));
                        //console.log('license date '+cust_license_date);
                    },
                    error: function(error){
                        console.log('autocomplete error: '+error);}
                });
            },
            delay: 500,
            minLength:3,
            select: function (event,ui)
            {
                //console.log("UI: "+ui.item.cust_firstname);
                var array = $.map(ui, function(value, index) {

                    //console.log("value: "+value +" Index: "+index)

                    var a2 = $.map(value, function(val, key){
                        //console.log("key:"+key+" val:"+val);
                        switch (key){
                            case 'cust_firstname':
                                $('#l_cust_firstname').html(val);
                                break;
                            case 'cust_lastname':
                                $('#l_cust_lastname').html(val);
                                break;
                            case 'cust_email':
                                $('#l_cust_email').html(val);
                                break;
                            case 'cust_phone':
                                $('#l_cust_handphone').html(val);
                                break;
                            case 'cust_oid':
                                $('#cust_ls_oid').val(val);
                                break;
                            case 'key':
                                $('#lira_customer_sn').val(val);
                                break;
                        }
                    })
                });

                $("#btnSave").html("<i class='fa fa-save'></i> Save");
                showCustomer();

                return false;
            },
            response:function(event, ui){
                //console.log('Autocomplete response : '+ui.content.length);
                if(ui.content.length == 0){
                    $('#searchResult').show();
                    $('#searchResult').removeClass('label-success');
                    $('#searchResult').html(' 0 results found.');
                    $('#lira_customer_sn').val('');
                    addCustomer();
                }else{
                    cancleAddCustomer();
                    $('#searchResult').show();
                    $('#searchResult').addClass('label-success');
                    $('#searchResult').html(' '+ui.content.length+' results found');
                }
            },
            close: function() {
                //$('#searchResult').css('display','none');
                $('#icon-search').addClass("fa-search");
                $('#icon-search').removeClass("fa-spinner fa-spin");
                $('#searchResult').hide();
            }
        });//end autocomplete


        var addCustomer = function(){
            $('#addCustomer').show();
            $('#cust_firstname').val('');
            $('#cust_lastname').val('');
            $('#cust_handphone').val('');
            $('#cust_email').val('');
            $("#lira_customer_sn").val()
            $("#cust_ls_oid").val()


            hideCustomer();
        }
        var showAddCustomer=function(){
            $('#addCustomer').show();
            $('#showCustomer').hide();
        }
        var cancleAddCustomer = function(){
            $('#addCustomer').hide();
            $('#cust_firstname').val('');
            $('#cust_lastname').val('');
            $('#cust_handphone').val('');
            $('#cust_email').val('');
            $("#lira_customer_sn").val()
            $("#cust_ls_oid").val()

        }

        var showCustomer = function(){
            //console.log("Show customer");

            $('#showCustomer').show();

            $('#cust_firstname').val('');
            $('#cust_lastname').val('');
            $('#cust_handphone').val('');
            $('#cust_email').val('');

            cancleAddCustomer();
        }
        var hideCustomer = function(){
            $('#showCustomer').hide();
            $('#lira_customer_sn').val('');
            $('#cust_ls_oid').val('');
        }


        $('#btnNewCustomer').click(function(){
            addCustomer();
            $('#cust_firstname').focus();
            //alert("New customer");
        });

        $('#btnSave').click(function(){

            //console.log("Reservation save");

            var action = $("#btnSave").text();

            //console.log("action: "+action);

            if($.trim(action)=='New Reservation'){
                //alert("prepare");
                $("#searchCustomer").focus();
                $("#searchCustomer").val("");
                $("#btnSave").prop('disabled', false);
                $("#reservationNotification").empty();
                cancleAddCustomer();
                showCustomer();
                enableForm();
                clearShowCustomers();

                $('#btnSave').html("<i class='fa fa-save'></i> Save");

            }else if($.trim(action)=='Save'){
                //alert("save");

            //console.log("time: "+$("#rtime").val().length);

                //Validation
                var validateCustomer_firstname = true;
                var validateCustomer_lastname = true;
                var validateCustomer_phonename = true;
                var validateCustomer_emailname = true;

                var validateTime = true;
                var validateDate = true;
                var validatePax  = true;

                if( ($("#lira_customer_sn").val().length <= 0)
                    && ($("#cust_ls_oid").val().length <= 0) ){
                    //No Customer selected.. check if all fields of new customer is provided

                    if($("#cust_firstname").val().length <= 0){
                        $("#firstname-group").addClass("has-error");
                        $("#cust_firstname").focus();
                        Messenger().post({
                            message: "Please enter first name!",
                            type: 'error', hideAfter: 10, showCloseButton: true
                        });
                        validateCustomer_firstname = false;
                        showAddCustomer();
                    }//end if
                    else{ validateCustomer_firstname = true;$("#firstname-group").removeClass("has-error");}

                    if($("#cust_lastname").val().length <= 0){
                        $("#lastname-group").addClass("has-error");
                        $("#cust_lastname").focus();
                        Messenger().post({
                            message: "Please enter last name!",
                            type: 'error', hideAfter: 10, showCloseButton: true
                        });
                        validateCustomer_lastname = false;
                        showAddCustomer();
                    }//end if
                    else{ validateCustomer_lastname = true;$("#lastname-group").removeClass("has-error");}

                    if($("#cust_handphone").val().length <= 0){
                        $("#handphone-group").addClass("has-error");
                        $("#cust_handphone").focus();
                        Messenger().post({
                            message: "Please enter handphone number!",
                            type: 'error', hideAfter: 10, showCloseButton: true
                        });
                        validateCustomer_phonename = false;
                        showAddCustomer();
                    }//end if
                    else{ validateCustomer_phonename = true; $("#handphone-group").removeClass("has-error");}

                    if($("#cust_email").val().length <= 0){
                        $("#email-group").addClass("has-error");
                        $("#cust_email").focus();
                        Messenger().post({
                            message: "Please enter email address !",
                            type: 'error', hideAfter: 10, showCloseButton: true
                        });
                        validateCustomer_emailname = false;
                        showAddCustomer();
                    }//end if
                    else{ validateCustomer_emailname = true;$("#email-group").removeClass("has-error");}


                }//end rtime
                else{
                    validateCustomer_firstname = true;
                    validateCustomer_lastname = true;
                    validateCustomer_phonename = true;
                    validateCustomer_emailname = true;
                }


                if( $("#rtime").val().length <= 0){
                    $("#time-group").addClass("has-error");
                    $("#rtime").focus();
                    Messenger().post({
                        message: "Please fill time !",
                        type: 'error', hideAfter: 20, showCloseButton: true
                    });
                    validateTime = false;
                }//end rtime
                else{
                    $("#time-group").removeClass("has-error");
                    validateTime = true;
                }

                //date
                if( $("#rdate").val().length <= 0){

                    $("#date-group").addClass("has-error");
                    $("#rdate").focus();
                    Messenger().post({
                        message: "Please fill Date !",
                        type: 'error', hideAfter: 20, showCloseButton: true
                    });
                    validateDate=false;
                }//end rtime
                else{
                    $("#date-group").removeClass("has-error");
                    validateDate=true;
                }

                //pax
                if( $("#rpax").val().length <= 0){
                    $("#pax-group").addClass("has-error");
                    $("#rpax").focus();
                    Messenger().post({
                        message: "Please fill Pax !",
                        type: 'error', hideAfter: 20, showCloseButton: true
                    });
                    validatePax=false;
                }//end rtime
                else{
                    $("#pax-group").removeClass("has-error");
                    validatePax=true;
                }

                if(validateTime == false || validateDate == false || validatePax == false || validateCustomer_firstname == false
                    || validateCustomer_lastname == false || validateCustomer_phonename == false || validateCustomer_emailname == false){
                    return 0;
                }

                //Preparation
                var progress = "<label class='label label-primary'><i class='"+"fa fa-spinner fa-spin"+"'></i> Saving reservation..</label>";
                $('#reservationNotification').empty();
                $('#reservationNotification').append(progress);


                disableForm();

                // Scope Variables
                var reservation ='';
                var ls_oid= $('#cust_ls_oid').val();

                reservation+= 'lr_cust_oid='+ls_oid;

                if(ls_oid.length>0){
                //    Just sent the customer oid and reservation details
                    reservation+= '&cust_sn='+$('#lira_customer_sn').val();
                    reservation+= '&cust_phone='+ $.trim($('#l_cust_handphone').html());

                }else {
                //    Add new customer and reservation details

                    reservation+= '&cust_firstname='+$('#cust_firstname').val();
                    reservation+= '&cust_lastname='+$('#cust_lastname').val();
                    reservation+= '&cust_phone='+$('#cust_handphone').val();
                    reservation+= '&cust_email='+$('#cust_email').val();

                }//end else

                //Reservation
                reservation+= '&res_time='+$('#rtime').val();
                reservation+= '&res_date='+$('#rdate').val();
                reservation+= '&res_pax='+$('#rpax').val();
                reservation+= '&res_table='+$('#floor_tables option:selected').val();
                reservation+= '&res_floor='+$('#floor_tables :selected').parent().attr('data-floor-id');
                reservation+= '&res_note='+$('#rnote').val();

                //console.log("reservation data: "+reservation);
                //return 0;

                $.ajax({
                type: "POST",
                url: app_path+'/reservation/ajax_save',
                data: reservation,
                success: function(response) {

                    //console.log("JSON: "+response);
                    //var result = $.parseJSON(response);

                    var result = JSON.parse(response);
                    //console.log("status:"+result.status);
                    if(result.status==true){

                        var success = "<label class='label label-success'>Reservation Complete <i class=''"+"fa fa-thumbs-up"+"'></i></label>";

                        $('#reservationNotification').empty();
                        $('#reservationNotification').append(success);

                        enableForm();
                        //$("#btnSave").prop('disabled', true);
                        $('#btnSave').html("<i class='fa fa-book'></i> New Reservation");
                    }
                    else{
                        var failed = "<label class='label label-danger'>Reservation Failed <i class='fa fa-exclamation'></i> </label>";

                        $('#reservationNotification').empty();
                        $('#reservationNotification').append(failed);

                        var msg = "<label class=''>"+result.error+"</label>" ;
                            msg +="<small>Error Type: "+result.errorType+"</small>"

                        Messenger().post({message: msg, type: 'error', hideAfter: 20, showCloseButton: true});
                        enableForm();
                    }//end else


                },
                error:function(_error){

                    enableForm();
                    var result = JSON.parse(_error);
                    console.log("Error: "+result);
                }
            });


            }//ene else

        });//end save

        //$("#btnNewReservation").click(function(){
        //
        //    $("#searchCustomer").focus();
        //    $("#searchCustomer").val("");
        //    $("#btnSave").prop('disabled', false);
        //    cancleAddCustomer();
        //    showCustomer();
        //    enableForm();
        //});//end function

        var clearShowCustomers= function(){
            $('#l_cust_firstname').text("");
            $('#l_cust_lastname').text("");
            $('#l_cust_handphone').text("");
            $('#l_cust_email').text("");
            $('#lira_customer_sn').val('');
            $('#cust_ls_oid').val('');
        }//end clearShowCustomer

        var enableForm = function(){
            $("input").prop('disabled', false);
            $("select").prop('disabled', false);
            $("button").prop('disabled', false);

        }

        var disableForm = function(){
            $("input").prop('disabled', true);
            $("select").prop('disabled', true);
            $("button").prop('disabled', true);
        }
    }//end reservation


    var user_index = $(".user_index").length;

    if(user_index>0){

        $('.remove_user').click(function(){

            var user_id = $(this).val();

            var r = confirm("Are you sure to delete user ?");

            if(r==true){

                $.ajax({
                    type: "POST",
                    url:app_path+'/user/ajax_delete',
                    //processData:false,
                    data:'user_id='+user_id,
                    success:function(_response){

                        //console.log("response: "+_response);
                        var result = JSON.parse(_response);

                        if(result.status==true){
                            Messenger().post({
                                message: "User is deleted",
                                type: 'info',
                                hideAfter: 7,
                                showCloseButton: true
                            });
                            $("#row_"+user_id).remove();
                        }else{

                            Messenger().post({
                                message: result.error,
                                type: 'error',
                                hideAfter: 15,
                                showCloseButton: true
                            });
                        }

                    },
                    error:function(_error){
                        Messenger().post({
                            message: result.error,
                            type: 'error',
                            hideAfter: 15,
                            showCloseButton: true
                        });
                    }
                });

            }//end if

        });//end remove_user
    }//end user


    //Customer Sync Form
    var customer_sync = $('.customer_sync').length;

    if(customer_sync > 0){

        $('#btnSync').click(function(){

            console.log("Sync started...");

            $("#btnSync").prop('disabled', true);
            $("#sync_title").css("display","block");
            $("#icon_sync").removeClass("fa-cog");
            $("#icon_sync").addClass("fa-circle-o-notch fa-spin");
            $('#sync_status').html("");


            $("#sync_title").html( "<i class='fa fa-spinner fa-spin'></i> "+ "Syncing Customers...");

            //return 0;
            //
            $.ajax({
                type: "GET",
                url:app_path+'/customer/sync/',
                success:function(response){

                    //console.log("response: "+response);
                    var result = JSON.parse(response);

                    //console.log(result);
                    if(result.status==true){
                        //$("#sync_title").css("display","block");
                        $("#sync_title").html( "<i class='fa fa-check'></i> "+ "Sync Complete");
                        console.log("Sync completed");

                        if(result.new_count==0){
                            $('#sync_status').html("No new customer found to sync.");

                        }else if (result.new_count>0){
                            $('#sync_status').html(result.new_count+" new customer synced.");
                        }else{
                            //console.log(result);
                        }

                    }else if(result.status==false){


                        //$("#sync_title").css("display","none");
                        $("#sync_title").html( "<i class='fa fa-exclamation'></i> "+ "Sync inomplete");
                        $('#sync_status').html("<label class='label label-danger'><i class='fa fa-exclamation-circle'></i> "+result.error+"</label>");
                        Messenger().post({
                            message: result.error,
                            type: 'error',
                            hideAfter: 15,
                            showCloseButton: true
                        });
                        syncCompleteAction();

                    }else{
                        console.log("Sync failed");
                    }
                    syncCompleteAction();

                },
                error:function(error){

                    //var array = $.map(error, function(value, index) {
                    //    console.log("Index: "+index+ " | Value: "+value );
                    //});

                    console.log("My Error: "+error);

                    Messenger().post({
                        message: error,
                        type: 'error',
                        hideAfter: 15,
                        showCloseButton: true
                    });
                    syncCompleteAction();
                }
            });

        });

        var syncCompleteAction=function(){
            //$("#sync_title").css("display","none");
            $("#icon_sync").addClass("fa-cog");
            $("#icon_sync").removeClass("fa-circle-o-notch fa-spin");
            $("#btnSync").prop('disabled', false);

            $("#btnSync").prop('disabled', false);
        }

    }//end if

});