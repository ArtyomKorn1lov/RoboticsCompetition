import BaseModel from "../BaseModel";
import FormFieldValue from "./FormFieldValue";

export default class FormField extends BaseModel {
    /** @type {String} */
    code;
    /** @type {String} */
    title;
    /** @type {String} */
    type;
    /** @type {String} */
    placeholder;
    /** @type {Boolean} */
    required;
    /** @type {FormFieldValue[]} */
    values;

    /** @param {FormField} data  */
    constructor(data) {
        super(data);
        this.code = data?.code;
        this.title = data?.title;
        this.type = data?.type;
        this.placeholder = data?.placeholder;
        this.required = data?.required;
        this.values = [...data?.values];
    }
}