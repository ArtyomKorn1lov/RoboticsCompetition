import FormGroup from "./FormGroup";

export default class FormFields {
    /** @type {FormGroup[]} */
    groups;

    /** @param {FormFields} data  */
    constructor(data) {
        this.groups = [...data?.groups];
    }
}