<template>
  <div class="flex gap-4 border-b border-gray-200 mb-4">
    <button
      v-for="(tab, index) in props.tabs"
      :key="index"
      @click="setActiveIndex(index)"
      class="pb-2 text-sm font-medium transition-colors border-b-2"
      :class="activeIndex === index
        ? 'border-indigo-500 text-indigo-600'
        : 'border-transparent text-gray-500 hover:text-gray-700 hover:border-gray-300'"
    >
      {{ tab }}
    </button>
  </div>
</template>

<script setup>
import { inject } from 'vue'

const { activeIndex, setActiveIndex } = inject('activeIndex')

const props = defineProps({
  tabs: { type: Array, required: true },
})
</script>

