<?php

namespace app\components;

class DateFormat
{
    public static function getWeekToString($date = null)
    {
        if (!$date) {
            $date = time();
        }
        $days = [
            'Воскресенье', 'Понедельник', 'Вторник', 'Среда',
            'Четверг', 'Пятница', 'Суббота'
        ];
        return $days[(date('w', $date))];
    }

    public static function getDatePass($datePass, $countDayToPass)
    {
        return date('d.m.Y H:i ', $datePass) . DateFormat::getWeekToString($datePass) .', через '. self::getPlural($countDayToPass, 'день', 'дня','дней');
    }

    public static function getPlural($number, $one, $two, $five)
    {
        if (($number - $number % 10) % 100 != 10) {
            if ($number % 10 == 1) {
                $result = $one;
            } elseif ($number % 10 >= 2 && $number % 10 <= 4) {
                $result = $two;
            } else {
                $result = $five;
            }
        } else {
            $result = $five;
        }
        return $number.' '.$result;
    }

    /**
     * Функция считает количество дней между двумя датами
     *
     * @param string $d1 первая дата
     * @param string $d2 вторая дата
     *
     * @return number количество дней
     */
    public static function countDaysBetweenDates($d1, $d2)
    {
        $d1_ts = $d1;
        $d2_ts = $d2;

        $seconds = abs($d1_ts - $d2_ts);

        return floor($seconds / 86400);
    }
}