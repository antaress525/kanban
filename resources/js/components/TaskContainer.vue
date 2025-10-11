<template>
    <div class="bg-neutral-100 rounded-xl flex-1 flex flex-col min-h-40 max-h-full pb-4">
        <!-- Header -->
        <div class="flex items-center justify-between h-[52px] px-4 shrink-0">
            <div class="flex items-center gap-x-2 font-medium">
                <Circle :class="['size-3.5', color]" />
                {{ title }}
                <Tag v-if="taskCount" :color="headerColor" rounded="full">{{ count }}</Tag>
            </div>
            <button @click="emits('createTask', name)">
                <Plus class="size-5" />
            </button>
        </div>

        <!-- Contenu scrollable -->
        <div class="px-3.5 py-2.5 flex-1 overflow-y-auto space-y-3.5 ">
            <slot name="list-task"></slot>
        </div>
    </div>
</template>

<script setup>
import { Circle, Plus } from 'lucide-vue-next';
import Tag from './Tag.vue';
import { computed } from 'vue';

const props = defineProps({
    name: {
        type: String,
        required: true,
    },
    title: {
        type: String,
        required: true
    },
    headerColor: {
        type: String,
        required: true
    },
    taskCount: {
        type: Number
    }
})

const emits = defineEmits(['createTask'])

const color = computed(() => ({
    'fill-blue-500 text-blue-500': props.headerColor === 'blue',
    'fill-amber-500 text-amber-500': props.headerColor === 'amber',
    'fill-green-500 text-green-500': props.headerColor === 'green',
}))

const count = computed(() => props.taskCount < 50 ? `${props.taskCount}` : `50+`)
</script>