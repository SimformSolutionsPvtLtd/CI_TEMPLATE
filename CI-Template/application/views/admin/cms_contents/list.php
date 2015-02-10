<script type="text/javascript">
<!--
function delete_cms_content(cms_contentid, cms_contentname) {
	if (confirm("Are you sure delete '" + cms_contentname + "'?")) {
		location.href="<?= site_url("admin/cms_contents/delete")?>/" + cms_contentid;
	}
}
//-->
</script>

<article class="module width_full">
	<header>
		<h3 class="tabs_involved">Content List</h3>
		
		<div class="submit_link">
			<input type="button" value="New Contents" onclick="location.href='<?php echo site_url("admin/cms_contents/edit")?>'"/>&nbsp;
		</div>
	</header>
	
	<table cellspacing="0" class="tablelist tablesorter"> 
		<?php 
			$fileds = array();
 			$fileds[] = array('filed'=>'', 'title'=>'Key', 'width'=>"150");
			$fileds[] = array('title'=>'Value Size');
			$fileds[] = array('title'=>'Options', 'width'=>"70");
			
			$this->load->view('admin/common/table_header', array('fileds'=>$fileds));
		?>
		<tbody>
		<?php if($cms_contents->result_count() > 0): ?> 
		<!-- show cms_content list --> 
		<?php
			$base_url = current_url();
		
			$odd = FALSE;
			foreach($cms_contents as $u):
				$odd = !$odd;
		?>
			<tr class="<?php echo $odd ? 'odd' : 'even'; ?>">
				<td>
					<a href="<?php echo site_url("admin/cms_contents/edit/".$u->id)?>"><?php echo $u->key?></a>
				</td>
				<td>
					<?php echo strlen($u->value)?>
				</td>
				<td>
					<a href="javascript:delete_cms_content(<?= $u->id?>, '<?= $u->key?>')" title="Delete this Cms_content"><?php echo my_icon('delete', 'Delete this Cms_content'); ?></a>
				</td>
			</tr>
		<?php
			endforeach;
		?>
		<?php else:?>
			<tr><td colspan="5">Emprty Contents</td></tr>
		<?php endif;?>
		</tbody> 
	</table>
</article>