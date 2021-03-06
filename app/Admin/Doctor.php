<?php

use App\Models\Doctor;
use App\Models\Hospital;
use App\Models\Polyclinic;
use App\Models\ProfileDoctors;
use SleepingOwl\Admin\Contracts\Display\Extension\FilterInterface;
use SleepingOwl\Admin\Model\ModelConfiguration;

AdminSection::registerModel(Doctor::class, function (ModelConfiguration $model) {
    $model->setTitle('Врачи');

    $model->onDisplay(function () {
        $display = AdminDisplay::datatablesAsync();

        $display->setColumnFilters([
            null,

            AdminColumnFilter::text()
                ->setPlaceholder('ФИО')
                ->setOperator(FilterInterface::CONTAINS)
                ->setHtmlAttribute('style', 'width: 100%'),

            AdminColumnFilter::select([
                'male' => 'Мужской',
                'female' => 'Женский',
            ], 'Пол')
                ->multiple()
                ->setHtmlAttribute('style', 'width: 100%'),


            AdminColumnFilter::select([
                'none' => 'Нет звания',
                'candidate' => 'Кандидат',
                'doctor' => 'Доктор',
            ], 'Звание')
                ->multiple()
                ->setHtmlAttribute('style', 'width: 100%'),

            AdminColumnFilter::select()
                ->setModelForOptions(ProfileDoctors::class, 'name')
                ->setColumnName('profile.id')
                ->multiple()
                ->setHtmlAttribute('style', 'width: 100%'),

            AdminColumnFilter::select()
                ->setModelForOptions(Polyclinic::class, 'name')
                ->setColumnName('polyclinics.id')
                ->multiple()
                ->setHtmlAttribute('style', 'width: 100%'),

            AdminColumnFilter::select()
                ->setModelForOptions(Hospital::class, 'name')
                ->setColumnName('hospitals.id')
                ->multiple()
                ->setHtmlAttribute('style', 'width: 100%'),

            AdminColumnFilter::text()
                ->setPlaceholder('Стаж работы')
        ]);

        $display->getColumnFilters()->setPlacement('table.header');
        $display->setColumns([
            AdminColumn::text('id')->setLabel('#'),
            AdminColumn::text('name')->setLabel('ФИО'),
            AdminColumn::custom('gender', function($doctor) {
                return match ($doctor['gender']) {
                    'male' => '<i class="fas fa-mars" style="color: #009ff1;font-size: 30px"></i>',
                    'female' => '<i class="fas fa-venus" style="color: #f284af;font-size: 30px"></i>',
                };
            })->setLabel('Пол'),

            AdminColumn::custom('degree', function($doctor) {
                return match ($doctor['degree']) {
                    'none' => 'Нет звания',
                    'candidate' => 'Кандидат',
                    'doctor' => 'Доктор',
                };
            })->setLabel('Звание'),

            AdminColumn::text('profile.name')->setLabel('Профиль'),
            AdminColumn::lists('polyclinics.name', 'Polyclinic')->setLabel('Поликлиники'),
            AdminColumn::lists('hospitals.name', 'Hospital')->setLabel('Больницы'),
            AdminColumn::text('experience', null, 'date_started_working')
                ->setLabel('Стаж в годах')
                ->setFilterCallback(function($column, $query, $search) {
                    if($search && is_numeric($search)) {
                        return $query->where('date_started_working', '<', DB::raw('DATE_SUB(NOW(),INTERVAL '.$search.' YEAR)'));
                    }
                    return $query;
                })
                ->setOrderCallback(function($column, $query, $search){
                    if($search)
                        return $query->orderBy('date_started_working', $search);
                    return $query;
                })
        ]);

        $display->paginate(15);
        return $display;
    });

    $model->onCreate(function () {
        $form = AdminForm::panel();

        $form->addBody([
            AdminFormElement::text('name', 'ФИО')->required(),
            AdminFormElement::select('gender', 'Пол', [
                'male' => 'Мужской',
                'female' => 'Женский',
            ])->required(),
            AdminFormElement::select('profile_doctors_id', 'Профиль', ProfileDoctors::class)
                ->setDisplay('name')
                ->required(),
            AdminFormElement::date('date_started_working', 'Когда начал работать')->required(),
        ]);
        return $form;
    });

    $model->onEdit(function (Doctor $doctor) {
        $form = AdminForm::panel();

        // Todo:: максимальное количество работ в зависимости от звания
        $form->addBody([
            AdminFormElement::text('name', 'ФИО')->required(),
            AdminFormElement::select('gender', 'Пол', [
                'male' => 'Мужской',
                'female' => 'Женский',
            ])->required(),
            AdminFormElement::select('profile_doctors_id', 'Профиль', ProfileDoctors::class)
                ->setDisplay('name')
                ->required(),
            AdminFormElement::date('date_started_working', 'Когда начал работать')->required(),
            AdminFormElement::select('degree', 'Звание', [
                'none' => 'Нет звания',
                'candidate' => 'Кандидат',
                'doctor' => 'Доктор',
            ]),
            AdminFormElement::multiselect('polyclinics', 'Поликлиники', Polyclinic::class)->setDisplay('name'),
            AdminFormElement::multiselect('hospitals', 'Больницы', Hospital::class)->setDisplay('name'),
        ]);
        return $form;
    });
});
