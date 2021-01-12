<?php
echo $this->Html->css('select2.css');
echo $this->Html->script('select2.min');
?>
<script>
$(document).ready(function() {
$(".mem_list").select2();
$(".date").datepicker( "option", "dateFormat", "<?php echo $this->Gym->dateformat_PHP_to_jQueryUI($this->Gym->getSettings("date_format")); ?>" );
var box_height = $(".box").height();
var box_height = box_height + 100 ;
$(".content-wrapper").css("height",box_height+"px");
});
</script>
<section class="content">
	<br>
	<div class="col-md-12 box box-default">		
		<div class="box-header">
			<section class="content-header">
			  <h1>
				<i class="fa fa-leaf"></i>
				<?php echo $title;?>
				<small><?php echo __("Nutrition Schedule");?></small>
			  </h1>
			  <ol class="breadcrumb">
				<a href="<?php echo $this->Gym->createurl("GymNutrition","nutritionList");?>" class="btn btn-flat btn-custom"><i class="fa fa-bars"></i> <?php echo __("Nutrition Schedule List");?></a>
			  </ol>
			</section>
		</div>
		<hr>
		<div class="box-body">
		<?php
			echo $this->Form->create("assignWorkout",["class"=>"validateForm form-horizontal","role"=>"form"]);
		?>
		<div class='form-group'>
			<label class="control-label col-md-3" for="email"><?php echo __("Select Member");?><span class="text-danger"> *</span></label>
			<div class="col-md-6">
				<?php 
					echo $this->Form->select("user_id",$members,["default"=>($edit)?$this->request->params["pass"]:"","empty"=>__("Select Member"),"class"=>"mem_list","required"=>"true"]);
				?>
			</div>
			<div class="col-md-3">
				<a href="<?php echo $this->request->base;?>/GymMember/addMember" class="btn btn-default btn-flat"><?php echo __("Add Member");?></a>
			</div>
		</div>	
		<div class='form-group'>
			<label class="control-label col-md-3" for="email"><?php echo __("Start Date");?><span class="text-danger"> *</span></label>
			<div class="col-md-6">
				<?php 
					echo $this->Form->input("",["label"=>false,"name"=>"start_date","class"=>"date validate[required] form-control"]);
				?>
			</div>	
		</div>
		<div class='form-group'>
			<label class="control-label col-md-3" for="email"><?php echo __("End Date");?><span class="text-danger"> *</span></label>
			<div class="col-md-6">
				<?php 
					echo $this->Form->input("",["label"=>false,"name"=>"expire_date","class"=>"date validate[required] form-control"]);
				?>
			</div>	
		</div>
		<div class="form-group">
			<label class="col-sm-1 control-label"></label>
			<div class="col-sm-10 border">
				<br>
				<div class="col-md-3">					
					<label class="list-group-item bg-default"><?php echo __("Select Days");?></label>
					<?php foreach ($this->Gym->days_array() as $key=>$name){?>
					<div class="checkbox">
					<label><input type="checkbox" value="" name="day[]" value="<?php echo $key;?>" id="<?php echo $key;?>" data-val="day"><?php echo __($name); ?> </label>
					</div>
					<?php }?>
				</div>
				<div class="col-md-8 activity_list">
					<label class="col-md-8 list-group-item bg-default"><?php echo __("Select Nutrition to add on selected days");?></label>
					<!-- <input type="button" value="<?php // echo __('+ Add Nutrition');?>" name="sadd_workouttype" id="add_nutrition" class="pull-right btn btn-flat btn-info"/> -->
					<label class="activity_title checkbox">				  		
				  		<strong>
				  			<input type="checkbox" value="" name="avtivity_id[]" value="breakfast" class="nutrition_check" 
				  			id="breakfast"  activity_title = "" data-val="nutrition_time"><?php echo __('Break Fast');?>
						</strong></label>
						<div id="txt_breakfast"></div>
						<label class="activity_title checkbox">
						<strong>
				  			<input type="checkbox" value="" name="avtivity_id[]" value="Mid-Morning-Snacks" class="nutrition_check" 
				  			id="midmorningsnacks"  activity_title = "" data-val="nutrition_time"><?php echo __('Mid-Morning Snacks');?>
						</strong></label>	
				  			<div id="txt_midmorningsnacks"></div>
				  			<label class="activity_title checkbox">
				  			<strong>
				  			<input type="checkbox" value="" name="avtivity_id[]" value="lunch" class="nutrition_check" 
				  			id="lunch"  activity_title = "" data-val="nutrition_time"><?php echo __('Lunch');?></strong></label>
				  			<div id="txt_lunch"></div>
							<label class="activity_title checkbox">
							<strong>
				  			<input type="checkbox" value="" name="avtivity_id[]" value="Afternoon-Snacks" class="nutrition_check" 
				  			id="afternoonsnacks"  activity_title = "" data-val="nutrition_time"><?php echo __('Afternoon Snacks');?>
							</strong></label>
							<div id="txt_afternoonsnacks"></div>
				  			<label class="activity_title checkbox"><strong>
				  			<input type="checkbox" value="" name="avtivity_id[]" value="dinner" class="nutrition_check" 
				  			id="dinner"  activity_title = "" data-val="nutrition_time"><?php  echo __('Dinner');?></strong></label>	
				  			<div id="txt_dinner"></div>							
						<div class="clear"></div>
						<br>
						<input type="button" value="<?php echo __('+ Add Nutrition');?>" name="sadd_workouttype" id="add_nutrition" class="pull-left btn btn-flat btn-info"/>
				</div>
			</div>
		</div>	
		<hr>
		<div class="col-sm-offset-2 col-sm-8">
			<div class="form-group">
			<!--	<div class="col-md-8">
					<input type="button" value="<?php //echo __('Step-1 Add Nutrition');?>" name="sadd_workouttype" id="add_nutrition" class="btn btn-flat btn-success"/>
				</div> -->
			</div>
		</div>
		<div id="display_nutrition_list"></div>
		<div class="clear"></div>	
		<br><br>
		<div class="col-md-offset-2 col-sm-8 schedule-save-button">
        	
        	<input type="submit" value="<?php if($edit){ echo __('Step-2 Save'); }else{ echo __('Save');}?>" name="save_workouttype" class="btn  btn-flat btn-success"/>
        </div>
		<input type="hidden" id="add_workout_url" value="<?php echo $this->request->base;?>/GymAjax/gmgt_add_workout">
		<div class='clear'>
		<br><br>
		<?php 
		$this->Form->end();
		
		if($edit)
		{
			foreach($nutrition_data as $data=>$row)
			{				
				foreach($row as $r)
				{
					if(is_array($r))
					{
						$days_array[$data]["start_date"] = $row["start_date"];
						$days_array[$data]["expire_date"] = $row["expire_date"];
						$day = $r["day_name"];
						$days_array[$data][$day][] = $r;
					}
				}					
			}
			
			// var_dump($days_array);
			foreach($days_array as $data=>$row)
			{?>
				<div class="panel panel-default workout-block" id="remove_panel_<?php echo $data;?>">				
				  <div class="panel-heading">
					<i class="fa fa-calendar"></i> <?php echo __("Start From")." <span class='work_date'>". date($this->Gym->getSettings("date_format"),strtotime($row["start_date"]))."</span> ".__("TO")." <span class='work_date'>".date($this->Gym->getSettings("date_format"),strtotime($row["expire_date"]))."</span>";?>
					<span class="del_nutrition_panel" del_id="<?php echo $data;?>" data-url="<?php echo $this->request->base;?>/GymAjax/deleteNutritionData/<?php echo $data;?>"><i class='fa fa-times-circle' aria-hidden="true"></i></span>
				  </div>
				  <br>
				<div class="work_out_datalist_header">
					<div class="col-md-4 col-sm-4">  
						<strong><?php echo __("Day name");?></strong>
					</div>
					<div class="col-md-8 col-sm-8 hidden-xs">						
						<span class="col-md-3 col-sm-3 col-xs-12"><?php echo __('Time');?></span>
	 					<span class="col-md-9 col-sm-9 col-xs-12"><?php echo __('Description');?></span>
					</div>
				</div>				
				<?php 
				foreach($row as $day=>$value)
				{
					if(is_array($value))
					{ 
					?>
						<div class="work_out_datalist">
						<div class="col-md-4 col-sm-4 day_name"><?php echo __($day);?></div>
						<div class="col-md-8 col-xs-8">
						<?php foreach($value as $r)
							{?>
							<div class="col-md-12">						
							<span class="col-md-3 col-sm-3 col-xs-12"><?php echo $r["nutrition_time"];?> </span>
							<span class="col-md-9 col-sm-9 col-xs-12"><?php echo $r["nutrition_value"];?> 
							</div>
						<?php } ?>
						</div>
						</div>
					<?php } 
				}?>				
				</div>
	  <?php } 
		}?>		
		<br><br>
		</div>
		<div class='overlay gym-overlay'>
			<i class='fa fa-refresh fa-spin'></i>
		</div>
	</div>
</section>
<script>

	 jQuery("body").on("click", "#add_nutrition", function(event){
		 var count = $("#display_nutrition_list div").length;
		
		
		 var day = '';
		 var activity = '';
		 var check_val = '';
		 jsonObj1 = [];
		 jsonObj2 = [];
		 jsonObj = [];
		
		 $(":checkbox:checked").each(function(o){
			
			  var chkID = $(this).attr("id");
			  var check_val = $(this).attr("data-val");
				
			  if(check_val == 'day')
			  {
				  //day += ' ' + chkID;
				  day += add_day(chkID,chkID);
				  item = {}
			        item ["day_name"] =chkID;
			       
			        jsonObj1.push(item);
			        //$(this).prop("disabled", true);
			  }
			  if(check_val == 'nutrition_time')
			  {
				  activity_name = $(this).attr("id");
				 if(activity_name == 'dinner')
				{
					 activity_name = 'Dinner';
				}
				 if(activity_name == 'breakfast')
					{
						 activity_name = 'Break Fast';
					}
				 if(activity_name == 'lunch')
					{
						 activity_name = 'Lunch';
					}
				  item = {};
			        item ["activity"] = {"activity":activity_name,"value":$("#valtxt_"+chkID).val()};
				  activity += add_nutrition(activity_name,chkID);
				 
			       
				  
			        jsonObj2.push(item);
			        
			  }
			  $(this).prop('checked', false);
			 
			 // $("#"+chkID+"summ").removeAttr("disabled");
			  /* ... */
			  jsonObj = {"days":jsonObj1,"activity":jsonObj2};
			});
		 
		 var curr_data = {
					action: 'gmgt_add_nutrition',
					data_array: jsonObj,			
					dataType: 'json'
					};
					// alert('hello');
					$.ajax({
						type : "POST",
						data : curr_data,
						url : "<?php echo $this->request->base . "/GymAjax/gym_add_nutrition"?>",
						success :function(response) {				
									var list_workout =  nutrition_list(day,activity,count,response);
									$("#display_nutrition_list").append(list_workout);
						}				
					});	
	}); 
	
	 $(".nutrition_check").change(function(){
			
			id = $(this).attr('id');
			//alert("Hello" + id);
			//return false;
			//$("#reps_sets_"+id).html('<P>Sets <input type="text" name = "sets_' + id + '"></p><P>Reps <input type="text" name = "reps_' + id + '"></p>');
			
			
		 if($(this).is(":checked"))
		{
			 //alert("chekked");
			 //$('#hmsg_message_sent').addClass('hmsg_message_block');
			 id = $(this).attr('id');
				//alert("Hello" + id);
			 string = '';
			
			string += '<div class="nutrition_add"><textarea name="'+id+'" id="valtxt_'+id+'"></textarea></div>';
			
				$("#txt_"+id).html(string);
			 
		}
		 else
		{
			// $('#hmsg_message_sent').addClass('hmsg_message_none');
			// $('#hmsg_message_sent').removeClass('hmsg_message_block');
			 id = $(this).attr('id');
				//alert("Hello" + id);
			 string = '';
				$("#txt_"+id).html(string);
		}
	 });
	  function add_day(day,id)
	 {
		 var string = '';
		 string = '<span id="'+id+'">'+day+'</span>, ';
		 string += '<input type="hidden" name="day[day]['+day+']" value="'+day+'">';
		 return string;
	 }
	  function add_nutrition(activity,id)
	 {
		 var string = '';
		 var sets = '';
		 var reps = '';
		 nutrition = $("#valtxt_"+id).val();		
		 // string += '<div id="'+id+'" class="nutrition_title"><strong>'+activity+' </strong></div>';
		 // string += '<div id="value_'+id+'" class="nutrition_value"> '+nutrition+' </div>';		 
		 string += '<div id="'+id+'" class="nutrition_title"><strong>'+activity+' </strong>: '+nutrition+'</div>';
		 
		
		 nutrition = $("#valtxt_"+id).val('');
		
		 return string;
	 }
	 function nutrition_list(day,activity,id,response)
		{
			var string = '';
			string += "<div class='activity border' id='block_"+id+"'>";
			string += '<div class="col-md-4">'+day+'</div>';
			string += '<div class="col-md-6">'+activity +'</div>';
			string += '<span>'+ response+'</span>';
			string += "<div id='"+id+"' class='removethis col-md-2'><span class='badge badge-delete pull-right'>X</span></div></div>";
			return string;
		}
 jQuery("body").on("click", ".removethis", function(event){
		// alert("hello");
		 var chkID = $(this).attr("id");
		 $("#block_"+chkID).remove();
	 });
</script>