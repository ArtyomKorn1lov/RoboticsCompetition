<template>
  <div class="b-section b-section_pb b-section_last b-archive">

    <div class="b-section__top">
      <h2 class="h5 b-section__title b-archive__subtitle">
        Фотографии
      </h2>
    </div>
    <div class="b-materials b-materials_mb">
      <a
          v-for="(item, index) in photos"
          :key="index"
          @click="openPopup(item)"
          class="b-materials__img-wrap"
          href="javascript:void(0)"
      >
        <img v-if="item.url" class="b-materials__img" :src="item.url" :alt="item.name">
      </a>
    </div>

    <div class="b-section__top">
      <h2 class="h5 b-section__title b-archive__subtitle">
        Видео
      </h2>
    </div>
    <div class="b-materials b-materials_video">
      <a
          v-for="(item, index) in videos"
          :key="index"
          @click="openPopup(item)"
          class="b-materials__video-wrap"
          href="javascript:void(0)"
      >
        <img v-if="item.preview" class="b-materials__video" :src="item.preview" :alt="item.name">
        <div class="b-materials__video-icon">
          <svg>
            <use xlink:href="/local/templates/robot/app/dist/assets/icons/sprite.svg#play"></use>
          </svg>
        </div>
      </a>
    </div>

    <MediaPopup
        :toggle="toggle"
        :item="popupContent"
        @close="closePopup"
    />
  </div>
</template>

<script setup>
import MediaPopup from "MediaPopup";
import {reactive, ref} from "vue";

const { photos, videos } = defineProps({
  photos: {
    type: Array,
    default: []
  },
  videos: {
    type: Array,
    default: []
  },
});

const toggle = ref(false);
const popupContent = reactive({
  url: "",
  preview: "",
  name: "",
  type: "",
  isVideo: false
});

const openPopup = (item) => {
  toggle.value = true;
  Object.assign(popupContent, {...item});
}

const closePopup = () => {
  toggle.value = false;
  setTimeout(() => {
    Object.assign(popupContent, {
      url: "",
      preview: "",
      name: "",
      type: "",
      isVideo: false
    });
  }, 300);
}

</script>