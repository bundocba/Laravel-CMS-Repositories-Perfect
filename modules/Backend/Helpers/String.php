<?php

namespace Modules\Backend\Helpers;

class String
{

    public static function lower($str)
    {
        $lower = '|a|b|c|d|e|f|g|h|i|j|k|l|m|n|o|p|q|r|s|t|u|v|w|x|y|z
                            |á|à|ả|ã|ạ|ă|ắ|ặ|ằ|ẳ|ẵ|â|ấ|ầ|ẩ|ẫ|ậ
                            |đ
                            |é|è|ẻ|ẽ|ẹ|ê|ế|ề|ể|ễ|ệ
                            |í|ì|ỉ|ĩ|ị
                            |ó|ò|ỏ|õ|ọ|ô|ố|ồ|ổ|ỗ|ộ|ơ|ớ|ờ|ở|ỡ|ợ
                            |ú|ù|ủ|ũ|ụ|ư|ứ|ừ|ử|ữ|ự
                            |ý|ỳ|ỷ|ỹ|ỵ';

        $upper = '|A|B|C|D|E|F|G|H|I|J|K|L|M|N|O|P|Q|R|S|T|U|V|W|X|Y|Z
                            |Á|À|Ả|Ã|Ạ|Ă|Ắ|Ặ|Ằ|Ẳ|Ẵ|Â|Ấ|Ầ|Ẩ|Ẫ|Ậ
                            |Đ
                            |É|È|Ẻ|Ẽ|Ẹ|Ê|Ế|Ề|Ể|Ễ|Ệ
                            |Í|Ì|Ỉ|Ĩ|Ị
                            |Ó|Ò|Ỏ|Õ|Ọ|Ô|Ố|Ồ|Ổ|Ỗ|Ộ|Ơ|Ớ|Ờ|Ở|Ỡ|Ợ
                            |Ú|Ù|Ủ|Ũ|Ụ|Ư|Ứ|Ừ|Ử|Ữ|Ự
                            |Ý|Ỳ|Ỷ|Ỹ|Ỵ';

        $arrayUpper = explode('|', preg_replace('/\n|\t|\r/', '', $upper));
        $arrayLower = explode('|', preg_replace('/\n|\t|\r/', '', $lower));

        return str_replace($arrayUpper, $arrayLower, $str);
    }

    public static function upper($str)
    {
        $lower = '|a|b|c|d|e|f|g|h|i|j|k|l|m|n|o|p|q|r|s|t|u|v|w|x|y|z
                            |á|à|ả|ã|ạ|ă|ắ|ặ|ằ|ẳ|ẵ|â|ấ|ầ|ẩ|ẫ|ậ
                            |đ
                            |é|è|ẻ|ẽ|ẹ|ê|ế|ề|ể|ễ|ệ
                            |í|ì|ỉ|ĩ|ị
                            |ó|ò|ỏ|õ|ọ|ô|ố|ồ|ổ|ỗ|ộ|ơ|ớ|ờ|ở|ỡ|ợ
                            |ú|ù|ủ|ũ|ụ|ư|ứ|ừ|ử|ữ|ự
                            |ý|ỳ|ỷ|ỹ|ỵ';

        $upper = '|A|B|C|D|E|F|G|H|I|J|K|L|M|N|O|P|Q|R|S|T|U|V|W|X|Y|Z
                            |Á|À|Ả|Ã|Ạ|Ă|Ắ|Ặ|Ằ|Ẳ|Ẵ|Â|Ấ|Ầ|Ẩ|Ẫ|Ậ
                            |Đ
                            |É|È|Ẻ|Ẽ|Ẹ|Ê|Ế|Ề|Ể|Ễ|Ệ
                            |Í|Ì|Ỉ|Ĩ|Ị
                            |Ó|Ò|Ỏ|Õ|Ọ|Ô|Ố|Ồ|Ổ|Ỗ|Ộ|Ơ|Ớ|Ờ|Ở|Ỡ|Ợ
                            |Ú|Ù|Ủ|Ũ|Ụ|Ư|Ứ|Ừ|Ử|Ữ|Ự
                            |Ý|Ỳ|Ỷ|Ỹ|Ỵ';

        $arrayUpper = explode('|', preg_replace('/\n|\t|\r/', '', $upper));
        $arrayLower = explode('|', preg_replace('/\n|\t|\r/', '', $lower));

        return str_replace($arrayLower, $arrayUpper, $str);
    }

    public static function upperFirstLetter($text)
    {
        $arrayChar = explode(' ', $text);

        for ($i = 0; $i < count($arrayChar); $i++) {

            $firstChar = Application_String::upper(substr($arrayChar[$i], 0, 1));

            $followChars = substr($arrayChar[$i], 1);

            $arrayChar[$i] = $firstChar . $followChars;
        }

        return implode(' ', $arrayChar);
    }

    public static function cv2urltitle($text)
    {
        $text = str_replace(
            array(' ', '%', '/', '\\', '"', '?', '<', '>', '#', '^', '`', '\'', '=', '!', ':', ',,', '..', '*', '&', '__', '▄'), array('-', '', '', '', '', '', '', '', '', '', '', '', '-', '', '-', '', '', '', '_', '', ''), $text);

        $chars = array('a', 'A', 'e', 'E', 'o', 'O', 'u', 'U', 'i', 'I', 'd', 'D', 'y', 'Y');

        $uni = array();

        $uni[0] = array('á', 'à', 'ạ', 'ả', 'ã', 'â', 'ấ', 'ầ', 'ậ', 'ẩ', 'ẫ', 'ă', 'ắ', 'ằ', 'ặ', 'ẳ', '� �');
        $uni[1] = array('Á', 'À', 'Ạ', 'Ả', 'Ã', 'Â', 'Ấ', 'Ầ', 'Ậ', 'Ẩ', 'Ẫ', 'Ă', 'Ắ', 'Ằ', 'Ặ', 'Ẳ', '� �');
        $uni[2] = array('é', 'è', 'ẹ', 'ẻ', 'ẽ', 'ê', 'ế', 'ề', 'ệ', 'ể', 'ễ');
        $uni[3] = array('É', 'È', 'Ẹ', 'Ẻ', 'Ẽ', 'Ê', 'Ế', 'Ề', 'Ệ', 'Ể', 'Ễ');
        $uni[4] = array('ó', 'ò', 'ọ', 'ỏ', 'õ', 'ô', 'ố', 'ồ', 'ộ', 'ổ', 'ỗ', 'ơ', 'ớ', 'ờ', 'ợ', 'ở', '� �');
        $uni[5] = array('Ó', 'Ò', 'Ọ', 'Ỏ', 'Õ', 'Ô', 'Ố', 'Ồ', 'Ộ', 'Ổ', 'Ỗ', 'Ơ', 'Ớ', 'Ờ', 'Ợ', 'Ở', '� �');
        $uni[6] = array('ú', 'ù', 'ụ', 'ủ', 'ũ', 'ư', 'ứ', 'ừ', 'ự', 'ử', 'ữ');
        $uni[7] = array('Ú', 'Ù', 'Ụ', 'Ủ', 'Ũ', 'Ư', 'Ứ', 'Ừ', 'Ự', 'Ử', 'Ữ');
        $uni[8] = array('í', 'ì', 'ị', 'ỉ', 'ĩ');
        $uni[9] = array('Í', 'Ì', 'Ị', 'Ỉ', 'Ĩ');
        $uni[10] = array('đ');
        $uni[11] = array('Đ');
        $uni[12] = array('ý', 'ỳ', 'ỵ', 'ỷ', 'ỹ');
        $uni[13] = array('Ý', 'Ỳ', 'Ỵ', 'Ỷ', 'Ỹ');

        for ($i = 0; $i <= 13; $i++)
            $text = str_replace($uni[$i], $chars[$i], $text);

        return strtolower($text);
    }

    public static function bb2html($text)
    {
        $bbCode = array('<', '>',
            '[list]', '[*]', '[/list]',
            '[img]', '[/img]',
            '[b]', '[/b]',
            '[u]', '[/u]',
            '[i]', '[/i]',
            '[color="', '[/color]',
            '[size="', '[/size]',
            '[url="', '[/url]',
            '[mail="', '[/mail]',
            '[code]', '[/code]',
            '[quote]', '[/quote]',
            '"]');

        $htmlCode = array('&lt;', '&gt;',
            '<ul>', '<li>', '</ul>',
            '<img src="', '>',
            '<b>', '</b>',
            '<u>', '</u>',
            '<i>', '</i>',
            '<span style="color:', '</span>',
            '<span style="font-size:', '</span>',
            '<a href="', '</a>',
            '<a href="mailto:', '</a>',
            '<code>', '</code>',
            '<table width="100%" bgcolor="lightgray"><tr><td bgcolor="white">', '</td></tr></table>',
            '">');

        $newText = str_replace($bbCode, $htmlCode, $text);
        $newText = nl2br($newText);

        return $newText;
    }

    public static function removeSign($string, $seperator = '-', $allowANSIOnly = false)
    {
        $pattern = array(
            'a' => 'á|à|ạ|ả|ã|Á|À|Ạ|Ả|Ã|ă|ắ|ằ|ặ|ẳ|ẵ|Ă|Ắ|Ằ|Ặ|Ẳ|Ẵ|â|ấ|ầ|ậ|ẩ|ẫ|Â|Ấ|Ầ|Ậ|Ẩ|Ẫ',
            'o' => 'ó|ò|ọ|ỏ|õ|Ó|Ò|Ọ|Ỏ|Õ|ô|ố|ồ|ộ|ổ|ỗ|Ô|Ố|Ồ|Ộ|Ổ|Ỗ|ơ|ớ|ờ|ợ|ở|ỡ|Ơ|Ớ|Ờ|Ợ|Ở|Ỡ',
            'e' => 'é|è|ẹ|ẻ|ẽ|É|È|Ẹ|Ẻ|Ẽ|ê|ế|ề|ệ|ể|ễ|Ê|Ế|Ề|Ệ|Ể|Ễ',
            'u' => 'ú|ù|ụ|ủ|ũ|Ú|Ù|Ụ|Ủ|Ũ|ư|ứ|ừ|ự|ử|ữ|Ư|Ứ|Ừ|Ự|Ử|Ữ',
            'i' => 'í|ì|ị|ỉ|ĩ|Í|Ì|Ị|Ỉ|Ĩ',
            'y' => 'ý|ỳ|ỵ|ỷ|ỹ|Ý|Ỳ|Ỵ|Ỷ|Ỹ',
            'd' => 'đ|Đ',
        );

        while (list($key, $value) = each($pattern)) {
            $string = preg_replace('/' . $value . '/i', $key, $string);
        }

        if ($allowANSIOnly) {
            $string = strtolower($string);
            $string = preg_replace('/(\w*)(\W+)/i', '$1' . $seperator, $string);
        }

        return $string;
    }

    function stripHtmlTags($text)
    {
        $text = preg_replace(
            array(
            // Remove invisible content
            '@<head[^>]*?>.*?</head>@siu',
            '@<style[^>]*?>.*?</style>@siu',
            '@<script[^>]*?.*?</script>@siu',
            '@<object[^>]*?.*?</object>@siu',
            '@<embed[^>]*?.*?</embed>@siu',
            '@<applet[^>]*?.*?</applet>@siu',
            '@<noframes[^>]*?.*?</noframes>@siu',
            '@<noscript[^>]*?.*?</noscript>@siu',
            '@<noembed[^>]*?.*?</noembed>@siu',
            // Add line breaks before and after blocks
            '@</?((address)|(blockquote)|(center)|(del))@iu',
            '@</?((div)|(h[1-9])|(ins)|(isindex)|(p)|(pre))@iu',
            '@</?((dir)|(dl)|(dt)|(dd)|(li)|(menu)|(ol)|(ul))@iu',
            '@</?((table)|(th)|(td)|(caption))@iu',
            '@</?((form)|(button)|(fieldset)|(legend)|(input))@iu',
            '@</?((label)|(select)|(optgroup)|(option)|(textarea))@iu',
            '@</?((frameset)|(frame)|(iframe))@iu',
            ), array(' ', ' ', ' ', ' ', ' ', ' ', ' ', ' ', ' ', "$0", "$0", "$0", "$0", "$0", "$0", "$0", "$0"), $text);

        // you can exclude some html tags here, in this case B and A tags
        return strip_tags($text, '<b><a>');
    }

    public static function toSlug($string)
    {
        $slug = strtolower(trim(preg_replace('/[^A-Za-z0-9-\.]+/', '-', $string)));
        $slug = str_replace('--', '-', $slug);
        return $slug;
    }

}
