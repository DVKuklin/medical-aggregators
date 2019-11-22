<?php

namespace Veezex\Medical;

use Illuminate\Support\Collection;
use Veezex\Medical\Docdoc\Models\DoctorDetails;

interface ProviderContract
{
    public function getProviderName(): string;
    public function getCities(): Collection;
    public function getMoscowAreas(): Collection;
    public function getDistricts(array $cityIds): Collection;
    public function getSpecialities(array $cityIds): Collection;
    public function getDiagnostics(): Collection;
    public function getServices(): Collection;
    public function getClinics(array $cityIds): Collection;
    public function getDoctors(array $cityIds): Collection;
    public function getDoctorDetails(int $doctorId): DoctorDetails;
    public function getClinicReviews(int $clinicId): Collection;
    public function getDoctorReviews(int $doctorId): Collection;
}
