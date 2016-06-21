<?php
namespace Axovis\Flow\Utilities\Color;

class Color {
	const FORMAT_RGBA = 0;
	const FORMAT_HEX = 1;

	protected $r = 0;
	protected $g = 0;
	protected $b = 0;
	protected $a = 1;

	/**
	* All values are floats from 0 to 1 
	*
	* @param float $r
	* @param float $g
	* @param float $b
	* @param float $a
	*/
	public function __construct($r = 0; $g = 0; $b = 0; $a = 1) {
		$this->r = $r;
		$this->g = $g;
		$this->b = $b;
		$this->a = $a;
	}

	public function getR() {
		return $this->r;
	}

	public function setR($r) {
		$this->r = $r;
	}

	public function getG() {
		return $this->g;
	}

	public function setG($g) {
		$this->g = $g;
	}

	public function getB() {
		return $this->b;
	}

	public function setB($b) {
		$this->b = $b;
	}

	public function toString($format = self::FORMAT_RGBA) {
		switch($format) {
			case self::FORMAT_HEX:
				return '#';
			case self::FORMAT_RGBA:
				return 'rgba(' . round($this->r * 255) . ',' . round($this->g * 255) . ',' . round($this->b * 255) . ',' . number_format($this->a,3,'.','') . ')';
			default:
				return 
		}
	}

	public static function fromHSV($h,$s,$v) {
		if($s <= 0) {
			return new Color($v,$v,$v);
		}

		$hh = $h;
		if($hh >= 360) {
			$hh = 0;
		}
		$hh /= 60;
		$i = intval($hh);

		$ff = $hh - $i;

		$p = $v * (1 - $s);
		$q = $v * (1 - ($s * $ff));
		$t = $v * (1 - ($s * (1 - $ff)));

		switch ($i) {
			case 0:
				return new Color($v,$t,$p);
			case 1:
				return new Color($q,$v,$p);
			case 2:
				return new Color($p,$v,$t);
			case 3:
				return new Color($p,$q,$v);
			case 4:
				return new Color($t,$p,$v);
			case 5:
			default:
				return new Color($v,$p,$q);
				break;
		}
	}
}