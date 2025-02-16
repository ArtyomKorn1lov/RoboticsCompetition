import Registration from "./components/Registration.vue";

import { createApp } from "vue";

BX.namespace("BX.Robot.Components.Vue");

BX.Robot.Components.Vue.Registration = function (props) {
    const app = createApp(Registration, !!props ? props : {});
    app.mount(`#${props.templateId}`);
}