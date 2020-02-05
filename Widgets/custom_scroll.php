<?php
namespace WPC\Widgets;
use Elementor\Widget_Base;
use Elementor\Controls_Manager;
use PremiumAddons\Includes;
use TheplusAddons\Theplus_Element_Load;

if(!defined('ABSPATH'))exit;
class Custom_Scroll extends Widget_Base{
    public function __construct($data = [], $args = null) {
        parent::__construct($data, $args);
        //Register All files from cloude and elemnter theme 
        //hello-elementor/assets/widgets/js/customscroll.js
        wp_register_script( 'script-handle',get_template_directory_uri().'/assets/js/customscroll.js', [ 'elementor-frontend' ], '1.0.0', true );
        wp_register_script( 'fullpage-handle',"https://cdnjs.cloudflare.com/ajax/libs/fullPage.js/3.0.5/fullpage.min.js", [ 'elementor-frontend' ], '1.0.0', true );
        wp_register_style( 'style-handle', '/assets/css/customscroll.CSS');
        wp_register_style( 'fullpage-style', 'https://cdnjs.cloudflare.com/ajax/libs/fullPage.js/3.0.5/fullpage.min.css');
     }
     public function get_all_post() {

		$all_posts = get_posts( array(
                'posts_per_page'    => -1,
				'post_type'         => array ( 'page', 'post','elementor_library'),
			)
		);
		if( !empty( $all_posts ) && !is_wp_error( $all_posts ) ) {
			foreach ( $all_posts as $post ) {
				$this->options[ $post->ID ] = strlen( $post->post_title ) > 30 ? substr( $post->post_title, 0, 30 ).'...' : $post->post_title ." [".$post->post_type."]";
			}
		}
		return $this->options;
	}
    public function getTemplateInstance() {
		return $this->templateInstance = Includes\premium_Template_Tags::getInstance();
	}
    public function get_name(){
        return 'custom scroll';
    }
    public function get_title(){
        return 'Custom Scroll';
    }
    public function get_icon(){
        return 'fa fa-arrows-alt';
    }
    public function get_categories(){
        return ['general'];
    }
    public function _register_controls(){
        $repeater = new \Elementor\Repeater();
        $this->start_controls_section(
            'section_content',
            ['label' => 'settings']
        ); 
      
        $repeater->add_control(
			'show_elements',
			[
				'label' => __( 'Show Elements', 'plugin-domain' ),
				'type' => \Elementor\Controls_Manager::SELECT2,
				'multiple' => false,
				'options' => [
					'title'  => __( 'Title', 'plugin-domain' ),
					'description' => __( 'Description', 'plugin-domain' ),
					'button' => __( 'Button', 'plugin-domain' ),
				],
				'default' => [ 'title', 'description' ],
			]
		);
        $repeater = new \Elementor\Repeater();
       // $templateObj = new TheplusAddons\Theplus_Element_Load();
        $repeater->add_control(
			'template', [
				'label' => __( 'Template', 'plugin-domain' ),
				'type' => \Elementor\Controls_Manager::SELECT,
                'options' => $this->get_all_post(),//$this->getTemplateInstance()->get_elementor_page_list(),//theplus_get_templates(),//
				'label_block' => true,
			]
        );
        
        $repeater->add_control(
			'show_in_mobile',
			[
				'label' => __( 'Show In Mobile', 'plugin-domain' ),
				'type' => \Elementor\Controls_Manager::SWITCHER,
				'label_on' => __( 'Show', 'your-plugin' ),
				'label_off' => __( 'Hide', 'your-plugin' ),
				'return_value' => 'Yes',
				'default' => 'Yes',
			]
        );
        $repeater->add_control(
			'show_in_tablet',
			[
				'label' => __( 'Show In Tablet', 'plugin-domain' ),
				'type' => \Elementor\Controls_Manager::SWITCHER,
				'label_on' => __( 'Show', 'your-plugin' ),
				'label_off' => __( 'Hide', 'your-plugin' ),
				'return_value' => 'Yes',
				'default' => 'Yes',
			]
		);
        $repeater->add_control(
			'show_in_Desktop',
			[
				'label' => __( 'Show In Desktop', 'plugin-domain' ),
				'type' => \Elementor\Controls_Manager::SWITCHER,
				'label_on' => __( 'Show', 'your-plugin' ),
				'label_off' => __( 'Hide', 'your-plugin' ),
				'return_value' => 'Yes',
				'default' => 'Yes',
			]
		);
		$repeater->add_control(
			'anchor_id', [
				'label' => __( 'Anchor ID', 'plugin-domain' ),
				'type' => \Elementor\Controls_Manager::TEXT,
				'default' => __( 'anchor_id' , 'plugin-domain' ),
				'label_block' => true,
			]
		);
		$this->add_control(
			'list', 
			[
				'label' => __( 'Repeater List', 'plugin-domain' ),
				'type' => \Elementor\Controls_Manager::REPEATER,
				'fields' => $repeater->get_controls(),
				'default' => [
					[	
                        'template' => __( 'select template', 'plugin-domain' ),
                        'show_in_Desktop' => __( 'Yes', 'plugin-domain' ),
                        'show_in_mobile' => __( 'No', 'plugin-domain' ),
                        'anchor_id' => __( 'Anchor_#1', 'plugin-domain' ),
					],
					[
                        'template' => __( 'select template', 'plugin-domain' ),
                        'show_in_Desktop' => __( 'Yes', 'plugin-domain' ),
                        'show_in_mobile'=>__( 'Yes', 'plugin-domain' ),
                        'anchor_id' => __( 'Anchor_#2', 'plugin-domain' ),
					],
				],
				'title_field' => '{{{ anchor_id }}}',
			]
        );
        $this->end_controls_section();

    }   
    public function get_script_depends() {
        return [ 'script-handle',
                'fullpage-handle'
                ];
    }
    public function get_style_depends(){
        return ['style-handle',
                'fullpage-style'];
    }
    //PHP render
    public function render(){
       
            $settings = $this->get_settings_for_display();
          echo "<div class='sfull-section'>"; //full section start
                foreach($settings['list'] as $index => $item ){   
                    //check for mobile and desktop
                    echo "<div class='";    //single full page start
                    if($item['show_in_Desktop'] === 'Yes'){
                        echo " desktop_show";
                    }else{
                        echo " desktop_hide";
                    }
                    if($item['show_in_tablet'] === 'Yes'){
                        echo " tablet_show";
                    }else{
                        echo " tablet_hide";
                    }
                    if($item['show_in_mobile'] === 'Yes'){
                        echo " mobile_show";
                    }else{
                        echo " mobile_hide";
                    }
                    
                    echo " section fullpagesection'";
                    echo " anchor_id = '".$item['anchor_id']."'>";
                    //get template
                    $template_title = $item['template'];
                    echo $this->getTemplateInstance()->get_template_content( $template_title );
                    echo "</div>";
                }
            echo "</div>" ; //full section end
    }
    //JS Render
    protected function _content_template(){
      /*  ?> 
        <#
            view.addInlineEditingAttributes( 'label_heading' , 'basic' );
            view.addRenderAttribute(
                'label_heading',
                {
                    'class' : [ 'advertisement__label-heading' ],
                }
            );
        #>
        <div class="advertisement">
            <div {{{ view.getRenderAttributeString( 'label_heading' ) }}}> {{{ settings.label_heading }}} </div>
            <div class="advertisement__content">
                <div class="advertisement__content__heading"> {{{ settings.content_heading }}} </div>
                <div class="advertisement__content__copy">
                    {{{ settings.content }}}
                </div>
            </div>
        </div>
        <?php
     */
    }
}
?>