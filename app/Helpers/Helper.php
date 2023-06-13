<?php

namespace App\Helpers;

use DateTime;

class Helper
{
	public static function convertMessageSentDatetime($datetimeString): string
    {
        $datetime = new DateTime($datetimeString);
        $today = new DateTime('today');
        $yesterday = new DateTime('yesterday');
        $formattedDatetime = '';

        if ($datetime->format('Ymd') === $today->format('Ymd')) {
            // Today's date
            $formattedDatetime = $datetime->format('g:i A');
        } else if ($datetime->format('Ymd') === $yesterday->format('Ymd')) {
            // Yesterday's date
            $formattedDatetime = 'Yesterday at ' . $datetime->format('g:i A');
        } else {
            // Older date
            $formattedDatetime = $datetime->format('D, F j, Y \a\t g:i A');
        }

        return $formattedDatetime;
    }

	public static function convertMessageSentDatetimeForReply($datetimeString): string
    {
        $datetime = new DateTime($datetimeString);
        $today = new DateTime('today');
        $yesterday = new DateTime('yesterday');
        $formattedDatetime = '';

        if ($datetime->format('Ymd') === $today->format('Ymd')) {
            // Today's date
            $formattedDatetime = 'Today at ' . $datetime->format('g:i A');
        } else if ($datetime->format('Ymd') === $yesterday->format('Ymd')) {
            // Yesterday's date
            $formattedDatetime = 'Yesterday at ' . $datetime->format('g:i A');
        } else {
            // Older date
            $formattedDatetime = $datetime->format('d m Y');
        }

        return $formattedDatetime;
    }
}
