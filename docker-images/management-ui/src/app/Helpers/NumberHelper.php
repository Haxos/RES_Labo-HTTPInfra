<?php

namespace MgmtUi\Helpers;

class NumberHelper
{
    private $number;
    private $unit = '';

    const MAGNITUDE_MIN = -9;
    const MAGNITUDE_MAX = +9;
    const MAGNITUDES = [
        +9 => 'G',
        +6 => 'M',
        +3 => 'k',
        +0 => '',
        -3 => 'm',
        -6 => 'μ',
        -9 => 'n',
    ];

    public function __construct($number)
    {
        $this->number = $number;
    }

    public static function make($number) : NumberHelper
    {
        return new static($number);
    }

    public function unit(string $unit) : NumberHelper
    {
        $this->unit = $unit;

        return $this;
    }

    public function humanFriendly(int $decimals = 2) : string
    {
        $magnitude = 0;
        $positive = $this->number >= 0;
        $adjustedValue = abs($this->number);

        while ($adjustedValue / 1000 > 1 && ($magnitude + 3) < self::MAGNITUDE_MAX)
        {
            $adjustedValue /= 1000;
            $magnitude += 3;
        }

        while ($adjustedValue * 1000 < 1000 && ($magnitude - 3) > self::MAGNITUDE_MIN)
        {
            $adjustedValue *= 1000;
            $magnitude -= 3;
        }

        $result = '';
        $result .= $positive ? '' : '-';
        $result .= round($adjustedValue, $decimals);
        $result .= ' ';
        $result .= $this->getMagnitudeString($magnitude);
        $result .= $this->unit;

        return $result;
    }

    private function getMagnitudeString($magnitude)
    {
        if (!isset(self::MAGNITUDES[$magnitude]))
            return '';

        return self::MAGNITUDES[$magnitude];
    }
}
