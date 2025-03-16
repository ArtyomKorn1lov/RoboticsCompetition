<template>
  <div class="b-section b-section_pb b-section_last">
    <div class="b-section__top">
      <h2 v-if="title" class="h5 b-section__title" v-text="title" />
    </div>
    <div class="b-program">
      <TimeLine
          v-if="dates && dates.length > 0 && !isLoading"
          :dates="dates"
          :active-tab="activeTab"
          @change-tab="selectDate"
      />
      <div class="b-program__list">
        <template v-if="!isLoading && programData && programData.length > 0">
          <Card
              v-for="program in programData"
              :key="program.id"
              :program="program"
          />
        </template>
        <div v-else-if="!isLoading && (!programData || programData.length <= 0)">
          Список элементов пуст
        </div>
        <el-skeleton
            v-else
            :rows="6"
            animated
        />
      </div>
    </div>
  </div>
</template>

<script setup>
import { ElSkeleton, ElNotification } from "element-plus";
import { ref } from "vue";
import Card from "./Card.vue";
import TimeLine from "./TimeLine.vue";
import { getProgramItems } from 'tools';

const { title, dates, programs } = defineProps({
  title: {
    type: String,
    default: ""
  },
  dates: {
    type: Array,
    default: []
  },
  programs: {
    type: Array,
    default: []
  }
});

const programData = ref([...programs]);
const activeTab = ref(0);
const isLoading = ref(false);

const selectDate = async (index) => {
  isLoading.value = true;
  activeTab.value = index;
  programData.value = [];
  await getProgramItems({
    date: dates[index]?.date
  })
      .then((response) => {
        // TODO обработка ошибки пока не разберусь как возвращать статус ошибки с сервера
        if (response?.data?.status === "error") {
          throw new Error(response?.data?.errors[0].message);
        }
        programData.value = [...response?.data?.data];
        isLoading.value = false;
      })
      .catch((error) => {
        isLoading.value = false;
        console.error('error', error);
        ElNotification({
          title: 'Ошибка',
          message: error,
          type: 'error',
        })
      });
}
</script>