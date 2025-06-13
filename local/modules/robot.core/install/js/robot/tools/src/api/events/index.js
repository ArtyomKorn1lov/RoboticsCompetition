import ApiClient from '../client';
import { BodyTypes, MessageTypes } from "../../enums/request";
import RequestConfig from "../../models/RequestConfig";

/**
 * @param {RequestConfig} params
 * @return {Promise}
 */
export const sendRegisterForm = async ({ data, dataType = BodyTypes.FormData, param, headers, showMessage = true, messageType = MessageTypes.MESSAGE_BOX }) => {
    return await ApiClient.executePostRequest('/events/register/', new RequestConfig({
        data: data,
        dataType: dataType,
        param: param,
        headers: headers,
        showMessage: showMessage,
        messageType: messageType,
    }));
}

/**
 * @param {RequestConfig} params
 * @return {Promise}
 */
export const searchCountries = async ({ data, dataType = BodyTypes.FormData, param, headers, showMessage = true, messageType = MessageTypes.NOTIFICATION }) => {
    return await ApiClient.executePostRequest('/events/search-countries/', new RequestConfig({
        data: data,
        dataType: dataType,
        param: param,
        headers: headers,
        showMessage: showMessage,
        messageType: messageType,
    }));
}