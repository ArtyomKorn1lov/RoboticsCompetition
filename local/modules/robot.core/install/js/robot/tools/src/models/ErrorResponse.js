export default class ErrorResponse extends Error {
    /** @type {Number} */
    status;

    /** @param {ErrorResponse} data */
    constructor(data) {
        super(data?.message);
        this.status = data?.status;
    }
}