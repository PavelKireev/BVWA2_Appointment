<?php

namespace Src\controller;

use PDO;
use Src\db\dao\AppointmentDAO;
use Src\db\dao\WorkingHoursDAO;
use Src\util\DateTimeUtil;

class AppointmentController
{
    private AppointmentDAO $appointmentDAO;
    private WorkingHoursDAO $workingHoursDAO;

    public function __construct(PDO $pdo)
    {
        $this->appointmentDAO = new AppointmentDAO($pdo);
        $this->workingHoursDAO = new WorkingHoursDAO($pdo);
    }

    public function getAvailableAppointmentTimes(string $doctorUuid): array
    {
        // Fetch working hours for the specific doctor
        $doctorWorkingHours = $this->workingHoursDAO->getWorkingHoursByDoctorUuid($doctorUuid);

        // Generate available appointment times
        return DateTimeUtil::generateAppointmentTimeList($doctorWorkingHours, $this->appointmentDAO);
    }
}
