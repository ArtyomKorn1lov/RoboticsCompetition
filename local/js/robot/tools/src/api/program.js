import { mutationPostRequest } from "./mutations";

/**
 * @param {Object} formData
 * @param {Boolean|Object} headers
 */
export const getProgramItems = async (formData, headers = false) => {
    return await mutationPostRequest(`/program/get-items/`, formData);
}

/**
 * @param {Object} formData
 * @param {Boolean|Object} headers
 */
export const sendRegisterForm = async (formData, headers = false) => {
    return await mutationPostRequest(`/events/register/`, formData);
}