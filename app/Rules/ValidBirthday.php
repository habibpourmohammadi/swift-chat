<?php

namespace App\Rules;

use Closure;
use Illuminate\Contracts\Validation\ValidationRule;

class ValidBirthday implements ValidationRule
{
    /**
     * Run the validation rule.
     *
     * @param \Closure(string, ?string=): \Illuminate\Translation\PotentiallyTranslatedString $fail
     */
    public function validate(string $attribute, mixed $value, Closure $fail): void
    {
        // Check if the format matches YYYY/MM/DD
        if (!preg_match('/^\d{4}\/\d{2}\/\d{2}$/', $value)) {
            $fail('فرمت تاریخ تولد اشتباه است.');
        }

        // Split the value into year, month, and day
        [$year, $month, $day] = explode('/', $value);

        // Validate that the year is not '0000'
        if ($year == '0000') {
            $fail('مقدار تاریخ تولد سال/ماه/روز معتبر نیست.');
        }

        // Validate the month is within 1-12 range
        if ($month == '00' || $month < 1 || $month > 12) {
            $fail('مقدار تاریخ تولد سال/ماه/روز معتبر نیست.');
        }

        // Validate the day is within 1-31 range
        if ($day == '00' || $day < 1 || $day > 31) {
            $fail('مقدار تاریخ تولد سال/ماه/روز معتبر نیست.');
        }
    }
}
