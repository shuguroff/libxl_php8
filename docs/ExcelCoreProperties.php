<?php
/*
  +---------------------------------------------------------------------------+
  | ExcelCoreProperties                                                       |
  |                                                                           |
  | Reference file for IDE autocompletion. Requires LibXL >= 4.5.0.           |
  | Available only for XLSX workbooks.                                        |
  |                                                                           |
  | php_excel "PECL" style module (http://github.com/iliaal/php_excel)        |
  | libxl library (http://www.libxl.com)                                      |
  +---------------------------------------------------------------------------+
*/
class ExcelCoreProperties
{
	/**
	* @return string
	*/
	public function title() {}

	/**
	* @param string $title
	* @return void
	*/
	public function setTitle($title) {}

	/**
	* @return string
	*/
	public function subject() {}

	/**
	* @param string $subject
	* @return void
	*/
	public function setSubject($subject) {}

	/**
	* @return string
	*/
	public function creator() {}

	/**
	* @param string $creator
	* @return void
	*/
	public function setCreator($creator) {}

	/**
	* @return string
	*/
	public function lastModifiedBy() {}

	/**
	* @param string $lastModifiedBy
	* @return void
	*/
	public function setLastModifiedBy($lastModifiedBy) {}

	/**
	* @return string
	*/
	public function created() {}

	/**
	* @param string $created
	* @return void
	*/
	public function setCreated($created) {}

	/**
	* @return string
	*/
	public function modified() {}

	/**
	* @param string $modified
	* @return void
	*/
	public function setModified($modified) {}

	/**
	* @return string
	*/
	public function tags() {}

	/**
	* @param string $tags
	* @return void
	*/
	public function setTags($tags) {}

	/**
	* @return string
	*/
	public function categories() {}

	/**
	* @param string $categories
	* @return void
	*/
	public function setCategories($categories) {}

	/**
	* @return string
	*/
	public function comments() {}

	/**
	* @param string $comments
	* @return void
	*/
	public function setComments($comments) {}

	/**
	* Returns the created date as Excel serial date number.
	*
	* @return float
	*/
	public function createdAsDouble() {}

	/**
	* Sets the created date as Excel serial date number.
	*
	* @param float $created
	* @return void
	*/
	public function setCreatedAsDouble($created) {}

	/**
	* Returns the modified date as Excel serial date number.
	*
	* @return float
	*/
	public function modifiedAsDouble() {}

	/**
	* Sets the modified date as Excel serial date number.
	*
	* @param float $modified
	* @return void
	*/
	public function setModifiedAsDouble($modified) {}

	/**
	* Removes all core properties.
	*
	* @return void
	*/
	public function removeAll() {}

} // end ExcelCoreProperties
