<template>
    <div class="space-y-5">
        <div class="flex items-center justify-between">
            <p class="text-neutral-400 uppercase text-xs font-medium">{{ label }}</p>
            <span v-if="count" class="grid place-items-center text-xs font-medium w-6 h-6 rounded-lg text-red-500 bg-red-100">4</span>
        </div>
        <div class="space-y-3">
            <slot name="nav-items"></slot>
        </div>
    </div>
</template>

<script setup>
defineProps({
    label: {
        type: String,
        required: true,
    },
    count: {
        type: String,
    },
})
</script>