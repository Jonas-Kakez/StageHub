<?php

namespace Database\Seeders;

use App\Models\Affectation;
use App\Models\Candidature;
use App\Models\Departement;
use App\Models\Encadreur;
use App\Models\Entreprise;
use App\Models\Etudiant;
use App\Models\OffreStage;
use App\Models\User;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;

class DatabaseSeeder extends Seeder
{
    public function run(): void
    {
        $admin = User::create([
            'name' => 'Administrateur',
            'email' => 'admin@stagehub.cd',
            'password' => Hash::make('password'),
            'role' => User::ROLE_ADMIN,
        ]);

        User::create([
            'name' => 'Chef Département',
            'email' => 'departement@stagehub.cd',
            'password' => Hash::make('password'),
            'role' => User::ROLE_DEPARTEMENT,
        ]);

        $deptInfo = Departement::create([
            'nom' => 'Informatique',
            'faculte' => 'Sciences',
            'description' => 'Département d\'informatique et télécommunications',
        ]);

        $deptMarketing = Departement::create([
            'nom' => 'Marketing',
            'faculte' => 'Économie',
            'description' => 'Département marketing et communication',
        ]);

        $encUser = User::create([
            'name' => 'Dr. Mukendi Kabongo',
            'email' => 'encadreur@stagehub.cd',
            'password' => Hash::make('password'),
            'role' => User::ROLE_ENCADREUR,
        ]);

        $encadreur = Encadreur::create([
            'user_id' => $encUser->id,
            'departement_id' => $deptInfo->id,
            'specialite' => 'Développement Web',
            'telephone' => '+243 999 000 001',
        ]);

        $entUser = User::create([
            'name' => 'Congo Digital SARL',
            'email' => 'entreprise@stagehub.cd',
            'password' => Hash::make('password'),
            'role' => User::ROLE_ENTREPRISE,
        ]);

        $entreprise = Entreprise::create([
            'user_id' => $entUser->id,
            'nom' => 'Congo Digital SARL',
            'secteur' => 'Informatique & Télécommunications',
            'telephone' => '+243 999 000 002',
            'adresse' => 'Av. Lumumba, Quartier Industriel',
            'ville' => 'Kolwezi',
            'province' => 'Lualaba',
            'pays' => 'RDC',
            'latitude' => -10.7167,
            'longitude' => 25.4667,
            'statut_validation' => 'validee',
        ]);

        Entreprise::create([
            'user_id' => User::create([
                'name' => 'Rawbank',
                'email' => 'rawbank@stagehub.cd',
                'password' => Hash::make('password'),
                'role' => User::ROLE_ENTREPRISE,
            ])->id,
            'nom' => 'Rawbank',
            'secteur' => 'Banque & Finance',
            'ville' => 'Kinshasa',
            'province' => 'Kinshasa',
            'pays' => 'RDC',
            'statut_validation' => 'validee',
        ]);

        $etuUser = User::create([
            'name' => 'Jean Dupont',
            'email' => 'etudiant@stagehub.cd',
            'password' => Hash::make('password'),
            'role' => User::ROLE_ETUDIANT,
        ]);

        $etudiant = Etudiant::create([
            'user_id' => $etuUser->id,
            'departement_id' => $deptInfo->id,
            'numero_etudiant' => 'ETU2024001',
            'niveau' => 'Master Informatique',
            'domaine' => 'Informatique',
            'competences' => 'JavaScript, React, Node.js, PHP, Laravel',
            'telephone' => '+243 999 000 003',
            'statut' => 'en_recherche',
        ]);

        Etudiant::create([
            'user_id' => User::create([
                'name' => 'Marie Martin',
                'email' => 'marie@stagehub.cd',
                'password' => Hash::make('password'),
                'role' => User::ROLE_ETUDIANT,
            ])->id,
            'departement_id' => $deptMarketing->id,
            'niveau' => 'Licence Marketing',
            'domaine' => 'Marketing',
            'statut' => 'en_recherche',
        ]);

        $offre1 = OffreStage::create([
            'entreprise_id' => $entreprise->id,
            'titre' => 'Stage Développeur Web',
            'departement_entreprise' => 'Département IT',
            'duree' => '6 mois',
            'localisation' => 'Kolwezi',
            'type_stage' => 'Informatique',
            'domaine' => 'Informatique',
            'description' => 'Développement d\'applications web avec Laravel et React.',
            'competences_requises' => 'JavaScript, React, Node.js, PHP',
            'quota_stagiaires' => 2,
            'statut' => 'active',
            'moderee' => true,
            'publie_le' => now()->subDays(10),
        ]);

        $offre2 = OffreStage::create([
            'entreprise_id' => $entreprise->id,
            'titre' => 'Stage Marketing Digital',
            'departement_entreprise' => 'Département Marketing',
            'duree' => '4 mois',
            'localisation' => 'Kolwezi',
            'type_stage' => 'Marketing',
            'domaine' => 'Marketing',
            'description' => 'Gestion des campagnes digitales et analyse de données.',
            'competences_requises' => 'SEO, Google Ads, Analytics',
            'statut' => 'active',
            'moderee' => true,
            'publie_le' => now()->subDays(5),
        ]);

        Candidature::create([
            'etudiant_id' => $etudiant->id,
            'offre_stage_id' => $offre1->id,
            'statut' => 'en_attente',
        ]);

        $this->command->info('StageHub seedé avec succès!');
        $this->command->info('Admin: admin@stagehub.cd / password');
        $this->command->info('Entreprise: entreprise@stagehub.cd / password');
        $this->command->info('Étudiant: etudiant@stagehub.cd / password');
        $this->command->info('Encadreur: encadreur@stagehub.cd / password');
    }
}
