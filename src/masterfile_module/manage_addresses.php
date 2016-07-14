<?php
/**
 * Created by PhpStorm.
 * User: JOEL
 * Date: 7/13/2016
 * Time: 11:57 AM
 */
	if(isset($_GET['mf_id'])){
        $mf_id = $_GET['mf_id'];
        $query = "SELECT a.*, c.county FROM address a
		LEFT JOIN county_ref c ON c.mf_id=a.mf_id
		WHERE a.mf_id = '".$mf_id."' ";
    }

	if(isset($_SESSION['done-deal'])){
        echo $_SESSION['done-deal'];
        unset($_SESSION['done-deal']);
    }

?>

    <!-- delete shd not have data toggle -->
    <a href="#add_address" data-toggle="modal" class="btn btn-small btn-primary tooltips m-wrap" data-trigger="hover" data-original-title="Add New Address"><i class="icon-plus"></i></a>&nbsp;
    <a href="#edit_address" id="edit_btn" class="btn btn-small btn-warning tooltips m-wrap" data-trigger="hover" data-original-title="Edit Address"><i class="icon-edit"></i></a>&nbsp;
    <a href="#delete_address" id="del_btn" class="btn btn-small btn-danger tooltips m-wrap" data-trigger="hover" data-original-title="Delete Address"><i class="icon-trash"></i></a>

    <table class="live_table table table-bordered">
        <thead>
        <tr>
            <th>Address#</th>
            <th>Postal Address</th>
            <th>County</th>
            <th>Town</th>
            <th>Ward</th>
            <th>Street</th>
            <th>Building</th>
            <th>Type</th>
        </tr>
        </thead>
        <tbody>
        <?php
        $result = $masterfile->getCustomerAddresses($_GET['mf_id']);
        while ($rows = get_row_data($result)) {
            ?>
            <tr>
                <td><?=$rows['address_id']; ?></td>
                <td><?=$rows['postal_address']; ?></td>
                <td><?=$rows['county_name']; ?></td>
                <td><?=$rows['town']; ?></td>
                <td><?=$rows['ward']; ?></td>
                <td><?=$rows['street']; ?></td>
                <td><?=$rows['building']; ?></td>
                <td><?=$rows['address_type_name']; ?></td>
            </tr>
        <?php } ?>
        </tbody>
    </table>

    <!-- begin add address modal -->
    <form action="" method="post">
        <div id="add_address" class="modal hide fade" tabindex="-1" role="dialog" aria-labelledby="myModalLabel1" aria-hidden="true">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-hidden="true">×</button>
                <h3 id="myModalLabel1">Add New Address</h3>
            </div>
            <div class="modal-body">
                <div class="row-fluid">
                    <input type="hidden" name="mf_id" value="<?=$_GET['mf_id']; ?>" class="span12" required>
                </div>
                <div class="row-fluid">
                    <label for="postal_address">Postal Address:</label>
                    <input type="text" name="postal_address" value="" class="span12" required>
                </div>
                <div class="row-fluid">
                    <label for="county">County:</label>
                    <select name="county" class="span12" id="select2_sample79" required>
                        <option value="">--Choose County--</option>
                        <?php
                        $query = "SELECT * From county_ref ORDER BY county_name ASC";
                        $options = run_query($query);
                        while($row = get_row_data($options)){
                            $county_ref_id = $rows['county_ref_id'];
                            $county_name = $rows['county_name'];
                            ?>
                            <option value="<?=$row['county_ref_id']; ?>" <?=($row['county_ref_id'] == $county_name) ? 'selected' : ''; ?> ><?=$row['county_name']; ?></option>
                            <?php
                        }
                        ?>
                    </select>
                </div>
                <div class="row-fluid">
                    <label for="address_type_id">Address Type:</label>
                    <select name="address_type_id" class="span12" required>
                        <option value="">--Choose Address type--</option>
                        <?php
                        $query = "SELECT * From address_types ORDER BY address_type_name ASC";
                        $options = run_query($query);
                        while($row = get_row_data($options)){
                            $address_type_id = $rows['address_type_id'];
                            $address_type_name = $rows['address_type_name'];
                            ?>
                            <option value="<?=$row['address_type_id']; ?>" <?=($row['address_type_id'] == $address_type_name) ? 'selected' : ''; ?> ><?=$row['address_type_name']; ?></option>
                            <?php
                        }
                        ?>
                    </select>
                </div>
                <div class="row-fluid">
                    <label for="town">Town:</label>
                    <input type="text" name="town" value="" class="span12" required>
                </div>
                <div class="row-fluid">
                    <label for="ward">Ward:</label>
                    <input type="text" name="ward" value="" class="span12" required>
                </div>
                <div class="row-fluid">
                    <label for="street">Street:</label>
                    <input type="text" name="street" value="" class="span12" required>
                </div>
                <div class="row-fluid">
                    <label for="building">Buiding:</label>
                    <input type="text" name="building" value="" class="span12" required>
                </div>
                <div class="row-fluid">
                    <label for="phone_no">Phone No:</label>
                    <input type="integer" name="phone_no" value="" class="span12" required>
                </div>
            </div>
            <!-- the hidden fields -->
            <input type="hidden" name="action" value="add_address"/>
            <div class="modal-footer">
                <?php createSectionButton($_SESSION['role_id'], $_GET['num'], 'Clo437'); ?>
                <?php createSectionButton($_SESSION['role_id'], $_GET['num'], 'Sav438'); ?>
            </div>
        </div>
    </form>
    <!-- end add address modal -->

    <!-- begin of edit modal -->
    <form action="" method="post">
        <div id="edit_address" class="modal hide fade" tabindex="-1" role="dialog" aria-labelledby="myModalLabel1" aria-hidden="true">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-hidden="true">×</button>
                <h3 id="myModalLabel1">Edit Address</h3>
            </div>
            <div class="modal-body">
                <div class="row-fluid">
                    <label for="postal_address">Postal Address:</label>
                    <input type="text" name="postal_address" id="postal_address" value="" class="span12" required>
                </div>
                <br>
                <div class="row-fluid">
                    <!-- <label for="county">County:</label> -->
                    <select name="county" class="span12" id="select2_sample80" required>
                        <option value="">--select county--</option>
                        <?php
                        $query = "SELECT * FROM county_ref ORDER BY county_name ASC";
                        if ($data = run_query($query))
                        {
                            while ( $fetch = get_row_data($data) )
                            {
                                ?>
                                <option value="<?=$fetch['county_ref_id']; ?>" <?php if($fetch['county_ref_id'] === $county_ref_id){ echo 'selected'; } ?>><?php echo $fetch['county_name']; ?></option>";
                                <?php
                            }
                        }
                        ?>
                    </select>
                </div>
                <br>
                <div class="row-fluid">
                    <!-- <label for="address_type_id">Address Type:</label> -->
                    <select name="address_type_id" class="span12" id="select2_sample81" required>
                        <option value="">--select address--</option>
                        <?php
                        $query = "SELECT * FROM address_types ORDER BY address_type_name ASC";
                        if ($data = run_query($query))
                        {
                            while ( $fetch = get_row_data($data) )
                            {
                                ?>
                                <option value="<?=$fetch['address_type_id']; ?>" <?php if($fetch['address_type_id'] === $address_type_id){ echo 'selected'; } ?>><?php echo $fetch['address_type_name']; ?></option>";
                                <?php
                            }
                        }
                        ?>
                    </select>
                </div>
                <br>
                <div class="row-fluid">
                    <label for="town">Town:</label>
                    <input type="text" name="town" id="town" value="" class="span12" required>
                </div>
                <div class="row-fluid">
                    <label for="ward">Ward:</label>
                    <input type="text" name="ward" id="ward" class="span12" required>
                </div>
                <div class="row-fluid">
                    <label for="street">Street:</label>
                    <input type="text" name="street" id="street" class="span12" required>
                </div>
                <div class="row-fluid">
                    <label for="building">Buiding:</label>
                    <input type="text" name="building" id="building" class="span12" required>
                </div>
                <div class="row-fluid">
                    <label for="house_no">House No:</label>
                    <input type="text" name="house_no" id="house_no" class="span12" required>
                </div>
                <div class="row-fluid">
                    <label for="phone_no">Phone No:</label>
                    <input type="integer" name="phone_no" id="phone_no" class="span12" required>
                </div>
            </div>
            <!-- the hidden fields -->
            <input type="hidden" name="action" value="edit_address"/>
            <input type="hidden" id="edit_id" name="edit_id"/>
            <div class="modal-footer">
                <?php createSectionButton($_SESSION['role_id'], $_GET['num'], 'Can439'); ?>
                <?php createSectionButton($_SESSION['role_id'], $_GET['num'], 'Sav440'); ?>
            </div>
        </div>
    </form>
    <!-- end of edit modal -->

    <!-- delete modal -->
    <form action=""  method="post">
        <div id="delete_address" class="modal hide fade" tabindex="-1" role="dialog" aria-labelledby="myModalLabel1" aria-hidden="true">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-hidden="true">×</button>
                <h3 id="myModalLabel1">Delete Address</h3>
            </div>
            <div class="modal-body">
                <p>Are you sure you want to delete the address (<span id="postal_addr"></span>)?</p>
            </div>

            <input type="hidden" name="action" value="delete_address"/>
            <input type="hidden" id="delete_id" name="delete_id"/>
            <div class="modal-footer">
                <?php createSectionButton($_SESSION['role_id'], $_GET['num'], 'No441'); ?>
                <?php createSectionButton($_SESSION['role_id'], $_GET['num'], 'Yes442'); ?>
            </div>
        </div>
    </form>
    <!-- end of delete modal -->

    <!-- js script -->
<? set_js(array('src/js/manage_address.js')); ?>