<article class="module width_full">
	<header>
		<h3 class="tabs_involved"><?= $cms_content?></h3>
		<div class="submit_link">
			<input type="button" value="Back" onclick="location.href='<?php echo site_url("admin/cms_contents")?>'">
		</div>
	</header>
	<form enctype="multipart/form-data" method="post" name="frm_cms">
		<div class="module_content">
			<fieldset>
				<label for="key">Key:</label>
				<input type="text" value="<?= $cms_content->key?>" id="key" name="key" class="required">
			</fieldset>
			<fieldset>
				<label for="cms_value">value:</label>
				<div style="clear: both; float: none;"></div>
				<div style="margin: 0 10px;">
					<textarea class="required" id="cms_value_buff" rows="30"><?= str_replace("\\", "", $cms_content->value)?></textarea>
					<input type="hidden" id="cms_value" name="value" />
				</div>
			</fieldset>
			<p class="buttons">
				<input type="button" class="alt_btn" value="Save" onclick="saveValues()">	
			</p>
		</div>
	</form>
</article>

<script type="text/javascript" src="<?= WEBSITE_ROOT?>static/tinymce/tiny_mce.js"></script>
<script language="javascript">tiny_mce_init()</script>

<script type="text/javascript">
<!--
function saveValues() {
	$('#cms_value').val(tinyMCE.get('cms_value_buff').getContent());
	document.frm_cms.submit();
}
//-->
</script>