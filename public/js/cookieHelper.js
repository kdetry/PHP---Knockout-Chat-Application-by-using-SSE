/**
 * This Class is a helper for cookie Actions
 * @returns {cookieHelper}
 */

var cookieHelper = function () {};


/**
 * Set a cookie value
 *
 * @param name
 * @param value
 * @param days      OPTIONAL
 * @param path      OPTIONAL
 */

cookieHelper.prototype.setProperty = function (name, value, days, path) {
    console.log(name);
    if (days) {
        var date = new Date();
        date.setTime(date.getTime() + (days * 24 * 60 * 60 * 1000));
        var expires = "; expires=" + date.toGMTString();
    } else
        var expires = "";

    var dir = path || '/';
    document.cookie = name + "=" + value + expires + "; path=" + dir;
};


/**
 * get a cookie value
 *
 * @param name
 * @return String|null
 */
cookieHelper.prototype.getProperty = function (name) {
    var nameEquals = name + "=";
    var ca = document.cookie.split(';');
    for (var i = 0; i < ca.length; i++) {
        var c = ca[i];
        while (c.charAt(0) == ' ')
            c = c.substring(1, c.length);
        if (c.indexOf(nameEquals) == 0)
            return c.substring(nameEquals.length, c.length);
    }
    return null;
};


/**
 * Remove a cookie
 *
 * @param name
 */
cookieHelper.prototype.remove = function (name) {
    this.set(name, "", -1);
};