import ProgramList from './components/App.vue';

import { createApp } from "vue";

BX.namespace("BX.Robot.Components.Vue");

BX.Robot.Components.Vue.ProgramList = function (props) {
    const app = createApp(ProgramList, !!props ? props : {});
    app.mount(`#${props.templateId}`);
}