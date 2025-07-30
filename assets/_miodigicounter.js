// Digi Counter Init
function isInViewport(element) {
    const rect = element.getBoundingClientRect();
    return (
        rect.top >= 0 &&
        rect.left >= 0 &&
        rect.bottom <= (window.innerHeight || document.documentElement.clientHeight) &&
        rect.right <= (window.innerWidth || document.documentElement.clientWidth)
    );
}
function animateCounters(targetValues) {
    const counters = document.querySelectorAll('.counter');
    const duration = 2000;
    const startTime = performance.now();
    function updateCounters(currentTime) {
        const elapsedTime = currentTime - startTime;
        const progress = Math.min(elapsedTime / duration, 1);
        
        counters.forEach((counter, index) => {
            const target = targetValues[index];
            const currentValue = Math.floor(progress * target);
            counter.textContent = currentValue.toLocaleString('it-IT');
        });
        
        if (progress < 1) {
            requestAnimationFrame(updateCounters);
        }
    }
    requestAnimationFrame(updateCounters);
}