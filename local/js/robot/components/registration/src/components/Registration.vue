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
          />
          <el-autocomplete
              v-else-if="field.type === 'autocomplete'"
              v-model="formData[field.code]"
              :fetch-suggestions="querySearchAsync"
              :placeholder="field.placeholder"
              class="b-input"
              popper-class="b-popper"
          />
          <el-input
              v-else-if="field.type === 'tel'"
              v-model="formData[field.code]"
              :placeholder="field.placeholder"
              v-mask="'+7(###)-###-##-##'"
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
            <el-checkbox class="b-checkbox" size="large">
              <span class="b-checkbox__label" v-html="field.label" />
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
        <div class="b-form__tooltip">
          Обязательные поля обозначены флажком <span>«*»</span>
        </div>
        <el-button
            class="b-button b-button_primary"
            native-type="submit"
            :loading="isLoading"
        >
          Регистрация
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
} from 'element-plus';
import { reactive, ref } from 'vue';
import { useForm } from 'composable';
import Validators from "../validators";
import { sendRegisterForm } from 'tools';

// TODO получать из запроса
const countries = [
  {value: 'Российская федерация'},
  {value: 'Республика Таджикистан'},
  {value: 'Республика Узбекистан'},
];

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

const querySearchAsync = async (queryString, callback) => {
  callback(countries);
}
</script>
