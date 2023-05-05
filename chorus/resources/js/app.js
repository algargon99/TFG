import * as bootstrap from 'bootstrap';

import { createApp } from 'vue/dist/vue.esm-bundler.js';
import ExampleComponent from './components/ExampleComponent.vue';


const app = createApp({})
app.component('example-component',ExampleComponent)
app.mount('#app')