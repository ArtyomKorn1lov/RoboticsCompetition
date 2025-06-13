import FormField from "./FormField";

export default class FormGroup {
    /** @type {String} */
    code;
    /** @type {String} */
    title;
    /** @type {FormField[]} */
    items;

    /** @param {FormGroup} data  */
    constructor(data) {
        this.code = data?.code;
        this.title = data?.title;
    }
}