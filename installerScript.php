<?php
/**
 * @package module pictureseriesghsvs for Joomla!
 * @version See pictureseriesghsvs.xml
 * @author G@HService Berlin Neukölln, Volkmar Volli Schlothauer
 * @copyright Copyright (C) 2019 - 2020, G@HService Berlin Neukölln, Volkmar Volli Schlothauer. All rights reserved.
 * @license GNU General Public License version 3 or later; see LICENSE.txt.
 * @authorUrl https://www.ghsvs.de
 * @link https://github.com/GHSVS-de/mod_pictureseriesghsvs
 */
/**
 * Use in your extension manifest file (any tag is optional!!!!!):
 * <minimumPhp>7.0.0</minimumPhp>
 * <minimumJoomla>3.9.0</minimumJoomla>
 * Yes, use 999999 to match '3.9'. Otherwise comparison will fail.
 * <maximumJoomla>3.9.999999</maximumJoomla>
 * <maximumPhp>7.3.999999</maximumPhp>
 * <allowDowngrades>1</allowDowngrades>
 */
defined('_JEXEC') or die;

use Joomla\CMS\Installer\InstallerScript;
use Joomla\CMS\Log\Log;

class mod_pictureSeriesGhsvsInstallerScript extends InstallerScript
{
	public function preflight($type, $parent)
	{
		$manifest = @$parent->getManifest();

		if ($manifest instanceof SimpleXMLElement)
		{
			if ($type === 'update' || $type === 'install' || $type === 'discover_install')
			{
				$minimumPhp = trim((string) $manifest->minimumPhp);
				$minimumJoomla = trim((string) $manifest->minimumJoomla);
	
				// Custom
				$maximumPhp = trim((string) $manifest->maximumPhp);
				$maximumJoomla = trim((string) $manifest->maximumJoomla);
	
				$this->minimumPhp = $minimumPhp ? $minimumPhp : $this->minimumPhp;
				$this->minimumJoomla = $minimumJoomla ? $minimumJoomla : $this->minimumJoomla;
	
				if ($maximumJoomla && version_compare(JVERSION, $maximumJoomla, '>'))
				{
					$msg = 'Your Joomla version (' . JVERSION . ') is too high for this extension. Maximum Joomla version is: ' . $maximumJoomla . '.';
					Log::add($msg, Log::WARNING, 'jerror');
				}
	
				// Check for the maximum PHP version before continuing
				if ($maximumPhp && version_compare(PHP_VERSION, $maximumPhp, '>'))
				{
					$msg = 'Your PHP version (' . PHP_VERSION . ') is too high for this extension. Maximum PHP version is: ' . $maximumPhp . '.';
	
					Log::add($msg, Log::WARNING, 'jerror');
				}
	
				if (isset($msg))
				{
					return false;
				}
			}

			if (trim((string) $manifest->allowDowngrades))
			{
				$this->allowDowngrades = true;
			}
		}

		if (!parent::preflight($type, $parent))
		{
			return false;
		}

		return true;
	}
}
