<?php

namespace Src\db\entity;

class Appointment
{
    public int $id;
    public string $doctorUuid;
    public string $patientUuid;
    public string $time;

    /**
     * @param int $id
     * @param string $doctorUuid
     * @param string $patientUuid
     * @param string $time
     */
    public function __construct(int $id, string $doctorUuid, string $patientUuid, string $time)
    {
        $this->id = $id;
        $this->doctorUuid = $doctorUuid;
        $this->patientUuid = $patientUuid;
        $this->time = $time;
    }


}