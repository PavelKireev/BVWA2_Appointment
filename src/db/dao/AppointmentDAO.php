<?php

namespace Src\db\dao;

use PDO;
use Src\db\entity\Appointment;

class AppointmentDAO
{
    private $pdo;

    public function __construct($pdo)
    {
        $this->pdo = $pdo;
    }

    public function getAppointmentsByDoctor($doctorUuid): array
    {
        $stmt = $this->pdo->prepare("SELECT * FROM appointment WHERE doctor_uuid = :doctorUuid");
        $stmt->execute(['doctorUuid' => $doctorUuid]);

        $appointments = [];
        while ($row = $stmt->fetch(PDO::FETCH_ASSOC)) {
            $appointments[] = new Appointment($row['id'], $row['doctor_uuid'], $row['patient_uuid'], $row['time']);
        }

        return $appointments;
    }
}