<?php

namespace Database\Seeders;

use App\Models\Department;
use App\Models\Doctor;
use App\Models\Hospital;
use App\Models\HospitalAppointment;
use App\Models\Operation;
use App\Models\Patient;
use App\Models\Polyclinic;
use App\Models\Worker;
use Illuminate\Support\Facades\DB;
use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     *
     * @return void
     */
    public function run()
    {
        // Добавляем профили лабораторий
        DB::table('profile_laboratories')->insert([
            ['name' => 'Биохимия'],
            ['name' => 'Физиология'],
            ['name' => 'Химия'],
        ]);

        // Добавляем профили врачей
        DB::table('profile_doctors')->insert([
            ['name' => 'Хирург', 'can_operate' => true],
            ['name' => 'Терапевт', 'can_operate' => false],
            ['name' => 'Невропатолог', 'can_operate' => false],
            ['name' => 'Окулист', 'can_operate' => false],
            ['name' => 'Стоматолог', 'can_operate' => true],
            ['name' => 'Рентгенолог', 'can_operate' => false],
            ['name' => 'Гинеколог', 'can_operate' => true],
        ]);

        // Добавляем лаборатории
        DB::table('laboratories')->insert([
            ['name' => 'Инвитро'],
            ['name' => 'Лабдиагностика'],
            ['name' => 'МедЛабЭкспресс'],
            ['name' => 'Клинико-диагностические лаборатории'],
            ['name' => 'KDL'],
            ['name' => 'Гемотест'],
            ['name' => 'Бактериологическая Лаборатория'],
            ['name' => 'Бактерицид'],
        ]);

        // Указываем профили лабораторий
        DB::table('laboratory_profiles')->insert([
            // Инвитро
            ['laboratory_id' => 1, 'profile_laboratories_id' => 1],
            ['laboratory_id' => 1, 'profile_laboratories_id' => 2],
            ['laboratory_id' => 1, 'profile_laboratories_id' => 3],

            // Лабдиагностика
            // ['laboratory_id' => 2, 'profile_laboratories_id' => 1],
            ['laboratory_id' => 2, 'profile_laboratories_id' => 2],
            // ['laboratory_id' => 2, 'profile_laboratories_id' => 3],

            // МедЛабЭкспресс
            ['laboratory_id' => 3, 'profile_laboratories_id' => 1],
            ['laboratory_id' => 3, 'profile_laboratories_id' => 2],
            ['laboratory_id' => 3, 'profile_laboratories_id' => 3],

            // Клинико-диагностические лаборатории
            // ['laboratory_id' => 4, 'profile_laboratories_id' => 1],
            // ['laboratory_id' => 4, 'profile_laboratories_id' => 2],
            ['laboratory_id' => 4, 'profile_laboratories_id' => 3],

            // KDL
            ['laboratory_id' => 5, 'profile_laboratories_id' => 1],
            // ['laboratory_id' => 5, 'profile_laboratories_id' => 2],
            // ['laboratory_id' => 5, 'profile_laboratories_id' => 3],

            // Гемотест
            // ['laboratory_id' => 6, 'profile_laboratories_id' => 1],
            ['laboratory_id' => 6, 'profile_laboratories_id' => 2],
            ['laboratory_id' => 6, 'profile_laboratories_id' => 3],

            // Бактериологическая Лаборатория
            ['laboratory_id' => 7, 'profile_laboratories_id' => 1],
            // ['laboratory_id' => 7, 'profile_laboratories_id' => 2],
            ['laboratory_id' => 7, 'profile_laboratories_id' => 3],

            // Бактерицид
            ['laboratory_id' => 8, 'profile_laboratories_id' => 1],
            ['laboratory_id' => 8, 'profile_laboratories_id' => 2],
            // ['laboratory_id' => 8, 'profile_laboratories_id' => 3],
        ]);

        // Больницы
        DB::table('hospitals')->insert([
           ['name' => 'ПККБ'],
           ['name' => 'ГКБ №4'],
        ]);

        // Отделения
        Department::factory(50)->create();

        // Поликлиники
        DB::table('polyclinics')->insert([
            // С больницей
            ['name' => 'Поликлиника ПККБ'],

            // Без больницы
            ['name' => 'Городская клиническая поликлиника №2'],
            ['name' => 'Городская клиническая поликлиника №4'],
            ['name' => 'Городская клиническая поликлиника №7'],
            ['name' => 'Формула жизни'],
            ['name' => 'Клиника Надежда'],
            ['name' => 'МЕДСИ'],
            ['name' => 'ГБУЗ ПК ГСП'],
            ['name' => 'Практик'],
            ['name' => 'Любимый доктор'],
            ['name' => 'КамаМед'],
            ['name' => 'МедГарант'],
        ]);

        // Прикрепляем поликлиники к больницам
        DB::table('polyclinics')
            ->where('id', '=', 1)
            ->update([
                'hospital_id' => 1
            ]);

        // Добавляем пациентов
        Patient::factory(50)->create();

        // Добавляем врачей
        Doctor::factory(50)->create();

        // Добавляем должности для обслуживающего персонала
        DB::table('profile_workers')->insert([
            ['name' => 'Заведующий хозяйством'],
            ['name' => 'Главный бухгалтер'],
            ['name' => 'Начальник отдела кадров'],
            ['name' => 'Инспектор по кадрам'],
            ['name' => 'Старший экономист'],
            ['name' => 'Инженер'],
            ['name' => 'Медсестра'],
            ['name' => 'Главный врач'],
            ['name' => 'Санитар'],
            ['name' => 'Уборщица'],
        ]);

        // Добавляем персонал
        Worker::factory(50)->create();

        // Приклепляем врачей
        $hospitals = Hospital::all();
        $polyclinics = Polyclinic::all();
        Doctor::all()->each(function ($doctor) use ($hospitals, $polyclinics) {
            $jobPlace = rand(1, 3);
            switch ($jobPlace) {
                case 1:
                    // Работает в поликлинике
                    DB::table('doctor_hospitals')->insert([
                        'doctor_id' => $doctor->id,
                        'hospital_id' => $hospitals->random()->id
                    ]);

                    break;
                case 2:
                    // Работает в больнице
                    DB::table('doctor_polyclinics')->insert([
                        'doctor_id' => $doctor->id,
                        'polyclinic_id' => $polyclinics->random()->id
                    ]);

                    break;
                case 3:
                    // Работает и там и там
                    DB::table('doctor_hospitals')->insert([
                        'doctor_id' => $doctor->id,
                        'hospital_id' => $hospitals->random()->id
                    ]);
                    DB::table('doctor_polyclinics')->insert([
                        'doctor_id' => $doctor->id,
                        'polyclinic_id' => $polyclinics->random()->id
                    ]);

                    break;
            }
        });

        // Операции
        Operation::factory(50)->create();

        // Добавляем палаты
        Department::all()->each(function ($department) {
            $cntRooms = rand(1,5);
            for($i = 1; $i < $cntRooms; $i++)
                DB::table('department_rooms')->insert([
                    'name' => 'каб. №'.$i,
                    'beds' => rand(2,10),
                    'department_id' => $department->id
                ]);
        });

        // Добавление пацентов в больницу
        HospitalAppointment::factory(50)->create();
    }
}
