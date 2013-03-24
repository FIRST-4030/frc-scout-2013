<?php
/**
 * PHPExcel
 *
 * Copyright (c) 2006 - 2012 PHPExcel
 *
 * This library is free software; you can redistribute it and/or
 * modify it under the terms of the GNU Lesser General Public
 * License as published by the Free Software Foundation; either
 * version 2.1 of the License, or (at your option) any later version.
 *
 * This library is distributed in the hope that it will be useful,
 * but WITHOUT ANY WARRANTY; without even the implied warranty of
 * MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE.  See the GNU
 * Lesser General Public License for more details.
 *
 * You should have received a copy of the GNU Lesser General Public
 * License along with this library; if not, write to the Free Software
 * Foundation, Inc., 51 Franklin Street, Fifth Floor, Boston, MA  02110-1301  USA
 *
 * @category   PHPExcel
 * @package    PHPExcel_Writer_Excel5
 * @copyright  Copyright (c) 2006 - 2012 PHPExcel (http://www.codeplex.com/PHPExcel)
 * @license	http://www.gnu.org/licenses/old-licenses/lgpl-2.1.txt	LGPL
 * @version	1.7.8, 2012-10-12
 */


/**
 * PHPExcel_Writer_Excel5
 *
 * @category   PHPExcel
 * @package    PHPExcel_Writer_Excel5
 * @copyright  Copyright (c) 2006 - 2012 PHPExcel (http://www.codeplex.com/PHPExcel)
 */
class PHPExcel_Writer_Excel5 implements PHPExcel_Writer_IWriter
{
	/**
	 * Pre-calculate formulas
	 *
	 * @var boolean
	 */
	private $_preCalculateFormulas	= true;

	/**
	 * PHPExcel object
	 *
	 * @var PHPExcel
	 */
	private $_phpExcel;

	/**
	 * Total number of shared strings in workbook
	 *
	 * @var int
	 */
	private $_str_total		= 0;

	/**
	 * Number of unique shared strings in workbook
	 *
	 * @var int
	 */
	private $_str_unique	= 0;

	/**
	 * Array of unique shared strings in workbook
	 *
	 * @var array
	 */
	private $_str_table		= array();

	/**
	 * Color cache. Mapping between RGB value and color index.
	 *
	 * @var array
	 */
	private $_colors;

	/**
	 * Formula parser
	 *
	 * @var PHPExcel_Writer_Excel5_Parser
	 */
	private $_parser;

	/**
	 * Identifier clusters for drawings. Used in MSODRAWINGGROUP record.
	 *
	 * @var array
	 */
	private $_IDCLs;

	/**
	 * Basic OLE object summary information
	 *
	 * @var array
	 */
	private $_summaryInformation;

	/**
	 * Extended OLE object document summary information
	 *
	 * @var array
	 */
	private $_documentSummaryInformation;

	/**
	 * Create a new PHPExcel_Writer_Excel5
	 *
	 * @param	PHPExcel	$phpExcel	PHPExcel object
	 */
	public function __construct(PHPExcel $phpExcel) {
		$this->_phpExcel	= $phpExcel;

		$this->_parser		= new PHPExcel_Writer_Excel5_Parser();
	}

	/**
	 * Save PHPExcel to file
	 *
	 * @param	string		$pFilename
	 * @throws	Exception
	 */
	public function save($pFilename = null) {

		// garbage collect
		$this->_phpExcel->garbageCollect();

		$saveDebugLog = PHPExcel_Calculation::getInstance()->writeDebugLog;
		PHPExcel_Calculation::getInstance()->writeDebugLog = false;
		$saveDateReturnType = PHPExcel_Calculation_Functions::getReturnDateType();
		PHPExcel_Calculation_Functions::setReturnDateType(PHPExcel_Calculation_Functions::RETURNDATE_EXCEL);

		// initialize colors array
		$this->_colors          = array();

		// Initialise workbook writer
		$this->_writerWorkbook = new PHPExcel_Writer_Excel5_Workbook($this->_phpExcel,
																	 $this->_str_total, $this->_str_unique, $this->_str_table,
																	 $this->_colors, $this->_parser);

		// Initialise worksheet writers
		$countSheets = $this->_phpExcel->getSheetCount();
		for ($i = 0; $i < $countSheets; ++$i) {
			$this->_writerWorksheets[$i] = new PHPExcel_Writer_Excel5_Worksheet($this->_str_total, $this->_str_unique,
																			   $this->_str_table, $this->_colors,
																			   $this->_parser,
																			   $this->_preCalculateFormulas,
																			   $this->_phpExcel->getSheet($i));
		}

		// build Escher objects. Escher objects for workbooks needs to be build before Escher object for workbook.
		$this->_buildWorksheetEschers();
		$this->_buildWorkbookEscher();

		// add 15 identical cell style Xfs
		// for now, we use the first cellXf instead of cellStyleXf
		$cellXfCollection = $this->_phpExcel->getCellXfCollection();
		for ($i = 0; $i < 15; ++$i) {
			$this->_writerWorkbook->addXfWriter($cellXfCollection[0], true);
		}

		// add all the cell Xfs
		foreach ($this->_phpExcel->getCellXfCollection() as $style) {
			$this->_writerWorkbook->addXfWriter($style, false);
		}

		// add fonts from rich text eleemnts
		for ($i = 0; $i < $countSheets; ++$i) {
			foreach ($this->_writerWorksheets[$i]->_phpSheet->getCellCollection() as $cellID) {
				$cell = $this->_writerWorksheets[$i]->_phpSheet->getCell($cellID);
				$cVal = $cell->getValue();
				if ($cVal instanceof PHPExcel_RichText) {
					$elements = $cVal->getRichTextElements();
					foreach ($elements as $element) {
						if ($element instanceof PHPExcel_RichText_Run) {
							$font = $element->getFont();
							$this->_writerWorksheets[$i]->_fntHashIndex[$font->getHashCode()] = $this->_writerWorkbook->_addFont($font);
						}
					}
				}
			}
		}

		// initialize OLE file
		$workbookStreamName = 'Workbook';
		$OLE = new PHPExcel_Shared_OLE_PPS_File(PHPExcel_Shared_OLE::Asc2Ucs($workbookStreamName));

		// Write the worksheet streams before the global workbook stream,
		// because the byte sizes of these are needed in the global workbook stream
		$worksheetSizes = array();
		for ($i = 0; $i < $countSheets; ++$i) {
			$this->_writerWorksheets[$i]->close();
			$worksheetSizes[] = $this->_writerWorksheets[$i]->_datasize;
		}

		// add binary data for global workbook stream
		$OLE->append( $this->_writerWorkbook->writeWorkbook($worksheetSizes) );

		// add binary data for sheet streams
		for ($i = 0; $i < $countSheets; ++$i) {
			$OLE->append($this->_writerWorksheets[$i]->getData());
		}

		$this->_documentSummaryInformation = $this->_writeDocumentSummaryInformation();
		// initialize OLE Document Summary Information
		if(isset($this->_documentSummaryInformation) && !empty($this->_documentSummaryInformation)){
			$OLE_DocumentSummaryInformation = new PHPExcel_Shared_OLE_PPS_File(PHPExcel_Shared_OLE::Asc2Ucs(chr(5) . 'DocumentSummaryInformation'));
			$OLE_DocumentSummaryInformation->append($this->_documentSummaryInformation);
		}

		$this->_summaryInformation = $this->_writeSummaryInformation();
		// initialize OLE Summary Information
		if(isset($this->_summaryInformation) && !empty($this->_summaryInformation)){
		  $OLE_SummaryInformation = new PHPExcel_Shared_OLE_PPS_File(PHPExcel_Shared_OLE::Asc2Ucs(chr(5) . 'SummaryInformation'));
		  $OLE_SummaryInformation->append($this->_summaryInformation);
		}

		// define OLE Parts
		$arrRootData = array($OLE);
		// initialize OLE Properties file
		if(isset($OLE_SummaryInformation)){
			$arrRootData[] = $OLE_SummaryInformation;
		}
		// initialize OLE Extended Properties file
		if(isset($OLE_DocumentSummaryInformation)){
			$arrRootData[] = $OLE_DocumentSummaryInformation;
		}

		$root = new PHPExcel_Shared_OLE_PPS_Root(time(), time(), $arrRootData);
		// save the OLE file
		$res = $root->save($pFilename);

		PHPExcel_Calculation_Functions::setReturnDateType($saveDateReturnType);
		PHPExcel_Calculation::getInstance()->writeDebugLog = $saveDebugLog;
	}

	/**
	 * Set temporary storage directory
	 *
	 * @deprecated
	 * @param	string	$pValue		Temporary storage directory
	 * @throws	Exception	Exception when directory does not exist
	 * @return PHPExcel_Writer_Excel5
	 */
	public function setTempDir($pValue = '') {
		return $this;
	}

	/**
	 * Get Pre-Calculate Formulas
	 *
	 * @return boolean
	 */
	public function getPreCalculateFormulas() {
		return $this->_preCalculateFormulas;
	}

	/**
	 * Set Pre-Calculate Formulas
	 *
	 * @param boolean $pValue	Pre-Calculate Formulas?
	 */
	public function setPreCalculateFormulas($pValue = true) {
		$this->_preCalculateFormulas = $pValue;
	}

	/**
	 * Build the Worksheet Escher objects
	 *
	 */
	private function _buildWorksheetEschers()
	{
		// 1-based index to BstoreContainer
		$blipIndex = 0;
		$lastReducedSpId = 0;
		$lastSpId = 0;

		foreach ($this->_phpExcel->getAllsheets() as $sheet) {
			// sheet index
			$sheetIndex = $sheet->getParent()->getIndex($sheet);

			$escher = null;

			// check if there are any shapes for this sheet
			$filterRange = $sheet->getAutoFilter()->getRange();
			if (count($sheet->getDrawingCollection()) == 0 && empty($filterRange)) {
				continue;
			}

			// create intermediate Escher object
			$escher = new PHPExcel_Shared_Escher();

			// dgContainer
			$dgContainer = new PHPExcel_Shared_Escher_DgContainer();

			// set the drawing index (we use sheet index + 1)
			$dgId = $sheet->getParent()->getIndex($sheet) + 1;
			$dgContainer->setDgId($dgId);
			$escher->setDgContainer($dgContainer);

			// spgrContainer
			$spgrContainer = new PHPExcel_Shared_Escher_DgContainer_SpgrContainer();
			$dgContainer->setSpgrContainer($spgrContainer);

			// add one shape which is the group shape
			$spContainer = new PHPExcel_Shared_Escher_DgContainer_SpgrContainer_SpContainer();
			$spContainer->setSpgr(true);
			$spContainer->setSpType(0);
			$spContainer->setSpId(($sheet->getParent()->getIndex($sheet) + 1) << 10);
			$spgrContainer->addChild($spContainer);

			// add the shapes

			$countShapes[$sheetIndex] = 0; // count number of shapes (minus group shape), in sheet

			foreach ($sheet->getDrawingCollection() as $drawing) {
				++$blipIndex;

				++$countShapes[$sheetIndex];

				// add the shape
				$spContainer = new PHPExcel_Shared_Escher_DgContainer_SpgrContainer_SpContainer();

				// set the shape type
				$spContainer->setSpType(0x004B);
				// set the shape flag
				$spContainer->setSpFlag(0x02);

				// set the shape index (we combine 1-based sheet index and $countShapes to create unique shape index)
				$reducedSpId = $countShapes[$sheetIndex];
				$spId = $reducedSpId
					| ($sheet->getParent()->getIndex($sheet) + 1) << 10;
				$spContainer->setSpId($spId);

				// keep track of last reducedSpId
				$lastReducedSpId = $reducedSpId;

				// keep track of last spId
				$lastSpId = $spId;

				// set the BLIP index
				$spContainer->setOPT(0x4104, $blipIndex);

				// set coordinates and offsets, client anchor
				$coordinates = $drawing->getCoordinates();
				$offsetX = $drawing->getOffsetX();
				$offsetY = $drawing->getOffsetY();
				$width = $drawing->getWidth();
				$height = $drawing->getHeight();

				$twoAnchor = PHPExcel_Shared_Excel5::oneAnchor2twoAnchor($sheet, $coordinates, $offsetX, $offsetY, $width, $height);

				$spContainer->setStartCoordinates($twoAnchor['startCoordinates']);
				$spContainer->setStartOffsetX($twoAnchor['startOffsetX']);
				$spContainer->setStartOffsetY($twoAnchor['startOffsetY']);
				$spContainer->setEndCoordinates($twoAnchor['endCoordinates']);
				$spContainer->setEndOffsetX($twoAnchor['endOffsetX']);
				$spContainer->setEndOffsetY($twoAnchor['endOffsetY']);

				$spgrContainer->addChild($spContainer);
			}

			// AutoFilters
			if(!empty($filterRange)){
				$rangeBounds = PHPExcel_Cell::rangeBoundaries($filterRange);
				$iNumColStart = $rangeBounds[0][0];
				$iNumColEnd = $rangeBounds[1][0];

				$iInc = $iNumColStart;
				while($iInc <= $iNumColEnd){
					++$countShapes[$sheetIndex];

					// create an