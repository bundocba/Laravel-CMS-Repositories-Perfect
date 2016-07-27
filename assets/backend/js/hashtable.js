
    function Hashtable() {

        this.hashtable = new Array();

        this.clear = function() {
            this.hashtable = new Array();
        }

        this.containsKey = function(key) {
            var exists = false;
            for (var i in this.hashtable) {
                if (i == key && this.hashtable[i] != null) {
                    exists = true;
                    break;
                }
            }
            return exists;
        }

        this.containsValue = function(value) {
            var contains = false;
            if (value != null) {
                for (var i in this.hashtable) {
                    if (this.hashtable[i] == value) {
                        contains = true;
                        break;
                    }
                }
            }
            return contains;
        }

        this.get = function(key) {
            return this.hashtable[key];
        }

        this.isEmpty = function() {
            return (parseInt(this.size()) == 0) ? true : false;
        }

        this.keys = function() {
            var keys = new Array();
            for (var i in this.hashtable) {
                if (this.hashtable[i] != null) {
                    keys.push(i);
                }
            }
            return keys;
        }

        this.put = function(key, value) {
            if (key == null || value == null) {
                throw "NullPointerException {" + key + "},{" + value + "}";
            } else {
                this.hashtable[key] = value;
            }
        }

        this.remove = function(key) {
            var rtn = this.hashtable[key];
            this.hashtable[key] = null;
            return rtn;
        }

        this.size = function() {
            var size = 0;
            for (var i in this.hashtable) {
                if (this.hashtable[i] != null) {
                    size ++;
                }
            }
            return size;
        }

        this.toString = function() {
            var result = '';
            for (var i in this.hashtable) {
                if (this.hashtable[i] != null) {
                    result += '{' + i + '},{' + this.hashtable[i] + '}\r\n';
                }
            }
            return result;
        }

        this.values = function() {
            var values = new Array();
            for (var i in this.hashtable) {
                if (this.hashtable[i] != null) {
                    values.push(this.hashtable[i]);
                }
            }
            return values;
        }
    }