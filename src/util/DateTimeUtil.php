<?php

namespace Src\util;

use DateTime;
use Src\db\dao\AppointmentDAO;

class DateTimeUtil
{
    private const REGULAR_DATE_FORMAT = 'Y-m-d H:i';

    public static function toDateTime(string $dateTime): DateTime
    {
        return DateTime::createFromFormat(self::REGULAR_DATE_FORMAT, $dateTime);
    }

    public static function fromDateTime(DateTime $dateTime): string
    {
        return $dateTime->format(self::REGULAR_DATE_FORMAT);
    }

    public static function generateAppointmentTimeList(array $workingHours, AppointmentDAO $appointmentDAO): array
    {
        $result = [];

        if (empty($workingHours)) {
            return $result;
        }

        // Fetch busy appointment dates using AppointmentDAO
        $busyAppointments = $appointmentDAO->getAppointmentsByDoctor($workingHours[0]->doctorUuid);
        $busyDates = array_map(function ($appointment) {
            return DateTime::createFromFormat('Y-m-d H:i:s', $appointment->time);
        }, $busyAppointments);

        $currentTime = new DateTime();
        $twoWeeksLater = (clone $currentTime)->modify('+14 days');

        while ($currentTime->format('Y-m-d') !== $twoWeeksLater->format('Y-m-d')) {
            $wh = current(array_filter($workingHours, function ($item) use ($currentTime) {
                return $item->dayOfWeek === $currentTime->format('l');
            }));

            if ($wh) {
                $dateTimeStart = (clone $currentTime)->setTime($wh->hourFrom, 0, 0);
                $dateTimeTill = (clone $dateTimeStart)->modify('+' . $wh->hoursCount . ' hours');

                while ($dateTimeStart < $dateTimeTill) {
                    if (!in_array($dateTimeStart, $busyDates)) {
                        $result[] = clone $dateTimeStart;
                    }
                    $dateTimeStart->modify('+30 minutes');
                }
            }

            $currentTime->modify('+1 day');
        }

        return array_map(function ($dateTime) {
            return $dateTime->format(self::REGULAR_DATE_FORMAT);
        }, $result);
    }
}