<?php

use App\Models\Department;
use App\Models\DepartmentRoom;
use App\Models\Patient;
use App\Models\Hospital;
use App\Models\Doctor;
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
        Schema::create('hospital_appointments', function (Blueprint $table) {
            $table->id();
            $table->foreignIdFor(Patient::class);
            $table->foreignIdFor(Hospital::class);
            $table->foreignIdFor(Department::class);
            $table->foreignIdFor(DepartmentRoom::class);
            $table->foreignIdFor(Doctor::class);
            $table->text('description')->nullable(true);
            $table->enum('status', [
                'process',
                'released'
            ])->default('process');
            $table->enum('condition', [
                'satisfactory',
                'critical',
            ]);
            $table->float('temperature');
            $table->date('date_in');
            $table->date('date_out')->nullable(true);
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
        Schema::dropIfExists('hospital_appointments');
    }
};
