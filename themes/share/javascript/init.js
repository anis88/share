window.addEvent('domready', function  () {

	var searchForm = $$('.search-form form')[0];
	
	if (searchForm) {
		searchForm.addEvent('submit', function (e) {
			e.stop();
			window.location.href = searchForm.get('action') + searchForm.getElement('input').get('value');
		});
	}
	
	if ($$('form input[type=submit]')[0]) {
		$$('form input[type=submit]')[0].addClass('button');
	}
	
	$$('a.new-window').each(function (el) {
		el.addEvent('click', function (e) {
			e.stop();
			window.open(el.get('href'));
		});
	});
	
	// like / unlike
	$$('a.like').each(function (el) {
		el.addEvent('click', function (e) {
			e.stop();
			if (el.hasClass('disabled'))  return;
			
			el.addClass('disabled');
			
			new Request({
				onSuccess: function () {
					//var likes = $$('.like-count')[0];
					//likes.set('text', likes.get('text').toInt() + 1);
					if (el.get('text') == 'Like') {
						el.set('text', 'Unlike');
					} else {
						el.set('text', 'Like');
					}
					el.removeClass('disabled');
				},
				url: el.get('href')
			}).send();
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
	$$('a.user-menue').each(function (el) {
		el.addEvent('click', function (e) {
			e.stop();
			
			if ($$('.dropdown')[0].hasClass('hidden')) {
				$$('.dropdown')[0].removeClass('hidden');
			} else {
				$$('.dropdown')[0].addClass('hidden');
			}
		});
	});
	
});