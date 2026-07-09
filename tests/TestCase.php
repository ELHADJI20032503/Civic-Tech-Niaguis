<?php

namespace Tests;

use Illuminate\Contracts\Console\Kernel;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Foundation\Testing\TestCase as BaseTestCase;
use Illuminate\Support\Facades\Schema;

abstract class TestCase extends BaseTestCase
{
    public function createApplication()
    {
        $app = require __DIR__.'/../bootstrap/app.php';

        $app->make(Kernel::class)->bootstrap();

        return $app;
    }

    protected function setUp(): void
    {
        parent::setUp();

        $this->createUtilisateurTable();
        $this->createDemandesTable();
        $this->createCitoyensTable();
        $this->createPaiementsTable();
    }

    protected function createUtilisateurTable(): void
    {
        Schema::dropIfExists('utilisateurs');

        Schema::create('utilisateurs', function (Blueprint $table) {
            $table->increments('id_user');
            $table->string('login')->unique();
            $table->string('password_hash');
            $table->string('prenom');
            $table->string('nom');
            $table->string('role');
            $table->string('statut_compte')->default('actif');
            $table->timestamps();
        });
    }

    protected function createDemandesTable(): void
    {
        Schema::dropIfExists('demandes');

        Schema::create('demandes', function (Blueprint $table) {
            $table->increments('id_demande');
            $table->string('statut')->default('Reçu');
            $table->string('type_acte')->nullable();
            $table->timestamps();
        });
    }

    protected function createCitoyensTable(): void
    {
        Schema::dropIfExists('citoyens');

        Schema::create('citoyens', function (Blueprint $table) {
            $table->increments('id_citoyen');
            $table->string('nom');
            $table->string('prenom');
            $table->date('date_naissance')->nullable();
            $table->string('lieu_naissance')->nullable();
            $table->string('genre')->nullable();
            $table->timestamps();
        });
    }

    protected function createPaiementsTable(): void
    {
        Schema::dropIfExists('paiements');

        Schema::create('paiements', function (Blueprint $table) {
            $table->increments('id_paiement');
            $table->unsignedInteger('id_demande');
            $table->integer('montant')->default(0);
            $table->dateTime('date_paiement')->nullable();
            $table->string('mode_paiement')->nullable();
            $table->timestamps();
        });
    }
}
