import './bootstrap';
import 'flowbite';
import './home-page.js';

document.addEventListener("livewire:navigated", () => {
    initFlowbite();
});
