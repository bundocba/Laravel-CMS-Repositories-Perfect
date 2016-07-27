
    function isIE() {
        var browserName = navigator.appName;
        if (browserName == 'Microsoft Internet Explorer') {
            return true;
        } else {
            return false;
        }
    }

    function redirect(url) {
        if (isIE()) {
            var referLink = document.createElement('a');
            referLink.href = url;
            document.body.appendChild(referLink);
            referLink.click();
        } else {
            document.location = url;
        }
    }

    function checkAll(state) {
        var items = $("*[name='itm[]']");
        for (var i = 0; i < items.length; i++) {
            items[i].checked = state;
        }
    }

    function toogleDiv(div, value) {
        $('#' + div).css('display', value != true ? '' : 'none');
    }

    var popUpWin = 0;
    function popUpWindow(url, left, top, width, height) {
        if (popUpWin) {
            if (!popUpWin.closed) popUpWin.close();
        }
        popUpWin = open(url, 'popUpWin', 'toolbar=no,location=no,directories=no,status=no,menubar=no,scrollbars=no,resizable=no,copyhistory=yes,width=' + width + ',height=' + height + ',left=' + left + ', top=' + top + ',screenX=' + left + ',screenY=' + top + '');
    }

    function removeParam(url, paramName) {

        var s = url.indexOf(paramName + '=');

        if (s < 0) return url;

        var e = url.indexOf('&', s);
        e++;

        if (e == 0) {
            e = url.length;
        }

        url = url.substring(0, s) + url.substring(e, url.length);

        if (url.length > 1) {
            var lastChar = url.charAt(url.length - 1);
            if (lastChar == '?' || lastChar == '&') {
                url = url.substring(0, url.length - 1);
            }
        }
        
        return url;
    }

    function setParam(url, paramName, paramValue) {

        url = removeParam(url, paramName);

        if (url.indexOf('?') > -1) {
            url = url + '&' + paramName + '=' + paramValue;
        } else {
            url = url + '?' + paramName + '=' + paramValue;
        }

        return url;
    }
    
    