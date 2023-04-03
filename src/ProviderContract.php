<?php

namespace DVKuklin\Medical;

use Illuminate\Support\Collection;
use DVKuklin\Medical\Docdoc\Models\DoctorDetails;

interface ProviderContract
{
    public function getProviderName(): string;
    public function getCities(): Collection;
    public function getMoscowAreas(): Collection;
    public function getDistricts(array $cityIds): Collection;
    public function getMetros(array $cityIds): Collection;
    public function getSpecialities(array $cityIds): Collection;
    public function getDiagnosticGroups(): Collection;
    public function getServices(): Collection;
    public function getClinics(array $cityIds): Collection;
    public function getDoctorSlots(int $doctorId, int $clinicId, int $days): Collection;
    public function getDiagnosticSlots(int $diagnosticId, int $clinicId, int $days): Collection;
    public function getDoctors(array $cityIds): Collection;
    public function getDoctorDetails(int $doctorId);
    public function getClinicReviews(int $clinicId): Collection;
    public function getDoctorReviews(int $doctorId): Collection;
    public function postRequest(array $data): ?int;
}
