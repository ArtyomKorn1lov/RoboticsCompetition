<template>
  <div class="b-section b-section_pb b-section_last">
    <div class="b-section__top">
      <h2 v-if="title" class="h5 b-section__title" v-text="title" />
    </div>
    <div class="b-program">
      <TimeLine
          v-if="dates && dates.length > 0"
          :dates="dates"
      />
      <div v-if="programData && programData.length > 0" class="b-program__list">
        <Card
            v-for="program in programData"
            :key="program.id"
            :program="program"
        />
      </div>
    </div>
  </div>
</template>

<script setup>
import { ref } from "vue";
import Card from "./Card.vue";
import TimeLine from "./TimeLine.vue";

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

</script>