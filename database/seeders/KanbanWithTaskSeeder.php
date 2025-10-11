<?php

namespace Database\Seeders;

use App\Models\User;
use App\Enums\TaskStatus;
use App\Enums\TaskPriority;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;

class KanbanWithTaskSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $colors = [
            '#E24E4E',
            '#FFC251',
            '#94ED27',
            '#AE673B',
            '#00FF08',
            '#2AD1E4',
            '#066AFF',
            '#844EE2',
            '#FF5EF4',
            '#9846CF',
        ];
        $tasks = [
            // 🟦 Phase 1 : Analyse & planification
            [
                'title' => 'Réunion de lancement avec le client',
                // 'description' => 'Discuter des objectifs, du budget, des délais et des fonctionnalités attendues.',
                'status' => TaskStatus::TODO,
                // 'priority' => TaskPriority::HIGH,
                // 'due_date' => now()->addDays(2),
                'order' => 1,
            ],
            [
                'title' => 'Rédiger le cahier des charges',
                'description' => 'Documenter les besoins techniques et fonctionnels du projet.',
                'status' => TaskStatus::IN_PROGRESS,
                'priority' => TaskPriority::HIGH,
                // 'due_date' => now()->addDays(4),
                'order' => 2,
            ],
            [
                'title' => 'Lister les besoins techniques',
                'description' => 'Identifier les outils et technologies nécessaires au développement du site.',
                'status' => TaskStatus::TODO,
                'priority' => TaskPriority::MEDIUM,
                'due_date' => now()->addDays(6),
                'order' => 3,
            ],
            [
                'title' => 'Analyser les sites concurrents',
                'description' => 'Observer la concurrence pour repérer les bonnes pratiques à reprendre.',
                'status' => TaskStatus::DONE,
                'priority' => TaskPriority::LOW,
                'due_date' => now()->addDays(3),
                'order' => 4,
            ],
            [
                'title' => 'Créer la structure du contenu',
                'description' => 'Organiser les pages et la hiérarchie des sections principales du site.',
                'status' => TaskStatus::TODO,
                'priority' => TaskPriority::MEDIUM,
                'due_date' => now()->addDays(7),
                'order' => 5,
            ],
            [
                'title' => 'Définir les objectifs du site',
                // 'description' => 'Spécifier les résultats attendus et les indicateurs de performance (KPI).',
                'status' => TaskStatus::DONE,
                // 'priority' => TaskPriority::LOW,
                'due_date' => now()->addDays(5),
                'order' => 6,
            ],
            [
                'title' => 'Établir le planning global du projet',
                // 'description' => 'Planifier les jalons de livraison et les dates de revue client.',
                'status' => TaskStatus::IN_PROGRESS,
                'priority' => TaskPriority::MEDIUM,
                'due_date' => now()->addDays(8),
                'order' => 7,
            ],
            [
                'title' => 'Choisir le CMS ou framework',
                'description' => 'Comparer les solutions techniques : Laravel, WordPress, Statique, etc.',
                'status' => TaskStatus::TODO,
                'priority' => TaskPriority::MEDIUM,
                'due_date' => now()->addDays(9),
                'order' => 8,
            ],

            // 🟩 Phase 2 : Design
            [
                'title' => 'Créer le moodboard du projet',
                'description' => 'Assembler les inspirations graphiques et définir le ton visuel.',
                'status' => TaskStatus::IN_PROGRESS,
                'priority' => TaskPriority::HIGH,
                'due_date' => now()->addDays(10),
                'order' => 9,
            ],
            [
                'title' => 'Choisir la palette de couleurs',
                'description' => 'Sélectionner les couleurs principales et d’accent pour le branding.',
                'status' => TaskStatus::DONE,
                'priority' => TaskPriority::LOW,
                'due_date' => now()->addDays(11),
                'order' => 10,
            ],
            [
                'title' => 'Sélectionner les typographies',
                'description' => 'Choisir les polices cohérentes avec l’image de marque du client.',
                'status' => TaskStatus::TODO,
                'priority' => TaskPriority::MEDIUM,
                'due_date' => now()->addDays(12),
                'order' => 11,
            ],
            [
                'title' => 'Créer la maquette de la page d’accueil',
                'description' => 'Réaliser le design principal sur Figma avec une approche responsive.',
                'status' => TaskStatus::IN_PROGRESS,
                'priority' => TaskPriority::HIGH,
                'due_date' => now()->addDays(14),
                'order' => 12,
            ],
            [
                'title' => 'Créer la maquette des pages secondaires',
                'description' => 'Concevoir les pages “À propos”, “Services” et “Contact”.',
                'status' => TaskStatus::TODO,
                'priority' => TaskPriority::MEDIUM,
                'due_date' => now()->addDays(16),
                'order' => 13,
            ],
            [
                'title' => 'Valider le design avec le client',
                'description' => 'Présenter les maquettes pour validation avant le développement.',
                'status' => TaskStatus::DONE,
                'priority' => TaskPriority::HIGH,
                'due_date' => now()->addDays(18),
                'order' => 14,
            ],
            [
                'title' => 'Préparer les icônes et illustrations',
                'description' => 'Créer ou choisir des visuels homogènes pour tout le site.',
                'status' => TaskStatus::DONE,
                'priority' => TaskPriority::LOW,
                'due_date' => now()->addDays(20),
                'order' => 15,
            ],

            // 🟨 Phase 3 : Développement Frontend
            [
                'title' => 'Initialiser le dépôt Git',
                'description' => 'Créer le dépôt et définir la structure des branches.',
                'status' => TaskStatus::DONE,
                'priority' => TaskPriority::LOW,
                'due_date' => now()->addDays(2),
                'order' => 16,
            ],
            [
                'title' => 'Mettre en place la structure du projet',
                'description' => 'Organiser les dossiers pour les composants, assets et vues.',
                'status' => TaskStatus::IN_PROGRESS,
                'priority' => TaskPriority::MEDIUM,
                'due_date' => now()->addDays(5),
                'order' => 17,
            ],
            [
                'title' => 'Développer la navigation principale',
                'description' => 'Créer le menu principal avec un système de surlignage actif.',
                'status' => TaskStatus::TODO,
                'priority' => TaskPriority::MEDIUM,
                'due_date' => now()->addDays(7),
                'order' => 18,
            ],
            [
                'title' => 'Développer la page d’accueil',
                'description' => 'Intégrer la section héros, les services et les témoignages.',
                'status' => TaskStatus::IN_PROGRESS,
                'priority' => TaskPriority::HIGH,
                'due_date' => now()->addDays(9),
                'order' => 19,
            ],
            [
                'title' => 'Développer la page “À propos”',
                'description' => 'Présenter la mission, les valeurs et l’équipe du client.',
                'status' => TaskStatus::TODO,
                'priority' => TaskPriority::MEDIUM,
                'due_date' => now()->addDays(11),
                'order' => 20,
            ],
            [
                'title' => 'Développer la page “Services”',
                'description' => 'Lister les prestations proposées avec leurs descriptions.',
                'status' => TaskStatus::IN_PROGRESS,
                'priority' => TaskPriority::HIGH,
                'due_date' => now()->addDays(13),
                'order' => 21,
            ],
            [
                'title' => 'Développer la page “Contact”',
                'description' => 'Intégrer un formulaire et une carte interactive.',
                'status' => TaskStatus::TODO,
                'priority' => TaskPriority::HIGH,
                'due_date' => now()->addDays(15),
                'order' => 22,
            ],
            [
                'title' => 'Ajouter les animations CSS',
                'description' => 'Améliorer l’expérience utilisateur avec des effets de transition.',
                'status' => TaskStatus::DONE,
                'priority' => TaskPriority::LOW,
                'due_date' => now()->addDays(17),
                'order' => 23,
            ],
            [
                'title' => 'Optimiser le responsive design',
                'description' => 'Assurer un affichage correct sur tous les appareils.',
                'status' => TaskStatus::IN_PROGRESS,
                'priority' => TaskPriority::HIGH,
                'due_date' => now()->addDays(19),
                'order' => 24,
            ],
            [
                'title' => 'Corriger les erreurs d’intégration',
                'description' => 'Corriger les bugs détectés après les tests de validation visuelle.',
                'status' => TaskStatus::DONE,
                'priority' => TaskPriority::MEDIUM,
                'due_date' => now()->addDays(21),
                'order' => 25,
            ],

            // 🟥 Phase 4 : Backend
            [
                'title' => 'Configurer la base de données',
                'description' => 'Créer les tables nécessaires avec les relations appropriées.',
                'status' => TaskStatus::DONE,
                'priority' => TaskPriority::HIGH,
                'due_date' => now()->addDays(3),
                'order' => 26,
            ],
            [
                'title' => 'Mettre en place l’authentification utilisateur',
                'description' => 'Créer le système de connexion et d’inscription sécurisé.',
                'status' => TaskStatus::IN_PROGRESS,
                'priority' => TaskPriority::LOW,
                'due_date' => now()->addDays(8),
                'order' => 27,
            ],
            [
                'title' => 'Configurer le tableau d’administration',
                'description' => 'Créer un espace administrateur pour gérer le contenu du site.',
                'status' => TaskStatus::TODO,
                'priority' => TaskPriority::HIGH,
                'due_date' => now()->addDays(12),
                'order' => 28,
            ],
            [
                'title' => 'Gérer l’envoi des emails',
                'description' => 'Configurer l’envoi automatique depuis le formulaire de contact.',
                'status' => TaskStatus::TODO,
                'priority' => TaskPriority::MEDIUM,
                'due_date' => now()->addDays(14),
                'order' => 29,
            ],
            [
                'title' => 'Implémenter la sécurité de base',
                'description' => 'Protéger les routes et les formulaires contre les attaques courantes.',
                'status' => TaskStatus::DONE,
                'priority' => TaskPriority::HIGH,
                'due_date' => now()->addDays(16),
                'order' => 30,
            ],

            // 🟧 Phase 5 : Contenu & SEO
            [
                'title' => 'Rédiger le contenu de la page d’accueil',
                'description' => 'Créer un texte percutant et optimisé SEO pour la page principale.',
                'status' => TaskStatus::TODO,
                'priority' => TaskPriority::MEDIUM,
                'due_date' => now()->addDays(18),
                'order' => 31,
            ],
            [
                'title' => 'Rédiger les textes des services',
                'description' => 'Mettre en avant les points forts et les avantages du client.',
                'status' => TaskStatus::IN_PROGRESS,
                'priority' => TaskPriority::MEDIUM,
                'due_date' => now()->addDays(20),
                'order' => 32,
            ],
            [
                'title' => 'Optimiser les balises meta',
                'description' => 'Renseigner les balises title, description et og:meta.',
                'status' => TaskStatus::DONE,
                'priority' => TaskPriority::HIGH,
                'due_date' => now()->addDays(22),
                'order' => 33,
            ],
            [
                'title' => 'Mettre en place Google Analytics',
                'description' => 'Installer et configurer le suivi de performance.',
                'status' => TaskStatus::TODO,
                'priority' => TaskPriority::LOW,
                'due_date' => now()->addDays(23),
                'order' => 34,
            ],
            [
                'title' => 'Créer le sitemap.xml',
                'description' => 'Faciliter l’indexation du site par les moteurs de recherche.',
                'status' => TaskStatus::IN_PROGRESS,
                'priority' => TaskPriority::MEDIUM,
                'due_date' => now()->addDays(24),
                'order' => 35,
            ],
            [
                'title' => 'Optimiser la vitesse de chargement',
                'description' => 'Compresser les images et minimiser les fichiers CSS/JS.',
                'status' => TaskStatus::TODO,
                'priority' => TaskPriority::HIGH,
                'due_date' => now()->addDays(26),
                'order' => 36,
            ],
            [
                'title' => 'Vérifier les liens internes',
                'description' => 'S’assurer que tous les liens internes fonctionnent correctement.',
                'status' => TaskStatus::DONE,
                'priority' => TaskPriority::LOW,
                'due_date' => now()->addDays(27),
                'order' => 37,
            ],

            // 🟪 Phase 6 : Tests & Livraison
            [
                'title' => 'Tester le site sur mobile',
                'description' => 'Vérifier l’affichage et les interactions sur différents appareils.',
                'status' => TaskStatus::IN_PROGRESS,
                'priority' => TaskPriority::HIGH,
                'due_date' => now()->addDays(29),
                'order' => 38,
            ],
            [
                'title' => 'Tester la compatibilité navigateurs',
                'description' => 'S’assurer du bon rendu sur Chrome, Firefox, Safari et Edge.',
                'status' => TaskStatus::TODO,
                'priority' => TaskPriority::MEDIUM,
                'due_date' => now()->addDays(31),
                'order' => 39,
            ],
            [
                'title' => 'Corriger les bugs détectés',
                'description' => 'Résoudre les erreurs signalées lors des tests finaux.',
                'status' => TaskStatus::DONE,
                'priority' => TaskPriority::HIGH,
                'due_date' => now()->addDays(33),
                'order' => 40,
            ],
            [
                'title' => 'Préparer la documentation technique',
                'description' => 'Décrire la structure du projet et les étapes de maintenance.',
                'status' => TaskStatus::DONE,
                'priority' => TaskPriority::MEDIUM,
                'due_date' => now()->addDays(35),
                'order' => 41,
            ],
            [
                'title' => 'Créer un guide utilisateur pour le client',
                'description' => 'Expliquer comment modifier le contenu et gérer le site.',
                'status' => TaskStatus::IN_PROGRESS,
                'priority' => TaskPriority::LOW,
                'due_date' => now()->addDays(36),
                'order' => 42,
            ],
            [
                'title' => 'Préparer le déploiement',
                'description' => 'Vérifier la configuration du serveur et les fichiers finaux.',
                'status' => TaskStatus::TODO,
                'priority' => TaskPriority::HIGH,
                'due_date' => now()->addDays(38),
                'order' => 43,
            ],
            [
                'title' => 'Déployer le site en production',
                'description' => 'Mettre le site en ligne avec le nom de domaine officiel.',
                'status' => TaskStatus::IN_PROGRESS,
                'priority' => TaskPriority::LOW,
                'due_date' => now()->addDays(40),
                'order' => 44,
            ],
            [
                'title' => 'Faire la présentation finale au client',
                'description' => 'Montrer le produit fini et recueillir les retours.',
                'status' => TaskStatus::DONE,
                'priority' => TaskPriority::HIGH,
                'due_date' => now()->addDays(42),
                'order' => 45,
            ],
            [
                'title' => 'Corriger les derniers ajustements demandés',
                'description' => 'Appliquer les petites modifications demandées après livraison.',
                'status' => TaskStatus::TODO,
                'priority' => TaskPriority::MEDIUM,
                'due_date' => now()->addDays(43),
                'order' => 46,
            ],
            [
                'title' => 'Archiver le projet',
                'description' => 'Sauvegarder les fichiers et la documentation finale.',
                'status' => TaskStatus::DONE,
                'priority' => TaskPriority::LOW,
                'due_date' => now()->addDays(45),
                'order' => 47,
            ],
            [
                'title' => 'Collecter le feedback du client',
                'description' => 'Recueillir les impressions et suggestions pour améliorer les prochains projets.',
                'status' => TaskStatus::DONE,
                'priority' => TaskPriority::LOW,
                'due_date' => now()->addDays(47),
                'order' => 48,
            ],
            [
                'title' => 'Publier le projet sur le portfolio',
                'description' => 'Ajouter ce site à la liste des réalisations de l’agence.',
                'status' => TaskStatus::DONE,
                'priority' => TaskPriority::LOW,
                'due_date' => now()->addDays(49),
                'order' => 49,
            ],
            [
                'title' => 'Effectuer une revue post-projet',
                'description' => 'Analyser le déroulement du projet et les points d’amélioration.',
                'status' => TaskStatus::TODO,
                'priority' => TaskPriority::LOW,
                'due_date' => now()->addDays(50),
                'order' => 50,
            ],
            [
                'title' => 'Mettre à jour les dépendances du projet',
                'description' => 'S’assurer que toutes les librairies utilisées sont à jour.',
                'status' => TaskStatus::IN_PROGRESS,
                'priority' => TaskPriority::MEDIUM,
                'due_date' => now()->addDays(52),
                'order' => 51,
            ],
            [
                'title' => 'Effectuer un audit SEO final',
                'description' => 'Vérifier les performances et l’indexation du site.',
                'status' => TaskStatus::DONE,
                'priority' => TaskPriority::MEDIUM,
                'due_date' => now()->addDays(54),
                'order' => 52,
            ],
            [
                'title' => 'Nettoyer les fichiers inutiles',
                'description' => 'Supprimer les ressources temporaires et les logs.',
                'status' => TaskStatus::DONE,
                'priority' => TaskPriority::LOW,
                'due_date' => now()->addDays(55),
                'order' => 53,
            ],
            [
                'title' => 'Créer un point de restauration serveur',
                'description' => 'Sauvegarder l’état stable du site pour réinstallation rapide.',
                'status' => TaskStatus::TODO,
                'priority' => TaskPriority::HIGH,
                'due_date' => now()->addDays(56),
                'order' => 54,
            ],
            [
                'title' => 'Envoyer le rapport final au client',
                'description' => 'Transmettre le résumé du projet, statistiques et accès administratifs.',
                'status' => TaskStatus::IN_PROGRESS,
                'priority' => TaskPriority::HIGH,
                'due_date' => now()->addDays(57),
                'order' => 55,
            ],
            [
                'title' => 'Mettre en place le suivi de maintenance',
                'description' => 'Configurer les alertes automatiques et tâches de maintenance récurrentes.',
                'status' => TaskStatus::TODO,
                'priority' => TaskPriority::MEDIUM,
                'due_date' => now()->addDays(58),
                'order' => 56,
            ],
            [
                'title' => 'Faire une réunion de clôture avec l’équipe',
                'description' => 'Analyser les réussites et les axes d’amélioration du projet.',
                'status' => TaskStatus::DONE,
                'priority' => TaskPriority::LOW,
                'due_date' => now()->addDays(59),
                'order' => 57,
            ],
            [
                'title' => 'Mettre à jour la documentation technique interne',
                'description' => 'Ajouter les leçons apprises et les bonnes pratiques dans le wiki interne.',
                'status' => TaskStatus::DONE,
                'priority' => TaskPriority::LOW,
                'due_date' => now()->addDays(60),
                'order' => 58,
            ],
            [
                'title' => 'Envoyer la facture finale au client',
                'description' => 'Clôturer le projet sur le plan administratif et financier.',
                'status' => TaskStatus::TODO,
                'priority' => TaskPriority::HIGH,
                'due_date' => now()->addDays(61),
                'order' => 59,
            ],
            [
                'title' => 'Archiver les accès et mots de passe',
                'description' => 'Sauvegarder de manière sécurisée les identifiants du site.',
                'status' => TaskStatus::DONE,
                'priority' => TaskPriority::MEDIUM,
                'due_date' => now()->addDays(62),
                'order' => 60,
            ],
        ];

        $user = User::firstOrCreate([
            'first_name' => 'john',
            'last_name' => 'doe',
            'email' => 'johndoe@gmail.com',
        ], [
            'password' => Hash::make('password')
        ]);

        $kanban = $user->kanbans()->create([
            'title' => 'Création d’un site web professionnel',
            'description' => 'Organisation complète du projet de conception, développement et déploiement d’un site vitrine pour un client.',
            'color' => fake()->randomElement($colors)
        ]);

        foreach($tasks as $task) {
            $kanban->tasks()->create($task);
        }
    }
}
