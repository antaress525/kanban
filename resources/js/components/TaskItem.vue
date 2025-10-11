<template>
    <div @click="emits('editTask', task)" class="bg-white p-3.5 space-y-4 border border-neutral-200 rounded-lg cursor-pointer hover:shadow-md transition-shadow">
        <!-- Header -->
        <div class="flex flex-col gap-y-0.5">
            <div class="flex items-center gap-x-2">
                <Checkbox />
                <p class="font-medium text-sm w-full">{{ task.title }}</p>
            </div>
            <p v-if="task.description" class="text-sm font-medium text-neutral-400">{{ task.description }}</p>
        </div>
        <!-- content -->
        <div v-if="task.priority || task.due_date" class="flex items-center gap-x-2">
            <Tag v-if="task.priority" :color="priority">{{ task.priority }}</Tag>
            <Tag v-if="task.due_date" color="neutral">{{ task.due_date }}</Tag>
        </div>
    </div>
</template>

<script setup>
import { Checkbox } from "@/components/ui/checkbox"
import Tag from '@/components/Tag.vue';
import { computed } from "vue";

const props = defineProps({
    task: {
        type: Object
    }
})
const emits = defineEmits(['editTask'])

const priority = computed(() => {
    if(props.task?.priority === 'low') {
        return 'blue'
    }
    else if (props.task?.priority === 'medium') {
        return 'amber'
    }
    else {
        return 'red' 
    }
})

</script>