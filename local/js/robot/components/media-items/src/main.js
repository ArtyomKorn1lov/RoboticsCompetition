import MediaItems from "./components/MediaItems.vue";

import { createApp } from "vue";

BX.namespace("BX.Robot.Components.Vue");

BX.Robot.Components.Vue.MediaItems = function (props) {
    const app = createApp(MediaItems, !!props ? props : {});
    app.mount(`#${props.templateId}`);
}