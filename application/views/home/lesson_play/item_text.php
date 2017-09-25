<div class="tuwen_content">
	<div class="c_cont1">
		<div>
			<?php echo $lesson[0]['content'];?>
		</div>
	</div>
</div>

<?php if($is_set['copy_enabled']==0):?>
<style type="text/css" media="screen">
 body {-moz-user-select: none;-webkit-user-select: none;}
</style>
<script type="text/javascript">
document.onselectstart = function(e) {
    return false;
}
document.oncontextmenu = function(e) {
    return false;
}
</script>
<?php endif;?>