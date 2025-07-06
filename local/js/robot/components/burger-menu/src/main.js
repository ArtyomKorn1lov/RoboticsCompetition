import BurgerMenu from "./components/BurgerMenu.vue";

import { createApp } from "vue";

BX.namespace("BX.Robot.Components.Vue");

BX.Robot.Components.Vue.BurgerMenu = function (props) {
    const app = createApp(BurgerMenu, !!props ? props : {});
    app.mount(`#${props.templateId}`);
}