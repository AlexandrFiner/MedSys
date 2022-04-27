<p align="center"><img src="./public/images/logo.svg" width="400px" alt="logo"></p>

## Описание

Курсовая работа по базам данных. 

- PHP 8.0.10
- Laravel Framework 9.0.2
- SleepingOwl Admin
- MySQL

## Установка
1. Скопируйте настройки окружения ``cp .env.example .env``
2. Выполните сборку с помощью команды: ``docker-compose build ``
3. После завершения сборки запустите среду в фоновом режиме с помощью следующей команды: ``docker-compose up -d``
4. Проверьте работу активных служб `` docker-compose ps ``
5. Зайдите в bash с помощью команды `` docker-compose exec app bash ``
6. Установите требуемые пакеты ```composer i```
7. Сгенерируйте ключ приложения Laravel ``php artisan key:generate``
8. Произведите миграцию в проекте ```php artisan migrate```
9. При необходимости используйте фабрики, для заполнения базы ```php artisan db:seed```

Сайт будет доступен по адресу ``localhost:8000``

## Постановка задачи

Каждая больница города состоит из одного или нескольких корпусов, в каждом из которых размещается одно или несколько отделений, специализирующихся на лечении определенной группы болезней; каждое отделение имеет некоторое количество палат на определенное число коек.

Поликлиники административно прикреплены к больницам.

Как больницы, так и поликлиники обслуживаются врачебным (хирурги, терапевты, невропатологи, окулисты, стоматологи, рентгенологи, гинекологи и пр.) и обслуживающим персоналом (медсестры, санитары, уборщицы и пр.). Каждая категория врачебного персонала обладает характеристиками, присущими только специалистам этого профиля и по-разному участвует в связях: хирурги, стоматологи и гинекологи могут проводить операции, они же имеют такие характеристики, как число проведенных операций, число операций с летальным исходом; рентгенологи и стоматологи имеют коэффициент к зарплате за вредные условия труда, у рентгенологов и невропатологов более длительный отпуск. Врачи любого профиля могут иметь степень кандидата или доктора медицинских наук. Степень доктора медицинских наук дает право на присвоение звания профессора, а степень кандидата медицинских наук на присвоение звания доцента. Разрешено совместительство, так что каждый врач может работать либо в больнице, либо в поликлинике, либо и в одной больнице, и в одной поликлинике. Врачи со званием доцента или профессора могут консультировать в нескольких больницах или поликлиниках.

Лаборатории, выполняющие те или иные медицинские анализы, могут обслуживать различные больницы и поликлиники, при условии наличия договора на обслуживание с соответствующим лечебным заведением. При этом каждая лаборатория имеет один или несколько профилей: биохимические, физиологические, химические исследования.

Пациенты амбулаторно лечатся в одной из поликлиник, и по направлению из них могут стационарно лечиться либо в больнице, к которой относится поликлиника, либо в любой другой, если специализация больницы, к которой приписана поликлиника, не позволяет провести требуемое лечение. Как в больнице, так и в поликлинике ведется персональный учет пациентов, полная история их болезней, назначения лечения, операции и т.д. В больнице пациент имеет в каждый данный момент одного лечащего врача, в поликлинике – несколько.

## Запросы в информационной системе

![42%](https://progress-bar.dev/42?width=500&title=Готово)

<!-- 6/14 -->
<!-- 50, 57, 64, 71, 78, 85, 92 -->
- [X] Получите перечень и общее число врачей указанного профиля для конкретного медицинского учреждения, больницы либо поликлиники, либо всех медицинских учреждений города. 
- [X] Получите перечень и общее число обслуживающего персонала указанной специальности для конкретного медицинского учреждения, больницы либо поликлиники, либо всех медицинских учреждений города. 
- [X] Получите перечень и общее число врачей указанного профиля, сделавших число операций не меньше заданного для конкретного медицинского учреждения, больницы либо поликлиники, либо всех медицинских учреждений города. 
- [X] Получите перечень и общее число врачей указанного профиля, стаж работы которых не меньше заданного для конкретного медицинского учреждения, больницы либо поликлиники, либо всех медицинских учреждений города. 
- [X] Получите перечень и общее число врачей указанного профиля со степенью кандидата или доктора медицинских наук, со званием доцента или профессора для конкретного медицинского учреждения либо больницы, либо поликлиники, либо всех медицинских учреждений города. 
- [ ] Получите перечень пациентов указанной больницы, отделения либо конкретной палаты указанного отделения, с указанием даты поступления, состояния, температуры, лечащего врача. 
- [ ] Получите перечень пациентов, прошедших стационарное лечение в указанной больнице либо у конкретного врача за некоторый промежуток времени. 
- [ ] Получите перечень пациентов, наблюдающихся у врача указанного профиля в конкретной поликлинике. 
- [ ] Получите общее число палат и коек указанной больницы в общем и по каждому отделению, а также число свободных коек по каждому отделению и число полностью свободных палат. 
- [ ] Получите общее число кабинетов указанной поликлиники, число посещений каждого кабинета за определенный период. 
- [ ] Получите данные о выработке (среднее число принятых пациентов в день) за указанный период для конкретного врача либо всех врачей поликлиники, либо для всех врачей названного профиля. 
- [ ] Получите данные о загрузке (число пациентов, у которых врач в настоящее время является лечащим врачом) для указанного врача либо всех врачей больницы, либо для всех врачей названного профиля. 
- [X] Получите перечень пациентов, перенесших операции в указанной больнице либо поликлинике, либо у конкретного врача за некоторый промежуток времени. 
- [ ] Получите данные о выработке лаборатории (среднее число проведенных обследований в день) за указанный период для данного медицинского учреждения либо всех медицинских учреждений города. 
