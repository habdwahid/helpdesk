<?php

use App\Models\Gender;
use App\Models\Position;
use App\Models\SubDepartment;
use App\Models\TechnicianStatus;
use App\Models\User;
use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('technicians', function (Blueprint $table) {
            $table->id();
            $table->foreignIdFor(User::class);
            $table->foreignIdFor(Position::class);
            $table->foreignIdFor(SubDepartment::class);
            $table->foreignIdFor(Gender::class);
            $table->foreignIdFor(TechnicianStatus::class);
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('technicians');
    }
};
