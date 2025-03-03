import { mutationPostRequest } from "./mutations";

/**
 * @param {Object} formData
 * @param {Boolean|Object} headers
 */
export const getProgramItems = async (formData, headers = false) => {
    return await mutationPostRequest(`/program/get-items/`, formData);
}