<template>
  <div class="b-program__item">
    <div class="b-program__left">
      <div v-if="program.timeLine" class="b-program__time" v-text="program.timeLine" />
      <span v-if="program.name" class="h6 b-program__name" v-text="program.name" />
    </div>
    <div v-if="program.location" class="b-program__right" v-text="program.location" />
  </div>
</template>

<script setup>

const { program } = defineProps({
  program: {
    type: Object,
    default: {
      id: 0,
      name: '',
      location: '',
      timeLine: ''
    }
  }
});

</script>