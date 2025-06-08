import ApiClient from '../client';
import { BodyTypes, MessageTypes } from "../../enums/request";
import RequestConfig from "../../models/RequestConfig";

/**
 * @param {RequestConfig} params
 * @return {Promise}
 */
export const getProgramItems = async ({ data, dataType = BodyTypes.FormData, param, headers, showMessage = true, messageType = MessageTypes.NOTIFICATION }) => {
    return await ApiClient.executePostRequest('/program/get-items/', new RequestConfig({
        data: data,
        dataType: dataType,
        param: param,
        headers: headers,
        showMessage: showMessage,
        messageType: messageType,
    }));
}