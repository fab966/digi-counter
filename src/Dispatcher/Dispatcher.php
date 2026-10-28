<?php
/**
 * Mod Digi Counter - Dispatcher
 *
 * @package     Joomla
 * @subpackage  Modules
 * @license     GNU/GPL, see LICENSE.php
 * @author      Fabrizio Galuppi - Digitest
 * @version     2.0.1
 * @date        Mar 2026
 * @copyright   Copyright (C) 2026 - 2030 Fabrizio Galuppi - Digitest
 * @link        https://www.digitest.net
 */

namespace Digitest\Module\DigiCounter\Site\Dispatcher;

defined('_JEXEC') or die;

use Joomla\CMS\Dispatcher\AbstractModuleDispatcher;
use Joomla\CMS\Uri\Uri;

class Dispatcher extends AbstractModuleDispatcher
{
    protected function getLayoutData(): array
    {
        $data   = parent::getLayoutData();
        $params = $data['params'];
        $module = $data['module'];

        $doc   = $this->getApplication()->getDocument();
        $modid = $module->id;

        // CSS opzionale del modulo
        if ($params->get('useintcss', '1')) {
            $doc->addStyleSheet(Uri::base(true) . '/modules/mod_digi_counter/assets/style.css');
        }

        // CSS personalizzato dall'utente
        $customCSS = $params->get('customCSS', '');
        if ($customCSS) {
            $doc->addStyleDeclaration($customCSS);
        }

        // Parametri di stile
        $numColor      = $params->get('numColor',      'rgba(100, 100, 100, 1)');
        $numSize       = $params->get('numSize',       '3rem');
        $labelColor    = $params->get('labelColor',    'rgba(55, 55, 55, 1)');
        $labelSize     = $params->get('labelSize',     '1rem');
        $titleColor    = $params->get('titleColor',    'rgba(50, 150, 227, 1)');
        $titleSize     = $params->get('titleSize',     '3rem');
        $subTitleColor = $params->get('subTitleColor', 'rgba(22, 138, 132, 1)');
        $subTitleSize  = $params->get('subTitleSize',  '2rem');
        $bkgColor      = $params->get('bkgColor',      'rgba(220, 220, 220, 1)');

        $styling  = 'div.digi-counter.modid-' . $modid . ' div.counter{color:' . $numColor . ' !important;font-size:' . $numSize . ';}';
        $styling .= 'div.digi-counter.modid-' . $modid . ' div.counter-column{background-color:' . $bkgColor . ';}';
        $styling .= 'div.digi-counter.modid-' . $modid . ' div.counter-label{color:' . $labelColor . ' !important;font-size:' . $labelSize . ';}';
        $styling .= 'div.digi-counter.modid-' . $modid . ' h3{color:' . $titleColor . ' !important;font-size:' . $titleSize . ';}';
        $styling .= 'div.digi-counter.modid-' . $modid . ' h4{color:' . $subTitleColor . ' !important;font-size:' . $subTitleSize . ';}';

        $doc->addStyleDeclaration($styling);

        // Elementi counter
        $elements   = (array) $params->get('element');
        $totalItems = count($elements);

        $data['modid']          = $modid;
        $data['title']          = $params->get('title', '');
        $data['subtitle']       = $params->get('subtitle', '');
        $data['duration']       = (int) $params->get('duration', 2000);
        $data['elements']       = $elements;
        $data['totalItems']     = $totalItems;
        $data['moduleclass_sfx'] = htmlspecialchars($params->get('moduleclass_sfx', ''), ENT_COMPAT, 'UTF-8');

        return $data;
    }
}
