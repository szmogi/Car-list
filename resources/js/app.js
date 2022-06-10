/**
 * First we will load all of this project's JavaScript dependencies which
 * includes Vue and other libraries. It is a great starting point when
 * building robust, powerful web applications using Vue and Laravel.
 */



import { createApp } from "vue";


import Welcom from "./components/welcome.vue";
import Part from "./components/part.vue";
import Cars from "./components/carsList.vue";
import NewCarsPart from "./components/newCar.vue";
import AddPart from "./components/addPart.vue";
import dayjs from 'dayjs';


const app = createApp({    
    name:'App',
   
});

app.component('add-part', AddPart)
app.component('part-list', Part)
app.component('list-cars', Cars)
app.component('new-cars-part', NewCarsPart)
app.component('welcome-cars', Welcom)
app.use(dayjs)




.mount('#app');