import BaseModel from "../BaseModel";
import Timing from "./Timing";

export {
    Timing,
}

export default class Program extends BaseModel {
    /** @type {String} */
    name;
    /** @type {String} */
    location;
    /** @type {String} */
    timeLine;

    /** @type {Program} */
    constructor(data) {
        super(data);
        this.name = data?.name;
        this.location = data?.location;
        this.timeLine = data?.timeLine;
    }
}