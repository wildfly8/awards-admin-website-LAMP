<?php

namespace Vonzo\Views;

/**
 * The view class which generates the views
 */
class View {

    /**
     * The site settings from the DB
     * @var array
     */
    protected $settings;

    /**
     * The language array
     * @var array
     */
    protected $lang;

    /**
     * The current URL path (route) array to be passed to the controllers
     * @var array
     */
    public $url;

    /**
     * The site metadata
     * @var array   An array containing various metadata attributes
     *              Array Map: Metadata => Mixed(Values)
     */
    public $metadata;

    public function __construct($settings, $language, $url) {
        $this->settings = $settings;
        $this->lang = $language;
        $this->url = $url;
    }

    /**
     * @param	array	$data	The data to be passed to the view template
     * @param	string	$view	The file path / name of the view
     * @return	string
     */
    public function render($data = [], $view = null) {
        // General variables used site-wide
        $data['settings']       = $this->settings;
        $data['year']           = date('Y');
        $data['url'] 		        = URL_PATH;
        $data['theme_path']     = THEME_PATH;
        $data['cookie']         = $_COOKIE;
        $lang = $this->lang;

        /**
         * Start the output buffer
         * This is needed to create the template inheritance
         */
        ob_start();

        // Do not use %_once as some of the template files may need to be called multiple times
        $path = sprintf('%s/../../%s/%s/%s/views/%s.php', __DIR__, PUBLIC_PATH, THEME_PATH, $this->settings['site_theme'], $view);
        require($path);

        return ob_get_clean();
    }

    /**
     * @return string
     */
    public function message() {
        $messages = null;

        // If a message exists
        if(isset($_SESSION['message'])) {
            // Render the message
            foreach($_SESSION['message'] as $key => $value) {
                $data['message'] = ['type' => $value[0], 'content' => $value[1]];
                $messages .= $this->render($data, 'shared/message');
            }
        }

        // Remove the message
        unset($_SESSION['message']);

        return $messages;
    }

    /**
     * @return string
     */
    public function token() {
      if (isset( $_SESSION['token_id'] )) {
        $data['token_id'] = $_SESSION['token_id'];
      } else {
        $data['token_id'] = "";
      }
      return $this->render($data, 'shared/token');
    }

    /**
     * @return string
     */
    public function docTitle() {
        // If the controller/method has additional title information
        if(isset($this->metadata['title'])) {
            $titleTrim = trim("".$this->metadata['title'][0]);
            $title = $this->metadata['title'][0] . " - " . SITE_NAME;
        } else {
            $title = $this->settings['site_title'];
        }
        return $title;
    }

    public function docMetaDesc() {
        // If the controller/method has additional title information
        if(isset($this->metadata['metaDesc'])) {
            $desc = $this->metadata['metaDesc'];

        } else {
            $desc = "";
        }
        return $desc;
    }
}
