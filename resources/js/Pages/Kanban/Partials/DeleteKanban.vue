<template>
    <BaseModal @click.self="emits('close')" v-if="open">
        <div class="w-full bg-white max-w-sm rounded-xl border border-neutral-200 p-4 space-y-5">
            <!-- Alert icon -->
            <div class="p-2.5 w-max mx-auto rounded-full bg-red-100 grid place-items-center">
                <AlertTriangle class="size-6 text-red-500" />
            </div>
            <!-- Text -->
            <div class="text-center">
                <p class="font-semibold">Êtes-vous certain de vouloir supprimer</p>
                <p class="text-sm">La suppression est définitive et vous ne pourrez pas restaurer cet élément.</p>
            </div>
            <!-- Button -->
            <div class="flex items-center gap-x-3.5">
                <Button @click="emits('close')" class="flex-1" variant="outline">Non, garder</Button>
                <Button @click="deleteKanban" class="flex-1" variant="destructive">
                    <Spinner v-if="form.processing" />
                    <Trash v-else class="size-5 text-white"/>
                    Oui, Supprimer
                </Button>
            </div> 
        </div>
    </BaseModal>
</template>

<script setup>
import BaseModal from '@/components/BaseModal.vue';
import { AlertTriangle, Trash } from 'lucide-vue-next';
import Button from '@/components/ui/button/Button.vue';
import { useForm } from '@inertiajs/vue3';
import Spinner from '@/components/Spinner.vue';

const props = defineProps({
    open: {
        type: Boolean,
        default: false
    },
    kanbanId: {
        type: null
    }
})
const emits = defineEmits(['close'])
const form = useForm()

const deleteKanban = () => {
    form.delete(route('kanban.delete', props.kanbanId), {
        onFinish: () => emits('close')
    })
}

</script>