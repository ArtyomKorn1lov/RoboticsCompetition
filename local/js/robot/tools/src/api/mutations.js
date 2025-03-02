import axios from "axios";
import {apiUrl, jsonToFormData} from "./options";

/**
 * Функция POST-запроса axios
 * @param {string} url
 * @param {boolean|object} formData
 * @param {boolean|object} headers
 */
export const mutationPostRequest = async (url, formData = false, headers = false) => {
    formData && (formData = jsonToFormData(formData));
    return await axios.post(apiUrl + url,formData ?? {}, !!headers ? { headers: headers } : {});
}