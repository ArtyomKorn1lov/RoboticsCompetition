import MediaPopup from "./models/media";

/** @type {String} */
export const DEFAULT_PHONE_MASK = '+7(###)-###-##-##';

/** @type {RegExp} */
export const DEFAULT_EMAIL_REGEX = /^[A-Z0-9._%+-]+@[A-Z0-9-]+.+.[A-Z]{2,4}$/i;

/** @type {RegExp} */
export const DEFAULT_PHONE_REGEX = /^(\+7\(\d{3}\)-\d{3}-\d{2}-\d{2})$/;

/** @type {MediaPopup} */
export const DEFAULT_PARAMS_MEDIA_POPUP = new MediaPopup({
    url: "",
    preview: "",
    name: "",
    type: "",
    isVideo: false
});

/** @type {String} */
export const DATE_PICKER_DATE_FORMAT = 'DD.MM.YYYY';

export const BxDocTypes = {
    PDF_FILE_TYPE: "application/pdf",
    DOC_FILE_TYPE: "application/msword",
    DOCX_FILE_TYPE: "application/vnd.openxmlformats-officedocument.wordprocessingml.document",
    HTML_FILE_TYPE: "text/html",
}