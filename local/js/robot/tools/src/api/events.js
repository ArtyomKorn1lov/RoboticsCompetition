import { postRequest } from "./requests";

export const sendRegisterForm = async (formData, headers = false) => {
    return await postRequest(`/events/register/`, formData);
}

export const searchCountries = async (formData, headers = false) => {
    return await postRequest(`/events/search-countries/`, formData);
}