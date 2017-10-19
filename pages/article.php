<?php

    if ( !defined( 'QA_VERSION' ) ) { // don't allow this page to be requested directly from browser
        header( 'Location: ../' );
        exit;
    }
    require_once(ARTICLES_DIR .'/vendor/spyc/Spyc.php');

    $qa_content = qa_content_prepare(true);
    $page = qa_request_part(1);

    $article = get_article_data($page);
    if (!empty($article)) {
        $qa_content['title'] = @$article['title'];
        $file = articles_get_html_path($page);
        if (file_exists($file)) {
            $html = file_get_contents($file);
            $qa_content['custom'] = $html;
        } else {
            $qa_content['custom'] = qa_lang('articles_lang/file_not_found');
        }
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

/*
 * 設定ファイルから$pageに該当する情報を取得
 */
function get_article_data($page)
{
    $articles = array();
    $yml = ARTICLES_DIR.'/articles.yml';
    if (file_exists($yml)) {
        $articles = Spyc::YAMLLoad($yml);
    }
    $ret = array();
    foreach ($articles as $article) {
        if($article['path'] === $page) {
            $ret = $article;
            break;
        }
    }
    return $ret;
}