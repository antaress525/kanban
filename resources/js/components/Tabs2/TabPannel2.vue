<template>
  <div v-show="activeIndex === props.index" class="transition-all duration-200">
    <slot />
  </div>
</template>

<script setup>
import { inject } from 'vue'

const { activeIndex } = inject('activeIndex')

const props = defineProps({
  index: { type: Number, required: true },
})
</script>
