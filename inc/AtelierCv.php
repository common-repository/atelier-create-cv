<?php

namespace ateliercv;

class AtelierCv
{

    public function __construct()
    {

        // Load text domain
        add_action('plugins_loaded', [&$this, 'loadDomainLang']);

        // Register admin menu page
        add_action('admin_menu', [&$this, 'addMenuCv']);

        // Register Settings
        add_action('admin_init', [&$this, 'settingsCv']);

        // Register Scripts Web
        add_action('admin_enqueue_scripts', [$this, 'enqueueScripts']);
        add_action('wp_enqueue_scripts', [$this, 'enqueueScripts']);

    }

    public static function getOptionValue($opt)
    {

        $name = $opt;

        if ($name != null) {
            return $name;
        } else {
            return '';
        }

    }

    public static function getValue($opt)
    {


        $name = get_option($opt);

        if ($name != null) {
	        return $name ;
        } else {
            return '';
        }

    }

    public function enqueueScripts()
    {

        // Enqueue Style
        wp_enqueue_style('wp-color-picker');

        // Google Fonts
        wp_enqueue_style('googleFontsCv', 'https://fonts.googleapis.com/css2?family=Lato:wght@100;300;400;700&family=Montserrat:wght@100;300;400;600&family=Open+Sans:wght@300;400;700&display=swap');

        // Fontello Css
        wp_enqueue_style('fontelloCss', ATL_CV_PLUGIN_URL . 'assets/css/fontello/css/fontello.css');

        // Main Cv Css
        wp_enqueue_style('mainCss', ATL_CV_PLUGIN_URL . 'assets/css/main.css');

        // Enqueue Scripts
        wp_enqueue_script('custom-script-handle', plugins_url('custom-script.js', __FILE__), array('wp-color-picker'), false, true);
        wp_enqueue_script('html2pdf', ATL_CV_PLUGIN_URL . 'assets/js/html2pdf.js', []);
        wp_enqueue_script('admin.js', ATL_CV_PLUGIN_URL . 'assets/js/admin.js', ['jquery']);

        // Enqueue Media
        wp_enqueue_media();

    }

    /**
     *  Load text Domain Internationalizing
     */
    public function loadDomainLang()
    {

        load_plugin_textdomain('ateliercv', false, basename(ATL_CV_PLUGIN_URL) . '/lang/');

    }

    /**
     * Add Menu Page
     */
    public function addMenuCv()
    {

        /* Menu Page */
        add_menu_page(
            __('Atelier Create CV', 'ateliercv'),
            __('Atelier CV', 'ateliercv'),
            'administrator',
            'atelier_cv',
            [&$this, 'atelierCreateCv'],
            'dashicons-media-document'
        );


        /* Submenu Personal Data */
        add_submenu_page(
            'atelier_cv',
            __('Personal Data', 'ateliercv'),
            __('Personal Data', 'ateliercv'),
            'administrator',
            'atelier_cv',
            [&$this, 'atelierCreateCv']
        );

        /* Submenu Experience */
        add_submenu_page(
            'atelier_cv',
            __('Professional experience', 'ateliercv'),
            __('Experience', 'ateliercv'),
            'administrator',
            'ateliercv_pe',
            [&$this, 'atelierCreateCv']
        );

        /* Educations */
        add_submenu_page(
            'atelier_cv',
            __('Educations', 'ateliercv'),
            __('Educations', 'ateliercv'),
            'administrator',
            'ateliercv_edu',
            [&$this, 'atelierCreateCv']
        );

        /* Submenu Qualifications */
        add_submenu_page(
            'atelier_cv',
            __('Qualifications', 'ateliercv'),
            __('Qualifications', 'ateliercv'),
            'administrator',
            'ateliercv_qf',
            [&$this, 'atelierCreateCv']
        );

    }

    public function settingsCv()
    {

        // Sections
        add_settings_section('atl_cv_data_personal_section', __('Data Personal', 'ateliercv'), [&$this, 'sectionPersonalData'], 'atelier_cv');
        add_settings_section('atl_cv_data_professional_experience', __('Professional Experience', 'ateliercv'), [&$this, 'sectionProfExp'], 'atelier_cv');
        add_settings_section('atl_cv_data_educations', __('Educations', 'ateliercv'), [&$this, 'sectionEducations'], 'atelier_cv');
        add_settings_section('atl_cv_data_qualifications', __('Qualifications', 'ateliercv'), [&$this, 'sectionQualifications'], 'atelier_cv');


        // Personal Data
        register_setting('data_personal_opt_group', 'atl_cv_first_name',[&$this,'sanitizeString']);
        register_setting('data_personal_opt_group', 'sidebar_bg_color',[&$this,'sanitizeString']);
        register_setting('data_personal_opt_group', 'atl_cv_font_color',[&$this,'sanitizeString']);
        register_setting('data_personal_opt_group', 'atl_cv_square_img',[&$this,'sanitizeString']);
        register_setting('data_personal_opt_group', 'atl_cv_surname',[&$this,'sanitizeString']);
        register_setting('data_personal_opt_group', 'atl_cv_email',[&$this,'sanitizeString']);
        register_setting('data_personal_opt_group', 'atl_cv_telephone',[&$this,'sanitizeString']);
        register_setting('data_personal_opt_group', 'atl_cv_person_image',[&$this,'sanitizeString']);
        register_setting('data_personal_opt_group', 'atl_cv_address',[&$this,'sanitizeString']);
        register_setting('data_personal_opt_group', 'atl_cv_address_code',[&$this,'sanitizeString']);
        register_setting('data_personal_opt_group', 'atl_cv_city',[&$this,'sanitizeString']);
        register_setting('data_personal_opt_group', 'atl_cv_date_birth',[&$this,'sanitizeString']);
        register_setting('data_personal_opt_group', 'atl_cv_place_birth',[&$this,'sanitizeString']);
        register_setting('data_personal_opt_group', 'atl_cv_driving_license',[&$this,'sanitizeString']);
        register_setting('data_personal_opt_group', 'atl_cv_gender',[&$this,'sanitizeString']);
        register_setting('data_personal_opt_group', 'atl_cv_nationality',[&$this,'sanitizeString']);
        register_setting('data_personal_opt_group', 'atl_cv_condition',[&$this,'sanitizeString']);
        register_setting('data_personal_opt_group', 'atl_cv_repo',[&$this,'sanitizeString']);
        register_setting('data_personal_opt_group', 'atl_cv_linkedin',[&$this,'sanitizeString']);
        register_setting('data_personal_opt_group', 'atl_cv_website',[&$this,'sanitizeString']);


        // Qualifications
        register_setting('qualifications_opt_group', 'atl_cv_qf_skills',[&$this,'sanitizeString']);
        register_setting('qualifications_opt_group', 'atl_cv_qf_hobby',[&$this,'sanitizeString']);
        register_setting('qualifications_opt_group', 'qf_privacy_policy',[&$this,'sanitizeString']);


    }

    public function sanitizeString($opt) {
        $opt = wp_strip_all_tags($opt);
        return $opt;
    }

    public function sectionPersonalData()
    {
        esc_html_e('Personal Data','ateliercv') ;
    }

    public function sectionProfExp()
    {

	    esc_html_e('Professional Experience','ateliercv');

    }

    public function sectionEducations()
    {

	    esc_html_e('Eduations','ateliercv');

    }

    public function sectionQualifications()
    {
        esc_html_e('Qualifications','ateliercv');
    }

    /**
     * Change Date with Month
     */
    public function changeDateMonth($old_date, $separator)
    {
        $old_date = explode('-', $old_date);
        $new_date = $old_date[1] . $separator . $old_date[0];

        $new_date = $this->editMonth($new_date);

        return $new_date;
    }

    public function editMonth($date)
    {

        $dates = explode('/', $date);

        /**
         *  Do refraktoryzacji
         */
        if ($dates[0] == '01') {
            $date = 'sty';
        } elseif ($dates[0] == '02') {
            $date = 'lut';
        } elseif ($dates[0] == '03') {
            $date = 'mar';
        } elseif ($dates[0] == '04') {
            $date = 'kwi';
        } elseif ($dates[0] == '05') {
            $date = 'maj';
        } elseif ($dates[0] == '06') {
            $date = 'cze';
        } elseif ($dates[0] == '07') {
            $date = 'lip';
        } elseif ($dates[0] == '08') {
            $date = 'sie';
        } elseif ($dates[0] == '09') {
            $date = 'wrz';
        } elseif ($dates[0] == '10') {
            $date = 'paż';
        } elseif ($dates[0] == '11') {
            $date = 'lis';
        } elseif ($dates[0] == '12') {
            $date = 'gru';
        }
        return $date . ' ' . $dates[1];

    }

    /**
     * Change Date
     */
    public function changeDate($old_date, $separator)
    {
        $old_date = explode('-', $old_date);
        if (isset($old_date[2]) && isset($old_date[1]) && isset($old_date[0])) {

            $new_date = $old_date[2] . $separator . $old_date[1] . $separator . $old_date[0];
            return $new_date;
        }


    }

    /**
     * Cut txt
     */
    public function textCut($text)
    {
        $text_end = str_split($text, 33);

        if (is_array($text_end)) {
            foreach ($text_end as $texts) {
	           return $texts . '<br>';
            }
        } else {

            return $text_end;

        }
    }

    /**
     * Method callback Menu Page
     */
    public function atelierCreateCv($activate_tab = '')
    { ?>


        <!-- Admin Header -->
        <div class="admin-header">

            <div class="admin-logo">
                <figure class="logo">
                    <img class="img-fluid logo" src="<?php echo esc_attr(ATL_CV_PLUGIN_URL . 'assets/img/logo.svg'); ?>"
                         alt="Admin Logo">
                </figure>
            </div>
            <div class="admin-title">
                <h1><?php esc_html_e('Atelier Create CV', 'ateliercv'); ?></h1>
            </div>

            <div class="paypalme">
                <h3><?php esc_html_e('Support me >>>', 'ateliercv' ); ?> </h3>
                <a href="https://paypal.me/mariusz1988?country.x=PL&locale.x=pl_PL" target="_blank"><img src="<?php echo esc_attr(ATL_CV_PLUGIN_URL . 'assets/img/paypalme.png'); ?>"  alt="Support me in the paypal me"></a>
            </div>

        </div><!-- end .admin-header.container-fluid -->


        <div class="wrap">

            <?php settings_errors(); ?>

            <?php

            if (isset($_GET['page'])) {
                $activate_tab = sanitize_text_field($_GET['page']);
            } else {
                $activate_tab = 'atelier_cv';
            }

            ?>


            <h2 class="nav-tab-wrapper">
                <a href="?page=atelier_cv"
                   class="nav-tab <?php echo $activate_tab == 'atelier_cv' ? 'nav-tab-active' : ''; ?>"><?php esc_html_e('Dane personalne', 'ateliercv'); ?></a>
                <a href="?page=ateliercv_pe"
                   class="nav-tab <?php echo $activate_tab == 'ateliercv_pe' ? esc_attr('nav-tab-active') : ''; ?>"><?php esc_html_e('Doświadczenie Zawodowe', 'ateliercv'); ?></a>
                <a href="?page=ateliercv_edu"
                   class="nav-tab <?php echo $activate_tab == 'ateliercv_edu' ? esc_attr('nav-tab-active') : ''; ?>"><?php esc_html_e('Edukacja', 'ateliercv'); ?></a>
                <a href="?page=ateliercv_qf"
                   class="nav-tab <?php echo $activate_tab == 'ateliercv_qf' ? esc_attr('nav-tab-active') : ''; ?>"><?php esc_html_e('Kwalifikacje', 'ateliercv'); ?></a>
            </h2>


            <div class="sections-wrap">

                <div class="sections-wrap-container">
                    <!-- Left Column Prview -->
                    <div class="preview-col">

                        <!-- Preview -->
                        <?php require_once 'template/preview.php'; ?>

                    </div>

                    <!-- Right column form -->
                    <div class="form-col">

                        <?php

                        if ($activate_tab == 'atelier_cv') { ?>

                            <!--Form Personal Data-->
                            <form method="post" action="options.php">

                                <h2><?php esc_html_e('Dane personalne', 'ateliercv'); ?></h2>

                                <?php
                                settings_fields('data_personal_opt_group');
                                do_settings_sections('atl_cv_data_personal_section');
                                require_once 'template/personaldata.php';
                                submit_button(__('Zapisz','ateliercv'));
                                ?>

                            </form>


                        <?php } elseif ($activate_tab == 'ateliercv_pe') { ?>

                            <h1><?php esc_html_e('Doświadczenie zawodowe', 'ateliercv'); ?></h1>

                            <!--Form Professions-->
                            <form method="post" action="">
                                <?php require_once 'template/professionalexperience.php'; ?>
                                <input type="submit" id="btn-pe" value="Zapisz" class="button-primary">
                            </form>

                        <?php } elseif ($activate_tab == 'ateliercv_edu') { ?>

                            <!-- Form Educations -->
                            <form method="post" action="">
                                <?php require_once 'template/education.php'; ?>
                                <input type="submit" id="btn-qf" class="button-primary" value="Zapisz">
                            </form>


                        <?php } elseif ($activate_tab == 'ateliercv_qf') { ?>


                            <!-- Form Qualifications -->
                            <form method="post" action="options.php">

                                <h2><?php esc_html_e('Kwalifikacje', 'ateliercv'); ?></h2>
                                <?php

                                settings_fields('qualifications_opt_group');
                                do_settings_sections('atl_cv_qualifications_section');
                                require_once 'template/qualifications.php';
                                submit_button(__('Zapisz','ateliercv'));
                                ?>
                            </form>
                        <?php } ?>
                    </div>
                </div>

                <div id="print-cv" class="print-cv">
                    <button onclick="pdf()" id="print-btn" class="button button-primary">Pobierz</button>
                </div>

                <div class="buy-coffee">
                    <h3>Support me:</h3>
                    <a href="https://paypal.me/mariusz1988?country.x=PL&locale.x=pl_PL" target="_blank"><img src="<?php echo esc_attr(ATL_CV_PLUGIN_URL . 'assets/img/paypalme.png'); ?>"  alt="Support me in the paypal me"></a>
                </div>

            </div>

        </div>
        <?php

    }
}