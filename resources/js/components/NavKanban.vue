<template>
<div @mouseenter="hover = true" @mouseleave="hover = false" class="relative flex items-center h-9 p-3.5 gap-x-2">
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
    <!-- Button -->
    <div 
        class="absolute right-0 h-9 w-9 bg-gradient-to-r from-white/90 via-white/95 to-white place-items-center"
        :class="{'grid opacity-100': hover || open, 'hidden opacity-0': !hover && !open}"
    >
        <button @click.stop="toggleDropdown">
            <EllipsisVertical class="w-4 h-4" />
        </button>
        <FadeScale>
            <div
                v-if="open"
                class="
                absolute z-50 mt-2 rounded-lg shadow-lg bg-white ring-1 ring-black ring-opacity-5 overflow-hidden
                top-full right-0 origin-top-right
                w-32"
                v-click-outside="closeDropdown"
            >
                <DropdownItem>Modifier</DropdownItem>
                <DropdownItem variant="danger" @click="deleteKanban">Supprimer</DropdownItem>
            </div>
        </FadeScale>
    </div>
</div>
</template>

<script setup>
import { EllipsisVertical } from 'lucide-vue-next'
import TextClamp from 'vue3-text-clamp'
import DropdownItem from './DropdownItem.vue'
import { ref, onMounted, onUnmounted } from 'vue'
import FadeScale from '@/Transitions/FadeScale.vue'

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
const hover = ref(false)
const open = ref(false)

const toggleDropdown = () => {
    open.value = !open.value
}
const closeDropdown = () => {
    open.value = false
}
const closeOnEscape = (e) => {
    if (e.key === 'Escape') {
        e.preventDefault();

        if (open.value) {
            closeDropdown();
        }
    }
};
onMounted(() => document.addEventListener('keydown', closeOnEscape));

onUnmounted(() => {
    document.removeEventListener('keydown', closeOnEscape);
});

const deleteKanban = () => {
    closeDropdown()
    emits('deleteKanban', props.kanban.id)
}
</script>