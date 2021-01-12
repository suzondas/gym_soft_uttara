<?php
echo $this->Html->css('bootstrap-multiselect');
echo $this->Html->script('bootstrap-multiselect');
?>
<script type="text/javascript">
    $(document).ready(function () {

        $('#activity').multiselect({
            includeSelectAllOption: true,
            buttonWidth: '400px'
        });
        $("#sDate").datepicker("option", "dateFormat", "yy-mm-dd");
        $("#eDate").datepicker("option", "dateFormat", "yy-mm-dd");

    });
</script>


<section class="content">
    <br>
    <div class="col-md-12 box box-default">
        <div class="box-header">
            <section class="content-header">
                <h1>
                    <?php echo $membership_name; ?>
                    <small><?php echo __("Attendance Report For Corporate Members"); ?></small>
                </h1>
                <ol class="breadcrumb">
                    <a href="<?php echo $this->Gym->createurl("Membership", "membershipList"); ?>"
                       class="btn btn-flat btn-custom"><i class="fa fa-bars"></i> <?php echo __("Membership List"); ?>
                    </a>
                </ol>
            </section>
        </div>
        <hr>
        <div class="box-body">
            <div class="row">
                <?= $this->Form->create("activity", ["class" => "validateForm", "target" =>"_blank"]); ?>
                <input type="hidden" name="class_id" value="0">
                <div class="form-group col-md-5">
                    <div class="row">
                        <div class="col-md-6">
                            <label class="control-label" for="sDate"><?php echo __("Select Start Date"); ?></label>
                            <input id="sDate" class="form-control validate[required] date" type="text"
                                   value="" data-date-format='yy-mm-dd'
                                   name="sDate">
                        </div>
                        <div class="col-md-6">
                            <label class="control-label" for="eDate"><?php echo __("Select End Date"); ?></label>
                            <input id="eDate" class="form-control validate[required] date" type="text"
                                   value="" data-date-format='yy-mm-dd'
                                   name="eDate">
                        </div>
                    </div>
                </div>
                <div class="form-group col-md-3 button-possition">
                    <label for="curr_date">&nbsp;</label>
                    <input type="submit" value="<?php echo __("View Attendance"); ?>" name="submit"
                           class="btn btn-flat btn-success">
                </div>
                <?= $this->Form->end(); ?>
            </div>
            <hr>
            <div class="row">
                <table class="table table-striped">
                    <thead>
                    <th>S.L.</th>
                    <th>ID</th>
                    <th>Name</th>
                    </thead>
                    <tbody>
                    <?php
                    for ($i = 0; $i < sizeof($usersArray); $i++) {
                        echo "<tr>";
                        echo "<td>" . ($i + 1) . "</td>";
                        echo "<td>" . $usersArray[$i][0] . "</td>";
                        echo "<td>" . $usersArray[$i][1] . "</td>";
                        echo "</tr>";
                    }
                    ?>
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</section>