(function(){
    const alerts = document.querySelectorAll('.alerta');
    alerts.forEach(alert => {
        setTimeout(() => {
            alert.remove();
        }, 3000);
    });
})();