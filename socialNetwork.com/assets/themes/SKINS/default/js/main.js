$(document).ready(function() {

	$('.conversation-message-list').niceScroll({
		cursorwidth: '8px',
		cursorborder: '0px',
		railalign: 'right',
		cursorcolor: '#fff',
		horizrailenabled: false
	});

	$('.emoticon-scroll').niceScroll({
		cursorwidth: '6px',
		cursorborder: '0px',
		railalign: 'right',
		cursorcolor: '#fff',
		horizrailenabled: false
	});

	$('.sticker-store-content').niceScroll({
		cursorwidth: '6px',
		cursorborder: '0px',
		railalign: 'right',
		cursorcolor: '#eee',
		horizrailenabled: false
	});

	$('#view-photo-comments').niceScroll({
		cursorwidth: '7px',
		cursorborder: '0px',
		railalign: 'right',
		cursorcolor: '#eee',
		horizrailenabled: false
	});

	$('#all-notifications').niceScroll({
		cursorwidth: '7px',
		cursorborder: '0px',
		railalign: 'right',
		cursorcolor: '#eee',
		horizrailenabled: false
	});

	$('.navbar-notification .niceScroll').niceScroll({
		cursorwidth: '10px',
		cursorborder: '0px',
		cursorcolor: '#eee',
		horizrailenabled: false
	});

	$('.gift-selection').niceScroll({
		cursorwidth: '5px',
		cursorborder: '0px',
		cursorcolor: '#e9573f',
		horizrailenabled: false
	});

	$('.gift-selection').niceScroll({
		cursorwidth: '5px',
		cursorborder: '0px',
		cursorcolor: '#eee',
		horizrailenabled: false
	});

	$('.chosen').each(function(){  
		$(this).chosen({disable_search_threshold: 10});
	}); 

	if(showControls == true) {
		$('.profile-gallery').bxSlider({
			minSlides: 2,
			maxSlides: 4,
			slideWidth: 150,
			slideMargin: 0,
			pager: false,
			preloadImages: 'all',
			controls: true,
			infiniteLoop: false
		});
	} else {
		$('.profile-gallery').bxSlider({
			minSlides: 2,
			maxSlides: 4,
			slideWidth: 150,
			slideMargin: 0,
			pager: false,
			preloadImages: 'all',
			controls: false,
			infiniteLoop: false
		});
	}

	var age_range = $("#age_range").slider();
	var distance_range = $("#distance_range").slider();

	$('.conversation-message-list').getNiceScroll(0).doScrollTop($('.conversation-content').height(),-1);

});

$(".fbphotobox img").fbPhotoBox({
	rightWidth: 360,
	minLeftWidth: 520,
	minHeight: 520,
	leftBgColor: "black",
	rightBgColor: "white",
	footerBgColor: "black",
	overlayBgColor: "black",
	overlayBgOpacity: 0.96,
	imageOverlayFadeSpeed: 150,
	containerClassName: 'fbphotobox',
	imageClassName: 'photo',
});

$(document).keypress(function(e) {
	if(e.which == 13) {
		var photo_id = $("#photo_id").val();
		var profile_id = $('#profile_id').val();
		if(photo_id == "" || photo_id == " ") {
			//Instagram
			var comment = $(".comment-input");
			var photo_url = $("#photo_url").val();
			if(/\S/.test(comment.val())) {
				$.get(base+'/ajax/addIGPhotoComment.php?comment='+comment.val()+'&photo_url='+photo_url+'&profile_id='+profile_id, function(data) {
					$('.fbphotobox-image-content').html(data);
					comment.val('');
				});
			}
		} else {
			//Uploaded
		}
	}

});

function likeProfile(id) {
	heart = $("#heart-"+id);
	$.get(base+'/ajax/likeProfile.php?id='+id, function(data) {
		heart.html(data);
	});
}

function toggleEmoticons() {
	var box = $('.emoticon-box');
	box.toggle();	
}

function hideEmoticons() {
	var box = $('.emoticon-box');
	box.hide();
}

function toggleStore() {
	var store = $('#sticker-store');
	store.modal('toggle');	
}

function loadStickers(pack_id) {
	var conversation_id = $('#conversation_id').val();
	$('.emoticon-box-control').each(function(){  
		$(this).removeClass('active');
	});  
	var sticker_control = $('.sticker-pack-'+pack_id).addClass('active');
	$.get(base+'/ajax/getStickers.php?pack_id='+pack_id+'&conversation_id='+conversation_id, function(data) {
		$('.emoticon-scroll').html(data);
	});
	$('.emoticon-scroll').addClass('no-padding');
}

function sendSticker(sticker_id,conversation_id) {
	$.get(base+'/ajax/sendSticker.php?sticker_id='+sticker_id+'&conversation_id='+conversation_id, function(data) {
	});
}

function addStickerPack(pack_id,receiver_id) {
	$.get(base+'/ajax/addStickerPack.php?pack_id='+pack_id+'&receiver_id='+receiver_id, function(data) {
		$('.add-sticker-pack-'+pack_id).html(data);
	});
}

function appendToMessage(str) {
	var message = $("#message");
	message.val(message.val()+" "+str);
}

function loadEmoticons() {
	$.get(base+'/ajax/getEmoticons.php', function(data) {
		$('.emoticon-scroll').html(data);
		$('.emoticon-box-control').each(function(){  
			$(this).removeClass('active');
		});  
		$('.emoticon').each(function() {
			var original = $(this).html();
			var converted = emojione.toImage(original);
			$(this).html(converted);
		});
		$('.emoticon-toggle').addClass('active');
	});
}


function addPhotoComment() {
	var comment = $("#comment");
	var photo_id = $("#photo_id").val();
	if(/\S/.test(comment.val())) {
		$.get(base+'/ajax/addPhotoComment.php?comment='+comment.val()+'&photo_id='+photo_id, function(data) {
			$('#view-photo-comments').html(data);
			comment.val('');
		});
	}
}

function readURL(input) {
	if (input.files && input.files[0]) {
		var reader = new FileReader();
		reader.onload = function (e) {
			$('.photo-upload-preview').attr('src', e.target.result);
		}
		reader.readAsDataURL(input.files[0]);
	}
}

function selectPhoto() {
	var file_input = $('#photo_file');
	file_input.trigger('click');
	$('.photo-upload-select').blur();
}

function photoChange(photo) {
	var select = $('.photo-upload-select');
	var ext = $('#photo_file').val().split('.').pop().toLowerCase();
	var error = $('#photo-upload-error');
	var upload_btn = $('#upload-btn');
	if($.inArray(ext, ['gif','png','jpg','jpeg']) == -1) {
		error.html('Please, upload a valid image file');
		error.show();
		upload_btn.prop('disabled',true);
	} else {
		error.hide();
		select.removeClass('text-muted');
		readURL(photo);
		$('.photo-upload-preview').show();
		upload_btn.removeAttr('disabled');
	}
}

function manageFriendStatus(user1,user2,action) {
	var friendArea = $("#friendArea");
	if(action === 'send_request') {
		$.get(base+'/ajax/manageFriendStatus.php?user1='+user1+'&user2='+user2+'&action=send_request', function(data) {
			friendArea.html(data);
			friendArea.attr('onclick',"manageFriendStatus("+user1+","+user2+",'cancel_request')");
		}); 
	} else if(action === 'unfriend') {
		$.get(base+'/ajax/manageFriendStatus.php?user1='+user1+'&user2='+user2+'&action=unfriend', function(data) {
			friendArea.html(data);
			friendArea.attr('onclick',"manageFriendStatus("+user1+","+user2+",'send_request')");
		}); 
	} else if(action === 'accept_request') {
		$.get(base+'/ajax/manageFriendStatus.php?user1='+user1+'&user2='+user2+'&action=accept_request', function(data) {
			friendArea.html(data);
			friendArea.attr('onclick',"manageFriendStatus("+user1+","+user2+",'unfriend')");
		}); 	
	} else if(action === 'cancel_request') {
		$.get(base+'/ajax/manageFriendStatus.php?user1='+user1+'&user2='+user2+'&action=cancel_request', function(data) {
			friendArea.html(data);
			friendArea.attr('onclick',"manageFriendStatus("+user1+","+user2+",'send_request')");
		}); 
	}
}

function setAsProfilePhoto(id) {
		$.get(base+'/ajax/setAsProfilePhoto.php?photo_id='+id, function(data) {
			location.reload();
		}); 
}

function deletePhoto(photo_id) {
	$.get(base+'/ajax/deletePhoto.php?photo_id='+photo_id, function(data) {
		location.reload();
	}); 
}

function getNotificationCount() {
	$.get(base+'/ajax/getNotificationCount.php', function(data) {
		$('#notification-count').each(function(){  
			$(this).html(data);
		});
	}); 
}

function getNotifications() {
	$.get(base+'/ajax/getNotifications.php', function(data) {
		$('#notification-list').html(data);
	}); 
}

function screenNotification(notification_id) {
	$.get(base+'/ajax/screenNotification.php?notification_id='+notification_id);
}

function screenNotifications() {
	$.get(base+'/ajax/getScreenNotifications.php', function(data) {
		var notifications = $.parseJSON(data);
		$.each(notifications, function(key, val) {
			$.gritter.add({
				title: val.title,
				text: val.text,
				image: val.image,
				sticky: false,
				time: '',
				fade_in_speed: 'medium', 
				fade_out_speed: 300,
				after_open: function(e){
					screenNotification(val.id);
					document.getElementById('notification').play();
				},
				after_close: function(e, manual_close){
					screenNotification(val.id);
				},
			});
		});
	}); 
}

function changePaymentMethod() {
	var credit_select = $('#credit_select');
	var payment_method = $('#payment_method');
	if(payment_method.val() == 1) {
		credit_select.hide();	
	} else {
		credit_select.show();
	}
}

function loadAllNotifications() {
	$.get(base+'/ajax/loadAllNotifications.php', function(data) { 
		$('#allNotifications').html(data);
	});
}

function selectGift(id) {
	for (var i = 1; i <= 26; i++) {
		if(id != i) {
			$('#gift'+i).css('background','none');
		} else {
			$('#gift'+i).css('background','#eee'); 
		}
	};
	$('#giftValue').val(id);
}

function closeConvActionMenu() {
	$('#conversation-actions').modal('hide');
}

window.setInterval(function(){
	screenNotifications();
	getNotificationCount();
}, 5000);

loadEmoticons();