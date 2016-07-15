<?php
    require_once 'src/models/Accounts.php';
    $acc = new Accounts();

    if(App::isAjaxRequest()) {
        $prop->getBranchByBranchId($_POST['edit_id']);
    }else{
        set_title('Add Bank Branch');
        /**
         * Set the page layout that will be used
         */
        set_layout("dt-layout.php", array(
            'pageSubTitle' => 'Bank Branches',
            'pageSubTitleText' => 'Allows one to manage bank branches',
            'pageBreadcrumbs' => array(
                array('url' => 'index.php', 'text' => 'Home'),
                array('text' => 'ACCOUNTS'),
                array('text' => 'Add Branch')
            ),
            'pageWidgetTitle' => 'Branch Details'
        ));

?>
    <div class="widget">
        <div class="widget-title"><h4><i class="icon-reorder"></i> Bank Branches</h4>
		<span class="actions">
			<a href="#add_branch" class="btn btn-small btn-primary" data-toggle="modal"><i class="icon-plus"></i> Add Bank</a>
		</span>
        </div>
        <div class="widget-body">
            <?php
            $acc->splash('acc');
            (isset($_SESSION['warnings'])) ? $prop->displayWarnings('warnings') : '';
            ?>
            <table id="table1" class="table table-bordered">
                <thead>
                    <tr>
                        <th>Branch#</th>
                        <th>Branch Name</th>
                        <th>Date Created</th>
                        <th>Status</th>
                        <th>Update</th>
                        <th>Delete</th>
                    </tr>
                </thead>
                <tbody>
                <?php
                $acc = $acc->getAllBranch();
                if(count($branches)){
                    foreach ($branches as $branch){
                        ?>
                        <tr>
                            <td><?php echo $branch['branch_id']; ?></td>
                            <td><?php echo $branch['branch_name']; ?></td>
                            <td><?php echo $branch['branch_code']; ?></td>
                            <td><?php echo $branch['status']; ?></td>
                            <td><a href="#update_branch" class="btn btn-mini btn-warning edit_branch" edit-id="<?php echo $branch['branch_id']; ?>" data-toggle="modal"><i class="icon-edit"></i> Edit</a> </td>
                            <td><a href="#del_prop" class="btn btn-mini btn-danger del_prop" edit-id="<?php echo $branch['branch_id']; ?>" data-toggle="modal"><i class="icon-trash"></i> Delete</a></td>
                        </tr>
                    <?php }} ?>
                </tbody>
            </table>
            <div class="clearfix"></div>
        </div>
    </div>

    <!-- The Modals -->
    <form action="" method="post">
        <div id="add_branch" class="modal hide fade" tabindex="-1" role="dialog" aria-labelledby="myModalLabel1" aria-hidden="true">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-hidden="true">×</button>
                <h3 id="myModalLabel1">Add Bank Branch </h3>
            </div>
            <div class="modal-body">
                <div class="row-fluid">
                    <label for="branch_name">Name:</label>
                    <input type="text" name="branch_name" class="span12" value="<?php echo $branch->get('branch_name'); ?>"/>
                </div>

                <div class="row-fluid">
                    <label for="branch_code">Branch Code:</label>
                    <input type="text" name="payment_code" class="span12" value="<?php echo $prop->get('branch-code'); ?>"/>
                </div>
                <div class="row-fluid">
                    <label for="created_at">Date:</label>
                    <input type="text" name="created_at" class="span12" value="<?php
                            if(isset($_POST['created_at'])){
                                echo $_POST['created_at'];
                            }else{
                                echo date('m/d/Y');
                            }
                            ?>"/>
                </div>

            </div>
            <!-- the hidden fields -->
            <input type="hidden" name="action" value="add_branch"/>
            <div class="modal-footer">
                <?php createSectionButton($_SESSION['role_id'], $_GET['num'], 'Clo649'); ?>
                <?php createSectionButton($_SESSION['role_id'], $_GET['num'], 'Sav650'); ?>
            </div>
        </div>
    </form>

    <form action="" method="post">
        <div id="update_branch" class="modal hide fade" tabindex="-1" role="dialog" aria-labelledby="myModalLabel1" aria-hidden="true">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-hidden="true">×</button>
                <h3 id="myModalLabel1">Update Branch </h3>
            </div>
            <div class="modal-body">
                <div class="row-fluid">
                    <label for="branch_name">Branch Name:</label>
                    <input type="text" name="ed_plot_name" id="branch_name" class="span12" value="<?php echo $prop->get('branch_name'); ?>"/>
                </div>
                <div class="row-fluid">
                    <label for="units">Branch Code:</label>
                    <input type="text" name="branch_code" id="branch_code" class="span12" value="<?php echo $prop->get('branch_code'); ?>"/>
                </div>
                <div class="row-fluid">
                    <label for="payment_code">Date Created:</label>
                    <input type="text" name="created_at" id="created_at" class="span12" value="<?php echo $prop->get('created_at'); ?>"/>
                </div>
            </div>
            <!-- the hidden fields -->
            <input type="hidden" name="action" value="edit_branch"/>
            <input type="hidden" name="edit_id" id="edit_id"/>
            <div class="modal-footer">
                <?php createSectionButton($_SESSION['role_id'], $_GET['num'], 'Can651'); ?>
                <?php createSectionButton($_SESSION['role_id'], $_GET['num'], 'Sav652'); ?>
            </div>
        </div>
    </form>

    <form action="" method="post">
        <div id="del_branch" class="modal hide fade" tabindex="-1" role="dialog" aria-labelledby="myModalLabel1" aria-hidden="true">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-hidden="true">×</button>
                <h3 id="myModalLabel1">Delete Branch </h3>
            </div>
            <div class="modal-body">
                <p>Are you sure you want to delete the selected branch?</p>
            </div>
            <!-- the hidden fields -->
            <input type="hidden" name="action" value="delete_branch"/>
            <input type="hidden" name="delete_id" id="delete_id"/>
            <div class="modal-footer">
                <?php createSectionButton($_SESSION['role_id'], $_GET['num'], 'No653'); ?>
                <?php createSectionButton($_SESSION['role_id'], $_GET['num'], 'Yes654'); ?>
            </div>
        </div>
    </form>
    <?php set_js(array('src/js/branch.js')); } ?>