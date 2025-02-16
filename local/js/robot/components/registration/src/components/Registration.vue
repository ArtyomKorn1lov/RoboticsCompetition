<template>
  <el-form
      class="b-form"
  >
    <el-row class="b-form__row">
      <el-col class="b-form__col">
        <el-form-item>
          <el-input
              class="b-input"
              :placeholder="'Имя*'"
          >
          </el-input>
        </el-form-item>
        <el-form-item>
          <el-input
              class="b-input"
              :placeholder="'Фамилия*'"
          >
          </el-input>
        </el-form-item>
        <el-form-item>
          <el-input
              class="b-input"
              :placeholder="'Отчество'"
          >
          </el-input>
        </el-form-item>
        <el-form-item>
          <el-input
              class="b-input"
              :placeholder="'E-mail*'"
          >
          </el-input>
        </el-form-item>
        <el-form-item>
          <el-input
              class="b-input"
              :placeholder="'Телефон*'"
          >
          </el-input>
        </el-form-item>
        <el-form-item>
          <el-input
              class="b-textarea"
              :placeholder="'Комментарий'"
              :rows="4"
              type="textarea"
          >
          </el-input>
        </el-form-item>
        <el-form-item>
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
  ElSelect,
  ElOption,
  ElUpload,
  ElIcon,
  ElButton,
  ElMessage,
} from 'element-plus';
import {ref} from 'vue';

const checkList = ref([]);
</script>
