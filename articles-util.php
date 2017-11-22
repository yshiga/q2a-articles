<?php

class articles_util
{
    /*
    * htmlフィアルのパス
    */
    public static function get_html_path($page)
    {
        return ARTICLES_DIR . '/html/' . $page . '.html';
    }

    /*
    * 他のまとめ記事のリストを取得
    */
    public static function get_list_html($ad, $page)
    {
        $title = qa_lang('articles_lang/list_title');
        $html = '<h3 class="mdl-typography--headline">'.$title.'</h3>';
        foreach($ad->get_articles() as $article) {
            if ($page !== $article['path']) {
                $html .= self::get_list_item($article);
            }
        }

        return $html;
    }

    /*
    * 個別の記事取得
    */
    public static function get_list_item($article)
    {
        $template_path = self::get_html_path('article_list_item');
        $template = file_get_contents($template_path);
        $url = qa_path('article/'.$article['path'], null, qa_opt('site_url'));
        $file = self::get_html_path($article['path']);
        if (file_exists($file)) {
            $html = file_get_contents($file);
            $image = self::get_item_image($html);
            if ($image) {
                $image_style = 'background-image:none;min-height:150px;';
                $lazy_load = 'lazyload';
                $data_src = 'data-src="'.$image.'"';
            } else {
                $image_style = '';
                $lazy_load = '';
                $data_src = '';
            }
            $content = self::get_item_content($html);
            $format = qa_lang('articles_lang/updated_format');
            $updated = date ($format, filemtime($file));
        } else {
            return '';
        }
        $params = array(
            '^url' => $url,
            '^lazyload' => $lazy_load,
            '^image_style' => $image_style,
            '^data_src' => $data_src,
            '^title' => $article['title'],
            '^content' => $content,
            '^updated' => $updated,
        );
        return strtr($template, $params);
    }

    /*
    * 記事内の文章を取得
    */
    public static function get_item_content($html)
    {
        $regex = '/<p class=\"mdl-typography--subhead\">(.+)<\/p>/i';
        if (preg_match($regex, $html, $matches)) {
            $ret = $matches[1];
            $ret = mb_strimwidth($ret, 0, 170, "...", "utf-8");
        } else {
            $ret = '';
        }
        return $ret;
    }

    /*
    * 記事内の画像を取得
    */
    public static function get_item_image($html)
    {
        $regex = '/<img [^>]* src=\"(.*)\"[^>]*>/i';
        if (preg_match($regex, $html, $matches)) {
            $ret = $matches[1];
        } else {
            $ret = '';
        }
        return $ret;
    }

}