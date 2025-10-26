<template>
    <FadeInUp>
    <div v-if="countSelected" class="fixed bottom-6 p-1 left-1/2 flex items-center gap-x-2 max-w-sm rounded-full bg-neutral-900 shadow-xl">
        <!-- selected-items -->
        <div class="rounded-full shrink-0 size-7 text-sm font-medium bg-green-500/20 text-green-500 grid place-items-center">
            {{ countSelected }}
        </div>
        <BulkSeparator/>
        <!-- Action button -->
        <slot/>
    </div>
    </FadeInUp>
</template>

<script setup>
import FadeInUp from '@/Transitions/FadeInUp.vue';
import BulkSeparator from './BulkSeparator.vue';

defineProps({
    countSelected: {
        type: Number,
        default: 0
    }
})
</script>