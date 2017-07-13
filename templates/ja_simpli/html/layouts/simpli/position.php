<?php
$columns = $displayData['columns'];
$options = $displayData['options'];
$helper = $displayData['helper'];
$key = $options['key'];
?>


<div id="<?php echo $options['id'] ?>"<?php echo $options['class'] ?><?php $helper->_bg($key) ?>>
<?php $helper->_container_open($key) ?>

<?php if ($helper->has('layoutTitle_' . $key)): ?>
  <h3 class="section-title"><?php $helper->_('layoutTitle_' . $key) ?></h3>
<?php endif ?>
<?php if ($helper->has('layoutDesc_' . $key)): ?>
  <p class="section-desc"><?php $helper->_('layoutDesc_' . $key) ?></p>
<?php endif ?>

<?php if ($options['row']): ?>
<div class="<?php $helper->_row_class($key) ?>">
<?php endif ?>

	<?php foreach ($columns as $column) : ?>
	<div class="<?php echo $column->width ?>">
		<?php echo $column->html ?>
	</div>
	<?php endforeach ?>

<?php if ($options['row']): ?>
</div>
<?php endif ?>

<?php $helper->_container_close($key) ?>
</div>