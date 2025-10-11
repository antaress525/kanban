<template>
    <GuestLayout>
        <Head title="Mot de passe oublier" />

        <div class="text-center mb-4 sm:mb-6 md:mb-8">
           <h1 class="text-2xl">Mot de passe oublié ?</h1>
           <p class="text-sm text-neutral-400">Entrez votre adresse e-mail pour recevoir un lien de <br> réinitialisation</p>
        </div>

        <div
            v-if="status"
            class="mb-4 text-sm font-medium text-green-600"
        >
            {{ status }}
        </div>

        <form @submit.prevent="submit" class="space-y-6 w-full max-w-[340px]">
            <!-- Email -->
            <div class="space-y-2">
                <Label for="email">Email</Label>
                <Input type="email" id="email" v-model="form.email" placeholder="johhdoe@gmail.com" />
                <label class="text-red-500 text-sm" v-if="form.errors.email">{{ form.errors.email }}</label>
            </div>
            <Button class="w-full bg-black text-white">
                <Loader2 v-if="form.processing" class="w-5 h-5 mr-2 animate-spin" />
                Reinitialiser le mot de passe
            </Button>
            <div class="flex justify-center">
                <Button as-child class="mx-auto" variant="link">
                    <Link :href="route('login')">
                        <ArrowLeft class="w-5 h-5" />
                        Retour connexion
                    </Link>
                </Button>
            </div>
        </form>
        
    </GuestLayout>
</template>

<script setup>
import GuestLayout from '@/Layouts/GuestLayout.vue';
import { Button } from '@/components/ui/button';
import { Label } from '@/components/ui/label';
import { Input } from "@/components/ui/input";
import { useForm } from '@inertiajs/vue3';
import { Loader2, ArrowLeft } from 'lucide-vue-next';

defineProps({
    status: {
        type: String,
    },
});

const form = useForm({
    email: '',
});

const submit = () => {
    form.post(route('password.email'));
};
</script>
