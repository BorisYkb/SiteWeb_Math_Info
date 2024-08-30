document.addEventListener('DOMContentLoaded', function() {
    // Fonction pour animer les nombres
    function animateCount(element) {
        const target = +element.getAttribute('data-target');
        const increment = target / 200; // Ajustez ce nombre pour changer la vitesse

        function updateCount() {
            const current = +element.innerText;
            if (current < target) {
                element.innerText = Math.ceil(current + increment);
                requestAnimationFrame(updateCount);
            } else {
                element.innerText = target;
            }
        }

        updateCount();
    }

    // Fonction pour vérifier si un élément est visible dans le viewport
    function isVisible(element) {
        const rect = element.getBoundingClientRect();
        return (
            rect.top >= 0 &&
            rect.left >= 0 &&
            rect.bottom <= (window.innerHeight || document.documentElement.clientHeight) &&
            rect.right <= (window.innerWidth || document.documentElement.clientWidth)
        );
    }

    // Animation des nombres lorsque les statistiques deviennent visibles
    const statsSection = document.querySelector('.stats-container');
    const statsCounters = document.querySelectorAll('.count');
    let hasAnimated = false;

    function checkVisibility() {
        if (isVisible(statsSection) && !hasAnimated) {
            statsCounters.forEach(counter => {
                animateCount(counter);
            });
            hasAnimated = true;
        }
    }

    window.addEventListener('scroll', checkVisibility);
    window.addEventListener('resize', checkVisibility);

    // Vérifiez la visibilité initiale au cas où l'utilisateur commence déjà au bas de la page
    checkVisibility();
});
