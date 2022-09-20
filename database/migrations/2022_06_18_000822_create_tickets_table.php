<?php

use App\Models\Category;
use App\Models\Employee;
use App\Models\Technician;
use App\Models\TicketStatus;
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
        Schema::create('tickets', function (Blueprint $table) {
            $table->id();
            $table->foreignIdFor(Employee::class);
            $table->foreignIdFor(Category::class);
            $table->foreignIdFor(Technician::class)->nullable();
            $table->foreignIdFor(TicketStatus::class);
            $table->text('description');
            $table->string('ticket_status_description')->nullable();
            $table->date('solved_at')->nullable();
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
        Schema::dropIfExists('tickets');
    }
};
