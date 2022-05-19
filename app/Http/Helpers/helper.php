<?php

if(! function_exists('aurl')){
    function aurl($url = null){
        return url('admin/' . $url);
    }
}

if(! function_exists('active_menu')){
    function active_menu($link){
        if(preg_match('/' . $link . '/i', Request::segment(3))){
            return['menu-open', 'active'];
        }else{
            return ['', ''];
        }
    }
}

if(! function_exists('generate_code')){
    function generate_code()
        {
            $characters       = '0123456789';
            $charactersLength = strlen( $characters );
            $code            = '';
            $length           = 4;
            for ( $i = 0; $i < $length; $i++ ) {
                $code .= $characters[ rand( 0, $charactersLength - 1 ) ];
            }
            return $code;
        }
}
