<?php

namespace Src\db\entity;

class WorkingHours
{
    public string $doctorUuid;
    public string $dayOfWeek;
    public int $hourFrom;
    public int $hoursCount;

    public function __construct(string $doctorUuid, string $dayOfWeek, int $hourFrom, int $hoursCount)
    {
        $this->doctorUuid = $doctorUuid;
        $this->dayOfWeek = $dayOfWeek;
        $this->hourFrom = $hourFrom;
        $this->hoursCount = $hoursCount;
    }

    // Getters
    public function getDoctorUuid(): string
    {
        return $this->doctorUuid;
    }

    public function getDayOfWeek(): string
    {
        return $this->dayOfWeek;
    }

    public function getHourFrom(): int
    {
        return $this->hourFrom;
    }

    public function getHoursCount(): int
    {
        return $this->hoursCount;
    }

    public function setDoctorUuid(string $doctorUuid): void
    {
        $this->doctorUuid = $doctorUuid;
    }

    public function setDayOfWeek(string $dayOfWeek): void
    {
        $this->dayOfWeek = $dayOfWeek;
    }

    public function setHourFrom(int $hourFrom): void
    {
        $this->hourFrom = $hourFrom;
    }

    public function setHoursCount(int $hoursCount): void
    {
        $this->hoursCount = $hoursCount;
    }
}
