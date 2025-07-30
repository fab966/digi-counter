// JS for Digi Counter Module

document.addEventListener('DOMContentLoaded', function() {
  // Funzione per verificare se un elemento è nella viewport
  function isInViewport(element) {
    const rect = element.getBoundingClientRect();
    return (
      rect.top >= 0 &&
      rect.left >= 0 &&
      rect.bottom <= (window.innerHeight || document.documentElement.clientHeight) &&
      rect.right <= (window.innerWidth || document.documentElement.clientWidth)
    );
  }

  // Funzione per animare i counter
  function animateCounters(targetValues) {
    const counters = document.querySelectorAll('.counter');
    const duration = 2000; // Durata dell'animazione in ms
    const startTime = performance.now();

    // Imposta i valori target dai parametri
    counters.forEach((counter, index) => {
      counter.setAttribute('data-target', targetValues[index]);
    });

    function updateCounters(currentTime) {
      const elapsedTime = currentTime - startTime;
      const progress = Math.min(elapsedTime / duration, 1);

      counters.forEach(counter => {
        const target = parseInt(counter.getAttribute('data-target'));
        const currentValue = Math.floor(progress * target);
        counter.textContent = currentValue.toLocaleString();
      });

      if (progress < 1) {
        requestAnimationFrame(updateCounters);
      }
    }

    requestAnimationFrame(updateCounters);
  }

  // Observer per attivare l'animazione quando il container entra in viewport
  const countersContainer = document.querySelector('.counters-container');
  let hasAnimated = false;

  function checkViewport() {
    if (isInViewport(countersContainer) && !hasAnimated) {
      hasAnimated = true;

      // Esempio di valori, sostituisci con i tuoi parametri
      const targetValues = [10, 10, 10, 10];
      animateCounters(targetValues);

      // Rimuovi l'event listener dopo l'animazione
      window.removeEventListener('scroll', checkViewport);
    }
  }

  // Controlla all'avvio e durante lo scroll
  checkViewport();
  window.addEventListener('scroll', checkViewport);
});





