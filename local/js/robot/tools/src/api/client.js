import { API_URL } from "../constants";
import axios from "axios";
import { RequestTypes, BodyTypes, ResponseStatus, MessageTypes } from "../enums/request";
import { showMessageBox, showNotification } from "./helper";
import ErrorResponse from "../models/ErrorResponse";
import getFilteredPhrases from "../loc";
import RequestConfig from "../models/RequestConfig";

const loc = getFilteredPhrases('TOOLS_');

/**
 * API-клиент для работы с axios
 */
class ApiClient {
    /**
     * @private
     * @type {String}
     */
    #apiUrl;

    /**
     * @constructor
     * @param {String} apiUrl
     */
    constructor(apiUrl) {
        this.#apiUrl = apiUrl;
    }

    /**
     * @private
     * @param {String} url
     * @param {Object} params
     * @return {String}
     */
    #prepareUrl(url, params = null) {
        let queryString = "";
        if (!!params) {
            queryString = '?' + new URLSearchParams(params);
        }
        return `${this.#apiUrl}${url}${queryString}`;
    }

    /**
     * @private
     * @param {FormData} formData
     * @param {any} data
     * @param {String} parentKey
     * @return {void}
     */
    #buildFormData(formData, data, parentKey = '') {
        if (data && typeof data === 'object' && !(data instanceof Date) && !(data instanceof File) && !(data instanceof Blob)) {
            Object.keys(data).forEach(key => {
                this.#buildFormData(formData, data[key], parentKey ? `${parentKey}[${key}]` : key);
            });
        } else {
            const value = data == null ? '' : data;

            formData.append(parentKey, value);
        }
    }

    /**
     * @private
     * @param {any} data
     * @return {FormData}
     */
    #jsonToFormData(data) {
        const formData = new FormData();
        this.#buildFormData(formData, data);
        return formData;
    }

    /**
     * @private
     * @param {any} data
     * @param {String} dataType
     * @return {any}
     */
    #setPayload(data, dataType = 'json') {
        switch (dataType) {
            case BodyTypes.FormData:
                data = this.#jsonToFormData(data);
                break;
            default:
                break;
        }
        return data;
    }

    /**
     * @private
     * @param {String} url
     * @param {RequestConfig} config
     * @return {Promise}
     */
    async #buildRequest(url, {data, dataType = 'json', params = null, headers = {}, requestType = 'post'}) {
        const requestUrl = this.#prepareUrl(url, params);

        const payload = !!data ? this.#setPayload(data, dataType) : {};
        const config = {}
        headers && (config.headers = {...headers});

        switch (requestType) {
            case RequestTypes.GET:
                return await axios.get(requestUrl, config);
            case RequestTypes.PUT:
                return await axios.put(requestUrl, payload, config);
            case RequestTypes.DELETE:
                return await axios.delete(requestUrl, config);
            default:
                return await axios.post(requestUrl, payload, config);
        }
    }

    /**
     * @private
     * @param {any} response
     * @return {any}
     * @throws {ErrorResponse}
     */
    #createSuccess(response) {
        if (!response) {
            throw new ErrorResponse({
                message: loc.TOOLS_ERROR_RESPONSE
            });
        }
        if (response.data?.status !== ResponseStatus.SUCCESS) {
            throw new ErrorResponse({
                message: response.data?.errors[0]?.message,
                status: response.data?.status
            });
        }
        return response.data?.data;
    }

    /**
     * @private
     * @param {ErrorResponse} error
     * @param {Boolean} showMessage
     * @param {String} messageType
     * @throws {ErrorResponse}
     */
    async #createError(error, showMessage = true, messageType = MessageTypes.NOTIFICATION) {
        if (!showMessage) {
            throw error;
        }

        if (messageType === MessageTypes.MESSAGE_BOX) {
            await showMessageBox(loc.TOOLS_ERROR_TITLE, error?.message ?? loc.TOOLS_ERROR_RESPONSE);
        } else {
            await showNotification(loc.TOOLS_ERROR_TITLE, error?.message ?? loc.TOOLS_ERROR_RESPONSE);
        }

        throw error;
    }

    /**
     * @public
     * @param {String} url
     * @param {RequestConfig} config
     * @return {Promise}
     */
    async executeRequest(url, config) {
        return await this.#buildRequest(url, config)
            .then(response => this.#createSuccess(response))
            .catch(async (error) => await this.#createError(error, config.showMessage, config.messageType));
    }

    /**
     * @public
     * @param {String} url
     * @param {RequestConfig} config
     * @return {Promise}
     */
    async executePostRequest(url, config) {
        return await this.executeRequest(url, {...config, requestType: RequestTypes.POST});
    }
}

export default new ApiClient(API_URL);