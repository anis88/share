window.addEvent('domready', function  () {

	var searchForm = $$('.search-form form')[0];
	
	if (searchForm) {
		searchForm.addEvent('submit', function (e) {
			e.stop();
			window.location.href = searchForm.get('action') + searchForm.getElement('input').get('value');
		});
	}
	
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
	
});