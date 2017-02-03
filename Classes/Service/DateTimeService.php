<?php
namespace Axovis\Flow\Utilities\Service;

use TYPO3\Flow\Annotations as Flow;
use TYPO3\Flow\I18n\Locale;
use TYPO3\Flow\Security\Exception\MissingConfigurationException;

/**
 * @Flow\Scope("singleton")
 */
class DateTimeService {
    /**
     * @Flow\Inject(setting="dateFormats", package="Axovis.SelfTrackingPortal.Core")
     * @var array
     */
    protected $dateFormats;

    /**
     * @param \DateTime $date
     * @param Locale $locale
     * @throws MissingConfigurationException
     * @return string
     */
    public function formatLocalized($date,$locale) {
        $format = $this->getLocaleDateFormat($locale);

        return $this->format($date,$format);
    }

    /**
     * @param Locale $locale
     * @throws MissingConfigurationException
     * @return string
     */
    public function getLocaleDateFormat($locale) {
        return $this->dateFormats[$this->getLanguageKeyForLocale($locale)]['date'];
    }

    /**
     * @param Locale $locale
     * @return string
     */
    public function getLocaleTimeFormat($locale) {
        return $this->dateFormats[$this->getLanguageKeyForLocale($locale)]['time'];
    }

    /**
     * @param Locale $locale
     * @throws MissingConfigurationException
     * @return string
     */
    private function getLanguageKeyForLocale($locale) {
        if(!isset($this->dateFormats['default'])) {
            throw new MissingConfigurationException('default date format is missing');
        }

        $languageKey = $locale->getLanguage();
        if(!isset($this->dateFormats[$languageKey])) {
            return 'default';
        }

        return $languageKey;
    }

    /**
     * @param \DateTime $date
     * @param string $format
     * @return string
     */
    public function format($date,$format) {
        return $date->format($format);
    }

    /**
     * @param string $value
     * @return \DateTime
     */
    public function parseDate($value) {
        if(!$this->validateDate($value)) {
            return null;
        }

        $timestamp = strtotime($value);
        if($timestamp === false) {
            return null;
        }

        $datetime = new \DateTime();
        $datetime->setTimestamp($timestamp);

        return $datetime;
    }

    /**
     * @param string $value
     * @return \DateTime
     */
    public function parseDateTime($value) {
        if(!$this->validateDateTime($value)) {
            return null;
        }

        $timestamp = strtotime($value);
        if($timestamp === false) {
            return null;
        }

        $datetime = new \DateTime();
        $datetime->setTimestamp($timestamp);

        return $datetime;
    }

    /*
     * @param $value
     * @return int
     *
    private function parseDate($value) {
        if(!$this->validateDate($value)) {
            return false;
        }


    }*/

    /*
     * @param $value
     * @return int
     *
    private function parseTime($value) {
        if(!$this->validateTime($value)) {
            return false;
        }

        $twelveHours = preg_match('/p|a/',$value) === 1;
        $pm = false;
        if($twelveHours) {
            $pm = preg_match('/p/',$value) === 1;
            $value = str_replace(array('a','A','p','P','m','M','.',' '),'',$value);
        }

        $value = trim($value);
        $parts = explode(':',trim($value));

        $hour = 0;
        $minute = 0;
        $second = 0;
        if(is_numeric($parts[0])) {
            $hour = $parts[0];
        }
        if(count($parts) > 0 && is_numeric($parts[1])) {
            $minute = $parts[1];
        }
        if(count($parts) > 1 && is_numeric($parts[2])) {
            $minute = $parts[2];
        }

        if($twelveHours && $pm) {
            $hour += 12;
        }

        return $second + $minute * 60 + $hour * 60 * 60;
    }*/

    /**
     * @param $value
     * @return bool
     */
    public function validateDateTime($value) {
        $parts = explode(' ',$value,2);
        if(count($parts) < 2) {
            return false;
        }

        if(!$this->validateDate(trim($parts[0]))) {
            return false;
        }

        if(!$this->validateTime(trim($parts[1]))) {
            return false;
        }

        return true;
    }

    /**
     * @param string $value
     * @return bool
     */
    public function validateDate($value) {
        return preg_match('/(^\d\d?\.\d\d?\.\d\d\d\d?$)|(^\d\d?[\/-]\d\d?[\/-]\d\d(\d\d)?$)/',$value) === 1;
    }

    /**
     * @param string $value
     * @return bool
     */
    public function validateTime($value) {
        return preg_match('/(^t?\d\d[.:]\d\d$)|(^\d?\d[.:]\d?\d ?(p\.?m\.?|a\.?m\.?)$)/i',$value) === 1;
    }

    public function phpToJsFormat($format) {
        return str_replace(array('j','d','n','m','y','Y'),array('d','dd','m','mm','yy','yyyy'),$format);
    }
}