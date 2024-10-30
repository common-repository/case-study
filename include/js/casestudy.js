jQuery(document).ready(function($){
	var upload_third_loc_file;
	var upload_third_loc_filedata;
	var upload_banner_third_loc_filedata;
	var upload_banner_svg_third_loc_filedata;
	var upload_list_third_loc_filedata;
	var upload_list_svg_third_loc_filedata;
	var upload_slider_third_loc_filedata;
	var upload_slider_svg_third_loc_filedata;
	var upload_third_locationlabel = 0;
	var upload_third_locationlabel_data = 0;
	var upload_third_banner_locationlabel_data = 0;
	var upload_third_banner_svg_locationlabel_data = 0;
	var upload_third_list_locationlabel_data = 0;
	var upload_third_list_svg_locationlabel_data = 0;
	var upload_third_slider_locationlabel_data = 0;	
	var upload_third_slider_svg_locationlabel_data = 0;	
	var myval;
	
	$(document.body).on('click.mojoOpenMediaManager', '#externallink_upload_image_button', function(e) { 
		//cs_image_issue is the class of our form button
		// Prevent the default action from occuring.
		 e.preventDefault();
		// Get our Parent element
		 upload_third_locationlabel = $(this).parent();	 
		 // If the frame already exists, re-open it.
		 if ( upload_third_loc_file ) {
			upload_third_loc_file.open();
			return;
		 }		 
		 upload_third_loc_file = wp.media.frames.upload_third_loc_file = wp.media({
			title: "Add Case Study Image",
			button: {
				text: "Insert Case Study Image",
			},
			editing:    true,
			className: 'media-frame upload_third_loc_file',
			frame: 'select', //Allow Select Only
			multiple: false, //Disallow Mulitple selections
			library: {
				type: 'image' //Only allow images type: 'image'
			},
		});
		
		upload_third_loc_file.on('select', function(){
			// Grab our attachment selection and construct a JSON representation of the model.
			var loc_media_attachment = upload_third_loc_file.state().get('selection').first().toJSON();
			var thum_url = loc_media_attachment.sizes.full.url;
			var thumb_id = loc_media_attachment.id; 
			// Send the attachment URL to our custom input field via jQuery.
			loc_url = loc_media_attachment.url;
			locurls = loc_url.substr( (loc_url.lastIndexOf('.') +1) );
			
			if(locurls !='pdf' && locurls !='zip' && locurls !='rar') {
				$('#external_link_image').css('display','block');
				$('#externallink_remove_image_button').css('display','inline-block');
				$('#cs_list_image').val(thumb_id);
				$('#externallink_display_image').attr('src',thum_url );
			} else {
				alert('Please add only image');
			}
		});
		// Now that everything has been set, let's open up the frame.
		 upload_third_loc_file.open();
	});
	 
	// image list manage
	$('#externallink_remove_image_button').click(function() {
		$("#externallink_display_image").attr('src','');
		$('#cs_list_image').attr('value','');	
		$('#external_link_image').css('display','none');
		$('#externallink_remove_image_button').css('display','none');
	});
	
	// image banner
	
	$(document.body).on('click.mojoOpenMediaManager', '#casestudy_upload_image_button', function(e){ 
	 	//cs_image_issue is the class of our form button
		// Prevent the default action from occuring.
		 e.preventDefault();
		// Get our Parent element
		 upload_third_locationlabel_data = $(this).parent();	 
		 // If the frame already exists, re-open it.
		 if ( upload_third_loc_filedata ) {
			upload_third_loc_filedata.open();
			return;
		 }	 
		 upload_third_loc_filedata = wp.media.frames.upload_third_loc_filedata = wp.media({
			title: "Add Case Study Banner",
			button: {
			text: "Insert Case Study Banner",
			},
			editing:    true,
			className: 'media-frame upload_third_loc_file',
			frame: 'select', //Allow Select Only
			multiple: false, //Disallow Mulitple selections
			library: {
				type: 'image' //Only allow images type: 'image'
			},
		});
		
		upload_third_loc_filedata.on('select', function() {
			// Grab our attachment selection and construct a JSON representation of the model.
			var loc_media_attachmentdata = upload_third_loc_filedata.state().get('selection').first().toJSON();
			var thum_url = loc_media_attachmentdata.sizes.full.url;
			var thumb_id = loc_media_attachmentdata.id; 
			// Send the attachment URL to our custom input field via jQuery.
			loc_url = loc_media_attachmentdata.url;
			locurls = loc_url.substr( (loc_url.lastIndexOf('.') +1) );
			if(locurls !='pdf' && locurls !='zip' && locurls !='rar') {
				$('#casestudy_link_image').css('display','block');
				$('#casestudy_remove_image_button').css('display','inline-block');
				$('#casestudy_upload_image').val(thumb_id);
				$('#casestudy_display_image').attr('src',thum_url );
			} else { 
				alert('Please add only image');
			}
		});
		// Now that everything has been set, let's open up the frame.
		 upload_third_loc_filedata.open();
	 });
	
	$('#casestudy_remove_image_button').click(function() {
		$("#casestudy_display_image").attr('src','');
		$('#casestudy_upload_image').attr('value','');	
		$('#casestudy_link_image').css('display','none');
		$('#casestudy_remove_image_button').css('display','none');
	});
	
	
	// banner no image	
	$(document.body).on('click.mojoOpenMediaManager', '#casestudy_banner_upload_image_button', function(e){ 
		//cs_image_issue is the class of our form button
		// Prevent the default action from occuring.
		e.preventDefault();
		// Get our Parent element
		upload_third_banner_locationlabel_data = $(this).parent();	 
		// If the frame already exists, re-open it.
		if ( upload_banner_third_loc_filedata ) {
			upload_banner_third_loc_filedata.open();
			return;
		}
		 
		upload_banner_third_loc_filedata = wp.media.frames.upload_banner_third_loc_filedata = wp.media({
			title: "Add No Image For Case Study Banner",
			button: {
				text: "Insert No Image For Case Study Banner",
			},
			editing:    true,
			className: 'media-frame upload_third_loc_file',
			frame: 'select', //Allow Select Only
			multiple: false, //Disallow Mulitple selections
			library: {
				type: 'image' //Only allow images type: 'image'
			},
		});
		
		 upload_banner_third_loc_filedata.on('select', function(){
		 // Grab our attachment selection and construct a JSON representation of the model.
		 var loc_media_attachmentdata = upload_banner_third_loc_filedata.state().get('selection').first().toJSON();
		 var thum_url = loc_media_attachmentdata.sizes.full.url;
		 var thumb_id = loc_media_attachmentdata.id; 
		// Send the attachment URL to our custom input field via jQuery.
		 loc_url = loc_media_attachmentdata.url;
		 locurls = loc_url.substr( (loc_url.lastIndexOf('.') +1) );
		
		 if(locurls !='pdf' && locurls !='zip' && locurls !='rar' && locurls !='svg+xml')
		 {
		 	 $('#casestudy_banner_link_image').css('display','block');
			 $('#casestudy_banner_remove_image_button').css('display','inline-block');
			 $('#casestudy_banner_upload_image_id').val(thumb_id);
			 $('#casestudy_banner_display_image').attr('src',thum_url );
		 }else{
			 alert('Please add only image');
	     }
		 });
 
		// Now that everything has been set, let's open up the frame.
		 upload_banner_third_loc_filedata.open();
	 });
	
	$('#casestudy_banner_remove_image_button').click(function() {
		$("#casestudy_banner_display_image").attr('src','');
		$('#casestudy_banner_upload_image_id').attr('value','');	
		$('#casestudy_banner_link_image').css('display','none');
		$('#casestudy_banner_remove_image_button').css('display','none');
	});
	
	
	// banner svg no image
	
	$(document.body).on('click.mojoOpenMediaManager', '#casestudy_banner_upload_svg_image_button', function(e){ 
	 	//cs_image_issue is the class of our form button
		// Prevent the default action from occuring.
		 e.preventDefault();
		// Get our Parent element
		 upload_third_banner_svg_locationlabel_data = $(this).parents();
		 
		 // If the frame already exists, re-open it.
		 if ( upload_banner_svg_third_loc_filedata ) {
		 upload_banner_svg_third_loc_filedata.open();
		 return;
		 }
		 
		 upload_banner_svg_third_loc_filedata = wp.media.frames.upload_banner_svg_third_loc_filedata = wp.media({
					 title: "Add SVG No Image For Case Study Banner",
				     button: {
					  text: "Insert SVG No Image For Case Study Banner",
				     },
					 editing:    true,
					 className: 'media-frame upload_third_loc_file',
					 frame: 'select', //Allow Select Only
					 multiple: false, //Disallow Mulitple selections
					 library: {
					 type: 'image' //Only allow images type: 'image'
			 },
		});
		
		 upload_banner_svg_third_loc_filedata.on('select', function(){
		 	
		 // Grab our attachment selection and construct a JSON representation of the model.
		 var loc_media_attachmentdata = upload_banner_svg_third_loc_filedata.state().get('selection').first().toJSON();
			 	
		 	if(loc_media_attachmentdata.subtype == "svg+xml"){
		 	 	upload_third_banner_svg_locationlabel_data.find('#casestudy_banner_svg_link_image').css('display','block');
			 	upload_third_banner_svg_locationlabel_data.find('#casestudy_banner_remove_svg_image_button').css('display','inline-block');
			 	upload_third_banner_svg_locationlabel_data.find('#casestudy_banner_upload_svg_image_id').val(loc_media_attachmentdata.id);
			 	upload_third_banner_svg_locationlabel_data.find('#casestudy_banner_svg_display_image').attr('src',loc_media_attachmentdata.url );	
			 }
			 else{
			 	alert('Please upload only svg image');
			 }
		 
		 });
 
		// Now that everything has been set, let's open up the frame.
		 upload_banner_svg_third_loc_filedata.open();
	 });
	
	$('#casestudy_banner_remove_svg_image_button').click(function() {
		$("#casestudy_banner_svg_display_image").attr('src','');
		$('#casestudy_banner_upload_svg_image_id').attr('value','');	
		$('#casestudy_banner_svg_link_image').css('display','none');
		$('#casestudy_banner_remove_svg_image_button').css('display','none');
	});
	
	// list no image
	
	$(document.body).on('click.mojoOpenMediaManager', '#casestudy_list_upload_image_button', function(e){ 
	 	//cs_image_issue is the class of our form button
		// Prevent the default action from occuring.
		 e.preventDefault();
		// Get our Parent element
		 upload_third_list_locationlabel_data = $(this).parent();
		 
		 // If the frame already exists, re-open it.
		 if ( upload_list_third_loc_filedata ) {
		 upload_list_third_loc_filedata.open();
		 return;
		 }
		 
		 upload_list_third_loc_filedata = wp.media.frames.upload_list_third_loc_filedata = wp.media({
					 title: "Add No Image For List",
				     button: {
					  text: "Insert No Image For List",
				     },
					 editing:    true,
					 className: 'media-frame upload_third_loc_file',
					 frame: 'select', //Allow Select Only
					 multiple: false, //Disallow Mulitple selections
					 library: {
					 type: 'image' //Only allow images type: 'image'
			 },
		});
		
		 upload_list_third_loc_filedata.on('select', function(){
		 // Grab our attachment selection and construct a JSON representation of the model.
		 var loc_media_attachmentdata = upload_list_third_loc_filedata.state().get('selection').first().toJSON();
		 var thum_url = loc_media_attachmentdata.sizes.full.url;
		 var thumb_id = loc_media_attachmentdata.id; 
		// Send the attachment URL to our custom input field via jQuery.
		 loc_url = loc_media_attachmentdata.url;
		 locurls = loc_url.substr( (loc_url.lastIndexOf('.') +1) );
		
		 if(locurls !='pdf' && locurls !='zip' && locurls !='rar'  && locurls !='svg+xml')
		 {
		 	 $('#casestudy_list_link_image').css('display','block');
			 $('#casestudy_list_remove_image_button').css('display','inline-block');
			 $('#casestudy_list_upload_image_id').val(thumb_id);
			 $('#casestudy_list_display_image').attr('src',thum_url );
		 }else{
			 alert('Please add only image');
	     }
		 });
 
		// Now that everything has been set, let's open up the frame.
		 upload_list_third_loc_filedata.open();
	 });
	
	$('#casestudy_list_remove_image_button').click(function() {
		$("#casestudy_list_display_image").attr('src','');
		$('#casestudy_list_upload_image_id').attr('value','');	
		$('#casestudy_list_link_image').css('display','none');
		$('#casestudy_list_remove_image_button').css('display','none');
	});
	
	
	// list svg no image
	
	$(document.body).on('click.mojoOpenMediaManager', '#casestudy_list_upload_svg_image_button', function(e){ 
	 	//cs_image_issue is the class of our form button
		// Prevent the default action from occuring.
		 e.preventDefault();
		// Get our Parent element
		 upload_third_list_svg_locationlabel_data = $(this).parents();
		 
		 // If the frame already exists, re-open it.
		 if ( upload_list_svg_third_loc_filedata ) {
		 upload_list_svg_third_loc_filedata.open();
		 return;
		 }
		 
		 upload_list_svg_third_loc_filedata = wp.media.frames.upload_list_svg_third_loc_filedata = wp.media({
					 title: "Add SVG No Image For List",
				     button: {
					  text: "Insert SVG No Image For List",
				     },
					 editing:    true,
					 className: 'media-frame upload_third_loc_file',
					 frame: 'select', //Allow Select Only
					 multiple: false, //Disallow Mulitple selections
					 library: {
					 type: 'image' //Only allow images type: 'image'
			 },
		});
		
		 upload_list_svg_third_loc_filedata.on('select', function(){
		 // Grab our attachment selection and construct a JSON representation of the model.
		 var loc_media_attachmentdata = upload_list_svg_third_loc_filedata.state().get('selection').first().toJSON();
		 
		 if(loc_media_attachmentdata.subtype == "svg+xml"){
	 	 	upload_third_list_svg_locationlabel_data.find('#casestudy_list_svg_link_image').css('display','block');
		 	upload_third_list_svg_locationlabel_data.find('#casestudy_list_remove_svg_image_button').css('display','inline-block');
		 	upload_third_list_svg_locationlabel_data.find('#casestudy_list_upload_svg_image_id').val(loc_media_attachmentdata.id);
		 	upload_third_list_svg_locationlabel_data.find('#casestudy_list_svg_display_image').attr('src',loc_media_attachmentdata.url );	
		 }
		 else{
		 	alert('Please upload only svg image');
		 }
		 
	  });	 
 
		// Now that everything has been set, let's open up the frame.
		 upload_list_svg_third_loc_filedata.open();
	 });
	
	$('#casestudy_list_remove_svg_image_button').click(function() {
		$("#casestudy_list_svg_display_image").attr('src','');
		$('#casestudy_list_upload_svg_image_id').attr('value','');	
		$('#casestudy_list_svg_link_image').css('display','none');
		$('#casestudy_list_remove_svg_image_button').css('display','none');
	});
	
	
	// Slider no image
	
	$(document.body).on('click.mojoOpenMediaManager', '#casestudy_slider_upload_image_button', function(e){ 
	 	//cs_image_issue is the class of our form button
		// Prevent the default action from occuring.
		 e.preventDefault();
		// Get our Parent element
		 upload_third_slider_locationlabel_data = $(this).parent();
		 
		 // If the frame already exists, re-open it.
		 if ( upload_slider_third_loc_filedata ) {
		 upload_slider_third_loc_filedata.open();
		 return;
		 }
		 
		 upload_slider_third_loc_filedata = wp.media.frames.upload_slider_third_loc_filedata = wp.media({
					 title: "Add No Image For Slider",
				     button: {
					  text: "Insert No Image For Slider",
				     },
					 editing:    true,
					 className: 'media-frame upload_third_loc_file',
					 frame: 'select', //Allow Select Only
					 multiple: false, //Disallow Mulitple selections
					 library: {
					 type: 'image' //Only allow images type: 'image'
			 },
		});
		
		 upload_slider_third_loc_filedata.on('select', function(){
		 // Grab our attachment selection and construct a JSON representation of the model.
		 var loc_media_attachmentdata = upload_slider_third_loc_filedata.state().get('selection').first().toJSON();
		 var thum_url = loc_media_attachmentdata.sizes.full.url;
		 var thumb_id = loc_media_attachmentdata.id; 
		// Send the attachment URL to our custom input field via jQuery.
		 loc_url = loc_media_attachmentdata.url;
		 locurls = loc_url.substr( (loc_url.lastIndexOf('.') +1) );
		
		 if(locurls !='pdf' && locurls !='zip' && locurls !='rar'  && locurls !='svg+xml')
		 {
		 	 $('#casestudy_slider_link_image').css('display','block');
			 $('#casestudy_slider_remove_image_button').css('display','inline-block');
			 $('#casestudy_slider_upload_image_id').val(thumb_id);
			 $('#casestudy_slider_display_image').attr('src',thum_url );
		 }else{
			 alert('Please add only image');
	     }
		 });
 
		// Now that everything has been set, let's open up the frame.
		 upload_slider_third_loc_filedata.open();
	 });
	
	$('#casestudy_slider_remove_image_button').click(function() {
		$("#casestudy_slider_display_image").attr('src','');
		$('#casestudy_slider_upload_image_id').attr('value','');	
		$('#casestudy_slider_link_image').css('display','none');
		$('#casestudy_slider_remove_image_button').css('display','none');
	});
	
	// Slider svg no image
	
	$(document.body).on('click.mojoOpenMediaManager', '#casestudy_slider_svg_upload_image_button', function(e){ 
	 	//cs_image_issue is the class of our form button
		// Prevent the default action from occuring.
		 e.preventDefault();
		// Get our Parent element
		 upload_third_slider_svg_locationlabel_data = $(this).parents();
		 
		 // If the frame already exists, re-open it.
		 if ( upload_slider_svg_third_loc_filedata ) {
		 upload_slider_svg_third_loc_filedata.open();
		 return;
		 }
		 
		 upload_slider_svg_third_loc_filedata = wp.media.frames.upload_slider_svg_third_loc_filedata = wp.media({
					 title: "Add SVG No Image For Slider",
				     button: {
					  text: "Insert SVG No Image For Slider",
				     },
					 editing:    true,
					 className: 'media-frame upload_third_loc_file',
					 frame: 'select', //Allow Select Only
					 multiple: false, //Disallow Mulitple selections
					 library: {
					 type: 'image' //Only allow images type: 'image'
			 },
		});
		
		 upload_slider_svg_third_loc_filedata.on('select', function(){
		 // Grab our attachment selection and construct a JSON representation of the model.
		 var loc_media_attachmentdata = upload_slider_svg_third_loc_filedata.state().get('selection').first().toJSON();
		
		 if(loc_media_attachmentdata.subtype == "svg+xml"){
	 	 	upload_third_slider_svg_locationlabel_data.find('#casestudy_slider_svg_link_image').css('display','block');
		 	upload_third_slider_svg_locationlabel_data.find('#casestudy_slider_svg_remove_image_button').css('display','inline-block');
		 	upload_third_slider_svg_locationlabel_data.find('#casestudy_slider_svg_upload_image_id').val(loc_media_attachmentdata.id);
		 	upload_third_slider_svg_locationlabel_data.find('#casestudy_slider_svg_display_image').attr('src',loc_media_attachmentdata.url );	
		 }
		 else{
		 	alert('Please upload only svg image');
		 }
		 
	   });	 
 
		// Now that everything has been set, let's open up the frame.
		 upload_slider_svg_third_loc_filedata.open();
	 });
	
	$('#casestudy_slider_svg_remove_image_button').click(function() {
		$("#casestudy_slider_svg_display_image").attr('src','');
		$('#casestudy_slider_svg_upload_image_id').attr('value','');	
		$('#casestudy_slider_svg_link_image').css('display','none');
		$('#casestudy_slider_svg_remove_image_button').css('display','none');
	});
	
});