<template>
<FadeInLeft>
<div @click.self="emits('close')" v-if="open" class="fixed inset-0 bg-black/20 z-50">
    <!-- Nav -->
    <div class="h-full max-w-xs bg-white">
        <!-- Header -->
        <div class="flex px-2 items-center justify-between h-14 border-b border-neutral-100">
            <h3 class="text-xl font-medium">Kanban</h3>
            <Button @click="emits('close')" variant="ghost" size="icon">
                <X class="w-5 h-5" />
            </Button>
        </div>
        <!-- Content -->
        <div class="h-full overflow-y-auto mt-8">
            <div class="space-y-6 px-2">
                <NavGroup label="Kanban">
                    <template #nav-items>
                        <ResponsiveNavKanban @delete-kanban="deleteKanban" v-for="kanban in kanbans" :kanban="kanban" :active="route().current('kanban.show', { kanban:  kanban.id})">
                            Creation d'un site web avec laravel
                        </ResponsiveNavKanban>
                        <NavItems as="button" @click="createKanban">
                            <Plus class="w-5 h-5" />
                            Creation kanban
                        </NavItems>
                    </template>
                </NavGroup>
            </div>
        </div>
    </div>
</div>
</FadeInLeft>
</template>

<script setup>
import { ref, computed } from 'vue';
import { Button } from '@/components/ui/button';
import { X, Plus } from 'lucide-vue-next';
import NavGroup from '@/components/NavGroup.vue';
import NavItems from '@/components/NavItems.vue';
import { usePage } from '@inertiajs/vue3';
import ResponsiveNavKanban from './ResponsiveNavKanban.vue';
import FadeInLeft from '@/Transitions/FadeInLeft.vue';


const props = defineProps({
    open: {
        type: Boolean,
        required: false
    }
})
const emits = defineEmits(['close', 'createKanban', 'deleteKanban'])

const page = usePage();
const kanbans = computed(() => {
    return page.props.auth.kanbans;
});

const createKanban = () => {
    emits('close')
    emits('createKanban')
}
const deleteKanban = (kanbanId) => {
    emits('close')
    emits('deleteKanban', kanbanId)
}

</script>