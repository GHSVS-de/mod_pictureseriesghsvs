<?php
defined('_JEXEC') or die;

use Joomla\CMS\Layout\LayoutHelper;
use Joomla\CMS\Plugin\PluginHelper;

$canResize = PluginHelper::isEnabled('system', 'bs3ghsvs')
	&& method_exists('PlgSystemBS3Ghsvs', 'moduleImagesResizing');

$imagesToResizeCollect = array();

$list = $params->get('fotos');

if (is_object($list) && count(get_object_vars($list)))
{
	foreach ($list as $key => $item)
	{
		if (
			!$item->active
			|| ! trim($item->Name . $item->text . $item->foto)
		){
			unset($list->$key);
			continue;
		}

		// Single item headline.
		$item->Name = htmlspecialchars(trim($item->Name), ENT_COMPAT, 'utf-8');
		$item->text = trim($item->text);
		$item->altText = htmlspecialchars(trim($item->altText), ENT_COMPAT, 'utf-8');

		if ($item->foto = trim($item->foto))
		{
			$item->foto = '<img src="' . $item->foto . '" alt="' . $item->altText . '">';

			$imagesToResizeCollect[$key] = $item->foto;
		}
	}
}

if (is_object($list) && count(get_object_vars($list)))
{
	// Main headline.
	if ($headLine = trim($params->get('headLine')))
	{
		$headLineTag = $params->get('headLineTag', 'h2');
		$headLine = '<' . $headLineTag . '>' . $headLine . '</' . $headLineTag . '>';
	}

	$headIcon = '';

	if ($headFoto = trim($params->get('headFoto')))
	{
		$headIcon = '<div class="section-title-icon" aria-hidden="true">'
			. '<span class="span4headFoto d-inline-block"><img src="' . $headFoto . '" alt=""></span>'
			. '</div>';
	}
	elseif ($headIcon = trim($params->get('headIcon')))
	{
		$headIcon = '<div class="section-title-icon" aria-hidden="true">'
			. '<i class="' . $headIcon . '"></i>'
			. '</div>';
	}
	
	$itemHeadTags = $params->get('itemHeadTags', 'h3');
}
else
{
	return '';
}

if ($canResize)
{
	// Replaces <img> with <figure> blocks (depends on used JLayout).
	$imagesToResizeCollect = PlgSystemBS3Ghsvs::moduleImagesResizing($imagesToResizeCollect);
}
?>
<?php
echo LayoutHelper::render('ghsvs.moduleColDiv.start',
	array(
		'module' => $module,
		'params' => $params,
		'attribs' => '',
		'prependClass' => $module->module,
	)
);
?>
<?php
if ($headLine || $headIcon)
{ ?>
<div class="row mb-60 mb-lg-40 mb-md-30 mb-sm-30 mb-xs-20">
	<div class="col">
		<div class="section-title-five text-center">
			<?php echo $headIcon; ?>
			<?php echo $headLine; ?>
		</div>
	</div>
</div>
<?php
}	?>

<?php
foreach ($list as $key => $item)
{ ?>
<div class="singleItem mb-3">
	<?php
	if ($item->Name)
	{ 
		echo '<' . $itemHeadTags . ' class="itemHead">' . $item->Name . '</' . $itemHeadTags . '>';
	} ?>
	<div class="row mb-3 align-items-center">
	<?php
	if (!empty($imagesToResizeCollect[$key]))
	{ ?>
	<div class="col-12 col-sm-6 order-last itemImage">
		<?php echo $imagesToResizeCollect[$key]; ?>
	</div>
	<?php
	} ?>
	<?php
	if ($item->text)
	{ ?>
	<div class="col-12<?php echo $item->foto ? ' col-sm-6' : ''; ?> itemText">
		<?php echo $item->text; ?>
	</div>
	<?php
	} ?>
	</div>
</div><!--/singleItem-->

<?php
}	// foreach $list

echo LayoutHelper::render('ghsvs.moduleColDiv.end');