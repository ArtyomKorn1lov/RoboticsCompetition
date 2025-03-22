<template>
  <el-form
      class="b-form"
      label-position="left"
      ref="formRef"
      :rules="rules"
      :model="formData"
      @submit.prevent.native="onSubmit(formRef)"
  >
    <el-row class="b-form__row">
      <el-col
          class="b-form__col"
          v-for="group in fields.groups"
          :key="group.code"
      >
        <el-form-item
            v-for="field in group.items"
            :key="field.code"
            :label="field.title"
            :prop="field.code"
            class="b-form__item"
        >
          <el-date-picker
              v-if="field.type === 'date'"
              type="date"
              v-model="formData[field.code]"
              :placeholder="field.placeholder"
              class="b-datepicker"
              popper-class="b-popper"
              :format="Constants.DATE_PICKER_DATE_FORMAT"
              :value-format="Constants.DATE_PICKER_DATE_FORMAT"
          />
          <el-select
              v-else-if="field.type === 'select'"
              v-model="formData[field.code]"
              class="b-select"
              popper-class="b-popper"
              :placeholder="field.placeholder"
          >
            <el-option
                v-for="option in field.items"
                class="b-select__tag"
                :key="option.id"
                :label="option.name"
                :value="option.id"
            />
          </el-select>
          <el-autocomplete
              v-else-if="field.type === 'autocomplete'"
              v-model="formData[field.code]"
              :fetch-suggestions="(queryString, callback) => querySearchAsync(queryString, callback, field.id)"
              :placeholder="field.placeholder"
              class="b-input"
              popper-class="b-popper"
          />
          <el-input
              v-else-if="field.type === 'tel'"
              v-model="formData[field.code]"
              :placeholder="field.placeholder"
              v-mask="Constants.DEFAULT_PHONE_MASK"
              class="b-input"
          />
          <el-input
              v-else-if="field.type === 'textarea'"
              v-model="formData[field.code]"
              :placeholder="field.placeholder"
              :rows="4"
              :type="field.type"
              resize="none"
              class="b-textarea"
          />
          <el-checkbox-group
              v-else-if="field.type === 'checkbox'"
              class="b-checkboxGroup"
              v-model="formData[field.code]"
          >
            <el-checkbox
                class="b-checkbox"
                size="large"
                :label="field.code"
            >
              <span class="b-checkbox__label" v-html="field.placeholder" />
            </el-checkbox>
          </el-checkbox-group>
          <el-input
              v-else
              v-model="formData[field.code]"
              :placeholder="field.placeholder"
              class="b-input"
          />
        </el-form-item>
      </el-col>

      <el-col class="b-form__col b-form__col_bottom">
        <div class="b-form__tooltip" v-html="loc.REGISTRATION_REQUIER_LABEL" />
        <el-button
            class="b-button b-button_primary"
            native-type="submit"
            :loading="isLoading"
        >
          {{ loc.REGISTRATION_SUBMIT_TITLE }}
        </el-button>
      </el-col>
    </el-row>
  </el-form>
</template>

<script setup>
import {
  ElForm,
  ElFormItem,
  ElCol,
  ElRow,
  ElInput,
  ElCheckbox,
  ElCheckboxGroup,
  ElDatePicker,
  ElButton,
  ElAutocomplete,
  ElSelect,
  ElOption
} from 'element-plus';
import { computed, reactive, ref } from 'vue';
import { useForm } from 'composable';
import Validators from "../validators";
import { sendRegisterForm, searchCountries, getFilteredPhrases, Constants, FormFields as FormFieldsModel, FormSearch } from 'tools';

/**
 * @typedef {{ formFields: FormFieldsModel[] }} RegistrationProps
 * @return {RegistrationProps}
 */
const { formFields } = defineProps({
  formFields: {
    type: Object,
    default: {}
  }
});

const formRef = ref();
const fields = reactive(formFields);

const {
  formData,
  isLoading,
  rules,
  onSubmit
} = useForm(
    fields,
    sendRegisterForm,
    Validators
);

const loc = computed(() => getFilteredPhrases('REGISTRATION_'));

const querySearchAsync = async (queryString, callback, id) => {
  if (queryString && id) {
    let countries = [];

    await searchCountries(new FormSearch({
      id: id,
      value: queryString
    }))
        .then((response) => {
          // TODO обработка ошибки пока не разберусь как возвращать статус ошибки с сервера
          if (response?.data?.status === 'error') {
            throw new Error(response?.data?.errors[0].message);
          }
          countries = [...response?.data?.data];
        })
        .catch((error) => {
          console.error('error', error);
        });

    callback(countries);
  }
}
</script>
