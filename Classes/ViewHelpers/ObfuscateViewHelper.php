<?php
namespace Axovis\Flow\Utilities\ViewHelpers;

use TYPO3\Flow\Exception;
use TYPO3\Fluid\Core\ViewHelper\AbstractViewHelper;
use TYPO3\Flow\Annotations as Flow;

class ObfuscateViewHelper extends AbstractViewHelper {
    protected $escapeOutput = false;
    protected $escapeChildren = false;
    protected $escapingInterceptorEnabled = false;

    public function render($value = null,$method = 'encode') {
        if($value === null) {
            $value = $this->renderChildren();
        }

        $methodName = 'obfuscate' . ucfirst(strtolower($method));
        if(method_exists($this,$methodName)) {
            return $this->$methodName($value);
        } else {
            throw new Exception("obfuscate method '" . $method . "' does not exist.");
        }
    }

    public function obfuscateJavascript($value) {
        $character_set = '+-.0123456789@ABCDEFGHIJKLMNOPQRSTUVWXYZ_abcdefghijklmnopqrstuvwxyz';
        $key = str_shuffle($character_set);
        $cipher_text = '';
        $id = 'e'.rand(1,999999999);

        for($i = 0; $i < strlen($value); $i += 1) {
            $cipher_text.= $key[strpos($character_set,$value[$i])];
        }

        $script = 'var a="'.$key.'";var b=a.split("").sort().join("");var c="'.$cipher_text.'";var d="";';
        $script.= 'for(var e=0;e<c.length;e++)d+=b.charAt(a.indexOf(c.charAt(e)));';
        $script.= 'document.getElementById("'.$id.'").innerHTML="<a href=\\"mailto:"+d+"\\">"+d+"</a>"';
        $script = "eval(\"".str_replace(array("\\",'"'),array("\\\\",'\"'), $script)."\")";
        $script = '<script type="text/javascript">/*<![CDATA[*/'.$script.'/*]]>*/</script>';

        return '<span id="'.$id.'">[javascript protected email address]</span>'.$script;
    }

    public function obfuscateReverse($value) {
        $id = 'obf-rev-' . md5($value);

        return '<style type="text/css">#' . $id . ' { direction: rtl; unicode-bidi: bidi-override; }</style><span id="' . $id . '">' . strrev($value) . '</span>';
    }

    public function obfuscateEncode($value) {
        $alwaysEncode = array('.', ':', '@');

        $result = '';

        // Encode string using oct and hex character codes
        for($i = 0; $i < strlen($value); $i++) {
            // Encode 25% of characters including several that always should be encoded
            if(in_array($value[$i], $alwaysEncode) || mt_rand(1, 100) < 25) {
                if(mt_rand(0, 1)) {
                    $result .= '&#' . ord($value[$i]) . ';';
                } else {
                    $result .= '&#x' . dechex(ord($value[$i])) . ';';
                }
            } else {
                $result .= $value[$i];
            }
        }

        return $result;
    }
}