import './bootstrap';

import Alpine from 'alpinejs';

window.Alpine = Alpine;

Alpine.start();

fetch('/notifications/latest')
.then(res => res.json())
.then(data => {

    if(data.length > 0){
        document.getElementById('notifSound').play();
    }

});

