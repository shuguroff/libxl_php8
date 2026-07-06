<?php

/**
 * ExcelConditionalFormat class (requires LibXL >= 4.1.0)
 *
 * Represents the formatting (font, borders, fill, number format) applied
 * by a conditional formatting rule.
 * Cannot be instantiated directly — use ExcelBook::addConditionalFormat().
 */
final class ExcelConditionalFormat
{
    /**
     * Returns the font of the conditional format.
     *
     * @return ExcelFont
     */
    public function font()
    {
    } // font

    /**
     * Returns the number format identifier (ExcelFormat::NUMFORMAT_* constant).
     *
     * @return int
     */
    public function numFormat()
    {
    } // numFormat

    /**
     * Sets the number format (ExcelFormat::NUMFORMAT_* constant).
     *
     * @param int $numFormat
     * @return void
     */
    public function setNumFormat($numFormat)
    {
    } // setNumFormat

    /**
     * Returns the custom number format string.
     *
     * @return string
     */
    public function customNumFormat()
    {
    } // customNumFormat

    /**
     * Sets a custom number format string.
     *
     * @param string $format
     * @return void
     */
    public function setCustomNumFormat($format)
    {
    } // setCustomNumFormat

    /**
     * Sets the border style for all sides (ExcelFormat::BORDERSTYLE_* constant).
     *
     * @param int $style
     * @return void
     */
    public function setBorder($style)
    {
    } // setBorder

    /**
     * Sets the border color for all sides (ExcelFormat::COLOR_* constant).
     *
     * @param int $color
     * @return void
     */
    public function setBorderColor($color)
    {
    } // setBorderColor

    /**
     * Returns the left border style.
     *
     * @return int
     */
    public function borderLeft()
    {
    } // borderLeft

    /**
     * Sets the left border style.
     *
     * @param int $style
     * @return void
     */
    public function setBorderLeft($style)
    {
    } // setBorderLeft

    /**
     * Returns the right border style.
     *
     * @return int
     */
    public function borderRight()
    {
    } // borderRight

    /**
     * Sets the right border style.
     *
     * @param int $style
     * @return void
     */
    public function setBorderRight($style)
    {
    } // setBorderRight

    /**
     * Returns the top border style.
     *
     * @return int
     */
    public function borderTop()
    {
    } // borderTop

    /**
     * Sets the top border style.
     *
     * @param int $style
     * @return void
     */
    public function setBorderTop($style)
    {
    } // setBorderTop

    /**
     * Returns the bottom border style.
     *
     * @return int
     */
    public function borderBottom()
    {
    } // borderBottom

    /**
     * Sets the bottom border style.
     *
     * @param int $style
     * @return void
     */
    public function setBorderBottom($style)
    {
    } // setBorderBottom

    /**
     * Returns the left border color.
     *
     * @return int
     */
    public function borderLeftColor()
    {
    } // borderLeftColor

    /**
     * Sets the left border color.
     *
     * @param int $color
     * @return void
     */
    public function setBorderLeftColor($color)
    {
    } // setBorderLeftColor

    /**
     * Returns the right border color.
     *
     * @return int
     */
    public function borderRightColor()
    {
    } // borderRightColor

    /**
     * Sets the right border color.
     *
     * @param int $color
     * @return void
     */
    public function setBorderRightColor($color)
    {
    } // setBorderRightColor

    /**
     * Returns the top border color.
     *
     * @return int
     */
    public function borderTopColor()
    {
    } // borderTopColor

    /**
     * Sets the top border color.
     *
     * @param int $color
     * @return void
     */
    public function setBorderTopColor($color)
    {
    } // setBorderTopColor

    /**
     * Returns the bottom border color.
     *
     * @return int
     */
    public function borderBottomColor()
    {
    } // borderBottomColor

    /**
     * Sets the bottom border color.
     *
     * @param int $color
     * @return void
     */
    public function setBorderBottomColor($color)
    {
    } // setBorderBottomColor

    /**
     * Returns the fill pattern (ExcelFormat::FILLPATTERN_* constant).
     *
     * @return int
     */
    public function fillPattern()
    {
    } // fillPattern

    /**
     * Sets the fill pattern (ExcelFormat::FILLPATTERN_* constant).
     *
     * @param int $pattern
     * @return void
     */
    public function setFillPattern($pattern)
    {
    } // setFillPattern

    /**
     * Returns the pattern foreground color.
     *
     * @return int
     */
    public function patternForegroundColor()
    {
    } // patternForegroundColor

    /**
     * Sets the pattern foreground color.
     *
     * @param int $color
     * @return void
     */
    public function setPatternForegroundColor($color)
    {
    } // setPatternForegroundColor

    /**
     * Returns the pattern background color.
     *
     * @return int
     */
    public function patternBackgroundColor()
    {
    } // patternBackgroundColor

    /**
     * Sets the pattern background color.
     *
     * @param int $color
     * @return void
     */
    public function setPatternBackgroundColor($color)
    {
    } // setPatternBackgroundColor
}
