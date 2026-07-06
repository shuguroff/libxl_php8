<?php

/**
 * ExcelConditionalFormatting class (requires LibXL >= 4.1.0)
 *
 * Represents a conditional formatting block in a sheet: cell ranges plus rules.
 * Cannot be instantiated directly — use ExcelSheet::addConditionalFormatting().
 */
final class ExcelConditionalFormatting
{
    /* Rule types (CFormatType) */
    const CFORMAT_BEGINWITH = 0;
    const CFORMAT_CONTAINSBLANKS = 1;
    const CFORMAT_CONTAINSERRORS = 2;
    const CFORMAT_CONTAINSTEXT = 3;
    const CFORMAT_DUPLICATEVALUES = 4;
    const CFORMAT_ENDSWITH = 5;
    const CFORMAT_EXPRESSION = 6;
    const CFORMAT_NOTCONTAINSBLANKS = 7;
    const CFORMAT_NOTCONTAINSERRORS = 8;
    const CFORMAT_NOTCONTAINSTEXT = 9;
    const CFORMAT_UNIQUEVALUES = 10;

    /* Comparison operators (CFormatOperator) */
    const CFOPERATOR_LESSTHAN = 0;
    const CFOPERATOR_LESSTHANOREQUAL = 1;
    const CFOPERATOR_EQUAL = 2;
    const CFOPERATOR_NOTEQUAL = 3;
    const CFOPERATOR_GREATERTHANOREQUAL = 4;
    const CFOPERATOR_GREATERTHAN = 5;
    const CFOPERATOR_BETWEEN = 6;
    const CFOPERATOR_NOTBETWEEN = 7;
    const CFOPERATOR_CONTAINSTEXT = 8;
    const CFOPERATOR_NOTCONTAINS = 9;
    const CFOPERATOR_BEGINSWITH = 10;
    const CFOPERATOR_ENDSWITH = 11;

    /* Time periods (CFormatTimePeriod) */
    const CFTP_LAST7DAYS = 0;
    const CFTP_LASTMONTH = 1;
    const CFTP_LASTWEEK = 2;
    const CFTP_NEXTMONTH = 3;
    const CFTP_NEXTWEEK = 4;
    const CFTP_THISMONTH = 5;
    const CFTP_THISWEEK = 6;
    const CFTP_TODAY = 7;
    const CFTP_TOMORROW = 8;
    const CFTP_YESTERDAY = 9;

    /* Color scale value types (CFVOType) */
    const CFVO_MIN = 0;
    const CFVO_MAX = 1;
    const CFVO_FORMULA = 2;
    const CFVO_NUMBER = 3;
    const CFVO_PERCENT = 4;
    const CFVO_PERCENTILE = 5;

    /**
     * Adds a cell range to the conditional formatting block.
     *
     * @param int $rowFirst
     * @param int $rowLast
     * @param int $colFirst
     * @param int $colLast
     * @return void
     */
    public function addRange($rowFirst, $rowLast, $colFirst, $colLast)
    {
    } // addRange

    /**
     * Adds a rule (self::CFORMAT_* constant).
     *
     * @param int $type
     * @param ExcelConditionalFormat $cFormat
     * @param string $value
     * @param bool $stopIfTrue
     * @return void
     */
    public function addRule($type, $cFormat, $value = null, $stopIfTrue = false)
    {
    } // addRule

    /**
     * Adds a top/bottom N (or N%) rule.
     *
     * @param ExcelConditionalFormat $cFormat
     * @param int $value
     * @param bool $bottom
     * @param bool $percent
     * @param bool $stopIfTrue
     * @return void
     */
    public function addTopRule($cFormat, $value, $bottom = false, $percent = false, $stopIfTrue = false)
    {
    } // addTopRule

    /**
     * Adds a numeric comparison rule (self::CFOPERATOR_* constant).
     *
     * @param int $op
     * @param ExcelConditionalFormat $cFormat
     * @param float $value1
     * @param float $value2 used with CFOPERATOR_BETWEEN / CFOPERATOR_NOTBETWEEN
     * @param bool $stopIfTrue
     * @return void
     */
    public function addOpNumRule($op, $cFormat, $value1, $value2 = 0.0, $stopIfTrue = false)
    {
    } // addOpNumRule

    /**
     * Adds a string comparison rule (self::CFOPERATOR_* constant).
     *
     * @param int $op
     * @param ExcelConditionalFormat $cFormat
     * @param string $value1
     * @param string $value2 used with CFOPERATOR_BETWEEN / CFOPERATOR_NOTBETWEEN
     * @param bool $stopIfTrue
     * @return void
     */
    public function addOpStrRule($op, $cFormat, $value1, $value2 = null, $stopIfTrue = false)
    {
    } // addOpStrRule

    /**
     * Adds an above/below average rule.
     *
     * @param ExcelConditionalFormat $cFormat
     * @param bool $aboveAverage
     * @param bool $equalAverage
     * @param int $stdDev
     * @param bool $stopIfTrue
     * @return void
     */
    public function addAboveAverageRule($cFormat, $aboveAverage = true, $equalAverage = false, $stdDev = 0, $stopIfTrue = false)
    {
    } // addAboveAverageRule

    /**
     * Adds a time period rule (self::CFTP_* constant).
     *
     * @param ExcelConditionalFormat $cFormat
     * @param int $timePeriod
     * @param bool $stopIfTrue
     * @return void
     */
    public function addTimePeriodRule($cFormat, $timePeriod, $stopIfTrue = false)
    {
    } // addTimePeriodRule

    /**
     * Adds a two-color scale rule with numeric limits (self::CFVO_* constants).
     *
     * @param int $minColor
     * @param int $maxColor
     * @param int $minType
     * @param float $minValue
     * @param int $maxType
     * @param float $maxValue
     * @param bool $stopIfTrue
     * @return void
     */
    public function add2ColorScaleRule($minColor, $maxColor, $minType = self::CFVO_MIN, $minValue = 0.0, $maxType = self::CFVO_MAX, $maxValue = 0.0, $stopIfTrue = false)
    {
    } // add2ColorScaleRule

    /**
     * Adds a two-color scale rule with formula limits (self::CFVO_* constants).
     *
     * @param int $minColor
     * @param int $maxColor
     * @param int $minType
     * @param string $minValue
     * @param int $maxType
     * @param string $maxValue
     * @param bool $stopIfTrue
     * @return void
     */
    public function add2ColorScaleFormulaRule($minColor, $maxColor, $minType = self::CFVO_MIN, $minValue = null, $maxType = self::CFVO_MAX, $maxValue = null, $stopIfTrue = false)
    {
    } // add2ColorScaleFormulaRule

    /**
     * Adds a three-color scale rule with numeric limits (self::CFVO_* constants).
     *
     * @param int $minColor
     * @param int $midColor
     * @param int $maxColor
     * @param int $minType
     * @param float $minValue
     * @param int $midType
     * @param float $midValue
     * @param int $maxType
     * @param float $maxValue
     * @param bool $stopIfTrue
     * @return void
     */
    public function add3ColorScaleRule($minColor, $midColor, $maxColor, $minType = self::CFVO_MIN, $minValue = 0.0, $midType = self::CFVO_PERCENTILE, $midValue = 50.0, $maxType = self::CFVO_MAX, $maxValue = 0.0, $stopIfTrue = false)
    {
    } // add3ColorScaleRule

    /**
     * Adds a three-color scale rule with formula limits (self::CFVO_* constants).
     *
     * @param int $minColor
     * @param int $midColor
     * @param int $maxColor
     * @param int $minType
     * @param string $minValue
     * @param int $midType
     * @param string $midValue
     * @param int $maxType
     * @param string $maxValue
     * @param bool $stopIfTrue
     * @return void
     */
    public function add3ColorScaleFormulaRule($minColor, $midColor, $maxColor, $minType = self::CFVO_MIN, $minValue = null, $midType = self::CFVO_PERCENTILE, $midValue = null, $maxType = self::CFVO_MAX, $maxValue = null, $stopIfTrue = false)
    {
    } // add3ColorScaleFormulaRule
}
