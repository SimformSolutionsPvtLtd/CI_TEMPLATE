<h1 class="title">User Export to XLS</h1>

<form method="post" target="export_result">
	CVS file name: <input type="text" name="export_file_name" id="export_file_name" value="<?=$table?>_<?= date('YmdHis')?>.xls" style="width: 250px;" class="validate[required]"/>
	<input type="submit" value="Export" name="action"/>
</form>

<iframe name="export_result" style="display: none; width: 500px; height: 200px;"></iframe>

