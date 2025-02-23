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
      >
        <svg>
          <use xlink:href="/local/templates/robot/app/dist/assets/icons/sprite.svg#close"></use>
        </svg>
      </a>
    </template>
    <video v-if="item.isVideo && item.url" class="b-dialog__video" controls="controls" muted :poster="item.preview">
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

const { toggle, item } = defineProps({
  toggle: {
    type: Boolean,
    default: false
  },
  item: {
    type: Object,
    default: {
      url: "",
      preview: "",
      name: "",
      type: "",
      isVideo: false
    }
  }
});

const emit = defineEmits(["close"]);

const close = () => {
  emit("close");
}

</script>