<template>
    <BaseModal v-if="open" @click.self="emits('close')">
        <div class="bg-white rounded-xl border border-neutral-200 w-full max-w-sm">
            <!-- Header -->
            <div class="flex items-center justify-between p-4 border-b border-neutral-100">
                <p class="font-medium">Nouvelle tache</p>
                <button @click="emits('close')" variant="ghost" size="icon">
                    <X class="w-5 h-5" />
                </button>
            </div>
            <!-- Content -->
            <form @submit.prevent="submit" class="p-4 space-y-6">
                <div class="grid w-full items-center gap-2">
                    <Label for="title">Nom de la kanban</Label>
                    <Input placeholder="Creation d'un site web" v-model="form.title" id="title" class="shadow-none"/>
                    <InputError v-if="form.errors.title">{{ form.errors.title }}</InputError>
                </div>
                <div class="grid w-full items-center gap-2">
                    <Label for="description">Description</Label>
                    <Textarea placeholder="Un super site web" v-model="form.description" id="description" class="shadow-none"/>
                    <InputError v-if="form.errors.description">{{ form.errors.description }}</InputError>
                </div>
                <div class="flex items-center justify-end gap-x-3">
                    <Button @click="emits('close')" type="button" variant="ghost">Annuler</Button>
                    <Button :disabled="form.processing">
                        <Spinner v-show="form.processing" />
                        Creer la kanban
                    </Button>
                </div>
            </form>
        </div>
    </BaseModal>
</template>

<script setup>
import BaseModal from '@/components/BaseModal.vue'
import { useForm } from '@inertiajs/vue3'
import { X } from 'lucide-vue-next'
import { Input } from "@/components/ui/input"
import { Label } from "@/components/ui/label"
import InputError from '@/components/InputError.vue'
import Button from '@/components/ui/button/Button.vue'
import Textarea from '@/components/ui/textarea/Textarea.vue'
import Spinner from '@/components/Spinner.vue'

const props = defineProps({
    open: {
        type: Boolean,
        default: false,
    },
    status: {
        type: String,
    },
    kanbanId: {
        type: Number,
    }
})
const emits = defineEmits(['close'])
const form = useForm({
    title: '',
    description: '',
})

const submit = () => {
    
    form.transform((data) => ({
        ...data,
        status: props.status,
    }))
    .post(route('task.store', props.kanbanId),{
        onSuccess: () => {
            form.resetAndClearErrors()
            emits('close')
        }
    })
}
</script>