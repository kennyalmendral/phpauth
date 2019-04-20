	<script src="vendors/jquery-3.4.0.min.js"></script>
	<script src="vendors/bootstrap/bootstrap.min.js"></script>

	<script>
		$(window).on('load', function() {
			$('#preloader').delay(100).fadeOut('slow', function() {
				$(this).remove();
			});
		});

		$(document).ready(function() {
		});
	</script>
</body>
</html>
