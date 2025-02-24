function animateCounter(element, target, duration, prefix = "", suffix = "") {
    let start = 0;
    let step = Math.ceil(target / (duration / 16)); // Suaviza o incremento (~60FPS)
    function updateCounter() {
        start += step;
        if (start >= target) {
            element.innerText = `${prefix}${target}${suffix}`; // Formata corretamente
        } else {
            element.innerText = `${prefix}${start}${suffix}`;
            requestAnimationFrame(updateCounter);
        }
    }
    updateCounter();
}
function startCounter(entries, observer) {
    entries.forEach(entry => {
        if (entry.isIntersecting) {
            let counter = entry.target;
            let target = parseInt(counter.getAttribute("data-target"));
            let prefix = counter.getAttribute("data-prefix") || "";
            let suffix = counter.getAttribute("data-suffix") || "";
            animateCounter(counter, target, 2000, prefix, suffix);
            observer.unobserve(counter); // Para evitar que reinicie várias vezes
        }
    });
}
let observer = new IntersectionObserver(startCounter, { threshold: 0.5 }); // Ativa quando 50% do elemento estiver visível
document.querySelectorAll(".counter").forEach(counter => {
    observer.observe(counter);
});