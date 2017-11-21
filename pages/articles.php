<?php

    if ( !defined( 'QA_VERSION' ) ) { // don't allow this page to be requested directly from browser
        header( 'Location: ../' );
        exit;
    }

    require_once ARTICLES_DIR.'/articles-util.php';

    $qa_content = qa_content_prepare(true);
    $qa_content['title'] = qa_lang_html('articles_lang/articles_page_title'); 

    $ad = new ArticlesData(ARTICLES_YML);
    $articles = $ad->get_articles();
    if (!empty($articles)) {
        $html = '';
        foreach($ad->get_articles() as $article) {
            $html .= articles_util::get_list_item($article);
        }
        $qa_content['custom'] = $html;
    } else {
        $qa_content['custom'] = qa_lang('articles_lang/articles_not_found');
    }

    return $qa_content;
