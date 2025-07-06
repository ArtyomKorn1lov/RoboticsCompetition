<template>
  <swiper
      class="b-slider"
      wrapper-class="b-tabs"
      :space-between="15"
      :slides-per-view="'auto'"
  >
    <swiper-slide
        class="b-slider__item"
        v-for="(date, index) in dates"
    >
      <a
          href="javascript:void(0)"
          class="b-tabs__item"
          :class="{'b-tabs__item_active': index === activeTab}"
          @click="selectDate(index)"
          v-text="date.dateString"
      />
    </swiper-slide>
  </swiper>
</template>

<script setup>
import { Swiper, SwiperSlide } from 'swiper/vue';
import { Timing } from 'tools';

/**
 * @typedef {{ dates: Timing[], activeTab: Number }} TimeLineProps
 * @return {TimeLineProps}
 */
const { dates, activeTab } = defineProps({
  dates: {
    type: Array,
    default: []
  },
  activeTab: {
    type: Number,
    default: 0
  }
});

const emit = defineEmits(['change-tab']);

const selectDate = (index) => {
  emit('change-tab', index);
}
</script>
