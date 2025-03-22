import BaseModel from "../BaseModel";

export default class FormSearch extends BaseModel {
    /** @type {String} */
    value;

    /** @type {FormSearch} data */
    constructor(data) {
        super(data);
        this.value = data?.value;
    }
}