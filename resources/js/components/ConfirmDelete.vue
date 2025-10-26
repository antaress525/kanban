<template>
    <BaseModal @click.self="emits('close')" v-if="open">
        <div class="w-full bg-white max-w-sm rounded-xl border border-neutral-200 p-4 space-y-5">
            <div class="p-2.5 w-max mx-auto rounded-full bg-red-100 grid place-items-center">
                <AlertTriangle class="size-6 text-red-500" />
            </div>
            
            <div class="text-center">
                <p class="font-semibold">{{ title }}</p>
                <p class="text-sm text-neutral-500">{{ description }}</p>
            </div>
            
            <div class="flex items-center gap-x-3.5">
                <Button @click="emits('close')" class="flex-1" variant="outline">Non, Annuler</Button>
                
                <Button @click="handleDelete" class="flex-1" variant="destructive" :disabled="form.processing">
                    <Spinner v-if="form.processing" />
                    <Trash v-else class="size-5 mr-2 text-white"/>
                    Oui, Supprimer
                </Button>
            </div> 
        </div>
    </BaseModal>
</template>

<script setup>
import BaseModal from '@/components/BaseModal.vue';
import { AlertTriangle, Trash, Loader2 } from 'lucide-vue-next';
import Button from '@/components/ui/button/Button.vue';
import { useForm } from '@inertiajs/vue3';
import Spinner from './Spinner.vue';

const props = defineProps({
    open: {
        type: Boolean,
        default: false
    },
    deleteUrl: {
        type: [String, null],
        default: null
    },
    title: {
        type: String,
        default: 'Êtes-vous certain de vouloir supprimer ?'
    },
    description: {
        type: String,
        default: 'La suppression est définitive et vous ne pourrez pas restaurer cet élément.'
    },
    data: {
        type: Object
    }
})

const emits = defineEmits(['close', 'success'])

const form = useForm() 

const handleDelete = () => {
    if (!props.deleteUrl) return;

    form.transform((data) => ({
        ...data,
        ...props.data
    }))
    .delete(props.deleteUrl, {
        preserveScroll: true,
        onFinish: () => {
            emits('close')
        },
        onSuccess: () => {
            emits('success')
        }
    })
}
</script>