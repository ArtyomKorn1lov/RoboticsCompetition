<template>
  <div class="b-study">
    <a
        v-for="(item, index) in items"
        :key="index"
        @click="openVideo(item)"
        href="javascript:void(0)"
        class="b-study__item"
        :id="item.areaId"
    >
      <span class="h5 b-study__name" v-text="item.name" />
      <div class="b-study__description" v-html="item.description" />
      <span class="b-study__icon">
          <svg><use xlink:href="/local/templates/robot/app/dist/assets/icons/sprite.svg#arrow_right"></use></svg>
      </span>
    </a>

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

const openVideo = (item) => {
  toggle.value = true;
  Object.assign(popupContent, {
    name: item.name,
    url: item.file.url,
    preview: item.preview ? item.preview : "",
    type: item.file.type,
    isVideo: true
  });
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