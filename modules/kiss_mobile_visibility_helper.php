<?php
/**
 * Mobile Visibility Helper
 * ========================
 * This helper class provides functions to decide which icons are rendered in the backend,
 * to toggle the mobi/desk visible state for content-elements, articles and pages and
 * to provide "gatekeeper" functions which control the appearance of above elements on the frontend.
 *
 * @author: Christian Engel <hello@wearekiss.com>
 * @version: 1 04.10.12
 */

class kiss_mobile_visibility_helper extends Backend {
    /**
     * Import the back end user object
     */
    public function __construct() {
        parent::__construct();
        $this->import('BackendUser', 'User');
    }

    /**
     * Return the "toggle mobile visibility" icon with correct state for the backend.
     * @param array
     * @param string
     * @param string
     * @param string
     * @param string
     * @param string
     * @return string
     */
    public function toggleMobileIcon($row, $href, $label, $title, $icon, $attributes) {
        // Check permissions AFTER checking the tid, so hacking attempts are logged
        if (!$this->User->isAdmin && !$this->User->hasAccess('tl_content::mobile_invisible', 'alexf')) {
            return '';
        }

        $href .= '&amp;id=' . Input::get('id') . '&amp;tid=' . $row['id'] . '&amp;state=' . $row['mobile_invisible'];

        if ($row['mobile_invisible']) {
            $icon = 'system/modules/kiss_mobile-visibility/assets/mobile-invisible.png';
        }

        return '<a href="' . $this->addToUrl($href) . '" title="' . specialchars($title) . '"' . $attributes . '>' . $this->generateImage($icon, $label) . '</a> ';
    }

    /**
     * Return the "toggle desktop visibility" icon with correct state for the backend.
     * @param array
     * @param string
     * @param string
     * @param string
     * @param string
     * @param string
     * @return string
     */
    public function toggleDesktopIcon($row, $href, $label, $title, $icon, $attributes) {
        // Check permissions AFTER checking the tid, so hacking attempts are logged
        if (!$this->User->isAdmin && !$this->User->hasAccess('tl_content::desktop_invisible', 'alexf')) {
            return '';
        }

        $href .= '&amp;id=' . Input::get('id') . '&amp;tid=' . $row['id'] . '&amp;state=' . $row['desktop_invisible'];

        if ($row['desktop_invisible']) {
            $icon = 'system/modules/kiss_mobile-visibility/assets/desktop-invisible.png';
        }

        return '<a href="' . $this->addToUrl($href) . '" title="' . specialchars($title) . '"' . $attributes . '>' . $this->generateImage($icon, $label) . '</a> ';
    }

    /**
     * Switch the mobile visibility state of an element.
     */
    public function toggleMobileState() {
        $do = $_GET['do'];
        if ($do == 'article') {
            $table_name = 'tl_article';
            if (isset($_GET['table'])) {
                $table_name = $_GET['table'];
            }
        }
        if ($do == 'page') {
            $table_name = 'tl_page';
        }

        $table_id = (int)$_GET['item'];
        $mobile_state = (bool)$_GET['mobile_state'];

        // Check permissions AFTER checking the tid, so hacking attempts are logged
        if (!$this->User->isAdmin && !$this->User->hasAccess($table_name . '::mobile_invisible', 'alexf')) {
            return '';
        }

        $sql = 'UPDATE ' . $table_name . ' SET mobile_invisible = ' . (($mobile_state) ? '0' : '1') . ' WHERE id = ' . $table_id . ' LIMIT 1;';
        $this->Database->query($sql);
    }

    /**
     * Switch the desktop visibility state of an element.
     */
    public function toggleDesktopState() {
        $do = $_GET['do'];
        if ($do == 'article') {
            $table_name = 'tl_article';
            if (isset($_GET['table'])) {
                $table_name = $_GET['table'];
            }
        }
        if ($do == 'page') {
            $table_name = 'tl_page';
        }
        $table_id = (int)$_GET['item'];
        $desktop_state = (bool)$_GET['desktop_state'];

        // Check permissions AFTER checking the tid, so hacking attempts are logged
        if (!$this->User->isAdmin && !$this->User->hasAccess($table_name . '::desktop_invisible', 'alexf')) {
            return '';
        }

        $sql = 'UPDATE ' . $table_name . ' SET desktop_invisible = ' . (($desktop_state) ? '0' : '1') . ' WHERE id = ' . $table_id . ' LIMIT 1;';
        $this->Database->query($sql);
    }

    /**
     * This is called before a content element is rendered on the frontend.
     * @param $objElement
     * @param $strBuffer
     * @return string
     */
    public function gateKeeperContent($objElement, $strBuffer) {
        if (TL_MODE == 'BE') {
            return $strBuffer;
        }

        $is_mobile = \Environment::get('agent')->mobile;

        if ($objElement->mobile_invisible && $is_mobile) {
            return '';
        }

        if ($objElement->desktop_invisible && !$is_mobile) {
            return '';
        }

        return $strBuffer;
    }

    /**
     * This is called before a article is rendered on the frontpage.
     * @param $objArticle
     * @return mixed
     */
    public function gateKeeperArticle($objArticle) {
        if (TL_MODE == 'BE') {
            return;
        }

        $is_mobile = \Environment::get('agent')->mobile;

        if ($objArticle->mobile_invisible && $is_mobile) {
            $objArticle->published = FALSE;
        }

        if ($objArticle->desktop_invisible && !$is_mobile) {
            $objArticle->published = FALSE;
        }
    }

    /**
     * This is called before a menu gets rendered and will remove page entities which should be hidden.
     * @param $obj
     */
    public function gateKeeperPage($obj) {
        $is_mobile = \Environment::get('agent')->mobile;

        $new = array();

        if (is_array($obj->items)) {
            for($k = 0; $k < count($obj->items); $k++){
                if ($obj->items[$k]['mobile_invisible'] && $is_mobile) {
                    continue;
                }

                if ($obj->items[$k]['desktop_invisible'] && !$is_mobile) {
                    continue;
                }

                $new[] = $obj->items[$k];
            }

            $obj->items = $new;
        }
    }
}