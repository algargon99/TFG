import * as bootstrap from 'bootstrap'

import { createApp } from 'vue';

import componente from './componentes/componente.vue';

createApp({
    components: {
        componente,
    },
}).mount('#app');