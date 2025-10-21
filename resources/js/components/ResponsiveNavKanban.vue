<template>
<div class="relative flex items-center justify-between h-9 p-3.5 gap-x-2">
    <!-- Letters -->
    <div class="w-7 h-7 grid place-items-center rounded-lg text-white font-medium" :style="{background: kanban.color}">
        {{ kanban.title[0].toUpperCase() }}
    </div>
    <Link :href="route('kanban.show', kanban.id)" class="absolute inset-0"></Link>
    <p :class="['text-sm font-medium', {'text-neutral-400': !active}]">
        <text-clamp 
            :text="kanban.title.charAt(0).toUpperCase() + kanban.title.slice(1)" 
            :max-lines='1' 
        />
    </p>
    <Dropdown size="sm">
        <template #trigger>
            <Button size="icon" variant="ghost">
                <EllipsisVertical class="w-4 h-4" />
            </Button>
        </template>
        <DropdownItem>
            Modifier
        </DropdownItem>
        <DropdownItem @click="deleteKanban" variant="danger">
            Supprimer
        </DropdownItem>
    </Dropdown>
</div>
</template>

<script setup>
import { EllipsisVertical } from 'lucide-vue-next'
import TextClamp from 'vue3-text-clamp'
import DropdownItem from './DropdownItem.vue'
import Dropdown from './Dropdown.vue'
import { ref, onMounted, onUnmounted } from 'vue'
import Button from './ui/button/Button.vue'

const props = defineProps({
    kanban: {
        type: Object,
        required: true
    },
    active: {
        type: Boolean,
        default: false
    }
})

const emits = defineEmits(['deleteKanban'])

const deleteKanban = () => {
    emits('deleteKanban', props.kanban.id)
}
</script>