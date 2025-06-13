export default class BaseModel {
    /** @type {Number} */
    id;

    get id() {
        return this.id;
    }

    /** @param {Object} data */
    constructor(data) {
        this.id = data?.id;
    }
}