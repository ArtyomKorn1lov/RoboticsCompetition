export default class Timing {
    /** @type {String} */
    date;
    /** @type {String} */
    dateString;

    /** @type {Timing} */
    constructor(data) {
        this.date = data?.date;
        this.dateString = data?.dateString;
    }
}