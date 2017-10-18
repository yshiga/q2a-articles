<?php

    if ( !defined( 'QA_VERSION' ) ) { // don't allow this page to be requested directly from browser
        header( 'Location: ../' );
        exit;
    }
    require_once(ARTICLES_DIR .'/vendor/spyc/Spyc.php');

    $qa_content = qa_content_prepare(true);
    $page = qa_request_part(1);

    $article = exists_article_page($page);
    if (!empty($article)) {
        $qa_content['title'] = @$article['title'];
        $html = '<p>'.$page.'のまとめページ</p>';
        $qa_content['custom'] = $html;
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
 * 設定ファイルに一致するpathがあるか
 */
function exists_article_page($page)
{
    $articles = Spyc::YAMLLoad(ARTICLES_DIR . '/articles.yml');
    $ret = array();
    foreach ($articles as $article) {
        if($article['path'] === $page) {
            $ret = $article;
            break;
        }
    }
    return $ret;
}