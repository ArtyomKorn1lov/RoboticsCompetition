import { ref, reactive } from "vue";
import { ElMessageBox } from "element-plus";

/**
 * Хук с общей логикой форм обратной связи
 * @param {Array<Object>} fields
 * @param {Function} ajaxFunc
 * @param {Object} validators
 * @returns {Object}
 */
export default function useForm(fields, ajaxFunc, validators = {}) {

    /**
     * @type {RegExp}
     */
    const defaultEmailRegex = /^(([^%№/!<>()\[\]\\.,;:\s@"]+(\.[^%№/!<>()\[\]\\.,;:\s@"]+)*)|(".+"))@((\[[0-9]{1,3}\.[0-9]{1,3}\.[0-9]{1,3}\.[0-9]{1,3}])|(([a-zA-Z\-0-9]+\.)+[a-zA-Z]{2,}))$/;
    /**
     * @type {RegExp}
     */
    const defaultPhoneRegex = /^(\+7\(\d{3}\)-\d{3}-\d{2}-\d{2})$/;

    /**
     * @type {Reactive<Object>}
     */
    const formData = reactive({});
    /**
     * @type {Ref<Boolean>}
     */
    const isLoading = ref(false);
    /**
     * @type {Reactive<Object>}
     */
    const rules = reactive({});

    const onInit = () => {
        initRules();
        initFormData();
    }

    const initRules = () => {
        (!!fields.groups && fields.groups.length > 0)
        && fields.groups.forEach(group => {
            (!!group.items && group.items.length > 0)
            && group.items.forEach((field) => {
                switch (field.type) {
                    case 'email':
                        rules[field.code] = [
                            { required: field.required, message: "Поле обязательно для заполнения", trigger: 'blur' },
                            {
                                validator:
                                    (rule, value, callback) => {
                                        const regularExpression = !!validators[field.type] ? validators[field.type] : defaultEmailRegex;
                                        if (regularExpression.test(value)) {
                                            return callback();
                                        }
                                        return callback(new Error("Невалидный email"));
                                    },
                                trigger: "change"
                            }
                        ];
                        break;
                    case 'tel':
                        rules[field.code] = [
                            { required: field.required, message: "Поле обязательно для заполнения", trigger: 'blur' },
                            {
                                validator:
                                    (rule, value, callback) => {
                                        const regularExpression = !!validators[field.type] ? validators[field.type] : defaultPhoneRegex;
                                        if (regularExpression.test(value)) {
                                            return callback();
                                        }
                                        return callback(new Error("Невалидный телефон"));
                                    },
                                trigger: "change"
                            }
                        ];
                        break;
                    case 'autocomplete':
                        rules[field.code] = [
                            { required: field.required, message: "Поле обязательно для заполнения", trigger: 'change' },
                        ];
                        break;
                    case 'select':
                        rules[field.code] = [
                            { required: field.required, message: "Поле обязательно для заполнения", trigger: 'change' },
                        ];
                        break;
                    case 'checkbox':
                        rules[field.code] = [
                            { required: field.required, message: "Поле обязательно для заполнения", trigger: 'change' },
                        ];
                        break;
                    default:
                        rules[field.code] = [
                            { required: field.required, message: "Поле обязательно для заполнения", trigger: 'blur' },
                        ];
                        break;
                }
            });
        });
    }

    const initFormData = () => {
        (!!fields.groups && fields.groups.length > 0)
        && fields.groups.forEach(group => {
            (!!group.items && group.items.length > 0)
            && group.items.forEach((field) => {
                switch (field.type) {
                    case 'checkbox':
                        formData[field.code] = [];
                        break;
                    default:
                        formData[field.code] = null;
                        break;
                }
            });
        });
    }

    /**
     * @param {ShallowRef} formRef
     * @param {Function} afterSuccess
     */
    const onSubmit = async (formRef, afterSuccess = null) => {
        if (!formRef) {
            return;
        }

        await formRef.validate(async (valid, fields) => {
            if (!valid) {
                return;
            }
            await sendRequest(formRef, afterSuccess);
        });
    }

    /**
     * @param {ShallowRef} formRef
     * @param {Function} afterSuccess
     */
    const sendRequest = async (formRef, afterSuccess = null) => {
        isLoading.value = true;
        const data = { formData: formData };
        await ajaxFunc(data)
            .then(async (response) => {
                // TODO обработка ошибки пока не разберусь как возвращать статус ошибки с сервера
                if (response?.data?.status === "error") {
                    throw new Error(response?.data?.errors[0].message);
                }
                resetForm(formRef);
                isLoading.value = false;
                await showMessage(
                    'Успешно',
                    response?.data?.data,
                    "success",
                    afterSuccess
                );
            })
            .catch(async (error) => {
                await showMessage('Ошибка', error);
                isLoading.value = false;
            })
    }

    /**
     * @param {String} title
     * @param {String} message
     * @param {String} type
     * @param {Function} callback
     */
    const showMessage = async (title, message, type = "error", callback = null) => {
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
                confirmButtonText: 'Ок',
                callback: callback
            });
    }

    /**
     * @param {ShallowRef} formRef
     */
    const resetForm = (formRef) => {
        if (!formRef) return;
        formRef.resetFields()
    }

    onInit();

    return {
        formData,
        isLoading,
        rules,
        onSubmit
    }
}
