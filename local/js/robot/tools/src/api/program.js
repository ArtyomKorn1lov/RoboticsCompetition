import { postRequest } from "./requests";

/**
 * @param {Object} formData
 * @param {Boolean|Object} headers
 */
export const getProgramItems = async (formData, headers = false) => {
    return await postRequest(`/program/get-items/`, formData);
}