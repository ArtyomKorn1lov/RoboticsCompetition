<template>
  <div class="b-section b-section_pb b-section_last b-archive">

    <template v-if="photos && photos.length > 0">
      <div class="b-section__top">
        <h2 class="h5 b-section__title b-archive__subtitle" v-text="loc.MEDIA_ITEMS_PHOTO_TITLE" />
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
    </template>

    <template v-if="videos && videos.length > 0">
      <div class="b-section__top">
        <h2 class="h5 b-section__title b-archive__subtitle" v-text="loc.MEDIA_ITEMS_VIDEO_TITLE" />
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
          <div class="b-materials__video-icon" v-html="TemplateHelper.getIcon('play')">
          </div>
        </a>
      </div>
    </template>

    <MediaPopup
        :toggle="toggle"
        :item="popupContent"
        @close="closePopup"
    />
  </div>
</template>

<script setup>
import { computed, reactive, ref } from "vue";
import MediaPopup from "MediaPopup";
import { TemplateHelper, getFilteredPhrases, MediaPopup as MediaPopupModel, Constants } from 'tools';

/**
 * @typedef {{ photos: MediaPopupModel[], videos: MediaPopupModel[] }} MediaItemsProps
 * @return {MediaItemsProps}
 */
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

const loc = computed(() => getFilteredPhrases('MEDIA_ITEMS_'));

const openPopup = (item) => {
  toggle.value = true;
  Object.assign(popupContent, {...new MediaPopupModel(item)});
}

const closePopup = () => {
  toggle.value = false;
  setTimeout(() => {
    Object.assign(popupContent, Constants.DEFAULT_PARAMS_MEDIA_POPUP);
  }, 300);
}

</script>