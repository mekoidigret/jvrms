$(document).ready(() => {
	$(document).on('click', '.ajax-btn', function(e) {
		disableLink(e);
		$.get($(this).attr('href'), result => {
			container.loadHTML(result);
		});
	});
});