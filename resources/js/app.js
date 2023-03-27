import "./bootstrap";
import { createApp } from "vue";
import router from "./router";

// Common Components
import ButtonComponent from "./components/Common/ButtonComponent.vue";
import InputComponent from "./components/Common/InputComponent.vue";
// Admin View Components
import AdminNavbarComponent from "./components/AdminView/AdminNavbarComponent.vue";
// Visitor View Components
import NewElementComponent from "./components/NewElementComponent.vue";
import NavbarComponent from "./components/NavbarComponent.vue";
import IntroductionComponent from "./components/introductionComponent.vue";

import App from "./App.vue";
const app = createApp(App);
app.component("NewElementComponent", NewElementComponent);
app.component("NavbarComponent", NavbarComponent);
app.component("IntroductionComponent", IntroductionComponent);
app.mount("#app");

import Admin from "./Admin.vue";
const admin = createApp(Admin).use(router);
admin.component("AdminNavbarComponent", AdminNavbarComponent);
admin.component("ButtonComponent", ButtonComponent);
admin.component("InputComponent", InputComponent);
admin.component("IntroductionComponent", IntroductionComponent);
admin.mount("#admin");
