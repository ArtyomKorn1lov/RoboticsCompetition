import { ref, reactive, computed } from "vue";
import { getFilteredPhrases, Constants, FormFields, ApiHelper } from 'tools';

/**
 * Хук с общей логикой форм обратной связи
 * @param {FormFields} fields
 * @param {Function} ajaxFunc
 * @param {Object} validators
 * @param {String} lang
 */
export default function useForm(fields, ajaxFunc, validators = {}, lang = 'ru') {

    const formData = reactive({});
    const isLoading = ref(false);
    const rules = reactive({});

    const loc = computed(() => getFilteredPhrases('COMPOSABLE_FORM_'));

    const onInit = () => {
        initRules();
        initFormData();
    }

    const initRules = () => {

        (!!fields.groups && fields.groups.length > 0)
        && fields.groups.forEach(group => {
            (!!group.items && group.items.length > 0)
            && group.items.forEach((field) => {
                if (!field.required) {
                    return;
                }

                // Правила для валидации поля
                switch (field.type) {
                    case 'email':
                        rules[field.code] = [
                            {
                                validator:
                                    (rule, value, callback) => {
                                        const regularExpression = !!validators[field.type] ? validators[field.type] : Constants.DEFAULT_EMAIL_REGEX;
                                        if (regularExpression.test(value)) {
                                            return callback();
                                        }
                                        return callback(new Error(loc.value.COMPOSABLE_FORM_EMAIL_INVALID));
                                    },
                                trigger: "change"
                            }
                        ];
                        break;
                    case 'tel':
                        rules[field.code] = [
                            {
                                validator:
                                    (rule, value, callback) => {
                                        const regularExpression = !!validators[field.type] ? validators[field.type] : Constants.DEFAULT_PHONE_REGEX;
                                        if (regularExpression.test(value)) {
                                            return callback();
                                        }
                                        return callback(new Error(loc.value.COMPOSABLE_FORM_PHONE_INVALID));
                                    },
                                trigger: "change"
                            }
                        ];
                        break;
                    default:
                        break;
                }

                // Установка правила, что поле обязательно для заполнения
                let requireRule;
                switch (field.type) {
                    case 'autocomplete':
                    case 'select':
                    case 'checkbox':
                        requireRule = { required: field.required, message: loc.value.COMPOSABLE_FORM_FIELD_REQUIRED, trigger: 'change' };
                        break;
                    default:
                        requireRule = { required: field.required, message: loc.value.COMPOSABLE_FORM_FIELD_REQUIRED, trigger: 'blur' };
                        break;
                }

                (rules[field.code] && rules[field.code].length > 0 && requireRule)
                    ? rules[field.code].push(requireRule)
                    : (rules[field.code] = [requireRule]);
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

    const sendRequest = async (formRef, afterSuccess = null) => {
        isLoading.value = true;
        const data = { formData: formData };
        const headers = { lang: lang };
        await ajaxFunc({
            data: data,
            headers: headers,
        })
            .then(async (response) => {
                resetForm(formRef);
                isLoading.value = false;
                await ApiHelper.showMessageBox(
                    loc.value.COMPOSABLE_FORM_SUCCESS_MESSAGE_TITLE,
                    response,
                    "success",
                    afterSuccess
                );
            })
            .catch(async () => {
                isLoading.value = false;
            })
    }

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
