function addDdctaskdetail()
{
	var typeInfo = {};
	jQuery("#addTaskdetailForm :input").each(function(idx,ele){
		typeInfo[jQuery(ele).attr('name')] = jQuery(ele).val();
	});

	jQuery.ajax({
		url:'index.php?option=com_devcloudmanager&controller=edit&format=raw&tmpl=component',
		type:'POST',
		data:typeInfo,
		dataType:'JSON',
		success:function(data)
		{
			console.log(typeInfo);
			if ( data.success ){
				location.reload()
			}else{
			}
		}
	});

}