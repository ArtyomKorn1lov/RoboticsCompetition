export const DocTypes = {
    PDF_FILE_TYPE: "application/pdf",
    DOC_FILE_TYPE: "application/msword",
    DOCX_FILE_TYPE: "application/vnd.openxmlformats-officedocument.wordprocessingml.document",
    HTML_FILE_TYPE: "text/html",
}

/**
 * @param {String} docType
 */
export function isDocType(docType) {
    let flag = false;
    for (const key in DocTypes) {
        if (DocTypes[key] === docType) {
            flag = true;
            break;
        }
    }
    return flag;
}