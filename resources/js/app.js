import './bootstrap';

import Alpine from 'alpinejs';
import intersect from '@alpinejs/intersect';
import focus from '@alpinejs/focus';
import Chart from 'chart.js/auto';

Alpine.plugin(intersect);
Alpine.plugin(focus);

window.Alpine = Alpine;
Alpine.start();
