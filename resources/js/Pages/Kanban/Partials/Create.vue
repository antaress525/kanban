<template>
    <div @click.self="emits('close')" v-if="open" class="fixed inset-0 bg-black/10 flex items-center justify-center">
        <div class="bg-white w-full max-w-[480px] border border-neutral-200 rounded-xl shadow-xl">
            <!-- Header -->
            <div class="flex items-center justify-between p-4 border-b border-neutral-100">
                <p class="font-medium">Nouveau Kanban</p>
                <button @click="emits('close')" variant="ghost" size="icon">
                    <X class="w-5 h-5" />
                </button>
            </div>
            <!-- Content -->
            <form @submit.prevent="submit" class="p-4 space-y-6">
                <div class="grid w-full items-center gap-2">
                    <Label for="title">Nom de la kanban</Label>
                    <Input v-model="form.title" id="title" class="shadow-none"/>
                    <InputError v-if="form.errors.title">{{ form.errors.title }}</InputError>
                </div>
                <div class="grid w-full items-center gap-2">
                    <SelectedColors @change-color="setColor" />
                    <InputError v-if="form.errors.color">{{ form.errors.color }}</InputError>
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
    </div>
</template>

<script setup>
import Button from '@/components/ui/button/Button.vue'
import { X } from 'lucide-vue-next'
import { Input } from "@/components/ui/input"
import { Label } from "@/components/ui/label"
import SelectedColors from '@/components/SelectedColors.vue'
import InputError from '@/components/InputError.vue'
import { useForm } from '@inertiajs/vue3'
import { ref } from 'vue'
import Spinner from '@/components/Spinner.vue'

const props = defineProps({
    open: {
        type: Boolean,
        default: false
    }
})
const emits = defineEmits(['close'])
const form = useForm({
    title: '',
    color: ''
})
const color = ref()

const setColor = (newColor) => {
    color.value = newColor
}
const submit = () => {
    form.transform((data) => ({
        title: data.title,
        color: color.value
    }))
    .post(
        route('kanban.store'),{
            onSuccess: () =>  {
                form.resetAndClearErrors(),
                emits('close')
            }
        }
    );
}
</script>