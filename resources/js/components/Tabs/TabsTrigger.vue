<template>
    <button
      :class="[
        'py-2 px-3 text-left text-sm font-medium rounded-lg transition-colors',
        {
          'bg-indigo-50 text-indigo-600': active,
          'text-gray-600 hover:bg-gray-50 hover:text-gray-800': !active
        }]"
    >
      <slot />
    </button>
</template>

<script setup>

defineProps({
    active: {
        type: Boolean,
        default: false
    }
})
</script>