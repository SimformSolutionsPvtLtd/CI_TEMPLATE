<?php
	// remove old page
	$base_url = my_switch_param($this->_segments, "page");
	
	// [page_size] => 20 [items_on_page] => 20 [current_page] => 3 [current_row] => 40 [total_rows] => 1041 [last_row] => 1040 [total_pages] => 53 [has_previous] => 1 [previous_page] => 2 [previous_row] => 20 [has_next] => 1 [next_page] => 4 [next_row] => 60
	
	$show_start_page = $paged->current_page - (($paged->current_page - 1) % MAX_DISPLAY_PAGE_LINKS);
	$show_last_page = $show_start_page + MAX_DISPLAY_PAGE_LINKS - 1;
	if ($show_last_page > $paged->total_pages) $show_last_page = $paged->total_pages; 
?>
<tfoot class="paging">
	<tr><td colspan="20">
		Displaying <?= $paged->current_row + 1?> to <?= $paged->current_row + $paged->items_on_page?> (of <?=$paged->total_rows?> <?=$model?><?= $paged->total_rows != 1 ? 's' : ''; ?>)
		&nbsp;&nbsp;&nbsp;
	<?php if ($paged->total_pages < MAX_DISPLAY_PAGE_LINKS):?>
		<?php for ($i = 1; $i < $paged->total_pages; $i ++) :?>
			<?php if ($i == $paged->current_page):?>
				<span><b><?= $i?></b></span>
			<?php else:?>
				<a href="<?= $base_url?>/page/<?= $i?>" title="Go to page <?= $i?>"><?= $i?></a>
			<?php endif;?>
		<?php endfor;?>
	<?php else:?>
		<?php if($paged->has_previous): ?>
			<a href="<?php echo $base_url; ?>/page/1" title="Go to first page">&#171;First</a>
		<?php else:?>
			&#171;First
		<?php endif;?>
		
		<?php if($show_start_page != 1): ?>
			<a href="<?php echo $base_url; ?>/page/<?=$show_start_page-10?>" title="Go to page <?=$show_start_page-10?>">...</a>
		<?php endif;?>
		
		<?php for ($i = $show_start_page; $i <= $show_last_page; $i ++) :?>
			<?php if ($i == $paged->current_page):?>
				<span><b><?= $i?></b></span>
			<?php else:?>
				<a href="<?= $base_url?>/page/<?= $i?>" title="Go to page <?= $i?>"><?= $i?></a>
			<?php endif;?>
		<?php endfor;?>
		
		<?php if($show_last_page != $paged->total_pages): ?>
			<a href="<?php echo $base_url; ?>/page/<?=$show_last_page+1?>" title="Go to page <?=$show_last_page+1?>">...</a>
		<?php endif;?>
		
		<?php if($paged->has_next): ?>
			<a href="<?php echo $base_url; ?>/page/<?= $paged->total_pages; ?>" title="Go to last <?= $i?>">Last&#187;</a>
		<?php else:?>
			Last&#187;
		<?php endif;?>
	<?php endif;?>
	</td></tr>
</tfooter>
