<?php


namespace Mr\NewsBundle\Service;


class Canonicalizer {
    /**
     * @param string   $text
     * @param callable $checkUnique
     */
    public function canonicalize($text, callable $checkUnique=null) {
        $unwanted_array = array('Š'=>'S', 'š'=>'s', 'Ž'=>'Z', 'ž'=>'z', 'À'=>'A', 'Á'=>'A', 'Â'=>'A', 'Ã'=>'A', 'Ä'=>'A', 'Å'=>'A', 'Æ'=>'A', 'Ç'=>'C', 'È'=>'E', 'É'=>'E',
                                'Ê'=>'E', 'Ë'=>'E', 'Ì'=>'I', 'Í'=>'I', 'Î'=>'I', 'Ï'=>'I', 'Ñ'=>'N', 'Ò'=>'O', 'Ó'=>'O', 'Ô'=>'O', 'Õ'=>'O', 'Ö'=>'O', 'Ø'=>'O', 'Ù'=>'U',
                                'Ú'=>'U', 'Û'=>'U', 'Ü'=>'U', 'Ý'=>'Y', 'Þ'=>'B', 'ß'=>'ss', 'à'=>'a', 'á'=>'a', 'â'=>'a', 'ã'=>'a', 'ä'=>'a', 'å'=>'a', 'æ'=>'a', 'ç'=>'c',
                                'è'=>'e', 'é'=>'e', 'ê'=>'e', 'ë'=>'e', 'ì'=>'i', 'í'=>'i', 'î'=>'i', 'ï'=>'i', 'ð'=>'o', 'ñ'=>'n', 'ò'=>'o', 'ó'=>'o', 'ô'=>'o', 'õ'=>'o',
                                'ö'=>'o', 'ø'=>'o', 'ù'=>'u', 'ú'=>'u', 'û'=>'u', 'ý'=>'y', 'ý'=>'y', 'þ'=>'b', 'ÿ'=>'y', 'Ğ'=>'G', 'İ'=>'I', 'Ş'=>'S', 'ğ'=>'g', 'ı'=>'i',
                                'ş'=>'s', 'ü'=>'u', 'ă'=>'a', 'Ă'=>'A', 'ș'=>'s', 'Ș'=>'S', 'ț'=>'t', 'Ț'=>'T', '@' => 'a',
                                ' ' => '-', "\t" => '-', "\n" => '-', '_' => '-');
        $wanted_array = array('a', 'b', 'c', 'd', 'e', 'f', 'g', 'h', 'i', 'j', 'k', 'l', 'm', 'n', 'o', 'p', 'q', 'r', 's', 't', 'u', 'v', 'w', 'x', 'y', 'z', '-');

        $tmpResult = strtr($text, $unwanted_array);
        $tmpResult = strtolower($tmpResult);
        $result = '';
        foreach (str_split($tmpResult) as $char) {
            if (in_array($char, $wanted_array)) {
                $result .= $char;
            }
        }
        do {
            $result = str_replace('--', '-', $result, $count);
        } while ($count > 0);
        $result = preg_replace('#^-#', '', $result);
        $result = preg_replace('#-$#', '', $result);

        if ($checkUnique !== null && $checkUnique($result) === false) {
            $i = 2;
            do {
                $tmpResult = $result . '-' . $i;
                $i++;
            } while ($checkUnique($tmpResult) === false);
            $result = $tmpResult;
        }
        return $result;
    }
} 