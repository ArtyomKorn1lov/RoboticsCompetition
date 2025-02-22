<template>
  <el-form
      class="b-form"
      label-position="left"
  >
    <el-row class="b-form__row">
      <el-col class="b-form__col">
        <el-form-item
            class="b-form__item"
            :label="'ФИО участника*'"
        >
          <el-input
              class="b-input"
              v-model="name"
              :placeholder="'ФИО участника*'"
          >
          </el-input>
        </el-form-item>
        <el-form-item
            class="b-form__item"
            :label="'Дата рождения*'"
        >
          <el-date-picker
              class="b-datepicker"
              type="date"
              v-model="date"
              :placeholder="'Дата рождения*'"
              popper-class="b-popper"
          />
        </el-form-item>
        <el-form-item
            class="b-form__item"
            :label="'Страна*'"
        >
          <el-autocomplete
              v-model="search"
              :fetch-suggestions="querySearchAsync"
              class="b-input"
              :placeholder="'Страна*'"
              popper-class="b-popper"
          >
          </el-autocomplete>
        </el-form-item>
        <el-form-item
            class="b-form__item"
            :label="'Курс'"
        >
          <el-input
              class="b-input"
              v-model="course"
              :placeholder="'Курс'"
          >
          </el-input>
        </el-form-item>
        <el-form-item
            class="b-form__item"
            :label="'Шифр и наименование направления подготовки'"
        >
          <el-input
              class="b-input"
              v-model="barcode"
              :placeholder="'Шифр и наименование направления подготовки'"
          >
          </el-input>
        </el-form-item>
        <el-form-item
            class="b-form__item"
            :label="'Телефон*'"
        >
          <el-input
              class="b-input"
              v-model="phone"
              :placeholder="'Телефон*'"
          >
          </el-input>
        </el-form-item>
        <el-form-item
            class="b-form__item"
            :label="'E-mail*'"
        >
          <el-input
              class="b-input"
              v-model="email"
              :placeholder="'E-mail*'"
          >
          </el-input>
        </el-form-item>
        <el-form-item
            class="b-form__item"
            :label="'Комментарий'"
        >
          <el-input
              class="b-textarea"
              v-model="comment"
              :placeholder="'Комментарий'"
              :rows="4"
              type="textarea"
              resize="none"
          >
          </el-input>
        </el-form-item>
        <el-form-item
            class="b-form__item"
        >
          <el-checkbox-group class="b-checkboxGroup" v-model="checkList">
            <el-checkbox class="b-checkbox" size="large">
              <span class="b-checkbox__label">
                Согласие на обработку <a href="#" target="_blank">персональных данных</a>*
              </span>
            </el-checkbox>
          </el-checkbox-group>
        </el-form-item>
      </el-col>
      <el-col class="b-form__col b-form__col_bottom">
        <div class="b-form__tooltip">
          Обязательные поля обозначены флажком <span>«*»</span>
        </div>
        <el-button
            class="b-button b-button_primary"
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
  ElMessage,
  ElAutocomplete,
} from 'element-plus';
import {ref} from 'vue';

const countries = [
  {value: 'Российская федерация'},
  {value: 'Республика Таджикистан'},
  {value: 'Республика Узбекистан'},
];

const name = ref('');
const date = ref('');
const search = ref('');
const course = ref('');
const barcode = ref('');
const phone = ref('');
const email = ref('');
const comment = ref('');
const checkList = ref([]);

const querySearchAsync = async (queryString, callback) => {
  callback(countries);
}
</script>
