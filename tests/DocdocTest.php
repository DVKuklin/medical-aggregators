<?php /** @noinspection PhpUndefinedMethodInspection */

namespace Veezex\Medical\Tests;

use Illuminate\Support\Collection;
use Veezex\Medical\Docdoc\Models\DoctorDetails;
use Veezex\Medical\Docdoc\Provider as Docdoc;

class DocdocTest extends MedicalTestCase
{
    /** @test */
    public function it_can_get_clinic_reviews()
    {
        $this->mockResponseFile(['reviews.json']);
        $provider = app(Docdoc::class);

        $reviews = $provider->getClinicReviews(32);

        $this->assertReviews($reviews);
    }

    /** @test */
    public function it_can_get_doctor_reviews()
    {
        $this->mockResponseFile(['reviews.json']);
        $provider = app(Docdoc::class);

        $reviews = $provider->getDoctorReviews(32);

        $this->assertReviews($reviews);
    }

    /**
     * @param Collection $reviews
     */
    protected function assertReviews(Collection $reviews)
    {
        $this->assertCount(2, $reviews);

        // 1
        $review = $reviews->get(0);
        $this->assertEquals($review->getId(), 617708);
        $this->assertEquals($review->getClient(), 'efghih cdefgh');
        $this->assertEquals($review->getRatingQlf(), 3);
        $this->assertEquals($review->getRatingAtt(), 3);
        $this->assertEquals($review->getRatingRoom(), 3);
        $this->assertEquals($review->getText(), "Елена Михайловна не до конца раскрыла всю информацию. Доктор по внешнему виду поставила диагноз и назначила лечение.");
        $this->assertEquals($review->getReviewTs(), 1573344000);
        $this->assertEquals($review->getDoctorId(), 1679);
        $this->assertEquals($review->getClinicId(), 44);
        $this->assertEquals($review->getAnswer(), null);
        $this->assertEquals($review->getWaitingTime(), null);
        $this->assertEquals($review->getRatingDoctor(), 5);
        $this->assertEquals($review->getRatingClinic(), null);
        $this->assertEquals($review->getTagClinicLocation(), false);
        $this->assertEquals($review->getTagClinicService(), false);
        $this->assertEquals($review->getTagClinicCost(), false);
        $this->assertEquals($review->getTagClinicRecommend(), false);
        $this->assertEquals($review->getTagDoctorAttention(), false);
        $this->assertEquals($review->getTagDoctorExplain(), false);
        $this->assertEquals($review->getTagDoctorQuality(), false);
        $this->assertEquals($review->getTagDoctorRecommend(), false);
        $this->assertEquals($review->getTagDoctorSatisfied(), false);
        $this->assertEquals($review->getReceptionTs(), 1572652800);

        // 2
        $review = $reviews->get(1);
        $this->assertEquals($review->getId(), 370096);
        $this->assertEquals($review->getClient(), 'opqrst ghihjl');
        $this->assertEquals($review->getRatingQlf(), null);
        $this->assertEquals($review->getRatingAtt(), null);
        $this->assertEquals($review->getRatingRoom(), null);
        $this->assertEquals($review->getText(), "Все было отлично. Елена Михайловна хороший специалист. Спасибо ей большое! Отзывы только самые хорошие.");
        $this->assertEquals($review->getReviewTs(), 1522195200);
        $this->assertEquals($review->getDoctorId(), 1679);
        $this->assertEquals($review->getClinicId(), 44);
        $this->assertEquals($review->getAnswer(), '111');
        $this->assertEquals($review->getWaitingTime(), null);
        $this->assertEquals($review->getRatingDoctor(), null);
        $this->assertEquals($review->getRatingClinic(), null);
        $this->assertEquals($review->getTagClinicLocation(), false);
        $this->assertEquals($review->getTagClinicService(), false);
        $this->assertEquals($review->getTagClinicCost(), false);
        $this->assertEquals($review->getTagClinicRecommend(), false);
        $this->assertEquals($review->getTagDoctorAttention(), false);
        $this->assertEquals($review->getTagDoctorExplain(), false);
        $this->assertEquals($review->getTagDoctorQuality(), false);
        $this->assertEquals($review->getTagDoctorRecommend(), false);
        $this->assertEquals($review->getTagDoctorSatisfied(), false);
        $this->assertEquals($review->getReceptionTs(), 1522108800);
    }

    /** @test */
    public function it_can_get_doctor_details()
    {
        $this->mockResponseFile(['doctor_details.json']);
        $provider = app(Docdoc::class);

        $details = $provider->getDoctorDetails(32);
        $this->assertInstanceOf(DoctorDetails::class, $details);

        $this->assertEquals($details->getId(), 32);
        $this->assertEquals($details->getAssociationText(), null);
        $this->assertEquals($details->getCourses(), [
            [
                'name' => 'Повышение квалификации «Урология»',
                'org' => "Российская медицинская академия последипломного образования Росздрава",
                'year' => 2013,
            ],
            [
                'name' => "Повышение квалификации по специальности «Ультразвуковая диагностика»",
                'org' => "РУДН",
                'year' => 2016,
            ]
        ]);
        $this->assertEquals($details->getEducation(), [
            [
                'name' => "Кабардино-Балкарский государственный университет им. Бербекова",
                'type' => "ВУЗ",
                'speciality' => "Лечебное дело (Лечебно-профилактическое дело)",
                'year' => 2005,
            ],
            [
                'name' => "Кабардино-Балкарский государственный университет им. Бербекова",
                'type' => "Интернатура",
                'speciality' => "Хирургия",
                'year' => 2006,
            ],
        ]);
        $this->assertEquals($details->getExperience(), [
            [
                'years' => [null, null],
                'city' => "Москва",
                'org' => "\"Ниармедик\"",
                'position' => "Уролог",
            ],
            [
                'years' => [2003, 2005],
                'city' => "Москва",
                'org' => "\"Медхелп\"",
                'position' => "Уролог",
            ],
        ]);
        $this->assertEquals($details->getSpecialization(), [
            [
                'name' => "Уролог",
                'illnesses' => [
                    "Аденома",
                    "Аденома предстательной железы",
                    "Аденома простаты",
                    "Азооспермия"
                ]
            ]
        ]);
    }

    /** @test */
    public function it_can_get_doctors()
    {
        $this->mockResponseFile(['doctors.1.json', 'doctors.2.json']);
        $provider = app(Docdoc::class);

        $doctors = $provider->getDoctors([1, 2]);
        $this->assertCount(2, $doctors);

        // 1
        $doctor = $doctors->get(0);
        $this->assertEquals($doctor->getId(), 9587);
        $this->assertEquals($doctor->getCityId(), 1);
        $this->assertEquals($doctor->getName(), "Киселёва Татьяна Юрьевна");
        $this->assertEquals($doctor->getSex(), 'female');
        $this->assertEquals($doctor->getRating(), 4.6);
        $this->assertEquals($doctor->getImage(), 'https://cdn.bookingtest.docdoc.pro/doctor/9587_small.jpg');
        $this->assertEquals($doctor->getCategory(), 'Врач высшей категории');
        $this->assertEquals($doctor->getPhoneNumber(), null);
        $this->assertEquals($doctor->getDegree(), null);
        $this->assertEquals($doctor->getRank(), null);
        $this->assertEquals($doctor->getDescription(), "Акушер-гинеколог, венеролог, гинеколог, гинеколог-эндокринолог. Проводит прерывание беременности, патология шейки, эндокринология, акушерство, лечение и обследование супружеских пар, введение и удаление внутриматочной спирали, видеокольпоскопия. Принимает участие в конференциях.  ");
        $this->assertEquals($doctor->getAbout(), 'Акушер-гинеколог, венеролог, гинеколог, гинеколог-эндокринолог. Проводит прерывание беременности, патология шейки, эндокринология, акушерство, лечение и обследование супружеских пар, введение и удаление внутриматочной спирали, видеокольпоскопия. Принимает участие в конференциях.  ');
        $this->assertEquals($doctor->getExperienceYears(), 38);
        $this->assertEquals($doctor->getPrice(), 1500);
        $this->assertEquals($doctor->getSpecialPrice(), null);
        $this->assertEquals($doctor->getKidsReception(), false);
        $this->assertEquals($doctor->getActive(), true);
        $this->assertEquals($doctor->getDeparture(), false);
        $this->assertEquals($doctor->getReviewsCount(), 251);
        $this->assertEquals($doctor->getFocusClinicId(), 252);
        $this->assertEquals($doctor->getBookingClinicIds(), []);
        $this->assertEquals($doctor->getClinicIds(), [252]);
        $this->assertEquals($doctor->getPriceList(), [
            '252' => [
                [
                    'speciality_id' => 72,
                    'price' => 1500,
                    'special_price' => null,
                    'departure_price' => [null, null]
                ]
            ]
        ]);

        // 2
        $doctor = $doctors->get(1);
        $this->assertEquals($doctor->getId(), 13581);
        $this->assertEquals($doctor->getCityId(), 2);
        $this->assertEquals($doctor->getName(), "Рубцова Ольга Игоревна");
        $this->assertEquals($doctor->getSex(), 'male');
        $this->assertEquals($doctor->getRating(), 4.4);
        $this->assertEquals($doctor->getImage(), 'https://cdn.bookingtest.docdoc.pro/doctor/13581_small.jpg');
        $this->assertEquals($doctor->getCategory(), null);
        $this->assertEquals($doctor->getPhoneNumber(), 'тел 1');
        $this->assertEquals($doctor->getDegree(), 'степень 1');
        $this->assertEquals($doctor->getRank(), 'ранг 1');
        $this->assertEquals($doctor->getDescription(), "Врач восстановительной медицины, диетолог, спортивный врач. Проводит индивидуальные занятия: при варикозном расширении вен, при заболеваниях опорно-двигательного аппарата. Разрабатывает индивидуальные, реабилитационные программы: при нарушении обмена веществ, при бронхиальной астме, хроническом бронхите, хроническом насморке, аденоидах, после травмы костей, связок, суставов, после перенесенного инсульта в восстановительный период, при заболеваниях сердечно-сосудистой системы.");
        $this->assertEquals($doctor->getAbout(), 'Врач восстановительной медицины, диетолог, спортивный врач. Проводит индивидуальные занятия: при варикозном расширении вен, при заболеваниях опорно-двигательного аппарата. Разрабатывает индивидуальные, реабилитационные программы: при нарушении обмена веществ, при бронхиальной астме, хроническом бронхите, хроническом насморке, аденоидах, после травмы костей, связок, суставов, после перенесенного инсульта в восстановительный период, при заболеваниях сердечно-сосудистой системы.');
        $this->assertEquals($doctor->getExperienceYears(), 23);
        $this->assertEquals($doctor->getPrice(), 1000);
        $this->assertEquals($doctor->getSpecialPrice(), null);
        $this->assertEquals($doctor->getKidsReception(), false);
        $this->assertEquals($doctor->getActive(), true);
        $this->assertEquals($doctor->getDeparture(), false);
        $this->assertEquals($doctor->getReviewsCount(), 24);
        $this->assertEquals($doctor->getFocusClinicId(), 46120);
        $this->assertEquals($doctor->getBookingClinicIds(), []);
        $this->assertEquals($doctor->getClinicIds(), [
            46120,
            2890,
            47342
        ]);
        $this->assertEquals($doctor->getPriceList(), [
            '46120' => [
                [
                    'speciality_id' => 74,
                    'price' => 1500,
                    'special_price' => null,
                    'departure_price' => [null, null]
                ],
                [
                    'speciality_id' => 155,
                    'price' => 1000,
                    'special_price' => null,
                    'departure_price' => [null, null]
                ],
                [
                    'speciality_id' => 177,
                    'price' => 1000,
                    'special_price' => null,
                    'departure_price' => [null, null]
                ],
            ],
            '2890' => [
                [
                    'speciality_id' => 74,
                    'price' => 2000,
                    'special_price' => null,
                    'departure_price' => [null, null]
                ],
            ],
            '47342' => [
                [
                    'speciality_id' => 74,
                    'price' => 1500,
                    'special_price' => null,
                    'departure_price' => [null, null]
                ],
                [
                    'speciality_id' => 155,
                    'price' => 1000,
                    'special_price' => null,
                    'departure_price' => [null, null]
                ],
                [
                    'speciality_id' => 177,
                    'price' => 1000,
                    'special_price' => null,
                    'departure_price' => [null, null]
                ],
            ]
        ]);
    }

    /** @test */
    public function it_can_get_clinics()
    {
        $this->mockResponseFile(['clinics.1.json', 'clinics.4.json']);
        $provider = app(Docdoc::class);

        $clinics = $provider->getClinics([1, 4]);
        $this->assertCount(2, $clinics);

        // 1
        $clinic = $clinics->get(0);
        $this->assertEquals($clinic->getId(), 44);
        $this->assertEquals($clinic->getDistrictId(), 63);
        $this->assertEquals($clinic->getCityId(), 1);
        $this->assertEquals($clinic->getBranchIds(), [250, 251, 252, 253, 254, 255, 256, 257, 258, 259, 260, 2275, 2276, 15757, 33033, 42522]);
        $this->assertEquals($clinic->getRootClinicId(), 44);
        $this->assertEquals($clinic->getName(), 'МедЦентрСервис на Авиамоторной');
        $this->assertEquals($clinic->getShortName(), 'МедЦентрСервис на Авиамоторной');
        $this->assertEquals($clinic->getUrl(), 'http://www.medcentrservis.ru');
        $this->assertEquals($clinic->getLng(), "37.7165130000");
        $this->assertEquals($clinic->getLat(), "55.7534580000");
        $this->assertEquals($clinic->getStreetId(), 12);
        $this->assertEquals($clinic->getAddrCity(), "Москва");
        $this->assertEquals($clinic->getAddrStreet(), "ул. Авиамоторная");
        $this->assertEquals($clinic->getAddrHouse(), "д. 41Б");
        $this->assertEquals($clinic->getDescription(), "Многопрофильный медицинский центр. Диагностика и лечение взрослых. Расположен в 7 мин. ходьбы от м. Авиамоторная. Прием происходит по предварительной записи.");
        $this->assertEquals($clinic->getShortDescription(), "Многопрофильный медицинский центр. Диагностика и лечение взрослых. Расположен в 7 мин. ходьбы от м. Авиамоторная. Прием происходит по предварительной записи.");
        $this->assertEquals($clinic->getTypeClinic(), true);
        $this->assertEquals($clinic->getTypeDiagnostic(), false);
        $this->assertEquals($clinic->getTypeDoctor(), false);
        $this->assertEquals($clinic->getTypeText(), "медицинская клиника");
        $this->assertEquals($clinic->getPhone(), "74952553137");
        $this->assertEquals($clinic->getReplacementPhone(), null);
        $this->assertEquals($clinic->getDirectPhone(), "+7 (495) 255-31-37; +7 (495) 104-77-99; +7 (495) 132-37-37; +7 (495) 151-23-32; +7 (495) 185-21-21");
        $this->assertEquals($clinic->getLogo(), "https://cdn.bookingtest.docdoc.pro/clinic/logo/min_44.jpg?1573413879");
        $this->assertEquals($clinic->getEmail(), "test@test.ru");
        $this->assertEquals($clinic->getRating(), 9.04);
        $this->assertEquals($clinic->getMinPrice(), 1500);
        $this->assertEquals($clinic->getMaxPrice(), 1500);
        $this->assertEquals($clinic->getOnlineSchedule(), true);
        $this->assertEquals($clinic->getSchedule(), [
            'monday' => ['00:00', '24:00'],
            'tuesday' => ['00:00', '24:00'],
            'wednesday' => ['00:00', '24:00'],
            'thursday' => ['00:00', '24:00'],
            'friday' => ['00:00', '24:00'],
            'saturday' => ['00:00', '24:00'],
            'sunday' => ['00:00', '24:00'],
        ]);
        $this->assertEquals($clinic->getHighlightDiscount(), 0);
        $this->assertEquals($clinic->getRequestFormSurname(), false);
        $this->assertEquals($clinic->getRequestFormBirthday(), true);
        $this->assertEquals($clinic->getMetroIds(), [1]);
        $this->assertEquals($clinic->getSpecialityIds(), [70,72,73,91,93]);
        $this->assertEquals($clinic->getServices(), [
            ['id' => 3821, 'price' => 1700, 'special_price' => null],
            ['id' => 3841, 'price' => 1000, 'special_price' => null],
            ['id' => 3865, 'price' => 1500, 'special_price' => null],
            ['id' => 3819, 'price' => 2500, 'special_price' => null],
            ['id' => 3817, 'price' => 2500, 'special_price' => null],
            ['id' => 3835, 'price' => 17000, 'special_price' => null],
            ['id' => 3859, 'price' => 4600, 'special_price' => null],
            ['id' => 3849, 'price' => 6200, 'special_price' => null],
            ['id' => 4633, 'price' => 750, 'special_price' => null],
            ['id' => 4625, 'price' => 1200, 'special_price' => 1000],
        ]);
        $this->assertEquals($clinic->getDiagnostics(), []);

        // 2
        $clinic = $clinics->get(1);
        $this->assertEquals($clinic->getId(), 2764);
        $this->assertEquals($clinic->getDistrictId(), 154);
        $this->assertEquals($clinic->getCityId(), 4);
        $this->assertEquals($clinic->getBranchIds(), []);
        $this->assertEquals($clinic->getRootClinicId(), 2764);
        $this->assertEquals($clinic->getName(), 'Новая Больница');
        $this->assertEquals($clinic->getShortName(), 'Новая Больница');
        $this->assertEquals($clinic->getUrl(), "https://newhospital.ru/");
        $this->assertEquals($clinic->getLng(), null);
        $this->assertEquals($clinic->getLat(), null);
        $this->assertEquals($clinic->getStreetId(), 5885);
        $this->assertEquals($clinic->getAddrCity(), "Екатеринбург");
        $this->assertEquals($clinic->getAddrStreet(), "ул. Заводская");
        $this->assertEquals($clinic->getAddrHouse(), "д. 29");
        $this->assertEquals($clinic->getDescription(), "Медицинское объединение Новая больница – это многопрофильная клиника полного цикла, включающая амбулаторно-поликлиническое отделение, стационар и специализированные городские центры.\r\nКлиника служит научной площадкой для семи кафедр Уральского государственного медицинского университета.\r\nПрименяются современные подходы к консервативным методам лечения, аппаратной и лабораторной диагностике. Имеются платные комплексные и специализированные программы медицинского обслуживания: экспресс-диагностика «Check Up», ведение беременности, годовые программы для детей и взрослых. В клинике можно вызвать детского или взрослого врача на дом в пределах Екатеринбурга и окрестностей (до 40 км от ЕКАД). Это амбулаторно-поликлиническое отделение, детская поликлиника, стационар, городские центры диагностики и лечения, центр иммунопрофилактики, стоматологическая клиника, косметологическая клиника, сеть аптек.");
        $this->assertEquals($clinic->getShortDescription(), "Медицинское объединение Новая больница – это многопрофильная клиника полного цикла, включающая амбулаторно-поликлиническое отделение, стационар и специализированные городские центры.\r\nКлиника служит научной площадкой для семи кафедр Уральского государственного медицинского университета.\r\nПрименяются современные подходы к консервативным методам лечения, аппаратной и лабораторной диагностике. Имеются платные комплексные и специализированные программы медицинского обслуживания: экспресс-диагностика «Check Up», ведение беременности, годовые программы для детей и взрослых. В клинике можно вызвать детского или взрослого врача на дом в пределах Екатеринбурга и окрестностей (до 40 км от ЕКАД). Это амбулаторно-поликлиническое отделение, детская поликлиника, стационар, городские центры диагностики и лечения, центр иммунопрофилактики, стоматологическая клиника, косметологическая клиника, сеть аптек.");
        $this->assertEquals($clinic->getTypeClinic(), true);
        $this->assertEquals($clinic->getTypeDiagnostic(), true);
        $this->assertEquals($clinic->getTypeDoctor(), false);
        $this->assertEquals($clinic->getTypeText(), "многопрофильный медицинский центр");
        $this->assertEquals($clinic->getPhone(), "73433555657");
        $this->assertEquals($clinic->getReplacementPhone(), null);
        $this->assertEquals($clinic->getDirectPhone(), "+7 (343) 355-56-57; +7 (343) 302-36-26");
        $this->assertEquals($clinic->getLogo(), "https://cdn.docdoc.ru/clinic/logo/min_2764.jpg?1574300156");
        $this->assertEquals($clinic->getEmail(), "market@newhospital.ru");
        $this->assertEquals($clinic->getRating(), 9);
        $this->assertEquals($clinic->getMinPrice(), 1150);
        $this->assertEquals($clinic->getMaxPrice(), 1500);
        $this->assertEquals($clinic->getOnlineSchedule(), true);
        $this->assertEquals($clinic->getSchedule(), null);
        $this->assertEquals($clinic->getHighlightDiscount(), 0);
        $this->assertEquals($clinic->getRequestFormSurname(), false);
        $this->assertEquals($clinic->getRequestFormBirthday(), false);
        $this->assertEquals($clinic->getMetroIds(), []);
        $this->assertEquals($clinic->getSpecialityIds(), [73,85,91,102,112,114]);
        $this->assertEquals($clinic->getServices(), []);
        $this->assertEquals($clinic->getDiagnostics(), [
            ['id' => 156, 'price' => 950, 'special_price' => null],
            ['id' => 53, 'price' => 2650, 'special_price' => null],
        ]);
    }

    /** @test */
    public function it_can_get_services()
    {
        $this->mockResponseFile(['services.json']);
        $provider = app(Docdoc::class);

        $services = $provider->getServices();
        $this->assertCount(2, $services);

        $service = $services->get(0);
        $this->assertEquals($service->getId(), 1);
        $this->assertEquals($service->getName(), 'Услуги');
        $this->assertEquals($service->getDiagnosticId(), null);
        $this->assertEquals($service->getSpecialityId(), null);

        $service = $services->get(1);
        $this->assertEquals($service->getId(), 3427);
        $this->assertEquals($service->getName(), 'Пластика уздечки верхней губы');
        $this->assertEquals($service->getDiagnosticId(), 91);
        $this->assertEquals($service->getSpecialityId(), 90);
    }

    /** @test */
    public function it_can_get_diagnostics()
    {
        $this->mockResponseFile(['diagnostics.json']);
        $provider = app(Docdoc::class);

        $diagnostics = $provider->getDiagnosticGroups();
        $this->assertCount(2, $diagnostics);

        // 1
        $diagnosticGroup = $diagnostics->get(0);
        $this->assertEquals($diagnosticGroup->getId(), 1);
        $this->assertEquals($diagnosticGroup->getName(), 'УЗИ (ультразвуковое исследование)');
        $this->assertCount(2, $diagnosticGroup->getDiagnostics());

        $diagnostic1 = $diagnosticGroup->getDiagnostics()->get(0);
        $this->assertEquals($diagnostic1->getId(), 71);
        $this->assertEquals($diagnostic1->getShortName(), 'печени');
        $this->assertEquals($diagnostic1->getName(), 'УЗИ (ультразвуковое исследование) печени');

        $diagnostic2 = $diagnosticGroup->getDiagnostics()->get(1);
        $this->assertEquals($diagnostic2->getId(), 72);
        $this->assertEquals($diagnostic2->getShortName(), 'поджелудочной железы');
        $this->assertEquals($diagnostic2->getName(), 'УЗИ (ультразвуковое исследование) поджелудочной железы');

        // 2
        $diagnosticGroup = $diagnostics->get(1);
        $this->assertEquals($diagnosticGroup->getId(), 19);
        $this->assertEquals($diagnosticGroup->getName(), 'КТ (компьютерная томография)');
        $this->assertCount(1, $diagnosticGroup->getDiagnostics());

        $diagnostic = $diagnosticGroup->getDiagnostics()->get(0);
        $this->assertEquals($diagnostic->getId(), 118);
        $this->assertEquals($diagnostic->getShortName(), 'головного мозга');
        $this->assertEquals($diagnostic->getName(), 'КТ (компьютерная томография) головного мозга');
    }

    /** @test */
    public function it_can_get_specialities()
    {
        $this->mockResponseFile(['speciality.1.json', 'speciality.2.json']);
        $provider = app(Docdoc::class);

        $specialities = $provider->getSpecialities([1,2]);
        $this->assertCount(2, $specialities);

        $speciality = $specialities->get(0);
        $this->assertEquals($speciality->getId(), 67);
        $this->assertEquals($speciality->getName(), 'Акушер');
        $this->assertEquals($speciality->getBranchName(), 'Акушерство');
        $this->assertEquals($speciality->getGenitiveName(), 'Акушера');
        $this->assertEquals($speciality->getPluralName(), 'Акушеры');
        $this->assertEquals($speciality->getPluralGenitiveName(), 'Акушеров');
        $this->assertEquals($speciality->getKidsReception(), false);
        $this->assertEquals($speciality->getCityIds(), [1, 2]);

        $speciality = $specialities->get(1);
        $this->assertEquals($speciality->getId(), 68);
        $this->assertEquals($speciality->getName(), 'Аллерголог');
        $this->assertEquals($speciality->getBranchName(), 'Аллергология');
        $this->assertEquals($speciality->getGenitiveName(), 'Аллерголога');
        $this->assertEquals($speciality->getPluralName(), 'Аллергологи');
        $this->assertEquals($speciality->getPluralGenitiveName(), 'Аллергологов');
        $this->assertEquals($speciality->getKidsReception(), true);
        $this->assertEquals($speciality->getCityIds(), [2]);
    }

    /** @test */
    public function it_can_get_metros()
    {
        $this->mockResponseFile(['metro.1.json', 'metro.2.json']);
        $provider = app(Docdoc::class);

        $metros = $provider->getMetros([1,2]);
        $this->assertCount(2, $metros);

        $metro = $metros->get(0);
        $this->assertEquals($metro->getId(), 267);
        $this->assertEquals($metro->getCityId(), 4);
        $this->assertEquals($metro->getName(), 'Ботаническая');
        $this->assertEquals($metro->getLineName(), 'Первая Екатеринбург');
        $this->assertEquals($metro->getLineColor(), 'cc0000');
        $this->assertEquals($metro->getLng(), '60.63336182');
        $this->assertEquals($metro->getLat(), '56.79748535');
        $this->assertEquals($metro->getDistrictIds(), []);

        $metro = $metros->get(1);
        $this->assertEquals($metro->getId(), 1);
        $this->assertEquals($metro->getCityId(), 1);
        $this->assertEquals($metro->getName(), 'Авиамоторная');
        $this->assertEquals($metro->getLineName(), 'Калининско-Солнцевская ');
        $this->assertEquals($metro->getLineColor(), 'ffdd03');
        $this->assertEquals($metro->getLng(), '37.7166214');
        $this->assertEquals($metro->getLat(), '55.75143051');
        $this->assertEquals($metro->getDistrictIds(), [63]);
    }

    /** @test */
    public function it_can_get_districts()
    {
        $this->mockResponseFile(['districts.1.json', 'districts.2.json']);
        $provider = app(Docdoc::class);

        $districts = $provider->getDistricts([1,2]);
        $this->assertCount(2, $districts);

        $district = $districts->get(0);
        $this->assertEquals($district->getId(), 1);
        $this->assertEquals($district->getAreaId(), 1);
        $this->assertEquals($district->getCityId(), 1);
        $this->assertEquals($district->getName(), 'Арбат');

        $district = $districts->get(1);
        $this->assertEquals($district->getId(), 139);
        $this->assertEquals($district->getAreaId(), null);
        $this->assertEquals($district->getCityId(), 2);
        $this->assertEquals($district->getName(), 'Кировский');
    }

    /** @test */
    public function it_can_get_moscow_areas()
    {
        $this->mockResponseFile('area.json');
        $provider = app(Docdoc::class);

        $areas = $provider->getMoscowAreas();
        $this->assertCount(2, $areas);

        $area = $areas->get(0);
        $this->assertEquals($area->getId(), 1);
        $this->assertEquals($area->getName(), 'Центральный Округ');
        $this->assertEquals($area->getShortName(), 'ЦАО');

        $area = $areas->get(1);
        $this->assertEquals($area->getId(), 2);
        $this->assertEquals($area->getName(), 'Северный Округ');
        $this->assertEquals($area->getShortName(), 'САО');
    }

    /** @test */
    public function it_can_get_cities()
    {
        $this->mockResponseFile('city.json');
        $provider = app(Docdoc::class);

        $cities = $provider->getCities();
        $this->assertCount(2, $cities);

        $city = $cities->get(0);
        $this->assertEquals($city->getId(), 1);
        $this->assertEquals($city->getName(), 'Москва');
        $this->assertEquals($city->getLat(), '55.755826');
        $this->assertEquals($city->getLng(), '37.6173');
        $this->assertEquals($city->getHasDiagnostic(), true);
        $this->assertEquals($city->getTimezoneShift(), 3);

        $city = $cities->get(1);
        $this->assertEquals($city->getId(), 2);
        $this->assertEquals($city->getName(), 'Санкт-Петербург');
        $this->assertEquals($city->getLat(), '59.9342802');
        $this->assertEquals($city->getLng(), '30.3350986');
        $this->assertEquals($city->getHasDiagnostic(), true);
        $this->assertEquals($city->getTimezoneShift(), 3);

    }

    /** @test */
    public function throws_exception_if_error_request_status()
    {
        $this->expectException('GuzzleHttp\Exception\ClientException');

        $this->mockResponseJson(['{"test":1}'], 401);
        $this->setProviderConfig('', '', 'true', 1);

        $provider = app(Docdoc::class);
        $provider->apiGet('someurl');
    }

    /** @test */
    public function throws_exception_if_error_request_status_after_tries()
    {
        $this->expectException('GuzzleHttp\Exception\ClientException');

        $this->mockResponseJson(['{"test":1}', '{"test":1}'], 401);
        $this->setProviderConfig('', '', 'true', 2);

        $provider = app(Docdoc::class);
        $provider->apiGet('someurl');
    }

    /**
     * @param $fileName
     * @param int $status
     */
    protected function mockResponseFile($fileName, int $status = 200)
    {
        if (!is_array($fileName)) {
            $fileName = [$fileName];
        }

        $filePrefix = __DIR__ . DIRECTORY_SEPARATOR . 'json' . DIRECTORY_SEPARATOR . 'docdoc' . DIRECTORY_SEPARATOR;
        $this->mockResponseJson(array_map(function($file) use ($filePrefix) {
            return file_get_contents($filePrefix . $file);
        }, $fileName), $status);
    }

    /**
     * @param array $bodies
     * @param int $status
     */
    protected function mockResponseJson(array $bodies, int $status = 200)
    {
        $this->setProviderConfig();
        $this->mockGuzzleResponses(array_map(function($body) use ($status) {
            return [$status, [], $body];
        }, $bodies));
    }

    /**
     * @param string $login
     * @param string $password
     * @param string $test
     * @param int $maxTries
     */
    protected function setProviderConfig(string $login = '', string $password = '', string $test = 'true', int $maxTries = 2): void
    {
        config([
            'medical-aggregators.providers' => [
                Docdoc::class => [
                    'test' => $test,
                    'login' => $login,
                    'password' => $password,
                    'max_tries' => $maxTries,
                    'retry_after' => 0,
                ],
            ],
        ]);
    }

}
