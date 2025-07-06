import EducationVideos from "./components/EducationVideos.vue";

import { createApp } from "vue";

BX.namespace("BX.Robot.Components.Vue");

BX.Robot.Components.Vue.EducationVideos = function (props) {
    const app = createApp(EducationVideos, !!props ? props : {});
    app.mount(`#${props.templateId}`);
}