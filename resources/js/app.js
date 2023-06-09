import "./bootstrap";
import { createApp } from "vue";
import router from "./router";

// Common Components
import ButtonComponent from "./components/Common/ButtonComponent.vue";
import CounterFieldComponent from "./components/Common/CounterFieldComponent.vue";
import InputComponent from "./components/Common/InputComponent.vue";
// Admin View Components
import AdminNavbarComponent from "./components/AdminView/AdminNavbarComponent.vue";
import PictureDatabaseComponent from "./components/AdminView/PictureDatabaseComponent.vue";
import PictureUploadComponent from "./components/AdminView/PictureUploadComponent.vue";
import ContentGeneratorComponent from "./components/AdminView/ContentGeneratorComponent.vue";
import SelectComponent from "./components/AdminView/SelectComponent.vue";
import TiptapComponent from "./components/AdminView/TiptapComponent.vue";
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
admin.component("TiptapComponent", TiptapComponent);
admin.component("ContentGeneratorComponent", ContentGeneratorComponent);
admin.component("ButtonComponent", ButtonComponent);
admin.component("CounterFieldComponent", CounterFieldComponent);
admin.component("InputComponent", InputComponent);
admin.component("PictureDatabaseComponent", PictureDatabaseComponent);
admin.component("PictureUploadComponent", PictureUploadComponent);
admin.component("SelectComponent", SelectComponent);
admin.mount("#admin");
