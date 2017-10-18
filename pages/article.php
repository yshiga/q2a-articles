<?php

    if ( !defined( 'QA_VERSION' ) ) { // don't allow this page to be requested directly from browser
        header( 'Location: ../' );
        exit;
    }

    $qa_content = qa_content_prepare(true);
    $page = qa_request_part(1);
    $html = "";
    $html .= "<p>".$page."</p>";
    $qa_content['title'] = $page."のまとめページ";
    $qa_content['custom'] = $html;

    return $qa_content;