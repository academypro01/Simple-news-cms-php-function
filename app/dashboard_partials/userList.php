<?php
pageGuard();

if(isset($_GET['count']) && filter_var($_GET['count'], FILTER_VALIDATE_INT)) {
    $count = abs(filter_var($_GET['count'], FILTER_SANITIZE_NUMBER_INT));
}else{
    $count = 1;
}
$prev = $count-1;
$next = $count+1;
$allUsers = getUsers($count);
?>
<div class="col-12">
    <h2>User List</h2>
    <?php sessionStatus(); ?>
    <small>Total Users: <?php echo $allUsers[1]; ?></small>
<div class="card">
              <div class="card-header d-flex justify-content-between">
                <h3 class="card-title">Users Data Table</h3>
                <div class='text-right w-75'>
                <a href="index.php?page=userCreate">
                    <button class='btn btn-primary mx-4'><ion-icon name="pencil"></ion-icon>Create</button>
                </a>
                </div>
              </div>
              <!-- /.card-header -->
              <div class="card-body">
                 
                <div id="example2_wrapper" class="dataTables_wrapper dt-bootstrap4">
                    <div class="row">
                        <div class="col-sm-12 col-md-6">
                        </div>
                        <div class="col-sm-12 col-md-6">

                        </div>
                    </div>
                    <div class="row">
                        <div class="col-sm-12">
                            <table id="example2" class="table text-center table-striped table-bordered table-hover dataTable dtr-inline" role="grid" aria-describedby="example2_info">
                <thead class='thead-dark text-center'>
                    <tr role="row">
                        <th class="sorting" tabindex="0" aria-controls="example2" rowspan="1" colspan="1" aria-label="Rendering engine: activate to sort column ascending">#</th>
                        <th class="sorting" tabindex="0" aria-controls="example2" rowspan="1" colspan="1" aria-label="Rendering engine: activate to sort column ascending">Photo</th>
                        <th class="sorting sorting_asc" tabindex="0" aria-controls="example2" rowspan="1" colspan="1" aria-label="Browser: activate to sort column descending" aria-sort="ascending">Firstname</th>
                        <th class="sorting" tabindex="0" aria-controls="example2" rowspan="1" colspan="1" aria-label="Platform(s): activate to sort column ascending">Lastname</th>
                        <th class="sorting" tabindex="0" aria-controls="example2" rowspan="1" colspan="1" aria-label="Engine version: activate to sort column ascending">Username</th>
                        <th class="sorting" tabindex="0" aria-controls="example2" rowspan="1" colspan="1" aria-label="CSS grade: activate to sort column ascending">Edit</th>
                        <th class="sorting" tabindex="0" aria-controls="example2" rowspan="1" colspan="1" aria-label="CSS grade: activate to sort column ascending">Delete</th>
                    </tr>
                  </thead>
                  <tbody>
                      <?php
                      $counter = 0;
                        while($row = mysqli_fetch_assoc($allUsers[0])):
                            $counter++;
                      ?>
                    <tr class="odd">
                        <td class="dtr-control" tabindex="0"><?php echo $counter; ?></td>
                        <td class="sorting_1 align-baseline align-middle"><img class='rounded circle' style='width:50px !important' src="<?php echo ($row['photo'] != NULL) ? $row['photo'] : '../public/images/default_user_profile.png'; ?>"></td>
                        <td class="align-baseline align-middle"><?php echo $row['firstname']; ?></td>
                        <td class="align-baseline align-middle"><?php echo $row['lastname']; ?></td>
                        <td class="align-baseline align-middle"><?php echo $row['username']; ?></td>
                        <td class="align-baseline align-middle">
                            <a href="index.php?page=userEdit&user_id=<?php echo $row['id']; ?>" class='text-primary '>
                            <ion-icon class='text-primary' name="create" title='test'></ion-icon>Edit
                            </a>
                        </td>
                        <td class="align-baseline align-middle">
                            <a href="index.php?page=userDelete&user_id=<?php echo $row['id']; ?>" class='text-danger '>
                            <ion-icon class='text-danger' name="skull"></ion-icon>Delete
                            </a>
                        </td>
                    </tr>
                    <?php
                    endwhile;
                    ?>
                </tbody>
                </table>
            </div>
        </div>
        <div class="row">
            <div class="col-sm-12 col-md-5">
                <div class="dataTables_info" id="example2_info" role="status" aria-live="polite">Page: <?php echo $count; ?></div>
            </div>
            <div class="col-sm-12 col-md-7">
                    <div class="dataTables_paginate paging_simple_numbers" id="example2_paginate">
                        <ul class="pagination">
                            <li class="paginate_button page-item previous <?php echo ($prev < 1) ? 'disabled' : "";  ?>" id="example2_previous">
                                <a href="index.php?page=userList&count=<?php echo $prev; ?>" aria-controls="example2" data-dt-idx="0" tabindex="0" class="page-link">Previous</a>
                            </li>
                            <?php
                            for($i=1; $i<=$allUsers[2]; $i++):
                            ?>
                            <li class="paginate_button page-item <?php 
                            if($i == $count) {
                                echo 'active';
                            }
                            ?>">
                                <a href="index.php?page=userList&count=<?php echo $i; ?>" aria-controls="example2" data-dt-idx="1" tabindex="0" class="page-link"><?php echo $i; ?></a>
                            </li>
                            <?php
                            endfor;
                            ?>
                            <li class="paginate_button page-item next <?php 
                            if($count >= $allUsers[2]) {
                                echo 'disabled';
                            }
                            ?>" id="example2_next">
                                <a href="index.php?page=userList&count=<?php echo $next; ?>" aria-controls="example2" data-dt-idx="7" tabindex="0" class="page-link">Next</a>
                            </li>
                        </ul>
                    </div>
                </div>
            </div>
        </div>
              </div>
              <!-- /.card-body -->
            </div>
</div>