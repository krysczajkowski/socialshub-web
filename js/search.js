 $(function() {
     $('.search').keyup(function(){
         var search = $(this).val();
         $.post('https://socialshub.net/ajax/search.php', {search:search}, function(data) {
         	$('.search-result').innerHTML= '';
            $('.search-result').html(data);
         });
     })
 })
