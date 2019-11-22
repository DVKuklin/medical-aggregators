<?php


namespace Veezex\Medical\Docdoc\Models;


class DoctorDetails extends Model
{
    protected $required = ['Id', 'Specialization', 'Achievements.Education', 'Achievements.Experience', 'Achievements.Courses'];

    /**
     * @return string
     */
    public function getAssociationText(): string
    {
        return $this->get('TextAssociation');
    }

    /**
     * @return array
     */
    public function getCourses(): array
    {
        return array_map(function($item) {
            return [
                'name' => $item['Name'],
                'org' => $item['Organization'],
                'year' => $item['Year'],
            ];
        }, $this->get('Achievements.Courses', []));
    }

    /**
     * @return array
     */
    public function getExperience(): array
    {
        return array_map(function($item) {
            return [
                'years' => [$item['YearBegin'] ?? null, $item['YearEnd'] ?? null],
                'city' => $item['City'],
                'org' => $item['Organization'],
                'position' => $item['Position'],
            ];
        }, $this->get('Achievements.Experience', []));
    }

    /**
     * @return array
     */
    public function getEducation(): array
    {
        return array_map(function($item) {
            return [
                'name' => $item['Name'],
                'type' => $item['Type'],
                'speciality' => $item['Specialization'],
                'year' => $item['Year'],
            ];
        }, $this->get('Achievements.Education', []));
    }

    /**
     * @return array
     */
    public function getSpecialization(): array
    {
        return array_map(function($item) {
            return [
                'name' => $item['Name'],
                'illnesses' => $item['Illnesses'],
            ];
        }, $this->get('Specialization', []));
    }
}
