(function(){
    async function readLedData(){
        const url = '/api/leds';
        const response = await fetch(url);
        const data = await response.json();
        updateLeds(data);
    }

    function updateLeds(leds){
        const ledsChart = document.querySelectorAll('.circle-graph');
        ledsChart.forEach(ledChart => {
            const led = leds.find(led => led.id === ledChart.dataset.ledId);
            const startPercentage = parseInt(ledChart.children[0].children[0].children[0].innerHTML);
            animatePercentageChange(startPercentage, parseInt(led.brightness), ledChart.children[0], ledChart.children[0].children[0].children[0]);
            ledChart.children[0].children[0].children[0].innerHTML = `${parseInt(led.brightness)}%`;
        });
    }

    // setTimeout(readLedData, 500);
    setInterval(readLedData, 200);

    function animatePercentageChange(startPercentage, endPercentage, circle, percentageText) {
        const duration = 500; // Duración de la animación en milisegundos
        const startTime = performance.now();
    
        function update() {
            const currentTime = performance.now();
            const progress = Math.min(1, (currentTime - startTime) / duration);
    
            // Interpolamos el porcentaje entre el inicio y el final
            const interpolatedPercentage = startPercentage + progress * (endPercentage - startPercentage);
    
            // Actualizamos el círculo y el texto
            circle.style.background = `conic-gradient(#02db02 ${interpolatedPercentage}%, #4b4b4e 0)`;
            // percentageText.textContent = `${Math.round(interpolatedPercentage)}%`;
    
            if (progress < 1) {
                // Si no hemos alcanzado el final, seguimos animando
                requestAnimationFrame(update);
            }
        }
    
        // Llamamos a la función de actualización para iniciar la animación
        requestAnimationFrame(update);
    }
})();