import { RequestTypes, BodyTypes, MessageTypes } from "../enums/request";

export default class RequestConfig {
    /** @type {any} */
    data;
    /** @type {BodyTypes|String} */
    dataType;
    /** @type {Object} */
    params;
    /** @type {Object} */
    headers;
    /** @type {RequestTypes|String} */
    requestType;
    /** @type {Boolean} */
    showMessage;
    /** @type {MessageTypes|String} */
    messageType;

    /** @param {RequestConfig} data */
    constructor(data) {
        this.data = data?.data;
        this.dataType = data?.dataType;
        this.params = data?.params;
        this.headers = data?.headers;
        this.requestType = data?.requestType;
        this.showMessage = data?.showMessage;
        this.messageType = data?.messageType;
    }
}