<?php
//included this file in function.php
namespace WPC;
class Widget_Loader{
    private static $_instance = null;

    public static function instance(){
        if(is_null(self::$_instance)){
            self::$_instance = new self();
        }
        return self::$_instance;
    }
    private function include_widgets_files(){
        //get custom widget file 
        require_once(__DIR__.'/Widgets/custom_scroll.php');
    }
    public function register_widgets(){
        $this->include_widgets_files();
        \Elementor\Plugin::instance()->widgets_manager->register_widget_type(new Widgets\Custom_Scroll());
    }
    public function __construct(){
        add_action('elementor/widgets/widgets_registered',[$this,'register_widgets'],99);
    }
}
//initialtion plugin class
Widget_Loader::instance();
?>