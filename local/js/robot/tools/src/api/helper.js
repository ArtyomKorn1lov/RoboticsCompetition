import { ElMessageBox, ElNotification } from "element-plus";
import getFilteredPhrases from "../loc";
import { ResponseStatus } from "../enums/request";

const loc = getFilteredPhrases('TOOLS_');

export const showMessageBox = async (title, message, type = "error", callback = null) => {
    await ElMessageBox.alert(
        message,
        title,
        {
            customClass: "b-message-box",
            showClose: type === "success",
            center: true,
            type: type,
            closeOnPressEscape: type === "success",
            closeOnHashChange: type === "success",
            showConfirmButton: true,
            confirmButtonClass: "b-button b-button_primary b-button_small",
            confirmButtonText: loc.TOOLS_OK_BTN_TITLE,
            callback: callback
        });
}

export const showNotification = async (title, message, type =  ResponseStatus.ERROR) => {
    ElNotification({
        title: title,
        message: message,
        type: type,
    });
}