<?php

    if ( !defined( 'QA_VERSION' ) ) { // don't allow this page to be requested directly from browser
        header( 'Location: ../' );
        exit;
    }
    require_once(ARTICLES_DIR .'/vendor/spyc/Spyc.php');

    $qa_content = qa_content_prepare(true);
    $page = qa_request_part(1);

    $ret = exists_article_page($page);
    if (!empty($ret)) {
        $qa_content['title'] = @$ret['title'];
        $html = '<p>'.$page.'のまとめページ</p>';
        $qa_content['custom'] = $html;
    } else {
        $qa_content = include QA_INCLUDE_DIR.'qa-page-not-found.php';
    }

    return $qa_content;


function articles_get_html_path($page)
{
    return ARTICLES_DIR . '/html/' . $page . '.html';
}

function exists_article_page($page)
{
    $articles = Spyc::YAMLLoad(ARTICLES_DIR . '/articles.yml');
    $ret = array();
    foreach ($articles as $article) {
        if($article['path'] === $page) {
            $ret = $article;
        }
    }
    return $ret;
}