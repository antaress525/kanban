<template>
    <span :class="['text-xs font-medium px-2 py-1', rounded, color]">
        <slot />
    </span>
</template>

<script setup>
import { computed } from 'vue';

const props = defineProps({
    rounded: {
        type: String,
        default: 'md',
    },
    color: {
        type: String,
        default: 'blue'
    }
})

const rounded = computed(() => ({
    'rounded-md': props.rounded === 'md',
    'rounded-lg': props.rounded === 'lg',
    'rounded-full': props.rounded === 'full',
}))

const color = computed(() => ({
    'bg-blue-500/15 text-blue-500': props.color === 'blue',
    'bg-red-500/15 text-red-500': props.color === 'red',
    'bg-amber-500/15 text-amber-500': props.color === 'amber',
    'bg-green-500/15 text-green-500': props.color === 'green',
    'bg-neutral-100': props.color === 'neutral',
    'border border-neutral-200': props.color === 'outline'

}))
</script>