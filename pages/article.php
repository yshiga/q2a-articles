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
