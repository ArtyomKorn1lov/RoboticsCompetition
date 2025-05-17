<template>
  <el-dialog
      class="b-dialog"
      :model-value="toggle"
      :show-close="false"
      :before-close="close"
      align-center
  >
    <template #header="{ close }">
      <h6 v-if="item.name" class="b-dialog__title" v-text="item.name" />
      <a
          href="javascript:void(0)"
          @click="close"
          class="b-dialog__close"
          v-html="TemplateHelper.getIcon('close')"
      />
    </template>
    <div class="b-dialog__video b-dialog__video_embed" v-if="item.type === Constants.EMBED_VIDEO_TYPES && item.isVideo">
      <iframe class="b-dialog__video-frame" :src="item.url" :title="item.name" allowfullscreen/>
    </div>
    <video v-else-if="item.isVideo && item.url" class="b-dialog__video" controls="controls" muted :poster="item.preview">
      <source :src="item.url" :type="item.type">
    </video>
    <div v-else-if="item.url" class="b-dialog__img-wrap">
      <img class="b-dialog__img" :src="item.url" :alt="item.name">
    </div>
  </el-dialog>
</template>
<script setup>
import {
  ElDialog
} from "element-plus";
import { TemplateHelper, MediaPopup, Constants } from 'tools';

const { toggle, item } = defineProps({
  toggle: {
    type: Boolean,
    default: false
  },
  item: {
    type: MediaPopup,
    default: Constants.DEFAULT_PARAMS_MEDIA_POPUP
  }
});

const emit = defineEmits(["close"]);

const close = () => {
  emit("close");
}

</script>