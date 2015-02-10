<html>
<title>Test web service</title>
<body>

<h2>url: <?= site_url("mobileservice/".$action)?></h2>

<form encType="multipart/form-data" method="post" target="result_view" action="<?= site_url("mobileservice/".$action)?>">
	<table class="contents_edit" id="public_profile">
		<tr>
			<td>email</td>
			<td class="edit">
				<input type="text" name="email" style="width: 300px;" />
			</td>
		</tr>
		<tr>
			<td>password</td>
			<td class="edit">
				<input type="text" name="password" style="width: 300px;" />
			</td>
		</tr>
		<tr>
			<td>os</td>
			<td class="edit">
				<select name="os">
					<option value="ios">ios</option>
					<option value="android">android</option>
				</select>
			</td>
		</tr>
		<tr>
			<td>device</td>
			<td class="edit">
				<input type="text" name="device" style="width: 300px;" />
			</td>
		</tr>
		<tr>
			<td>timezone</td>
			<td class="edit">
				<input type="text" name="timezone" style="width: 300px;" />
			</td>
		</tr>
		
		<tr height="35px">
			<td></td>
			<td class="edit">
				<input type="submit" value="  login " />
			</td>
		</tr>
	</table>

</form>

</body>
</html>