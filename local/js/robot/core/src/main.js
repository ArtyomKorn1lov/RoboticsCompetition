import * as vue from "vue";
import axios from 'axios';
import {
    ElButton
} from "element-plus";
import VueTheMask from 'vue-the-mask';

const ElPlus = {
    ElButton
}

// TODO подумать как потом изолировать UI от core на webpack, в данный момент есть проблемы с element plus
export default { vue, axios, ElPlus, VueTheMask }