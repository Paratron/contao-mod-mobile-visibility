<?php

//Extend tl_content
array_insert($GLOBALS['TL_DCA']['tl_content']['list']['operations'], 5,
    array(
         'toggle_mobile' => array
         (
             'label' => &$GLOBALS['TL_LANG']['tl_content']['toggle_mobile'],
             'icon' => 'system/modules/kiss_mobile-visibility/assets/mobile-visible.png',
             'attributes' => 'onclick="Backend.getScrollOffset();return AjaxRequest.toggleMobileVisibility(this,%s)"',
             'button_callback' => array(
                 'kiss_mobile_visibility_helper',
                 'toggleMobileIcon'
             )
         ),
    )
);

array_insert($GLOBALS['TL_DCA']['tl_content']['list']['operations'], 5,
    array(
         'toggle_desktop' => array
         (
             'label' => &$GLOBALS['TL_LANG']['tl_content']['toggle_desktop'],
             'icon' => 'system/modules/kiss_mobile-visibility/assets/desktop-visible.png',
             'attributes' => 'onclick="Backend.getScrollOffset();return AjaxRequest.toggleDesktopVisibility(this,%s)"',
             'button_callback' => array(
                 'kiss_mobile_visibility_helper',
                 'toggleDesktopIcon'
             )
         ),
    )
);

/*$GLOBALS['TL_DCA']['tl_content']['fields']['invisible']['eval'] = array(
    'tl_class' => 'w50'
);*/

$GLOBALS['TL_DCA']['tl_content']['fields']['mobile_invisible'] = array
(
    'label' => &$GLOBALS['TL_LANG']['tl_content']['mobile_invisible'],
    'exclude' => true,
    'filter' => true,
    'inputType' => 'checkbox',
    'sql' => "char(1) NOT NULL default ''",
    'eval' => array(
        'tl_class' => 'w50'
    )
);

$GLOBALS['TL_DCA']['tl_content']['fields']['desktop_invisible'] = array
(
    'label' => &$GLOBALS['TL_LANG']['tl_content']['desktop_invisible'],
    'exclude' => true,
    'filter' => true,
    'inputType' => 'checkbox',
    'sql' => "char(1) NOT NULL default ''",
    'eval' => array(
        'tl_class' => 'w50'
    )
);

//@TODO: remove this monkey patch
//Fiddle the field into the tl_content palettes:
foreach ($GLOBALS['TL_DCA']['tl_content']['palettes'] as $k => $v) {
    $GLOBALS['TL_DCA']['tl_content']['palettes'][$k] = str_replace('invisible,', 'invisible,mobile_invisible,desktop_invisible,', $v);
}


/**
 * Hacking that to be used as AJAX stuff x)
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