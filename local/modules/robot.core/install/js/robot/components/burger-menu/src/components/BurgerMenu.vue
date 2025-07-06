<template>
  <div>
    <a
        @click="openMenu"
        href="javascript:void(0)"
        class="b-button b-button_primary b-header__burger"
        v-html="TemplateHelper.getIcon('burger')"
    />
    <el-drawer
        direction="ltr"
        v-model="toggle"
        :size="300"
        modal-class="b-burger"
        header-class="b-burger__header"
        body-class="b-burger__body"
    >
      <template #header>
        <div
            class="b-burger__title"
            v-text="loc.BURGER_MENU_TITLE"
        />
      </template>
      <nav v-if="items && items.length > 0" class="b-burger__menu">
        <a
            v-for="(item, index) in items"
            :key="index"
            class="b-burger__menu-item"
            :class="{'b-burger__menu-item_selected': !!item.selected}"
            :href="item.url"
            :title="item.title"
            v-text="item.title"
        />
      </nav>
    </el-drawer>
  </div>
</template>
<script setup>
import {
  ElDrawer
} from "element-plus";
import {computed, ref} from "vue";
import { TemplateHelper, getFilteredPhrases } from 'tools';

const { items } = defineProps({
  items: {
    type: Array,
    default: []
  }
});

const toggle = ref(false);

const loc = computed(() => getFilteredPhrases('BURGER_MENU_'));

const openMenu = () => {
  toggle.value = true;
}

</script>