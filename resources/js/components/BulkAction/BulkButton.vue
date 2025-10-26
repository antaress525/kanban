<template>
    <button 
        class="inline-flex items-center justify-center gap-2 whitespace-nowrap text-sm font-medium transition-colors focus-visible:outline-none focus-visible:ring-1 focus-visible:ring-ring disabled:pointer-events-none disabled:opacity-50 [&_svg]:pointer-events-none [&_svg]:size-4 [&_svg]:shrink-0 shadow-sm h-7 px-2 rounded-full"
        :class="variantClass"
    >
        <slot/>
    </button>
</template>

<script setup>
import { computed } from 'vue';

const props = defineProps({
    variant: {
        type: String,
        default: 'default'
    }
})

const variantClass = computed(() => ({
    'bg-white/5 text-neutral-500': props.variant === 'default',
    'bg-red-500/15 text-red-500': props.variant === 'destructive'
}))
</script>