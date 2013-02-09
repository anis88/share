window.addEvent('domready', function  () {

	var searchForm = $$('.search-form form')[0];
	
	if (searchForm) {
		searchForm.addEvent('submit', function (e) {
			e.stop();
			window.location.href = searchForm.get('action') + searchForm.getElement('input').get('value');
		});
	}
	
	if ($$('form input[type=submit]')[0]) {
		$$('form input')[0].focus();
		$$('form input[type=submit]')[0].addClass('button');
	}
	
	$$('a.new-window').each(function (el) {
		el.addEvent('click', function (e) {
			e.stop();
			window.open(el.get('href'));
		});
	});
	
	// like / unlike
	$$('a.xhr').each(function (el) {
		el.addEvent('click', function (e) {
			e.stop();
			if (el.hasClass('disabled'))  return;
			
			el.addClass('disabled');
			
			new Request({
				onSuccess: function () {
					if (el.hasClass('like')) {
						if (el.get('text') == 'Like') {
							el.set('text', 'Unlike');
						} else {
							el.set('text', 'Like');
						}
					}
					el.removeClass('disabled');
				},
				url: el.get('href')
			}).send();
		});
	});
	
	// links in post content
	$$('.post-content a').each(function (el) {
		el.addEvent('click', function (e) {
			e.stop();
			window.open(el.get('href'));
		});
	});
	
	// Tooltips
	$$('a.show-tooltip').each(function (el) {
		el.addEvents({
			'click':      function (e) {
				e.stop();
			},
			'mouseenter': function () {
				// TODO show tooltip and reuest data from href
			},
			'mouseleave': function () {
				// TODO hide tooltip
			}
		});
	});
	
	// user menue
	$$('a.user-menue, a.mobile-menue').each(function (el) {
		el.addEvent('click', function (e) {
			var holder = $$('.dropdown')[0].getParent('.row');
			e.stop();
			
			if (holder.hasClass('hidden')) {
				userMenue.show();
			} else {
				userMenue.hide();
			}
		});
	});
	
});

var userMenue = {

	holder: $$('.dropdown')[0].getParent('.row'),
	
	hide: function () {
		$$('header')[0].removeClass('header-open-mobile');
		this.holder.addClass('hidden');
	},
	
	show: function () {
		if ( ! this.holder.hasClass('hidden')) {
			return;
		}
		
		$$('header')[0].addClass('header-open-mobile');
		this.holder.removeClass('hidden');
		
		document.body.addEvent('click', function () {
			userMenue.hide();
			document.body.removeEvents('click');
		});
	}
	
};