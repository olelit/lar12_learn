<?php

use App\Models\Client;
use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::table('clients', function (Blueprint $table) {
            $table->string('web_identificator')->nullable();
        });


        Schema::create('file_histories', function (Blueprint $table) {
            $table->id();
            $table->foreignIdFor(Client::class)
                ->index()
                ->constrained()
                ->cascadeOnUpdate()
                ->cascadeOnDelete();

            $table->string('original_name');
            $table->string('outer_name');

            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('clients', function (Blueprint $table) {
            $table->dropColumn(['web_identificator']);
        });

        Schema::dropIfExists('file_histories');
    }
};
