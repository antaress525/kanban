<template>
    <div class="bg-neutral-100 rounded-xl flex-1 flex flex-col min-h-40 max-h-full pb-4">
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

        <draggable
            class="px-3.5 py-2.5 flex-1 overflow-y-auto space-y-3.5 "
            :list="tasks"
            :group="{ name: 'tasks', pull: true, put: true }"
            item-key="id"
            @change="handleChange"
            :data-status="name"
            tag="div"
            :animation="200"
            :ghost-class="'opacity-40'"
            :chosen-class="'scale-95'"
            :component-data="{ name: 'fade-move' }"
        >
            <template #item="{ element }">
                <div :key="element.id" class="cursor-move">
                    <slot name="task-item" :task="element"></slot>
                </div>
            </template>
        </draggable>
    </div>
</template>

<script setup>
import { Circle, Plus } from 'lucide-vue-next';
import Tag from './Tag.vue';
import { computed } from 'vue';
import draggable from 'vuedraggable'

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
    },
    tasks: { // 👈 NOUVEAU: La liste de tâches pour cette colonne (doit être modifiable)
        type: Array,
        required: true
    }
})

const emits = defineEmits(['createTask', 'taskMoved'])

const color = computed(() => ({
    'fill-blue-500 text-blue-500': props.headerColor === 'blue',
    'fill-amber-500 text-amber-500': props.headerColor === 'amber',
    'fill-green-500 text-green-500': props.headerColor === 'green',
}))

const count = computed(() => props.taskCount < 50 ? `${props.taskCount}` : `50+`)


// NOUVEAU: Gestionnaire de l'événement de déplacement
const handleChange = (event) => {
    if (event.added || event.moved) {
        // Déclencher un événement vers le parent (la vue Kanban)
        emits('taskMoved', {
            status: props.name,
            tasks: props.tasks,
            event: event
        });
    }
}
</script>