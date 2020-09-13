<?php
defined('VONZO') OR exit();
?>

<div class="section">

	<?php echo $data['profile']; ?>

</div>

<script type="text/javascript">
// need this for on dynamic load
if (window.jQuery) {
	$( "#p_dob" ).datepicker({
		changeMonth: true,
		changeYear: true,
		maxDate: "+2Y",
		minDate: "-100Y",
		yearRange: "-100:+2"
	});
	$( "#p_dod" ).datepicker({
		changeMonth: true,
		changeYear: true,
		maxDate: "+2Y",
		minDate: "-100Y",
		yearRange: "-100:+2"
	});
}
</script>
