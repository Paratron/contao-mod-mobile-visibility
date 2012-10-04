<?php

//Extend tl_article
array_insert($GLOBALS['TL_DCA']['tl_article']['list']['operations'], 5,
    array(
         'toggle_mobile' => array
         (
             'label' => &$GLOBALS['TL_LANG']['tl_article']['toggle_mobile'],
             'icon' => 'system/modules/kiss_mobile-visibility/assets/mobile-visible.png',
             'attributes' => 'onclick="Backend.getScrollOffset();return AjaxRequest.toggleMobileVisibility(this,%s)"',
             'button_callback' => array(
                 'kiss_mobile_visibility_helper',
                 'toggleMobileIcon'
             )
         ),
    )
);

array_insert($GLOBALS['TL_DCA']['tl_article']['list']['operations'], 5,
    array(
         'toggle_desktop' => array
         (
             'label' => &$GLOBALS['TL_LANG']['tl_article']['toggle_desktop'],
             'icon' => 'system/modules/kiss_mobile-visibility/assets/desktop-visible.png',
             'attributes' => 'onclick="Backend.getScrollOffset();return AjaxRequest.toggleDesktopVisibility(this,%s)"',
             'button_callback' => array(
                 'kiss_mobile_visibility_helper',
                 'toggleDesktopIcon'
             )
         ),
    )
);


$GLOBALS['TL_DCA']['tl_article']['fields']['mobile_invisible'] = array
(
    'label' => &$GLOBALS['TL_LANG']['tl_article']['mobile_invisible'],
    'exclude' => true,
    'filter' => true,
    'inputType' => 'checkbox',
    'sql' => "char(1) NOT NULL default ''",
    'eval' => array(
        'tl_class' => 'w50'
    )
);

$GLOBALS['TL_DCA']['tl_article']['fields']['desktop_invisible'] = array
(
    'label' => &$GLOBALS['TL_LANG']['tl_article']['desktop_invisible'],
    'exclude' => true,
    'filter' => true,
    'inputType' => 'checkbox',
    'sql' => "char(1) NOT NULL default ''",
    'eval' => array(
        'tl_class' => 'w50'
    )
);

//@TODO: remove this monkey patch
//Fiddle the field into the tl_article palettes:
foreach ($GLOBALS['TL_DCA']['tl_article']['palettes'] as $k => $v) {
    $GLOBALS['TL_DCA']['tl_article']['palettes'][$k] = str_replace('published,', 'published,mobile_invisible,desktop_invisible,', $v);
}


//AJAX Stuff is handled in tl_content DCA at the bottom.