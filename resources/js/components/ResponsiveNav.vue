<template>
<div>
    <!-- Trigger -->
    <button @click="toggle" class="space-y-1 w-5 rounded-md">
        <div class="h-0.5  bg-black"></div>
        <div class="h-0.5  bg-black"></div>
        <div class="h-0.5  bg-black"></div>
    </button>
    <!-- Panel -->
    <teleport to="body">
        <div @click.self="close" v-if="open" class="fixed inset-0 bg-black/20">
            <!-- Nav -->
            <div class="h-full max-w-xs bg-white">
                <!-- Header -->
                <div class="flex px-2 items-center justify-between h-14 border-b border-neutral-100">
                    <h3 class="text-xl font-medium">Kanban</h3>
                    <Button @click="close" variant="ghost" size="icon">
                        <X class="w-5 h-5" />
                    </Button>
                </div>
                <!-- Content -->
                <div class="h-full overflow-y-auto mt-8">
                    <div class="space-y-6 px-2">
                        <NavGroup label="Kanban">
                            <template #nav-items>
                                <NavKanban v-for="kanban in kanbans" :kanban="kanban" :active="route().current('kanban.show', { kanban:  kanban.id})">
                                    Creation d'un site web avec laravel
                                </NavKanban>
                                <NavItems as="button">
                                    <Plus class="w-5 h-5" />
                                    Creation kanban
                                </NavItems>
                            </template>
                        </NavGroup>
                    </div>
                </div>
            </div>
        </div>
    </teleport>
</div>
</template>

<script setup>
import { ref, computed } from 'vue';
import { Button } from '@/components/ui/button';
import { X, Plus } from 'lucide-vue-next';
import NavGroup from '@/components/NavGroup.vue';
import NavItems from '@/components/NavItems.vue';
import NavKanban from './NavKanban.vue';
import { usePage } from '@inertiajs/vue3';


const open = ref(false)
const toggle = () => {
    open.value = !open.value
};
const close = () => {
    open.value = false
};

const page = usePage()

const kanbans = computed(() => {
    return page.props.auth.kanbans;
});
</script>