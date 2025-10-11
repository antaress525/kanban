<template>
<AuthenticatedLayout>
    <Head title="Kanban"></Head>
    <div class="h-full flex flex-col items-center justify-center">
        <div class="flex flex-col gap-y-5 items-center justify-center max-w-md">
            <div class="p-2 border border-neutral-100 rounded-md bg-white shadow-2xl">
                <LayoutDashboard class="h-6 w-6" />
            </div>
            <div class="flex flex-col gap-y-3.5 items-center">
                <p class="font-medium">Aucun Kanban pour le moment</p>
                <p class="text-sm text-center">Commencez à organiser vos projets en créant votre premier tableau Kanban.</p>
                <Button @click="openModal">
                    <Plus class="h-5 w-5" />
                    Créer un Kanban
                </Button>
            </div>
        </div>
    </div>
    <Create :open="open" @close="closeModal"/>
</AuthenticatedLayout>
</template>
<script setup>
import AuthenticatedLayout from '@/Layouts/AuthenticatedLayout.vue';
import { LayoutDashboard } from 'lucide-vue-next';
import { Button } from '@/components/ui/button';
import { Plus } from 'lucide-vue-next';
import Create from './Partials/Create.vue';
import { ref } from 'vue';

const open = ref(false)

const openModal = () => {
    open.value = true
}
const closeModal = () => {
    open.value = false
}
</script>
