$(function(){
	$(document).on('click', '.social-link-click', function(){
		var sociallink_id = $(this).data('sociallink');
		$.post('https://socialshub.net/ajax/click.php', {sociallink_id:sociallink_id});
	})
});

$(function(){
	$(document).on('click', '.custom-link-click', function(){
		var customlink_id = $(this).data('customlink');
		$.post('https://socialshub.net/ajax/click.php', {customlink_id:customlink_id});
	})
});