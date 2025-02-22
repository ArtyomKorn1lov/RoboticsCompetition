<template>
  <div class="b-section b-section_pb b-section_last b-archive">

    <div class="b-section__top">
      <h2 class="h5 b-section__title b-archive__subtitle">
        Фотографии
      </h2>
    </div>
    <div class="b-materials b-materials_mb">
      <a @click="openPhoto" class="b-materials__img-wrap" href="javascript:void(0)">
        <img class="b-materials__img" src="/local/templates/robot/app/img/archive_photo_1.webp" alt="Фото фестиваля 1">
      </a>
      <a class="b-materials__img-wrap" href="javascript:void(0)">
        <img class="b-materials__img" src="/local/templates/robot/app/img/archive_photo_2.webp" alt="Фото фестиваля 2">
      </a>
      <a class="b-materials__img-wrap" href="javascript:void(0)">
        <img class="b-materials__img" src="/local/templates/robot/app/img/archive_photo_3.webp" alt="Фото фестиваля 3">
      </a>
      <a class="b-materials__img-wrap" href="javascript:void(0)">
        <img class="b-materials__img" src="/local/templates/robot/app/img/archive_photo_4.webp" alt="Фото фестиваля 4">
      </a>
      <a class="b-materials__img-wrap" href="javascript:void(0)">
        <img class="b-materials__img" src="/local/templates/robot/app/img/archive_photo_1.webp" alt="Фото фестиваля 1">
      </a>
      <a class="b-materials__img-wrap" href="javascript:void(0)">
        <img class="b-materials__img" src="/local/templates/robot/app/img/archive_photo_2.webp" alt="Фото фестиваля 2">
      </a>
      <a class="b-materials__img-wrap" href="javascript:void(0)">
        <img class="b-materials__img" src="/local/templates/robot/app/img/archive_photo_3.webp" alt="Фото фестиваля 3">
      </a>
      <a class="b-materials__img-wrap" href="javascript:void(0)">
        <img class="b-materials__img" src="/local/templates/robot/app/img/archive_photo_4.webp" alt="Фото фестиваля 4">
      </a>
      <a class="b-materials__img-wrap" href="javascript:void(0)">
        <img class="b-materials__img" src="/local/templates/robot/app/img/archive_photo_1.webp" alt="Фото фестиваля 1">
      </a>
      <a class="b-materials__img-wrap" href="javascript:void(0)">
        <img class="b-materials__img" src="/local/templates/robot/app/img/archive_photo_2.webp" alt="Фото фестиваля 2">
      </a>
    </div>

    <div class="b-section__top">
      <h2 class="h5 b-section__title b-archive__subtitle">
        Видео
      </h2>
    </div>
    <div class="b-materials b-materials_video">
      <a @click="openVideo" class="b-materials__video-wrap" href="javascript:void(0)">
        <img class="b-materials__video" src="/local/templates/robot/app/img/archive_video_1.webp" alt="Видео фестиваля 1">
        <div class="b-materials__video-icon">
          <svg>
            <use xlink:href="/local/templates/robot/app/dist/assets/icons/sprite.svg#play"></use>
          </svg>
        </div>
      </a>
      <a class="b-materials__video-wrap" href="javascript:void(0)">
        <img class="b-materials__video" src="/local/templates/robot/app/img/archive_video_1.webp" alt="Видео фестиваля 1">
        <div class="b-materials__video-icon">
          <svg>
            <use xlink:href="/local/templates/robot/app/dist/assets/icons/sprite.svg#play"></use>
          </svg>
        </div>
      </a>
      <a class="b-materials__video-wrap" href="javascript:void(0)">
        <img class="b-materials__video" src="/local/templates/robot/app/img/archive_video_1.webp" alt="Видео фестиваля 1">
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

const toggle = ref(false);
const popupContent = reactive({
  url: "",
  preview: "",
  name: "",
  type: "",
  isVideo: false
});

const openPhoto = () => {
  toggle.value = true;
  Object.assign(popupContent, {
    name: "Фото робототехники 1",
    url: "/local/templates/robot/app/img/archive_video_1.webp",
    isVideo: false
  });
}

const openVideo = () => {
  toggle.value = true;
  Object.assign(popupContent, {
    name: "Видео робототехники 1",
    url: "/local/templates/robot/app/video/demo_video.mp4",
    preview: "/local/templates/robot/app/img/archive_video_1.webp",
    type: "video/mp4",
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