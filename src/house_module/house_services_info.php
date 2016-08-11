<?php


?>
<ul class="unstyled span10">
    <?php if (isset($_GET['house_id'])) {
        $id = $_GET['house_id'];
        $services = $house->selectQuery('house_services_view', '*', " house_id = '" . $id . "'");
       // var_dump($services);
        ?>
        <table class="table table-stripped">
            <thead>

            <tr>
                <th>ID</th>
                <th>Service Option</th>
                <th>Amount</th>
            </tr>
            </thead>
            <tbody>
            <?php
            if (count($services)){
                $count = 1;
                foreach ($services as $service){

            ?>
                    <tr>
                        <td><?php echo $count; ?></td>
                        <td><?php echo $service['service_option']; ?></td>
                        <td><?php echo $service['price']; ?></td>
                    </tr>
            <?php $count++; }?>
            </tbody>
        </table>
        <div class="clearfix"></div>
    <?php }}?>

</ul>

