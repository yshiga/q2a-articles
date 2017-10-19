<?php

    if ( !defined( 'QA_VERSION' ) ) { // don't allow this page to be requested directly from browser
        header( 'Location: ../' );
        exit;
    }

    $siteurl = qa_opt( 'site_url' );
    $ad = new ArticlesData(ARTICLES_YML);
    $articles = $ad->get_articles();
    if (empty($articles)) {
        return null;
    }

    header( 'Content-type: text/xml; charset=utf-8' );

    echo '<?xml version="1.0" encoding="UTF-8"?>' . "\n";
    echo '<urlset xmlns="http://www.sitemaps.org/schemas/sitemap/0.9">' . "\n";
    // まとめページ
    foreach ($articles as $article) {
        sitemap_output('article/'.$article['path'], $siteurl, 0.1);
    }
    // 一覧ページ
    sitemap_output('artcles', $siturl, 0.5);
    echo "</urlset>\n";
    return null;

function sitemap_output( $request, $siteurl, $priority )
{
    echo "\t<url>\n" .
        "\t\t<loc>" . qa_xml( qa_path( $request, null, qa_opt( 'site_url' ) ) ) . "</loc>\n" .
        "\t\t<priority>" . max( 0, min( 1.0, $priority ) ) . "</priority>\n" .
        "\t</url>\n";
}