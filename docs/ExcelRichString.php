<?php

/**
 * ExcelRichString class (requires LibXL >= 3.9.0)
 *
 * Represents a rich string — a string with multiple font runs.
 * Cannot be instantiated directly — use ExcelBook::addRichString().
 */
final class ExcelRichString
{
    /**
     * Adds a new font to the rich string, optionally copying an existing font.
     *
     * @param ExcelFont $initFont
     * @return ExcelFont
     */
    public function addFont($initFont = null)
    {
    } // addFont

    /**
     * Adds a text fragment with an optional font.
     *
     * @param string $text
     * @param ExcelFont $font
     * @return bool
     */
    public function addText($text, $font = null)
    {
    } // addText

    /**
     * Returns the text fragment and its font by index.
     * Result: ['text' => string, 'font' => ExcelFont|null]
     *
     * @param int $index
     * @return array
     */
    public function getText($index)
    {
    } // getText

    /**
     * Returns the number of text fragments in the rich string.
     *
     * @return int
     */
    public function textSize()
    {
    } // textSize
}
