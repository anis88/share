$(document).ready(function  () {

	var searchForm = jQuery('.search-form form');
	
	if (searchForm) {
		searchForm.submit(function () {
			var value = jQuery('input[type=search]',this).val();
			if (value !== '') {
				window.location.href = searchForm.attr('action') + value;
			}
			return false;
		});
	}
	
	if (jQuery('form input[type=submit]')) {
		jQuery('form input[type=submit]').addClass('button');
	}
	
	// target blank
	jQuery('a.new-window').each(function () {
		$(this).click(function () {
			window.open($(this).attr('href'));
			return false;
		});
	});
	
	// like / unlike
	jQuery('a.xhr').each(function () {
		$(this).click(function () {
			var a = $(this);
			if ($(this).hasClass('disabled')) return false;
			
			$(this).addClass('disabled');
			
			$.ajax({
				url: $(this).attr('href')
			}).done(function () {
				if (a.hasClass('like')) {
					if (a.text() == 'Like') {
						a.html('Unlike');
					} else {
						a.html('Like');
					}
				}
				a.removeClass('disabled');
			});
			
			return false;
		});
	});
	
	// links in post content
	jQuery('.post-content a').each(function () {
		$(this).click(function () {
			window.open($(this).attr('href'));
			return false;
		});
	});
	
	// new post
	if (jQuery('#NewPost')) {
		jQuery('#NewPost').submit(function () {
			jQuery('#NewPost input[type=submit]').attr('disabled', 'disabled');
			
			$.ajax({
				data: $(this).serialize(),
				dataType: 'json',
				success: function (data) {
					if (data.success) {					
						window.location = 'http://' + window.location.hostname + '/share/post/' + data.success.ID;
					} else {
						alert('An error occured :(');
					}
				},
				type: 'post',
				url: $(this).attr('action')
			});
			
			return false;
		});
	};
	
	/*
	// Tooltips
	jQuery('a.show-tooltip').each(function () { });
	*/
	
	// user menue
	jQuery('a.user-menue, a.mobile-menue').each(function () {
		$(this).click(function () {
			var holder = jQuery('.dropdown').closest('.row');
			
			if (holder.hasClass('hidden')) {
				userMenue.show();
			} else {
				userMenue.hide();
			}
			
			return false;
		});
	});
	
});

var userMenue = {
	
	holder: jQuery('.dropdown').closest('.row'),
	
	hide: function () {
		jQuery('header').removeClass('header-open-mobile');
		this.holder.addClass('hidden');
	},
	
	show: function () {
		if ( ! this.holder.hasClass('hidden')) {
			return;
		}
		
		jQuery('header').addClass('header-open-mobile');
		this.holder.removeClass('hidden');
		
		jQuery('body').click(function () {
			userMenue.hide();
			jQuery('body').unbind('click');
		});
	}
	
};