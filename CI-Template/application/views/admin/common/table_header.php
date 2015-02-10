<thead>
	<tr>
<?php
if (!isset($order)) $order = "";

$oder_filed = "";
$order_by = "";
if ($order != '') {
	$order = explode(":", $order);
	
	$oder_filed = $order[0];
	$order_by	= $order[1];
}
   
for ($i = 0; $i < count($fileds); $i ++) {
	$width = isset($fileds[$i]['width']) ? $fileds[$i]['width']:"";
	$align = isset($fileds[$i]['align']) ? $fileds[$i]['align']:"left";
	$filed = isset($fileds[$i]['filed']) ? $fileds[$i]['filed']:"";
	$title = isset($fileds[$i]['title']) ? $fileds[$i]['title']:"";
?>
	<th class="header" width="<?= $width?>" style="text-align:<?php echo $align?>">
	<?php if ($filed == '') : ?>
		<?= $title?>
	<?php elseif ($oder_filed == $filed) : ?>
		<?php if ($order_by == 'ASC'):?>
		<a href="<?= my_switch_param($this->_segments, "order", $filed.":DESC")?>">
			<?= $title?>&#9650;
		</a>
		<?php else: ?>
		<a href="<?= my_switch_param($this->_segments, "order")?>">
			<?= $title?>&#9660;
		</a>
		<?php endif;?>
	<?php else : ?>
		<a href="<?= my_switch_param($this->_segments, "order", $filed.":ASC")?>">
			<?= $title?>
		</a>
	<?php endif; ?>
	</td>
<?php 
}
?>
	</tr>
</thead>