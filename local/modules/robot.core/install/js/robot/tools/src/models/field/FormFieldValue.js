import BaseModel from "../BaseModel";

export default class FormFieldValue extends BaseModel {
    /** @type {String} */
    code;
    /** @type {String} */
    name;

    /** @param {FormFieldValue} data */
    constructor(data) {
        super(data);
        this.code = data?.code;
        this.name = data?.name;
    }
}