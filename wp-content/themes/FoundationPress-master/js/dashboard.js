$(document).ready(function() {

/******************* Dashboard *******************************/
function patient_list()	{
	var doctor_id = $("#user_id").val();
	$.ajax({
		type: 'POST',
		data: 'id='+doctor_id,
		url: 'wp-content/themes/FoundationPress-master/dashboard/patient_list.php',
		success: function(success)	{
			$(".patient_results").html(success);
			$('#patient_input').fastLiveFilter('#patients');
			$(".patient").click(function()	{
				var patient = $(this).attr('id');
				$("#patient_id").val(patient);
				user_dashboard();
				$(".search_box").fadeOut();
				$(".close_search").fadeOut();
				$(".left_widget").delay(200).animate({
					width: "75px"
				},200);	
				$("#soap_notes").removeClass('dashboard_icons_disabled').addClass('dashboard_icons');
				$("#meds").removeClass('dashboard_icons_disabled').addClass('dashboard_icons');
				$(".doctor_dash").click(function()	{
					$("#patient_id").val('');
					$("#soap_notes").removeClass('dashboard_icons').addClass('dashboard_icons_disabled');
					$("#meds").removeClass('dashboard_icons').addClass('dashboard_icons_disabled');
					user_dashboard();
				});				
				dashboard_icons();
			});
		},
		error: function(error)	{
			console.log(error);
		}
	});
}
$(".search_patients").click(function()	{

	if($(".patient_results").html() == '')	{
		patient_list();
	}
	$(".left_widget").animate({
		width: "250px"
	},200);
	$(".search_box").delay(200).fadeIn('slow');
	$(".close_search").delay(200).fadeIn('slow');
});
$(".close_search").click(function()	{
	$(".search_box").fadeOut();
	$(".close_search").fadeOut();
	$(".left_widget").delay(200).animate({
		width: "75px",
	},200);		

});
$(".doctor_dash").click(function()	{
	$("#patient_id").val('');
	$("#soap_notes").removeClass('dashboard_icons').addClass('dashboard_icons_disabled');
	$("#meds").removeClass('dashboard_icons').addClass('dashboard_icons_disabled');
	user_dashboard();
});
$("#clear_search").click(function()	{
	$("#patient_input").val('');
	patient_list();
});

/*************************** Functions *******************************************/

function dashboard_icons()	{
	$(".dashboard_icons").click(function()	{
		var function_name = $(this).attr('id');
		$("#dashboard").empty();
		var user_id = $("#user_id").val();
		var patient_id = $("#patient_id").val();
		$.ajax({
			type: 'post',
			data: 'id='+ user_id+'&patient_id='+patient_id,
			url: 'wp-content/themes/FoundationPress-master/dashboard/'+function_name+'.php',
			success: function(success)	{
				$("#dashboard").html(success);
				$(".goback img").click(function()	{
					user_dashboard();
				});	
				message();
				$(".dashboard_small_widget_lip").click(function()	{
					var function_name = $(this).attr('id');
					$("#dashboard").empty();
					var user_id = $("#user_id").val();
					$.ajax({
						type: 'post',
						data: 'id='+ user_id,
						url: 'wp-content/themes/FoundationPress-master/dashboard/'+function_name+'.php',
						success: function(success)	{
							$("#dashboard").html(success);
							$(".goback img").click(function()	{
								user_dashboard();
							});
							$(".add_entry_family_condition").click(function()	{
								$(".family_conditions tr:last-child").before("<tr><td><input type='text' name='new_family_condition'></td><td></td></tr>");
							});
						},
						error: function(error)	{
							console.log(error);
						}
					}); 
				});	
				$(".dashboard_large_widget_lip").click(function()	{
					var function_name = $(this).attr('id');
					$("#dashboard").empty();
					var user_id = $("#user_id").val();
					$.ajax({
						type: 'post',
						data: 'id='+ user_id,
						url: 'wp-content/themes/FoundationPress-master/dashboard/'+function_name+'.php',
						success: function(success)	{
							$("#dashboard").html(success);
							$(".goback img").click(function()	{
								user_dashboard();
							});
						},
						error: function(error)	{
							console.log(error);
						}
					}); 
				});		
				$(".goals_button").click(function()	{
					var function_name = $(this).attr('id');
					$("#dashboard").empty();
					var user_id = $("#user_id").val();
					$.ajax({
						type: 'post',
						data: 'id='+ user_id,
						url: 'wp-content/themes/FoundationPress-master/dashboard/'+function_name+'.php',
						success: function(success)	{
							$("#dashboard").html(success);
							$(".goback img").click(function()	{
								user_dashboard();
							});						
						},
						error: function(error)	{
							console.log(error);
						}
					}); 
				});	

			},
			error: function(error)	{
				console.log(error);
			}
		}); 
	});	
}
function user_dashboard()	{
	$("#dashboard").empty();
	var user_id = $("#user_id").val();
	var patient_id = $("#patient_id").val();
	$.ajax({
		type: 'post',
		data: 'id='+ user_id+'&patient_id='+patient_id,
		url: 'wp-content/themes/FoundationPress-master/dashboard/user_dashboard.php',
		success: function(success)	{
			$("#dashboard").html(success);
		
			$(".dashboard_small_widget_lip").click(function()	{
				var function_name = $(this).attr('id');
				$("#dashboard").empty();
				var user_id = $("#user_id").val();
				var patient_id = $("#patient_id").val();
				$.ajax({
					type: 'post',
					data: 'id='+ user_id+'&patient_id='+patient_id,
					url: 'wp-content/themes/FoundationPress-master/dashboard/'+function_name+'.php',
					success: function(success)	{
						$("#dashboard").html(success);
						$(".goback img").click(function()	{
							user_dashboard();
						});					
						$(".add_entry").click(function()	{
							var this_table = $(this).closest('table').attr('id');
							console.log(this_table);
							if(this_table == "family_conditions")	{
								$("#"+this_table+" tr:last-child").before("<tr><td><input type='text' name='new_family_condition'></td><td><select><option>Father</option><option>Mother</option><option>Sibling</option></select></td><td><div class='save'>Save</div></td></tr>");
							}
							else if(this_table == "family_history")	{
								$("#"+this_table+" tr:last-child").before("<tr><td><select name='family_member'><option value='Father'>Father</option><option value='Mother'>Mother</option><option value='Sibling'>Sibling</option></select></td><td><select name='alive'><option value='1'>Living: Yes</option><option value='2'>Living: No</option></select></td><td><input name='age' type='number'></td><td><div class='save'>Save</div></td></tr>");
							}
							$(".save").click(function()	{
								var data = [];
								var xx = 0;
								var ii = 0;
								var yy = 0;
								var tdCount = $("#"+this_table).children('tr:nth-child(2) :input').length;
								$("#"+this_table+" tr").each(function()	{
									var subarray = [];
									if(xx > tdCount)	{
										data.push(subarray);
										xx = 0;
									} else {
										var tableInputs = $(this).find(':input').val();
										subarray.push(tableInputs);
										xx++;
									}
								});
								console.log(tdCount);
							});
						});						
					},
					error: function(error)	{
						console.log(error);
					}
				}); 
			});	
			$(".dashboard_large_widget_lip").click(function()	{
				var function_name = $(this).attr('id');
				$("#dashboard").empty();
				var user_id = $("#user_id").val();
				var patient_id = $("#patient_id").val();
				$.ajax({
					type: 'post',
					data: 'id='+ user_id+'&patient_id='+patient_id,
					url: 'wp-content/themes/FoundationPress-master/dashboard/'+function_name+'.php',
					success: function(success)	{
						$("#dashboard").html(success);
						$(".goback img").click(function()	{
							user_dashboard();
						});						
					},
					error: function(error)	{
						console.log(error);
					}
				}); 
			});
			$(".goals_button").click(function()	{
				var function_name = $(this).attr('id');
				$("#dashboard").empty();
				var user_id = $("#user_id").val();
				var patient_id = $("#patient_id").val();
				$.ajax({
					type: 'post',
					data: 'id='+ user_id+'&patient_id='+patient_id,
					url: 'wp-content/themes/FoundationPress-master/dashboard/'+function_name+'.php',
					success: function(success)	{
						$("#dashboard").html(success);
						$(".goback img").click(function()	{
							user_dashboard();
						});						
					},
					error: function(error)	{
						console.log(error);
					}
				}); 
			});					
		},
		error: function(error)	{
			console.log(error);
		}
	}); 
}
function message()	{
	$('.message').click(function()	{
		var messageId = $(this).attr('id');
		$.ajax({
			type: 'POST',
			data: 'message_id='+messageId,
			url: 'wp-content/themes/FoundationPress-master/dashboard/message.php',
			success: function(success)	{
				$("#dashboard").html(success);
				$(".message_go_back").click(function()	{
					var function_name = $(this).attr('id');
					$("#dashboard").empty();
					var user_id = $("#user_id").val();
					var patient_id = $("#patient_id").val();
					$.ajax({
						type: 'post',
						data: 'id='+ user_id+'&patient_id='+patient_id,
						url: 'wp-content/themes/FoundationPress-master/dashboard/communications.php',
						success: function(success)	{
							$("#dashboard").html(success);
							message();
						},
						error: function(error)	{
							console.log(error);
						}
					});
				});
			},
			error: function(error)	{
				console.log(error);
			}
		});
	});
}
/********************* INIT ***************************************/

user_dashboard();
dashboard_icons();
});