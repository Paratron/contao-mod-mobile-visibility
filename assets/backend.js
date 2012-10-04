/**
 * Toggle the mobile visibility of an element
 * @param object
 * @param string
 * @param string
 * @return boolean
 */
AjaxRequest.toggleMobileVisibility = function (el, id, table) {
    el.blur();
    var img = null;
    var image = $(el).getFirst('img');
    var publish = (image.src.indexOf('invisible') != -1);
    var div = el.getParent('div');

    // Send request
    if (publish) {
        image.src = image.src.replace('mobile-invisible.png', 'mobile-visible.png');
        new Request({'url':window.location.href}).get({'item':id, 'mobile_state':1});
    } else {
        image.src = image.src.replace('mobile-visible.png', 'mobile-invisible.png');
        new Request({'url':window.location.href}).get({'item':id, 'mobile_state':0});
    }

    return false;
}

/**
 * Toggle the desktop visibility of an element
 * @param object
 * @param string
 * @param string
 * @return boolean
 */
AjaxRequest.toggleDesktopVisibility = function (el, id, table) {
    el.blur();
    var img = null;
    var image = $(el).getFirst('img');
    var publish = (image.src.indexOf('invisible') != -1);
    var div = el.getParent('div');

    // Send request
    if (publish) {
        image.src = image.src.replace('desktop-invisible.png', 'desktop-visible.png');
        new Request({'url':window.location.href}).get({'item':id, 'desktop_state':1});
    } else {
        image.src = image.src.replace('desktop-visible.png', 'desktop-invisible.png');
        new Request({'url':window.location.href}).get({'item':id, 'desktop_state':0});
    }

    return false;
}