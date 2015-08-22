window.onload = function (){
	
	jQuery('#selbox0').change(function() {
		var i = jQuery(this).attr('id');
		i = i.substring(i.length-1, i.length);
		i = parseInt(i);
		var val = jQuery('#selbox'+i).val();
		updateSelbox(val,i)
	});
	jQuery('#selbox1').change(function() {
		var i = jQuery(this).attr('id');
		i = i.substring(i.length-1, i.length);
		i = parseInt(i);
		var val = jQuery('#selbox'+i).val();
		updateSelbox(val,i)
	});
	jQuery('#selbox2').change(function() {
		var i = jQuery(this).attr('id');
		i = i.substring(i.length-1, i.length);
		i = parseInt(i);
		var val = jQuery('#selbox'+i).val();
		updateSelbox(val,i)
	});
	jQuery('#selbox3').change(function() {
		var i = jQuery(this).attr('id');
		i = i.substring(i.length-1, i.length);
		i = parseInt(i);
		var val = jQuery('#selbox'+i).val();
		updateSelbox(val,i)
	});
	jQuery('#selbox4').change(function() {
		var i = jQuery(this).attr('id');
		i = i.substring(i.length-1, i.length);
		i = parseInt(i);
		var val = jQuery('#selbox'+i).val();
		updateSelbox(val,i)
	});
	
}

function updateSelbox(val,i){
	if(val == 'service_id')
	  {
		  jQuery("#service_id"+i).val(0);
		  jQuery("#item_id"+i).val(0);
		  jQuery("#task_id"+i).val(0);
		  jQuery("#service_id"+i).removeClass("hidden").addClass("span12");
		  jQuery("#item_id"+i).removeClass("span12").addClass("hidden");
		  jQuery("#task_id"+i).removeClass("span12").addClass("hidden");
	  }
	  if(val == 'item_id')
	  {
		  jQuery("#service_id"+i).val(0);
		  jQuery("#item_id"+i).val(0);
		  jQuery("#task_id"+i).val(0);
		  jQuery("#service_id"+i).removeClass("span12").addClass("hidden");
		  jQuery("#item_id"+i).removeClass("hidden").addClass("span12");
		  jQuery("#task_id"+i).removeClass("span12").addClass("hidden");
	  }
	  if(val == 'task_id')
	  {
		  jQuery("#service_id"+i).val(0);
		  jQuery("#item_id"+i).val(0);
		  jQuery("#task_id"+i).val(0);
		  jQuery("#service_id"+i).removeClass("span12").addClass("hidden");
		  jQuery("#item_id"+i).removeClass("span12").addClass("hidden");
		  jQuery("#task_id"+i).removeClass("hidden").addClass("span12");
	  }
}

function delinvd(id)
{
	var typeInfo = {"jform[ddcinvd_id]":id};
	
	jQuery.ajax({
		url:'index.php?option=com_devcloudmanager&controller=delete&format=raw',
		type:'POST',
		data:typeInfo,
		dataType:'JSON',
		success:function(data)
		{
			if ( data.success ){
				location.reload();
			}else{
				console.log(data);
			}
		}
	});

}
function deltaskdetail(id)
{
	var typeInfo = {"jform[ddctaskdetail_id]":id};
	
	jQuery.ajax({
		url:'index.php?option=com_devcloudmanager&controller=delete&format=raw',
		type:'POST',
		data:typeInfo,
		dataType:'JSON',
		success:function(data)
		{
			if ( data.success ){
				location.reload();
			}else{
				console.log(data);
			}
		}
	});

}