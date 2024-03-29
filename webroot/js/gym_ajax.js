$( document ).ajaxStart(function() {
  $(".gym-overlay").css("display","block");
});

$( document ).ajaxStop(function() {
  $(".gym-overlay").css("display","none");
});

$(document).ready(function(){
$(".body-overlay").css("display","none");
$("body").css("overflow-y","scroll");

$(".gym-modal").on("hidden.bs.modal", function () {
   $('.gym-modal').modal('hide');
   $("body").css("padding-right","0");
});

$("body").on("click",".add_category",function(){	
	var ajaxurl = $(this).attr("data-url");	
	$.ajax({
		url:ajaxurl,
		type : "POST",
		success : function(result){			
			$('.gym-modal').modal('show');			
			$(".gym-modal .modal-content").html(result);
		},
		error : function(e)
		{
			alert("There was an error processing form.Please try again later.");
			// alert(e.responseText);
			console.log(e.responseText);
		}
	});
});

$("body").on("click",".add-category",function(){
	var name = $(".cat_name").val();
	var ajaxurl = $(this).attr("data-url");
	if(name != "")
	{
		var curr_data = { name : name};
		$.ajax({
			url : ajaxurl,
			type : "POST",
			data : curr_data,
			success : function(response){					
					if(response)
					{
						$(".cat_name").val('');
						response = $.parseJSON(response);
						$("#category_list").prepend(response[0]);
						$(".cat_list").append(response[1]);
					}
			}
		});		
	}else{
		alert("Please Enter Category Name.");
	}
	
});

$("body").on("click",".del-category",function(){
	var did = $(this).attr("del-id");
	var ajaxurl = $(this).attr("data-url");
	var cdata = {did:did};
	if(confirm("Are you sure you want to delete this record?"))
	{
		$.ajax({
				url:ajaxurl,
				type : "POST",
				data : cdata,
				success : function(response)
				{
					if(response)
					{
						$("tr[id=row-"+did+"]").remove();
						$("option[value="+did+"]").remove();
					}
				}
		});
	}
});

$("body").on("click",".add_plan",function(){	
	var ajaxurl = $(this).attr("data-url");
	$.ajax({
			url:ajaxurl,
			type : "POST",			
			success : function(response)
			{
				if(response)
				{
					$('.gym-modal').modal('show');			
					$(".gym-modal .modal-content").html(response);
				}
			}
	});
});

$("body").on("click",".add-plan",function(){
	var number = $("#number").val();
	var duration = $("#duration").val();
	var ajaxurl = $(this).attr("data-url");
	if(number != "" && duration!="")
	{
		var curr_data = { name : name,number:number,duration:duration};
		$.ajax({
			url : ajaxurl,
			type : "POST",
			data : curr_data,
			success : function(response){					
					if(response)
					{
						$("#number").val('');
						$("#duration").val('');
						response = $.parseJSON(response);
						$("#plan_list").prepend(response[0]);
						$(".plan_list").append(response[1]);
					}
			}
		});		
	}else{
		alert("Please Enter Number or Select Duration.");
	}
	
});

$("body").on("click",".del-plan",function(){
	var did = $(this).attr("del-id");
	var ajaxurl = $(this).attr("data-url");
	var cdata = {did:did};
	if(confirm("Are you sure you want to delete this record?"))
	{
		$.ajax({
				url:ajaxurl,
				type : "POST",
				data : cdata,
				success : function(response)
				{
					if(response)
					{
						$("tr[id=row-"+did+"]").remove();
						$("option[value="+did+"]").remove();
					}
				}
		});	
	}
});

$("body").on("click",".del-membership",function(e){
	e.preventDefault();
	var ajaxurl = $(this).attr("data-url");
	var did = $(this).attr("did");
	var cdata = {did:did};
	if(confirm('Are you sure you want to delete this record?'))
	{
		$.ajax({
			url:ajaxurl,
			type:"POST",
			data:cdata,
			success:function(response){					
						$("#row-"+did).fadeOut("slow");
						var flash = "<div class='message success' onclick=\"this.classList.add('hidden')\">Success! Record Deleted Successfully.</div>"
						$(".content-wrapper").prepend(flash);					
					},
			error : function(e){
						alert("There was an error deleting record,Please try again later.");
						console.log(e.responseText);
					}
		});
	}
});

$("body").on("click",".add-role",function(){
	var ajaxurl = $(this).attr("data-url");	
	$.ajax({
		url:ajaxurl,
		type : "POST",
		success : function(result){			
			$('.gym-modal').modal('show');			
			$(".gym-modal .modal-content").html(result);
		},
		error : function(e)
		{
			alert("There was an error processing form.Please try again later.");
			// alert(e.responseText);
			console.log(e.responseText);
		}
	});
	
});

$("body").on("click",".save-role",function(){
	var name = $(".role_name").val();
	var ajaxurl = $(this).attr("data-url");
	if(name != "")
	{
		var curr_data = { role : name};
		$.ajax({
			url : ajaxurl,
			type : "POST",
			data : curr_data,
			success : function(response){					
					if(response)
					{
						response = $.parseJSON(response);
						$("#roles_list").prepend(response[0]);
						$(".roles_list").append(response[1]);
						var name = $(".role_name").val("");
					}
			}
		});		
	}else{
		alert("Please Enter Category Name.");
	}
	
});

$("body").on("click",".del-role",function(e){
	e.preventDefault();
	var ajaxurl = $(this).attr("data-url");
	var did = $(this).attr("del-id");
	// var cdata = {did:did};
	if(confirm('Are you sure you want to delete this record?'))
	{
		$.ajax({
			url:ajaxurl,
			type:"POST",
			// data:cdata,
			success:function(response){					
						$("#row-"+did).fadeOut("slow");
						$(".roles_list option[value="+did+"]").remove();
						var flash = "<div class='message success' onclick=\"this.classList.add('hidden')\">Success! Record Deleted Successfully.</div>"
						$(".content-wrapper").prepend(flash);					
					},
			error : function(e){
						alert("There was an error deleting record,Please try again later.");
						console.log(e.responseText);
					}
		});
	}
});


$("body").on("click",".add-spec",function(){
	var ajaxurl = $(this).attr("data-url");	
	$.ajax({
		url:ajaxurl,
		type : "POST",
		success : function(result){			
			$('.gym-modal').modal('show');			
			$(".gym-modal .modal-content").html(result);
		},
		error : function(e)
		{
			alert("There was an error processing form.Please try again later.");
			// alert(e.responseText);
			console.log(e.responseText);
		}
	});
	
});

$("body").on("click",".save-spec",function(){
	var name = $(".spec_name").val();
	var ajaxurl = $(this).attr("data-url");
	if(name != "")
	{
		var curr_data = { name : name};
		$.ajax({
			url : ajaxurl,
			type : "POST",
			data : curr_data,
			success : function(response){					
					if(response)
					{
						response = $.parseJSON(response);
						var name = $(".spec_name").val("");
						$("#specialization_list").prepend(response[0]);
						$(".specialization_list").append(response[1]);
						$('#specialization').multiselect('destroy');
						$('#specialization').multiselect('rebuild');
						var name = $(".role_name").val("");
						$('#empty_row').hide();
					}
			},
			error : function(e){
				alert(e);
				console.log(e.responseText);
			}
		});		
	}else{
		alert("Please Enter Category Name.");
	}
	
});

$("body").on("click",".del-spec",function(e){
	e.preventDefault();
	var ajaxurl = $(this).attr("data-url");
	var did = $(this).attr("del-id");
	
	if(confirm('Are you sure you want to delete this record?'))
	{
		$.ajax({
			url:ajaxurl,
			type:"POST",			
			success:function(response){					
						$("#row-"+did).fadeOut("slow");
						$(".specialization_list option[value="+did+"]").remove();
						$('#specialization').multiselect('destroy');
						$('#specialization').multiselect('rebuild');
						var flash = "<div class='message success' onclick=\"this.classList.add('hidden')\">Success! Record Deleted Successfully.</div>"
						$(".content-wrapper").prepend(flash);					
					},
			error : function(e){
						alert("There was an error deleting record,Please try again later.");
						console.log(e.responseText);
					}
		});
	}
});

$("body").on("click",".interest-list",function(){
	var ajaxurl = $(this).attr("data-url");	
	$.ajax({
		url:ajaxurl,
		type : "POST",
		success : function(result){			
			$('.gym-modal').modal('show');			
			$(".gym-modal .modal-content").html(result);
		}
	});
	
});

$("body").on("click",".save-interest",function(){
	var interest = $(".interest").val();
	var ajaxurl = $(this).attr("data-url");
	if(interest != "")
	{		
		var curr_data = { interest : interest};
		$.ajax({
			url : ajaxurl,
			type : "POST",
			data : curr_data,
			success : function(response){					
					if(response)
					{	
						response = $.parseJSON(response);						
						var interest = $(".interest").val("");
						$("#interest_list").prepend(response[0]);
						$(".interest_list").append(response[1]);						
						$(".interest").val("");
						$("#empty_row").hide();
					}
			},
			error : function(e){
				alert(e);
				console.log(e.responseText);
			}
		});		
	}else{
		alert("Please Enter Interest.");
	}
	
});

$("body").on("click",".del-interest",function(e){
	e.preventDefault();
	var ajaxurl = $(this).attr("data-url");
	var did = $(this).attr("del-id");
	
	if(confirm('Are you sure you want to delete this record?'))
	{
		$.ajax({
			url:ajaxurl,
			type:"POST",			
			success:function(response){					
						$("#row-"+did).fadeOut("slow");
						$(".interest_list option[value="+did+"]").remove();						
						var flash = "<div class='message success' onclick=\"this.classList.add('hidden')\">Success! Record Deleted Successfully.</div>"
						$(".content-wrapper").prepend(flash);					
					},
			error : function(e){
						alert("There was an error deleting record,Please try again later.");
						console.log(e.responseText);
					}
		});
	}
});

$("body").on("click",".source-list",function(){
	var ajaxurl = $(this).attr("data-url");	
	$.ajax({
		url:ajaxurl,
		type : "POST",
		success : function(result){			
			$('.gym-modal').modal('show');			
			$(".gym-modal .modal-content").html(result);
		}
	});
	
});


$("body").on("click",".save-source",function(){
	var source = $(".source").val();
	var ajaxurl = $(this).attr("data-url");
	if(source != "")
	{		
		var curr_data = { source : source};
		$.ajax({
			url : ajaxurl,
			type : "POST",
			data : curr_data,
			success : function(response){					
					if(response)
					{	
						response = $.parseJSON(response);					
						$("#source_list").prepend(response[0]);
						$(".source_list").append(response[1]);						
						$(".source").val("");
					}
			},
			error : function(e){
				alert(e);
				console.log(e.responseText);
			}
		});		
	}else{
		alert("Please Enter Source.");
	}
	
});

$("body").on("click",".del-source",function(e){
	e.preventDefault();
	var ajaxurl = $(this).attr("data-url");
	var did = $(this).attr("del-id");
	
	if(confirm('Are you sure you want to delete this record?'))
	{
		$.ajax({
			url:ajaxurl,
			type:"POST",			
			success:function(response){					
						$("#row-"+did).fadeOut("slow");
						$(".source_list option[value="+did+"]").remove();						
						var flash = "<div class='message success' onclick=\"this.classList.add('hidden')\">Success! Record Deleted Successfully.</div>"
						$(".content-wrapper").prepend(flash);					
					},
			error : function(e){
						alert("There was an error deleting record,Please try again later.");
						console.log(e.responseText);
					}
		});
	}
});


$("body").on("click",".level-list",function(){
	var ajaxurl = $(this).attr("data-url");	
	$.ajax({
		url:ajaxurl,
		type : "POST",
		success : function(result){			
			$('.gym-modal').modal('show');			
			$(".gym-modal .modal-content").html(result);
		}
	});
	
});

$("body").on("click",".save-level",function(){
	var ajaxurl = $(this).attr("data-url");
	var level = $(".level").val();
	if(level != "")
	{	
		var curr_data = { level : level};
		$.ajax({
			url:ajaxurl,
			data : curr_data,
			type:"POST",
			success:function(response){
				if(response)
						{	
							response = $.parseJSON(response);					
							$("#level_list").prepend(response[0]);
							$(".level_list").append(response[1]);						
							$(".level").val("");
						}
			},
			error : function(e){
							alert("There was an error deleting record,Please try again later.");
							console.log(e.responseText);
						}
		});
	}
	else{
		alert("Please Enter Level");
	}
});

$("body").on("click",".del-level",function(e){
	e.preventDefault();
	var ajaxurl = $(this).attr("data-url");
	var did = $(this).attr("del-id");
	
	if(confirm('Are you sure you want to delete this record?'))
	{
		$.ajax({
			url:ajaxurl,
			type:"POST",			
			success:function(response){					
						$("#row-"+did).fadeOut("slow");
						$(".level_list option[value="+did+"]").remove();						
						var flash = "<div class='message success' onclick=\"this.classList.add('hidden')\">Success! Record Deleted Successfully.</div>"
						$(".content-wrapper").prepend(flash);					
					},
			error : function(e){
						alert("There was an error deleting record,Please try again later.");
						console.log(e.responseText);
					}
		});
	}
});

$("body").on("click",".del_panel",function(){
	var del_id = $(this).attr("del_id");
	var ajaxurl = $(this).attr("data-url");
	var curr_data = { workout_id : del_id};
	if(confirm("Are you sure, you want to delete this workout data?"))
	{
		$.ajax({
			url:ajaxurl,
			data:curr_data,
			success:function(response)
					{   
						if(response)
						{							
							$("#remove_panel_"+del_id).remove();
						}else{
							alert("Error While deleting, please try again.");
						}
					}
		});
	}
});


$("body").on("change","#mem_list",function(){
	var uid = $(this).val();
	var ajaxurl = $(this).attr("data-url");	/*getworkoutdates*/	
	var curr_data = {uid:uid};
	if(uid != "")
	{
		$.ajax({
			url : ajaxurl,
			data : curr_data,
			type : "POST",
			success : function(response){
				console.log(response); 
					if(response != false)
					{
						var dates = $.parseJSON(response);				
						$("#date_range").val(dates);
						
						var assigned_dates = $("#date_range").val();
						var dates = assigned_dates.split(",");
						$("a").removeClass(" sel_date");
						for(var i=0;i<dates.length;i++)
						{				
							$("[data-moment="+dates[i]+"]").addClass(" sel_date");							
						}						
						$(".dp-selected").removeClass("sel_date"); 
					}
			},
			error : function(e){
							alert("There was an error deleting record,Please try again later.");
							console.log(e.responseText);
						}
		});
	}
});

$("body").on("change",".show_workout",function(){
	  $("#box-widget").activateBox();
	if(this.checked)
	{
		var cat_id = $(this).attr("id");
		var ajaxurl = $("#get_url").val();
		var curr_data = {cat_id:cat_id};
		$.ajax({
			url:ajaxurl,
			type:"POST",
			data:curr_data,
			success:function(response){
						if(response != false)
						{
							$(".activity_data").append(response);
						}else{
							alert("No activity found.");
						}						
					},
			error:function(e){
					alert("There was an error deleting record,Please try again later.");
					console.log(e.responseText);
				}
		});
		
	}else{
		var cat_id = $(this).attr("id");		
		$("#act_block_"+cat_id).remove();
	}	
});

$("body").on("click",".view_measurment",function(){
var ajaxurl = $(this).attr("data-url");
var user_id = $(this).attr("data-val");
var curr_data = {user_id:user_id};
	$.ajax({
		url:ajaxurl,
		data:curr_data,
		type:"POST",
		success : function(result){
					$('.gym-modal').modal('show');			
					$(".gym-modal .modal-content").html(result);	
				},
		error:function(e){
					alert("There was an error deleting record,Please try again later.");
					console.log(e.responseText);
				}
	});
});

$("body").on("click",".delete_measurment",function(){
	var did = $(this).attr("did");
	var ajaxurl = $(this).attr("data-url");	
	if(confirm("Are you sure, you want to delete this workout data?"))
	{
		$.ajax({
			url:ajaxurl,
			success:function(response)
					{   
						if(response)
						{							
							$("#row_"+did).remove();
						}else{
							alert("Error While deleting, please try again.");
						}
					}
		});
	}
});

$("body").on("click",".del_nutrition_panel",function(){
	var del_id = $(this).attr("del_id");
	var ajaxurl = $(this).attr("data-url");
	var curr_data = { workout_id : del_id};
	if(confirm("Are you sure, you want to delete this workout data?"))
	{
		$.ajax({
			url:ajaxurl,
			data:curr_data,
			success:function(response)
					{   
						if(response)
						{							
							$("#remove_panel_"+del_id).remove();
						}else{
							alert("Error While deleting, please try again.");
						}
					}
		});
	}
});

$("body").on("click","#eventplace_list",function(){
	var ajaxurl = $(this).attr("data-url");	
	$.ajax({
		url:ajaxurl,
		type : "POST",
		success : function(result){			
			$('.gym-modal').modal('show');			
			$(".gym-modal .modal-content").html(result);
		}
	});
	
});


$("body").on("click",".save-event-place",function(){
	var place_name = $(".place_name").val();
	var ajaxurl = $(this).attr("data-url");
	if(place_name != "")
	{		
		var curr_data = { place_name : place_name};
		$.ajax({
			url : ajaxurl,
			type : "POST",
			data : curr_data,
			success : function(response){					
					if(response)
					{	
						$('#empty_row').hide();
						response = $.parseJSON(response);					
						$("#events_place_list").prepend(response[0]);
						$(".events_place_list").append(response[1]);						
						$(".events_place_list").val("");
					}
			},
			error : function(e){
				alert(e);
				console.log(e.responseText);
			}
		});		
	}else{
		alert("Please Enter Place Name.");
	}
	
});

$("body").on("click",".del-event-place",function(e){
	e.preventDefault();
	var ajaxurl = $(this).attr("data-url");
	var did = $(this).attr("del-id");
	
	if(confirm('Are you sure you want to delete this record?'))
	{
		$.ajax({
			url:ajaxurl,
			type:"POST",			
			success:function(response){					
						$("#row-"+did).fadeOut("slow");
						$(".events_place_list option[value="+did+"]").remove();						
						var flash = "<div class='message success' onclick=\"this.classList.add('hidden')\">Success! Record Deleted Successfully.</div>"
						$(".content-wrapper").prepend(flash);					
					},
			error : function(e){
						alert("There was an error deleting record,Please try again later.");
						console.log(e.responseText);
					}
		});
	}
});

$("body").on("click",".view-grp-member",function(){
	var ajaxurl = $(this).attr("data-url");	
	$.ajax({
		url:ajaxurl,
		type : "POST",
		success : function(result){			
			$('.gym-modal').modal('show');			
			$(".gym-modal .modal-content").html(result);
		}
	});	
});

$("body").on("click",".view-grp-member",function(){
	var ajaxurl = $(this).attr("data-url");	
	$.ajax({
		url:ajaxurl,
		type : "POST",
		success : function(result){			
			$("#mem_amt").val(result);
		}
	});	
});

$("body").on("click",".amt_pay",function(){
	var ajaxurl = $(this).attr("data-url");	
	$.ajax({
		url:ajaxurl,
		type : "POST",
		success : function(result){			
			$('.gym-modal').modal('show');			
			$(".gym-modal .modal-content").html(result);			
		}
	});	
});

$("body").on("change",".gen_membership_id",function(){
	var mid = $(this).val();
	$("#total_amount").val('');
	var ajaxurl = $(this).attr("data-url");	
	var curr_data = {mid:mid};
	$.ajax({
		url:ajaxurl,
		data : curr_data,
		type : "POST",
		success : function(result){
			var parsed = JSON.parse(result);
			$("#total_amount").val(parsed.membership_amount);
			console.log(parsed.discount_id);
			if(parsed.discount_id === 1){
				$("#discount_amount").val(Number(parsed.membership_amount)-Number(parsed.membership_amount*Number(parsed.type.number/100)));
			}
			if(parsed.discount_id === 2){
				$("#discount_amount").val(Number(parsed.membership_amount)-Number(parsed.membership_amount*Number(parsed.type.number/100)));
			}
			if(parsed.discount_id === 3){
				$("#discount_amount").val(Number(parsed.membership_amount)-Number(parsed.membership_amount*Number(parsed.type.number/100)));
			}
			if(parsed.discount_id === 4){
				$("#discount_amount").val(Number(parsed.membership_amount)-Number(parsed.type.number));
			}
			if(parsed.discount_id === 5){
				$("#discount_amount").val(Number(parsed.membership_amount)-Number(parsed.type.number));
			}
			if(parsed.discount_id === 10){
				$("#discount_amount").val(Number(parsed.membership_amount)-Number(parsed.type.number));
			}
			if(parsed.discount_id === 11){
				$("#discount_amount").val(Number(parsed.membership_amount)-Number(parsed.type.number));
			}
			if(parsed.discount_id === 12){
				$("#discount_amount").val(Number(parsed.membership_amount)-Number(parsed.type.number));
			}

		}
	});
});

$("body").on("click",".view_invoice",function(){
	var ajaxurl = $(this).attr("data-url");	
	$.ajax({
		url:ajaxurl,
		type : "POST",
		success : function(result){			
			$('.gym-modal').modal('show');			
			$(".gym-modal .modal-content").html(result);
		}
	});	
});


$("body").on("click",".view_income_expense",function(){
	var ajaxurl = $(this).attr("data-url");	
	var type = $(this).attr("type");
	var curr_data = {type:type};
	$.ajax({
		url:ajaxurl,
		data : curr_data,
		type : "POST",
		success : function(result){			
			$('.gym-modal').modal('show');			
			$(".gym-modal .modal-content").html(result);
		}
	});	
});

$("body").on("click",".view_notice",function(){
	var ajaxurl = $(this).attr("data-url");	
	var id = $(this).attr("id");
	var curr_data = {id:id};
	$.ajax({
		url:ajaxurl,
		data : curr_data,
		type : "POST",
		success : function(result){			
			$('.gym-modal').modal('show');			
			$(".gym-modal .modal-content").html(result);
		}
	});	
});

$("body").on("change",".membership_id",function(){
	var m_id = $(this).val();
	var ajaxurl = $("#mem_class_url").val();
	var curr_data = { m_id : m_id};
	$(".class_list").html("");
	$.ajax({
		url : ajaxurl,
		type : "POST",
		data : curr_data,
		success : function(response){
			$(".class_list").append(response);
			$(".class_list").multiselect("rebuild");
			return false;
		},
		error : function(e){
			alert("Error: Could not fetch class list");
			console.log(e.responseText);
		}
	});
});

$("body").on("change",".mem_list_workout",function(){
	var member_id = $(this).val();	
	$("#append").html("");
	var ajaxurl = $("#getcategory").attr("data-url");
	var curr_data = {member_id:member_id};
	$.ajax({
		url : ajaxurl,
		type : "POST",
		data : curr_data,
		success : function(result)
		{		
			$("#append").append(result);			
		},
		error : function(e)
		{
			console.log(e.responseText);
		}
	});
});

});