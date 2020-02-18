import Vue from 'vue';
import 'bootstrap';
import 'bootstrap/dist/css/bootstrap.min.css';
import Header from "../components/Header";
import HomePage from "../components/HomePage";
import ProfilePage from "../components/ProfilePage";

require('./bootstrap');

const app = new Vue({
    el: '#app',
    components: {
        'header-app': Header,
        'home-page': HomePage,
        'profile-page': ProfilePage
    }
});
