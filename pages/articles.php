<?php

    if ( !defined( 'QA_VERSION' ) ) { // don't allow this page to be requested directly from browser
        header( 'Location: ../' );
        exit;
    }
    require_once(ARTICLES_DIR .'/vendor/spyc/Spyc.php');

    $qa_content = qa_content_prepare(true);
    $qa_content['title'] = 'まとめページ一覧'; 

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
        $qa_content = include QA_INCLUDE_DIR.'qa-page-not-found.php';
    }

    return $qa_content;

/*
 * 設定ファイルから情報を取得
 */
function get_articles()
{
    $articles = Spyc::YAMLLoad(ARTICLES_DIR . '/articles.yml');
    return $articles;
}