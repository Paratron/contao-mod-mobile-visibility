<?php

//Extend tl_page
array_insert($GLOBALS['TL_DCA']['tl_page']['list']['operations'], 5,
    array(
         'toggle_mobile' => array
         (
             'label' => &$GLOBALS['TL_LANG']['tl_page']['toggle_mobile'],
             'icon' => 'system/modules/kiss_mobile-visibility/assets/mobile-visible.png',
             'attributes' => 'onclick="Backend.getScrollOffset();return AjaxRequest.toggleMobileVisibility(this,%s)"',
             'button_callback' => array(
                 'kiss_mobile_visibility_helper',
                 'toggleMobileIcon'
             )
         ),
    )
);

array_insert($GLOBALS['TL_DCA']['tl_page']['list']['operations'], 5,
    array(
         'toggle_desktop' => array
         (
             'label' => &$GLOBALS['TL_LANG']['tl_page']['toggle_desktop'],
             'icon' => 'system/modules/kiss_mobile-visibility/assets/desktop-visible.png',
             'attributes' => 'onclick="Backend.getScrollOffset();return AjaxRequest.toggleDesktopVisibility(this,%s)"',
             'button_callback' => array(
                 'kiss_mobile_visibility_helper',
                 'toggleDesktopIcon'
             )
         ),
    )
);

$GLOBALS['TL_DCA']['tl_page']['fields']['mobile_invisible'] = array
(
    'label' => &$GLOBALS['TL_LANG']['tl_page']['mobile_invisible'],
    'exclude' => true,
    'inputType' => 'checkbox',
    'sql' => "char(1) NOT NULL default ''",
    'eval' => array(
        'tl_class' => 'w50'
    )
);

$GLOBALS['TL_DCA']['tl_page']['fields']['desktop_invisible'] = array
(
    'label' => &$GLOBALS['TL_LANG']['tl_page']['desktop_invisible'],
    'exclude' => true,
    'inputType' => 'checkbox',
    'sql' => "char(1) NOT NULL default ''",
    'eval' => array(
        'tl_class' => 'w50'
    )
);

//@TODO: remove this monkey patch
//Fiddle the field into the tl_page palettes:
foreach ($GLOBALS['TL_DCA']['tl_page']['palettes'] as $k => $v) {
    $GLOBALS['TL_DCA']['tl_page']['palettes'][$k] = str_replace('published,', 'published,mobile_invisible,desktop_invisible,', $v);
}

/**
 * Hacking that to be used as AJAX stuff.
 * In theory, this has already been applied in tht tl_content.php but we have to include it twice.
 */
//@TODO: propably a bad way to weasel additional AJAX functionality into the backend. Find another way.
if (isset($_GET['mobile_state'])) {
    $this->import('kiss_mobile_visibility_helper');
    $this->kiss_mobile_visibility_helper->toggleMobileState();
}
if (isset($_GET['desktop_state'])) {
    $this->import('kiss_mobile_visibility_helper');
    $this->kiss_mobile_visibility_helper->toggleDesktopState();
}