<template>
<div class="relative" ref="dropdownRef">
    <!-- Bouton déclencheur -->
    <div @click="toggleDropdown" class="cursor-pointer select-none">
      <slot name="trigger"></slot>
    </div>

    <!-- Contenu du menu -->
    <FadeScale>
      <div
        v-if="open"
        :class="[
          'absolute z-50 mt-2 rounded-lg shadow-lg bg-white ring-1 ring-black ring-opacity-5 overflow-hidden',
          positionClass,
          sizeClass
        ]"
      >
        <slot />
      </div>
    </FadeScale>
  </div>
</template>

<script setup>
import { ref, computed, onMounted, onBeforeUnmount } from 'vue'
import FadeScale from '@/Transitions/FadeScale.vue'

const props = defineProps({
  position: {
    type: String,
    default: 'bottom-right', // top-left, top-right, bottom-left, bottom-right
  },
  size: {
    type: String,
    default: 'md', // sm, md, lg, full
  },
})

const open = ref(false)
const dropdownRef = ref(null)

const toggleDropdown = () => (open.value = !open.value)
const closeDropdown = (e) => {
  if (dropdownRef.value && !dropdownRef.value.contains(e.target)) {
    open.value = false
  }
}

onMounted(() => document.addEventListener('click', closeDropdown))
onBeforeUnmount(() => document.removeEventListener('click', closeDropdown))

// Position classes dynamiques
const positionClass = computed(() => {
  switch (props.position) {
    case 'top-left':
      return 'bottom-full left-0 mb-2 origin-bottom-left'
    case 'top-right':
      return 'bottom-full right-0 mb-2 origin-bottom-right'
    case 'bottom-left':
      return 'top-full left-0 mt-2 origin-top-left'
    case 'bottom-right':
    default:
      return 'top-full right-0 mt-2 origin-top-right'
  }
})

// Taille classes dynamiques
const sizeClass = computed(() => {
  switch (props.size) {
    case 'sm':
      return 'w-32'
    case 'md':
      return 'w-48'
    case 'lg':
      return 'w-64'
    case 'full':
      return 'w-full'
    default:
      return 'w-48'
  }
})
</script>
