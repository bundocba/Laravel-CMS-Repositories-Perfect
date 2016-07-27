    
    function setCookie(name, value, days) {
        var expires = '';
        if (days) {
            var d = new Date();
            d.setTime(d.getTime() + days * 24 * 60 * 60 * 1000);
            expires = '; expires=' + d.toGMTString();
        }
        document.cookie = name + '=' + value + expires + '; path=/';
    }

    function getCookie(name) {
        var re = new RegExp('(\;|^)[^;]*(' + name + ')\=([^;]*)(;|$)');
        var res = re.exec(document.cookie);
        return res != null ? res[3] : null;
    }

    function deleteCookie(name, path, domain) {
        if ( getCookie(name) ) document.cookie = name + '=' +
        ((path) ? ';path=' + path : '') +
        ((domain) ? ';domain=' + domain : '') +
        ';expires=Thu, 01-Jan-1970 00:00:01 GMT';
    }
