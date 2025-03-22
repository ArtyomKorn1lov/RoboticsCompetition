<template>
  <div class="b-study">
    <a
        v-for="(item, index) in items"
        :key="index"
        @click="!isFile(item.file.type) && openVideo(item)"
        :href="isFile(item.file.type) ? item.file.url : 'javascript:void(0)'"
        :target="isFile(item.file.type) ? '_blank' : '_self'"
        class="b-study__item"
        :id="item.areaId"
    >
      <span class="h5 b-study__name" v-text="item.name" />
      <div class="b-study__description" v-html="item.description" />
      <span class="b-study__icon" v-html="TemplateHelper.getIcon('arrow_right')" />
    </a>

    <MediaPopup
        :toggle="toggle"
        :item="popupContent"
        @close="closePopup"
    />
  </div>
</template>
<script setup>
import { reactive, ref } from "vue";
import MediaPopup from "MediaPopup";
import { TemplateHelper, MediaPopup as MediaPopupModel, Constants, DocsEnum } from "tools";

/**
 * @typedef {{ items: MediaPopupModel[] }} EducationVideos
 * @return {EducationVideos}
 */
const { items } = defineProps({
  items: {
    type: Array,
    default: []
  }
});

const toggle = ref(false);
const popupContent = reactive({
  url: "",
  preview: "",
  name: "",
  type: "",
  isVideo: false
});

const isFile = (type) => {
  return DocsEnum.isDocType(type);
}

const openVideo = (item) => {
  toggle.value = true;
  Object.assign(popupContent, new MediaPopupModel({
    name: item.name,
    url: item.file.url,
    preview: item.preview ? item.preview : "",
    type: item.file.type,
    isVideo: true
  }));
}

const closePopup = () => {
  toggle.value = false;
  setTimeout(() => {
    Object.assign(popupContent, Constants.DEFAULT_PARAMS_MEDIA_POPUP);
  }, 300);
}

</script>