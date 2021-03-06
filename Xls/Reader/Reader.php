<?php
namespace Arodiss\XlsBundle\Xls\Reader;

use Arodiss\XlsBundle\Iterator\NestingDiscloseIterator;
use Arodiss\XlsBundle\Iterator\StringifyIterator;

class Reader {

	/**
	 * @param string $path
	 * @return array
	 */
	public function readAll($path,$sheet='') {
		return $this->getExcel($path,$sheet)->toArray();
	}

	/**
	 * @param string $path
	 * @return \Iterator
	 */
	public function getReadIterator($path,$sheet='') {
		return new StringifyIterator(new NestingDiscloseIterator($this->getExcel($path, $sheet)->getRowIterator()));
	}

	/**
	 * @param string $path
	 * @return \Iterator
	 */
	public function getItemsCount($path,$sheet='') {
		return $this->getExcel($path, $sheet)->getHighestRow();
	}

	/**
	 * @param string $path
	 * @return \PHPExcel_Worksheet
	 */
	protected function getExcel($path,$sheet='') {
		$reader = \PHPExcel_IOFactory::createReaderForFile($path);
        if ($sheet) $reader->setLoadSheetsOnly(array($sheet));
        /** @var \PHPExcel $excel */
		$excel = $reader->load($path);
		return $excel->getActiveSheet();
	}
}
