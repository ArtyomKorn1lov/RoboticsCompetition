import Test from "./components/Test.vue";

import { createApp } from "vue";

BX.namespace("BX.Robot.Components.Vue");

BX.Robot.Components.Vue.Test = function (props) {
    const app = createApp(Test, !!props ? props : {});
    app.mount(`#${props.templateId}`);
}