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
        <div v-else-if="!isLoading && (!programData || programData.length <= 0)" v-text="loc.PROGRAM_LIST_EMPTY" />
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
import { computed, ref } from "vue";
import Card from "./Card.vue";
import TimeLine from "./TimeLine.vue";
import { getProgramItems, getFilteredPhrases, Program, Timing } from 'tools';

/**
 * @typedef {{ title: String, dates: Timing[], programs: Program[], lang: String }} ProgramListProps
 * @return {ProgramListProps}
 */
const { title, dates, programs, lang } = defineProps({
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
  },
  lang: {
    type: String,
    default: 'ru'
  }
});

const programData = ref([...programs]);
const activeTab = ref(0);
const isLoading = ref(false);

const loc = computed(() => getFilteredPhrases('PROGRAM_LIST_'));

const selectDate = async (index) => {
  isLoading.value = true;
  activeTab.value = index;
  programData.value = [];
  await getProgramItems(
      {
        date: dates[index]?.date
      },
      {
        lang: lang
      }
  )
      .then((response) => {
        // TODO обработка ошибки пока не разберусь как возвращать статус ошибки с сервера
        if (response?.data?.status === 'error') {
          throw new Error(response?.data?.errors[0].message);
        }
        programData.value = [...response?.data?.data];
        isLoading.value = false;
      })
      .catch((error) => {
        isLoading.value = false;
        console.error('error', error);
        ElNotification({
          title: loc.value.PROGRAM_LIST_ERROR_TITLE,
          message: error,
          type: 'error',
        })
      });
}
</script>