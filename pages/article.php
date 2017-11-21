<?php

    if ( !defined( 'QA_VERSION' ) ) { // don't allow this page to be requested directly from browser
        header( 'Location: ../' );
        exit;
    }

    $qa_content = qa_content_prepare(true);
    $page = qa_request_part(1);

    $ad = new ArticlesData(ARTICLES_YML);
    if ($ad->exists_path($page)) {
        $qa_content['title'] = $ad->get_article_title($page);
        $file = articles_get_html_path($page);
        if (file_exists($file)) {
            $html = file_get_contents($file);
            $qa_content['custom'] = $html;
        } else {
            $qa_content['custom'] = qa_lang('articles_lang/file_not_found');
        }
        $qa_content['article_list'] = articles_get_list_html($ad, $page);
    } else {
        $qa_content = include QA_INCLUDE_DIR.'qa-page-not-found.php';
    }

    return $qa_content;

/*
 * htmlフィアルのパス
 */
function articles_get_html_path($page)
{
    return ARTICLES_DIR . '/html/' . $page . '.html';
}

function articles_get_list_html($ad, $page)
{
    $title = qa_lang('articles_lang/list_title');
    $html = '<h3 class="mdl-typography--headline">'.$title.'</h3>';
    foreach($ad->get_articles() as $article) {
        if ($page !== $article['path']) {
            $html .= articles_get_list_item($article);
        }
    }

    return $html;
}

function articles_get_list_item($article)
{
    $template_path = articles_get_html_path('article_list_template');
    $template = file_get_contents($template_path);
    $url = qa_path('article/'.$article['path'], null, qa_opt('site_url'));
    $file = articles_get_html_path($article['path']);
    if (file_exists($file)) {
        $html = file_get_contents($file);
        $image = articles_get_item_image($html);
        if ($image) {
            $image_style = 'background-image:url('.$image.');min-height:150px;';
        } else {
            $image_style = '';
        }
        $content = articles_get_item_content($html);
        $updated = date ("更新日： Y年m月d日", filemtime($file));
    } else {
        return '';
    }
    $params = array(
        '^url' => $url,
        '^image_style' => $image_style,
        '^title' => $article['title'],
        '^content' => $content,
        '^updated' => $updated,
    );
    return strtr($template, $params);
}

function articles_get_item_content($html)
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

function articles_get_item_image($html)
{
    $regex = '/<img [^>]* src=\"(.*)\"[^>]*>/i';
    if (preg_match($regex, $html, $matches)) {
        $ret = $matches[1];
    } else {
        $ret = '';
    }
    return $ret;
}