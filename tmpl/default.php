<?php

/**
 * Mod Digi Counter Module Output
 * 
 * @package    	Joomla
 * @subpackage 	Modules
 * @license    	GNU/GPL, see LICENSE.php
 * @author		Fabrizio Galuppi - Digitest
 * @version		1.0.5
 * @date		May 2025
 * @copyright   Copyright (C) 2025- 2030 Fabrizio Galuppi - Digitest
 * @link       	https://www.digitest.net
 */



defined('_JEXEC') or die;

use Joomla\CMS\Factory;
use Joomla\CMS\Router\Route;
use Joomla\CMS\HTML\HTMLHelper;
use Joomla\CMS\Language\Text;

$doc = Factory::getDocument();

$targetValues = [];

?>

<div class="digi-counter modid-<?php echo $modid; ?><?php echo $moduleclass_sfx; ?> reveal-digi-counter">

	<?php echo $title ? '<h3>' . $title . '</h3>' : ''; ?>
	<?php echo $subtitle ? '<h4>' . $subtitle . '</h4>' : ''; ?>

	<div class="counters-container">

	<?php	
	
	foreach ($elements as $item) {
		
    	echo '<div class="counter-column cols-' . $totalItems . '">';
		
    	echo '<div class="counter" data-target="'.$item->number.'" data-suffix="'.$item->suffix.'"'.($item->plus ? ' data-plus="true"' : '').'>0</div>';
		
    	echo '<div class="counter-label">' . $item->label . '</div>';
    	echo '</div>';
    
		// Populate Array with target Values
    	$targetValues[] = $item->number;
	}
		
	$jsArray = implode(', ', $targetValues);	
		
	?>
	</div>
	
</div>

<?php
	
// Prepara lo script
$script = <<<JS
// Funzione per verificare la visibilità dell'elemento
function isInViewport(element) {
    const rect = element.getBoundingClientRect();
    return (
        rect.top >= 0 &&
        rect.left >= 0 &&
        rect.bottom <= (window.innerHeight || document.documentElement.clientHeight) &&
        rect.right <= (window.innerWidth || document.documentElement.clientWidth)
    );
}

// Funzione principale per animare i counter
function animateCounters(targetValues) {
    const counters = document.querySelectorAll('.counter');
    const duration = $duration;
    const startTime = performance.now();
    
    function formatValue(value, suffix) {
        if (suffix === 'k' && value >= 1000) {
            return (value / 1000).toFixed(1).replace('.0', '') + 'K';
        } 
        else if (suffix === 'm' && value >= 1000000) {
            return (value / 1000000).toFixed(1).replace('.0', '') + 'M';
        }
		else if (suffix === 'c') {
			return (value) + '%';
		}
        return value.toLocaleString('it-IT');
    }
    
    function updateCounters(currentTime) {
        const elapsedTime = currentTime - startTime;
        const progress = Math.min(elapsedTime / duration, 1);
        
        counters.forEach((counter, index) => {
            const target = targetValues[index];
            const currentValue = Math.floor(progress * target);
            const suffix = counter.dataset.suffix || 'none';
            const formattedValue = formatValue(currentValue, suffix);
            
            // Aggiunge + SOLO se presente nel parametro Joomla (anche con suffisso)
            counter.textContent = formattedValue + (counter.dataset.plus === 'true' ? '+' : '');
        });
        
        if (progress < 1) {
            requestAnimationFrame(updateCounters);
        }
    }
    
    requestAnimationFrame(updateCounters);
}

// Inizializzazione
document.addEventListener('DOMContentLoaded', function() {
    const countersContainer = document.querySelector('.counters-container');
    let hasAnimated = false;
    const targetValues = [{$jsArray}];
    
    function checkViewport() {
        if (isInViewport(countersContainer) && !hasAnimated) {
            hasAnimated = true;
            animateCounters(targetValues);
            window.removeEventListener('scroll', checkViewport);
        }
    }
    
    // Controlla all'avvio e allo scroll
    checkViewport();
    window.addEventListener('scroll', checkViewport);
});
JS;

	// Aggiungi lo script al documento Joomla
	$doc->addScriptDeclaration($script);
	
?>