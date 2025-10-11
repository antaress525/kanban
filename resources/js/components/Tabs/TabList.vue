<template>
  <div class="flex flex-col w-56 pr-4">
    <TabsTrigger
      v-for="(tab, index) in props.tabs"
      :key="index"
      @click="setActiveIndex(index)"
      :active="activeIndex === index"
    >
      {{ tab }}
    </TabsTrigger>
  </div>
</template>

<script setup>
import { inject } from 'vue'
import TabsTrigger from './TabsTrigger.vue'

const activeIndex = inject('activeIndex')
const setActiveIndex = inject('setActiveIndex')

const props = defineProps({
  tabs: { type: Array, required: true },
})
</script>

