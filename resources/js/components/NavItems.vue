<template>
    <component :is="as === 'a' ? Link : 'button'" :class="`flex w-full items-center px-3.5 h-9 gap-x-3.5 text-sm font-medium rounded-lg ${classes}`">
        <slot />
    </component>
</template>

<script setup>
import { Link } from '@inertiajs/vue3';
import { computed } from 'vue';

const props = defineProps({
    as: {
        type: String,
        default: 'a',
    },
    variant: {
        type: String,
        default: 'default',
    },
})

const classes = computed(() => {
    if (props.variant === 'default') {
        return 'text-neutral-400 hover:bg-neutral-100';
    }
    else if (props.variant === 'danger') {
        return 'text-red-500 hover:bg-red-100';
    }
})
</script>