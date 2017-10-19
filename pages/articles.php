<?php

    if ( !defined( 'QA_VERSION' ) ) { // don't allow this page to be requested directly from browser
        header( 'Location: ../' );
        exit;
    }
    require_once(ARTICLES_DIR .'/vendor/spyc/Spyc.php');

    $qa_content = qa_content_prepare(true);
    $qa_content['title'] = qa_lang_html('articles_lang/articles_page_title'); 

    $articles = get_articles();
    $html = "";
    if (!empty($articles)) {
        $html = "<ul>";
        foreach ($articles as $article) {
            $url = qa_path('article/'.$article['path'], null, qa_opt('site_url'));
            $html .= '<li><a href="'.$url.'">'.$article['title'].'</a></li>';
        }
        $html .= "</ul>";
        $qa_content['custom'] = $html;
    } else {
        $qa_content['custom'] = qa_lang('articles_lang/articles_not_found');
    }

    return $qa_content;

/*
 * 設定ファイルから情報を取得
 */
function get_articles()
{
    $articles = array();
    $yml = ARTICLES_DIR.'/articles.yml';
    if (file_exists($yml)) {
        $articles = Spyc::YAMLLoad($yml);
    }
    return $articles;
}