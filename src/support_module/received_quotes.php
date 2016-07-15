<?php
    require_once 'src/models/ReceivedQuotes.php';
    $quote = new ReceivedQuotes();

    if(App::isAjaxRequest()){
        $quote->getAllQuotesInJson();
    }else{
        set_title('Received Quotes');
        set_layout("dt-layout.php", array(
            'pageSubTitle' => 'Received Quotes',
            'pageSubTitleText' => '',
            'pageBreadcrumbs' => array (
                array ( 'url'=>'index.php', 'text'=>'Home' ),
                array ( 'text'=>'Maintenance' ),
                array ( 'text'=>'Received Quotes' )
            )
        ));
?>
<div class="widget">
    <div class="widget-title"><h4><i class="icon-reorder"></i> All Received Quotes</h4></div>
    <div class="widget-body form">
        <table id="received_quotes" class="table table-bordered">
            <thead>
                <tr>
                    <th>Quote#</th>
                    <th>Contractor</th>
                    <th>Bid Amount</th>
                    <th>Bid Date</th>
                    <th>Bid Status</th>
                    <th>Job Status</th>
                </tr>
            </thead>
        </table>
        <div class="clearfix"></div>
    </div>
</div>
<?php set_js(array('src/js/rec_quotes.js'));} ?>
