<template>
    <div @click="emits('editTask', task)" class="bg-white p-3.5 space-y-4 border border-neutral-200 rounded-lg cursor-pointer hover:shadow-md transition-shadow group">
        <!-- Header -->
        <div class="flex flex-col gap-y-0.5">
            <div class="flex items-center gap-x-2">
                <Checkbox @click.stop="" :value="task.id" v-model="model" />
                <p class="font-medium text-sm w-full">{{ task.title }}</p>
                <!-- Desktop -->
                <button 
                    @click.stop="emits('deleteTask', task.id)" 
                    class="text-red-500 hidden md:block p-1.5 hover:bg-red-50 rounded-full opacity-0 group-hover:opacity-100 transition-opacity"
                    title="Supprimer la tâche"
                >
                    <Trash2 class="size-4" />
                </button>
                <!-- Mobile -->
                <button 
                    @click.stop="emits('deleteTask', task.id)" 
                    class="text-red-500 md:hidden p-1.5 hover:text-red-700 bg-red-50 rounded-full"
                    title="Supprimer la tâche"
                >
                    <Trash2 class="size-4" />
                </button>
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
import Tag from '@/components/Tag.vue'
import { computed } from "vue"
import { Trash2 } from 'lucide-vue-next'
import Checkbox from './Checkbox.vue'

const props = defineProps({
    task: {
        type: Object
    }
})
const model = defineModel()
const emits = defineEmits(['editTask', 'deleteTask'])

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