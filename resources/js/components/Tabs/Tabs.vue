<template>
  <!-- Layout horizontal : barre gauche + contenu -->
  <div class="flex w-full gap-4">
    <slot name="tablist" />
    <div class="flex-1">
      <slot />
    </div>
  </div>
</template>

<script setup>
import { ref, provide } from 'vue'

const props = defineProps({
  defaultIndex: { type: Number, default: 0 },
})

const activeIndex = ref(props.defaultIndex)
const setActiveIndex = (index) => { activeIndex.value = index }

provide('activeIndex', activeIndex)
provide('setActiveIndex', setActiveIndex)
</script>