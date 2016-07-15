<?php
include_once('src/models/House.php');
$Houses = new House;

if(App::isAjaxRequest()){
   // $Houses->getQuoteDataFromHousId($_POST['quote_id']);
}else {
    set_layout("dt-layout.php", array(
        'pageSubTitle' => 'House Attributes',
        'pageSubTitleText' => '',
        'pageBreadcrumbs' => array(
            array('url' => 'index.php', 'text' => 'Home'),
            array('text' => 'Houses'),
            array('text' => 'House Attributes')
        )
    ));

    ?>
    <div class="widget">
        <div class="widget-title"><h4><i class="icon-comments-alt"></i> House Attributes</h4>
	    <span class="actions">
			<a href="#add-quotation" data-toggle="modal" class="btn btn-small btn-primary"><i class="icon-plus"></i>Add an Attribute</a>
		</span>
        </div>
        <div class="widget-body form">
<!--            --><?php
//            if (isset($_SESSION['quotes'])) {
//                echo $_SESSION['quotes'];
//                unset($_SESSION['quotes']);
//            }
            ?>

            <table id="table1" style="width: 100%" class="table table-bordered">
                <thead>
                <tr>
                    <th>#ID</th>
                    <th>NAME</th>
                    <th>Edit</th>
                    <th>Delete</th>


                </tr>
                </thead>
                <tbody>

                    <tr>
                        <td></td>
                        <td></td>
                        <td></td>
                        <td></td>

                    </tr>


                </tbody>

            </table>
            <div class="clearfix"></div>
        </div>
    </div>

    <!-- The Modals -->
    <form action="" method="post">
        <div id="add-support" class="modal hide fade" tabindex="-1" role="dialog" aria-labelledby="myModalLabel1"
             aria-hidden="true">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-hidden="true">×</button>
                <h3 id="myModalLabel1">Add Quotation</h3>
            </div>
            <div class="modal-body">
                <div class="row-fluid">

                </div>
            </div>
            <!-- the hidden fields -->
            <input type="hidden" name="" id="support_ticket_id"/>
            <input type="hidden" name="action" value="assign_staff">
            <div class="modal-footer">
                <?php createSectionButton($_SESSION['role_id'], $_GET['num'], 'Can584'); ?>
                <?php createSectionButton($_SESSION['role_id'], $_GET['num'], 'Sav583'); ?>
            </div>
        </div>
    </form>

    <form action="" method="post">
        <div id="reassing_staff" class="modal hide fade" tabindex="-1" role="dialog" aria-labelledby="myModalLabel1"
             aria-hidden="true">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-hidden="true">×</button>
                <h3 id="myModalLabel1">Reassign Staff</h3>
            </div>
            <div class="modal-body">
                <div class="row-fluid">

                </div>
            </div>
            <!-- the hidden fields -->
            <input type="hidden" name="origin_staff" id="origin_staff"/>
            <input type="hidden" name="support_ticket_id" id="supp_ticket_id"/>
            <input type="hidden" name="action" value="">
            <div class="modal-footer">
                <?php createSectionButton($_SESSION['role_id'], $_GET['num'], 'Can584'); ?>
                <?php createSectionButton($_SESSION['role_id'], $_GET['num'], 'Sav583'); ?>
            </div>
        </div>
    </form>

    <form action="" method="post">
        <div id="add-quotation" class="modal hide fade" tabindex="-1" role="dialog" aria-labelledby="myModalLabel1"
             aria-hidden="true">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-hidden="true">×</button>
                <h3 id="myModalLabel1"><i class="icon-comments"></i> Add Quotation</h3>
            </div>
            <div class="modal-body">
                <div class="row-fluid">
                    Quation

                </div>

                <div class="row-fluid">
                    <label for="bid_amount" class="control-label">Bid Amount</label>
                    <input type="number" name="bid_amount" class="span12" required="true">
                </div>


            </div>
            <!-- the hidden fields -->
            <input type="hidden" name="action" value="add_quotation"/>
            <div class="modal-footer">
                <?php createSectionButton($_SESSION['role_id'], $_GET['num'], 'Clo656'); ?>
                <?php createSectionButton($_SESSION['role_id'], $_GET['num'], 'Sav655'); ?>
            </div>
        </div>
    </form>
    <!-- modal for edit -->
    <form action="" method="post">
        <div id="edit-quotation" class="modal hide fade" tabindex="-1" role="dialog" aria-labelledby="myModalLabel1"
             aria-hidden="true">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-hidden="true">×</button>
                <h3 id="myModalLabel1"><i class="icon-comments"></i> Edit Quotation</h3>
            </div>
            <div class="modal-body">
                <div class="row-fluid">
                    Quotation

                </div>

                <div class="row-fluid">
                    <label for="bid_amount" class="control-label">Bid Amount</label>
                    <input type="number" name="bid_amount" id="bid_amount" class="span12" required="true">
                </div>


            </div>
            <!-- the hidden fields -->
            <input type="hidden" name="action" value="edit_quotation"/>
            <input type="hidden" name="edit_id" id="edit_id"/>
            <div class="modal-footer">
                <?php createSectionButton($_SESSION['role_id'], $_GET['num'], 'Clo650'); ?>
                <?php createSectionButton($_SESSION['role_id'], $_GET['num'], 'Sav649'); ?>
            </div>
        </div>
    </form>

    <!-- delete modal -->
    <form action="" method="post">
        <div id="delete_quotaion" class="modal hide fade" tabindex="-1" role="dialog" aria-labelledby="myModalLabel1"
             aria-hidden="true">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-hidden="true">×</button>
                <h3 id="myModalLabel1">Delete Quotation</h3>
            </div>
            <div class="modal-body">
                <p>Are you sure you want to delete the quotation?</p>
            </div>
            <!-- hidden fields -->
            <input type="hidden" name="action" value="delete_quotation"/>
            <input type="text" id="delete_id" name="delete_id"/>
            <div class="modal-footer">
                <?php createSectionButton($_SESSION['role_id'], $_GET['num'], 'No652'); ?>
                <?php createSectionButton($_SESSION['role_id'], $_GET['num'], 'Yes651'); ?>
            </div>
        </div>
    </form>
    <? // set_js(array('src/js/quotation.js')); }
}?>