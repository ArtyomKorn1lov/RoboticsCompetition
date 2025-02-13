<template>
  <h1 class="red">Тестовый вывод компонента</h1>
  <el-button>
    Тестовая кнопка!
  </el-button>
  <TestCard />
</template>

<script setup>
import { ElButton } from 'element-plus';
import TestCard from 'TestCard';

console.log('TestCard', TestCard);
</script>
<style scoped>
  .red {
    color: red;
  }
</style>