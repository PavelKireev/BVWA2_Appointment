<?php

namespace Src\db\dao;

use PDO;
use Src\db\entity\WorkingHours;

class WorkingHoursDAO
{
    private PDO $pdo;

    public function __construct(PDO $pdo)
    {
        $this->pdo = $pdo;
    }

    public function getWorkingHoursByDoctorUuid(string $doctorUuid): array
    {
        $stmt = $this->pdo->prepare("SELECT * FROM working_hours WHERE doctor_uuid = :doctorUuid");
        $stmt->execute(['doctorUuid' => $doctorUuid]);

        $workingHours = [];
        while ($row = $stmt->fetch(PDO::FETCH_ASSOC)) {
            $workingHours[] = new WorkingHours($row['doctor_uuid'], $row['day_of_week'], $row['hour_from'], $row['hours_count']);
        }

        return $workingHours;
    }
}
