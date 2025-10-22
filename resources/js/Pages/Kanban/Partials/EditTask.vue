<template>
<BaseModal @click.self="emits('close')" v-if="open">
    <div class="bg-white border border-neutral-200 rounded-xl w-full max-w-[600px] min-h-96">
        <!-- Header -->
        <div class="flex items-center justify-between p-4 border-b border-neutral-100">
            <p class="font-medium">{{ task.title }}</p>
            <button @click="emits('close')" variant="ghost" size="icon">
                <X class="w-5 h-5" />
            </button>
        </div>
        <!-- Content -->
        <div class="p-4 flex gap-x-4">
            <Tabs :default-index="0">
                <template #tablist>
                    <TabList :tabs="['Information de base', 'Membre', 'Planification']"></TabList>
                </template>
                <TabPannel :index="0">
                    <div class="space-y-8 flex-1">
                        <div class="space-y-0.5">
                            <h3 class="font-medium">Information de base</h3>
                            <p class="text-sm text-neutral-400">Renseigner les informations de base de la tache</p>
                        </div>
                        <form @submit.prevent="submit" class="space-y-6">
                            <div class="grid w-full items-center gap-2">
                                <Label for="title">Nom de la kanban</Label>
                                <Input placeholder="Creation d'un site web" v-model="form.title"  id="title" class="shadow-none"/>
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
                                    <Spinner v-if="form.processing" />
                                    Modifier
                                </Button>
                            </div>
                        </form>
                    </div>
                </TabPannel>
            </Tabs>

        </div>
    </div>
</BaseModal>
</template>

<script setup>
import BaseModal from '@/components/BaseModal.vue'
import { X } from 'lucide-vue-next'
import Label from '@/components/ui/label/Label.vue'
import Input from '@/components/ui/input/Input.vue'
import InputError from '@/components/InputError.vue'
import Textarea from '@/components/ui/textarea/Textarea.vue'
import Button from '@/components/ui/button/Button.vue'
import { useForm } from '@inertiajs/vue3'
import { watch } from 'vue'
import Tabs from '@/components/Tabs/Tabs.vue'
import TabList from '@/components/Tabs/TabList.vue'
import TabPannel from '@/components/Tabs/TabPannel.vue'
import Spinner from '@/components/Spinner.vue'

const props = defineProps({
    task: {
        type: Object,
        default: null
    },
    open: {
        type: Boolean,
        default: false,
    },
})
const emits = defineEmits(['close'])
const form = useForm({
    title: '',
    description: '',
    statu: ''
})
watch(() => props.task, (task) => {
    if(task) {
        form.title = props.task.title,
        form.description = props.task.description
    }
})

const submit = () => {
    form.put(route('task.update.base', props.task.id), {
        onSuccess: () => {
            form.resetAndClearErrors()
            emits('close')
        }
    })
}
</script>