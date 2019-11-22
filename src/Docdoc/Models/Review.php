<?php


namespace Veezex\Medical\Docdoc\Models;


class Review extends Model
{
    protected $required = [
        'Id',
        'Client',
        'DoctorId',
        'ClinicId',
        'Text',
        'Answer',
        'WaitingTime',
        'TagClinicLocation',
        'TagClinicService',
        'TagClinicCost',
        'TagClinicRecommend',
        'TagDoctorAttention',
        'TagDoctorExplain',
        'TagDoctorQuality',
        'TagDoctorRecommend',
        'TagDoctorSatisfied',
        'RatingQlf',
        'RatingAtt',
        'RatingRoom',
        'RatingDoctor',
        'RatingClinic',
        'ReceptionDate',
        'Date',
    ];

    /**
     * @return string
     */
    public function getClient(): string
    {
        return $this->get('Client');
    }

    /**
     * @return int
     */
    public function getDoctorId(): int
    {
        return $this->get('DoctorId');
    }

    /**
     * @return int
     */
    public function getClinicId(): int
    {
        return $this->get('ClinicId');
    }

    /**
     * @return string
     */
    public function getText(): string
    {
        return $this->get('Text');
    }

    /**
     * @return string|null
     */
    public function getAnswer(): ?string
    {
        return $this->get('Answer') ?: null;
    }

    /**
     * @return int|null
     */
    public function getWaitingTime(): ?int
    {
        return $this->get('WaitingTime');
    }

    /**
     * @return bool
     */
    public function getTagClinicLocation(): bool
    {
        return $this->get('TagClinicLocation');
    }

    /**
     * @return bool
     */
    public function getTagClinicService(): bool
    {
        return $this->get('TagClinicService');
    }

    /**
     * @return bool
     */
    public function getTagClinicCost(): bool
    {
        return $this->get('TagClinicCost');
    }

    /**
     * @return bool
     */
    public function getTagClinicRecommend(): bool
    {
        return $this->get('TagClinicRecommend');
    }

    /**
     * @return bool
     */
    public function getTagDoctorAttention(): bool
    {
        return $this->get('TagDoctorAttention');
    }

    /**
     * @return bool
     */
    public function getTagDoctorExplain(): bool
    {
        return $this->get('TagDoctorExplain');
    }

    /**
     * @return bool
     */
    public function getTagDoctorQuality(): bool
    {
        return $this->get('TagDoctorQuality');
    }

    /**
     * @return bool
     */
    public function getTagDoctorRecommend(): bool
    {
        return $this->get('TagDoctorRecommend');
    }

    /**
     * @return bool
     */
    public function getTagDoctorSatisfied(): bool
    {
        return $this->get('TagDoctorSatisfied');
    }

    /**
     * @return int|null
     */
    public function getRatingQlf(): ?int
    {
        return $this->get('RatingQlf') ?: null;
    }

    /**
     * @return int|null
     */
    public function getRatingAtt(): ?int
    {
        return $this->get('RatingAtt') ?: null;
    }

    /**
     * @return int|null
     */
    public function getRatingRoom(): ?int
    {
        return $this->get('RatingRoom') ?: null;
    }

    /**
     * @return int|null
     */
    public function getRatingDoctor(): ?int
    {
        return $this->get('RatingDoctor');
    }

    /**
     * @return int|null
     */
    public function getRatingClinic(): ?int
    {
        return $this->get('RatingClinic');
    }

    /**
     * @return int
     */
    public function getReceptionTs(): int
    {
        return strtotime($this->get('ReceptionDate'));
    }

    /**
     * @return int
     */
    public function getReviewTs(): int
    {
        return strtotime($this->get('Date'));
    }

}
