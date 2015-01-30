
<section class="page-content">
    <div class="content">


    <header class="page-title">
        <i class="fa fa-user"></i> <h3 style="width: 50%;"><i class="fa fa-users"></i> <?php echo $_page_title;?></h3>
        <a class="btn btn-primary btn-sm pull-right" href="<?php echo base_url().'user/new'?>" role="button">Add User</a>
    </header>


    <div class="grid simple horizontal green">
        <div class="grid-title">
            Users List
        </div>
            <div class="grid-body">

                <table class="table table-advance table-hover table-bordered">
                <thead>
                    <tr>
                        <th><i class=" fa fa-edit"></i> Action</th>
                        <th>Name</th>
                        <th>Username</th>
                        <th>User Email</th>
                        <th>Status</th>
                    </tr>
                </thead>
                <tbody>

                    <?php
                    foreach($_list as $row): ?>
                        <tr id="row_<?php echo $row['user_sn'];?>">
                            <td>
                                <div class="btn-group">

                                    <a href="<?php echo base_url().'user/edit/'.$row['user_sn'];?>" title="Edit"
                                       class="btn btn-primary btn-mini"><i class="fa fa-pencil"></i></a>

                                    <button value="<?php echo $row['user_sn'];?>" title="Remove"
                                            class="btn remove_user btn-danger  btn-mini">
                                        <i class="fa fa-trash-o "></i></button>
                                </div>
                            </td>

                            <td><a href="#">
                                    <span class="user_name"><?php echo $row['user_name'];?></span></a></td>
                            <td><?php echo $row['username'];?></td>
                            <td><?php echo $row['user_email'];?></td>
                            <td>
                                <?php echo $row['user_status']; ?>
                            </td>
                        </tr>


                        <?php
                    endforeach;
                    ?>
                </tbody>
            </table>
            </div>
    </div><!--end grid-->

    </div><!--end content-->
</section>

<section class="panel">
  <div class="panel-body">
      <div class="text-center">
          <?php echo $this->pagination->create_links();?>
      </div>
  </div>

</section>

<?php /*
<!-- Modal -->
<div class="modal fade" id="remove_modal" tabindex="-1" role="dialog" 
     aria-labelledby="myModalLabel" aria-hidden="true">
  <div class="modal-dialog">
    <div class="modal-content">
      <div class="modal-header">
        <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
        <h4 class="modal-title" id="myModalLabel">Remove user</h4>
      </div>
      <div class="modal-body">
          Are you sure to delete <strong><span id="remove_name"></span></strong> User?
          <input type="hidden" value="" id="remove_id">
      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
        <button type="button" id="btn_delete" class="btn btn-danger">Remove</button>
      </div>
    </div><!-- /.modal-content -->
  </div><!-- /.modal-dialog -->
</div><!-- /.modal -->
*/?>