<?php
    function utf8_encode_deep($string){
        if(is_array($string)){
            foreach ($string as &$value) {
                if(is_array($value))
                    utf8_encode_deep($value);
                else
                    utf8_encode($value);
            }
        }else{
            utf8_encode($string);
        }
    }
?>