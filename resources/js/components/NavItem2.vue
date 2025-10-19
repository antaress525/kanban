<template>
    <Link :href="route('kanban.show', {id: kanban.id})" class="flex items-center justify-between px-3.5 py-3 hover:bg-neutral-100 rounded-xl group transition-all">
        <div class="flex items-center gap-x-2">
            <div class="w-7 h-7 grid place-items-center rounded-lg text-white font-medium" :style="{background: kanban.color}">
                {{ kanban.title[0].toUpperCase() }}
            </div>
            <p class="text-sm font-medium">{{ kanban.title }}</p>        
        </div>
        <ChevronRight class="size-5 opacity-0 group-hover:opacity-100"/>
    </Link>
</template>

<script setup>
import { ChevronRight } from 'lucide-vue-next'
defineProps({
    kanban: {
        type: Object,
    }
})
</script>