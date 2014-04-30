<?php
    /** LZW compression
* @param string data to compress
* @return string binary data
* Adapted from http://rosettacode.org/wiki/LZW_compression
* @author: colby callahan
*/
function lzw_compress($string) {
    // compression
    $dictionary = array_flip(range("\0", "\xFF"));
    $word = "";
    $codes = array();
    for ($i=0; $i < strlen($string); $i += 1) {
        $x = $string[$i];
        if (strlen($x) && isset($dictionary[$word . $x])) {
            $word .= $x;
        } elseif ($i) {
            $codes[] = $dictionary[$word];
            $dictionary[$word . $x] = count($dictionary);
            $word = $x;
        }
    }
    
    // convert codes to binary string
    $dictionary_count = 256;
    $bits = 8; // ceil(log($dictionary_count, 2))
    $return = "";
    $rest = 0;
    $rest_length = 0;
    foreach ($codes as $code) {
        $rest = ($rest << $bits) + $code;
        $rest_length += $bits;
        $dictionary_count++;
        if ($dictionary_count > (1 << $bits)) {
            $bits++;
        }
        while ($rest_length > 7) {
            $rest_length -= 8;
            $return .= chr($rest >> $rest_length);
            $rest &= (1 << $rest_length) - 1;
        }
    }
    return $return . ($rest_length ? chr($rest << (8 - $rest_length)) : "");
}

function lzw_decompress($compressed) {
    $word = ""; 
    $dictionary = []; 
    $entry = "";
    $dictSize = 256;

    for ($i = 0; $i < 256; $i += 1) {
        $dictionary[$i] = chr($i);
    }

    $w = chr($compressed[0]);
    $result = $w;
    for ($i = 1; $i < count($compressed); $i += 1) {
        $k = $compressed[$i];
        if ($dictionary[$k]) {
            $entry = $dictionary[$k];
        } else {
            if ($k === $dictSize) {
                $entry = $w . substr($w, 0, 1);
            } else {
                return $k;
                return null;
            }
        }

        $result .= $entry;

        // Add w+entry[0] to the dictionary.
        $dictionary[$dictSize++] = $w . substr($entry, 0, 1);

        $w = $entry;
    }
    return $result;
}

/*This handles the compressed data*/    
echo lzw_decompress(explode(',', $_POST['test']));die;

?>