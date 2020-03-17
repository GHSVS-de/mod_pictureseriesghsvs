<?php
defined('_JEXEC') or die;

use Joomla\CMS\Helper\ModuleHelper;

$moduleclass_sfx = htmlspecialchars($params->get('moduleclass_sfx'), ENT_COMPAT, 'UTF-8');

require ModuleHelper::getLayoutPath('mod_pictureseriesghsvs', $params->get('layout', 'default'));
