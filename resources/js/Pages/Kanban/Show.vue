<template>
<AuthenticatedLayout>
    <Head :title="kanban.title"></Head>
    <div class="space-y-6">
        <!-- Cover image -->
        <div class="relative overflow-hidden rounded-xl h-[120px] md:h-[160px] bg-cover bg-center" :style="`background-image: url(${defaultCoverImage})`">
            <!-- <img :src="defaultCoverImage" alt=""> -->
            <div class="flex items-center absolute">
            </div>
        </div>
        <!-- Title + Search -->
        <div class="flex items-center justify-between flex-wrap gap-y-3">
            <h2 class="font-semibold text-xl sm:text-2xl">{{ kanban.title }}</h2>
            <div class="relative w-full sm:max-w-[260px] items-center">
                <Input id="search" type="text" placeholder="Search..." class="pl-10 shadow-none rounded-lg" />
                <span class="absolute start-0 inset-y-0 flex items-center justify-center px-2">
                    <Search class="size-5 text-muted-foreground" />
                </span>
            </div>
        </div>
        <!-- Invite + Filter -->
        <div class="flex items-center justify-between">
            <!-- Button -->
            <div class="flex-1 flex justify-end items-center gap-x-2">
                <Button variant="outline" class="shadow-none rounded-lg">
                    <UserPlus class="size-5"/>
                    Inviter
                </Button>
                <Button variant="outline" class="shadow-none rounded-lg">
                    <Settings2 class="size-5"/>
                    Filtrer
                </Button>
            </div>
        </div>
        <!-- Kanban -->
        <div class="h-[500px] flex gap-x-6 overflow-x-scroll snap-x snap-mandatory md:flex-row md:overflow-x-auto md:snap-none">
            
            <TaskContainer 
                name="todo" 
                title="A faire" 
                header-color="blue" 
                :tasks="allTasks.todo.data" 
                :task-count="allTasks.todo.data.length" 
                @create-task="openCreateTaskModal"
                @task-moved="handleTaskMoved"
                class="w-80 flex-shrink-0 snap-center md:flex-1 md:w-auto"
            >
                <template #task-item="{ task }">
                    <TaskItem :task="task" @edit-task="openEditTaskModal"/>
                </template>
            </TaskContainer>
            
            <TaskContainer 
                name="in_progress" 
                title="En cours" 
                header-color="amber" 
                :tasks="allTasks.in_progress.data"
                :task-count="allTasks.in_progress.data.length" 
                @create-task="openCreateTaskModal"
                @task-moved="handleTaskMoved"
                class="w-80 flex-shrink-0 snap-center md:flex-1 md:w-auto"
            >
                <template #task-item="{ task }">
                    <TaskItem :task="task" @edit-task="openEditTaskModal"/>
                </template>
            </TaskContainer>
            
            <TaskContainer 
                name="done" 
                title="Fait" 
                header-color="green" 
                :tasks="allTasks.done.data"
                :task-count="allTasks.done.data.length" 
                @create-task="openCreateTaskModal"
                @task-moved="handleTaskMoved"
                class="w-80 flex-shrink-0 snap-center md:flex-1 md:w-auto"
            >
                <template #task-item="{ task }">
                    <TaskItem :task="task" @edit-task="openEditTaskModal"/>
                </template>
            </TaskContainer>
        </div>
    </div>
    <Teleport to="body">
        <CreateTask :open="openCreateTask" :kanban-id="kanban.id" :status="statusCreateTask" @close="closeCreateTaskModal"/>
        <EditTask :open="openEditTask" :task="taskSelected" @close="closeEditTaskModal"/>
    </Teleport>
</AuthenticatedLayout>
</template>

<script setup>
import AuthenticatedLayout from '@/Layouts/AuthenticatedLayout.vue';
import { Input } from "@/components/ui/input"
import { Search, UserPlus, Settings2 } from 'lucide-vue-next';
import { Button } from '@/components/ui/button';
import defaultCoverImage from '@img/default_cover_image.jpg'
import TaskContainer from '@/components/TaskContainer.vue';
import TaskItem from '@/components/TaskItem.vue';
import CreateTask from './Partials/CreateTask.vue';
import EditTask from './Partials/EditTask.vue';
import { ref } from 'vue';
import { router, Head } from '@inertiajs/vue3'; // 👈 Import de 'router'

const props = defineProps({
    kanban: {
        type: Object,
    },
    tasks: { // La prop initiale du serveur
        type: Object
    }
})

// NOUVEAU: Rend les listes de tâches réactives pour que Vue.Draggable puisse les manipuler directement
const allTasks = ref({
    todo: { data: props.tasks.todo.data, total: props.tasks.todo.total },
    in_progress: { data: props.tasks.in_progress.data, total: props.tasks.in_progress.total },
    done: { data: props.tasks.done.data, total: props.tasks.done.total },
});


const openCreateTask = ref(false)
const openEditTask = ref(false)
const statusCreateTask = ref('')
const taskSelected = ref(null)

const openCreateTaskModal = (name) => {
    statusCreateTask.value = name
    openCreateTask.value = true
}
const closeCreateTaskModal = () => {
    openCreateTask.value = false
    statusCreateTask.value = null
}
const openEditTaskModal = (task) => {
    taskSelected.value = task
   openEditTask.value = true
}
const closeEditTaskModal = () => {
   openEditTask.value = false 
   taskSelected.value = null
}

/**
 * Gère l'événement de déplacement émis par TaskContainer et envoie la requête Inertia.
 * @param {Object} payload - { status, tasks, event }
 */
const handleTaskMoved = (payload) => {
    let movedTask;
    let sourceStatus = null;

    // --- Gestion du cas 'moved' (changement d'ordre dans la même colonne) ---
    if (payload.event.moved) {
        movedTask = payload.tasks[payload.event.moved.newIndex];
        // Le statut est déjà correct (celui de la colonne actuelle)

    // --- Gestion du cas 'added' (changement de colonne) ---
    } else if (payload.event.added) {
        // La tâche est celle qui vient d'être ajoutée à la liste de destination
        movedTask = payload.tasks[payload.event.added.newIndex];
        
        // La tâche change de statut pour devenir celui de la colonne de destination
        movedTask.status = payload.status; 

        // Pour mettre à jour les totaux (optionnel mais propre) :
        // L'information sur la colonne source se trouve dans event.added.from
        // On utilise dataset pour lire la propriété 'data-status' que nous avions ajouté dans l'exemple précédent
        // Attention: la méthode recommandée est de lire directement l'état de l'autre liste
        
        // L'erreur venait d'ici : 'payload.event.added.from' n'est pas l'élément DOM, 
        // c'est un wrapper SortableJS. La façon la plus simple est de ne pas s'en soucier 
        // ou de lire l'ID depuis l'objet 'removed' sur la colonne source.
    }

    if (!movedTask) return;

    // Mise à jour locale du compte de tâches pour toutes les colonnes après le drag
    // On doit mettre à jour les totaux de toutes les colonnes impliquées
    // La méthode la plus simple est de mettre à jour le total de la colonne de destination :
    allTasks.value[payload.status].total = payload.tasks.length;
    
    // Si la tâche a été ajoutée (changement de colonne), nous devons aussi mettre à jour
    // le total de l'ancienne colonne.
    // Cette partie est difficile car 'TaskContainer' n'a pas accès à la liste source.
    // Pour simplifier et garantir l'exactitude des totaux, on peut déclencher 
    // un re-render des totaux en mettant à jour la prop `tasks` de la colonne. 
    // Mais puisque vous utilisez `preserveState: true`, le moyen le plus sûr 
    // est de laisser Laravel renvoyer les données complètes ou de faire confiance 
    // à Inertia pour recharger après la requête `put`.

    // Récupérer l'ordre (index) des IDs de tâches dans la nouvelle colonne
    const newOrder = payload.tasks.map(t => t.id);

    // Envoi de la requête au serveur
    router.put(route('task.reorder', movedTask.id), {
        status: movedTask.status,
        task_order: newOrder,
    }, {
        preserveScroll: true,
        preserveState: true,
        // On ajoute un callback onFinish pour s'assurer que les totaux sont rafraîchis
        onFinish: () => {
             // Recharger les props Inertia pour rafraîchir les totaux si nécessaire
             // Note: Si vous utilisez `preserveState: true`, les props ne sont pas rafraîchies.
             // Laisser `preserveState: true` est bien si vous n'avez pas de problème visuel.
        }
    });
}
</script>