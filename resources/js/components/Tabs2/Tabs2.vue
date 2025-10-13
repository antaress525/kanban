<template>
  <!-- Layout horizontal : barre gauche + contenu -->
  <div class="space-y-8">
    <slot name="tablist" />
    <div>
      <slot />
    </div>
  </div>
</template>

<script setup>
import { ref, provide, readonly } from 'vue'

const props = defineProps({
  defaultIndex: { type: Number, default: 0 },
})

const activeIndex = ref(props.defaultIndex)

provide('activeIndex', {
  activeIndex: readonly(activeIndex),
  setActiveIndex: (index) => {
    activeIndex.value = index
  }
})
</script>