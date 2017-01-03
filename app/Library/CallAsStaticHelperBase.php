<?php
namespace App\Library;

class CallAsStaticHelperBase {

    protected static $class_type = 'base';

    public function initiate(){
        if( static::$class_type == 'base' ){
            throw new \Exception( 'You are calling the base class, do not do that!!' );
        }
    }   

    public function __call($method, $args){
        $this->initiate();

        $method = '_'.$method;

        if( method_exists( $this, $method ) ){
            return call_user_func_array( [ $this, $method ], $args );
        }

        throw new \Exception( 'Method not found: '.$method );
    }   

    public static function __callStatic($method, $args) {
        $globalvarname = 'CALLASSTATICHELPER'.static::$class_type;
        global $$globalvarname;

        if( !$$globalvarname ){
            $$globalvarname = new static();
        }
        $$globalvarname->initiate();

        $method = '_'.$method;
        if( method_exists( $$globalvarname, $method ) ){
            return call_user_func_array( [ $$globalvarname, $method ], $args );
        }

        throw new \Exception( 'Method not found: '.$method );
    }   

}
