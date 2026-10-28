<?php
/**
 * Mod Digi Counter - Template
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

defined('_JEXEC') or die;

use Joomla\CMS\Factory;
use Joomla\CMS\Language\Text;

$doc = Factory::getApplication()->getDocument();
$targetValues = [];
?>

<div class="digi-counter modid-<?php echo $modid; ?> <?php echo $moduleclass_sfx; ?> reveal-digi-counter"
     role="region"
     aria-label="<?php echo Text::_('MOD_DIGI_COUNTER_ARIA_LABEL'); ?>">

    <?php echo $title    ? '<h3>' . htmlspecialchars($title)    . '</h3>' : ''; ?>
    <?php echo $subtitle ? '<h4>' . htmlspecialchars($subtitle) . '</h4>' : ''; ?>

    <div class="counters-container">

        <?php foreach ($elements as $item) : ?>
            <?php
                $targetValues[] = (int) $item->number;
                $plus           = !empty($item->plus)   ? ' data-plus="true"' : '';
                $suffix         = !empty($item->suffix) ? ' data-suffix="' . htmlspecialchars($item->suffix) . '"' : ' data-suffix="none"';
                $ariaLabel      = htmlspecialchars($item->label) . ': ' . (int) $item->number . (!empty($item->plus) ? '+' : '');
            ?>
            <div class="counter-column cols-<?php echo $totalItems; ?>">
                <div class="counter"
                     data-target="<?php echo (int) $item->number; ?>"
                     <?php echo $suffix; ?>
                     <?php echo $plus; ?>
                     aria-label="<?php echo $ariaLabel; ?>"
                     role="img">0</div>
                <div class="counter-label"><?php echo htmlspecialchars($item->label); ?></div>
            </div>
        <?php endforeach; ?>

    </div>

</div>

<?php

$jsArray = implode(', ', $targetValues);

// Unique ID per supportare più istanze del modulo nella stessa pagina
$uid = 'digiCounter_' . $modid;

$script = <<<JS
(function() {

    var targetValues = [{$jsArray}];
    var duration     = {$duration};
    var initiated    = false;
    var container    = null;

    function isInViewport(el) {
        var rect = el.getBoundingClientRect();
        return (
            rect.top    >= 0 &&
            rect.left   >= 0 &&
            rect.bottom <= (window.innerHeight || document.documentElement.clientHeight) &&
            rect.right  <= (window.innerWidth  || document.documentElement.clientWidth)
        );
    }

    function formatValue(value, suffix) {
        if (suffix === 'k' && value >= 1000) {
            return (value / 1000).toFixed(1).replace('.0', '') + 'K';
        } else if (suffix === 'm' && value >= 1000000) {
            return (value / 1000000).toFixed(1).replace('.0', '') + 'M';
        } else if (suffix === 'c') {
            return value + '%';
        }
        return value.toLocaleString('it-IT');
    }

    function animateCounters() {
        var counters  = container.querySelectorAll('.counter');
        var startTime = performance.now();

        function update(currentTime) {
            var elapsed   = currentTime - startTime;
            var progress  = Math.min(elapsed / duration, 1);

            counters.forEach(function(counter, index) {
                var target    = targetValues[index];
                var current   = Math.floor(progress * target);
                var suffix    = counter.dataset.suffix || 'none';
                counter.textContent = formatValue(current, suffix) + (counter.dataset.plus === 'true' ? '+' : '');
            });

            if (progress < 1) {
                requestAnimationFrame(update);
            } else {
                counters.forEach(function(counter, index) {
                    var suffix = counter.dataset.suffix || 'none';
                    counter.textContent = formatValue(targetValues[index], suffix) + (counter.dataset.plus === 'true' ? '+' : '');
                });
            }
        }

        requestAnimationFrame(update);
    }

    function checkViewport() {
        if (!initiated && isInViewport(container)) {
            initiated = true;
            animateCounters();
            window.removeEventListener('scroll', checkViewport);
        }
    }

    function init() {
        container = document.querySelector('.digi-counter.modid-{$modid} .counters-container');
        if (!container) return;
        checkViewport();
        window.addEventListener('scroll', checkViewport);
    }

    if (document.readyState === 'loading') {
        document.addEventListener('DOMContentLoaded', init);
    } else {
        setTimeout(init, 0);
    }

}());
JS;

$doc->addScriptDeclaration($script);
?>
