<template>
  <button
    :class="['w-full text-left px-4 py-2 text-sm transition-colors duration-100', varaintClass]"
    @click="handleClick"
  >
    <slot />
  </button>
</template>

<script setup>
import { computed } from 'vue'

const props = defineProps({
  variant: {
    type: String,
    default: 'default'
  }
})
const emits = defineEmits(['click'])

const handleClick = (event) => {
  emits('click', event)
}

const varaintClass = computed(() => ({
  'text-gray-700 hover:bg-gray-100': props.variant === 'default',
  'text-red-700 hover:bg-red-100': props.variant === 'danger',
}))
</script>
