import Registration from "./components/Registration.vue";

import { createApp } from "vue";
import VueTheMask from 'vue-the-mask';

BX.namespace("BX.Robot.Components.Vue");

BX.Robot.Components.Vue.Registration = function (props) {
    const app = createApp(Registration, !!props ? props : {});
    app.use(VueTheMask);
    app.mount(`#${props.templateId}`);
}