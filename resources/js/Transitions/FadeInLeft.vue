<template>
  <transition
    enter-active-class="transition ease-out duration-300"
    enter-from-class="opacity-0 -translate-x-5"
    enter-to-class="opacity-100 translate-x-0"
    leave-active-class="transition ease-in duration-200"
    leave-from-class="opacity-100 translate-x-0"
    leave-to-class="opacity-0 -translate-x-5"
  >
    <slot />
  </transition>
</template>

<script setup>

</script>
