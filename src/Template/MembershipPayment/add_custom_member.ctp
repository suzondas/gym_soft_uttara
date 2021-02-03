<?php
echo $this->Html->css('select2.css');
echo $this->Html->script('select2.min');
?>
<div class="container">
<br>
<br>
    <div class="row text-right">

        <div class="col-sm-8"><a href="income-list"><input type="button" class="btn btn-warning" value="Income List"/></a></div>
    </div>
    <h1>
        Add Custom Member
        <hr>
    </h1>
    <form class="form-group container" method="post" action="add_custom_member">
        <div class="row">
            <label class="col-sm-2 control-label">Id</label>
            <div class="col-sm-8"><input class="form-control" type="number" name="custom_member_id" value="<?php echo $member_id; ?>"/> </div>
        </div>
        <div class="row">
            <label class="col-sm-2 control-label">First Name</label>
            <div class="col-sm-8"><input class="form-control" name="first_name"/> </div>
        </div>
        <div class="row">
            <label class="col-sm-2 control-label">Last Name</label>
            <div class="col-sm-8"><input class="form-control" name="last_name"/> </div>
        </div>
        <input class="btn btn-success" type="submit" value="Submit" />
    </form>
</div>