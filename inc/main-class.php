<?php

class TripTicket{
    
    public function __construct(){
        
        $this->activate();
        
    }
    
    private function activate(){
        register_activation_hook( ROOT . '/index.php' , array( $this, 'TT_activate' ) );
        
    }
    
    public static function TT_activate(){
        
        require_once( ROOT . '/inc/tt-class-install.php' );
        
    }
    
    
}



?>