import { mutationPostRequest } from "./mutations";

export const sendRegisterForm = async (formData, headers = false) => {
    return await mutationPostRequest(`/events/register/`, formData);
}

export const searchCountries = async (formData, headers = false) => {
    return await mutationPostRequest(`/events/search-countries/`, formData);
}