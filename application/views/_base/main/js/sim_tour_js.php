<script type="text/javascript">
	$(document).ready(function(){
		$('table.zebra tbody > tr:nth-child(odd)').addClass('alt');
		$('table.zebra-even tbody > tr:nth-child(even)').addClass('alt');
		
		$("a[rel^='prettyPhoto']").prettyPhoto({
			theme: 'dark_rounded'
		});
	});
</script>