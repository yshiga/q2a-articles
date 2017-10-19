<?php

    if ( !defined( 'QA_VERSION' ) ) { // don't allow this page to be requested directly from browser
        header( 'Location: ../' );
        exit;
    }

    class qa_article_page
    {

        private $directory;
        private $urltoroot;


        public function load_module( $directory, $urltoroot )
        {
            $this->directory = $directory;
            $this->urltoroot = $urltoroot;
        }

        public function match_request( $request )
        {
            $requestparts = qa_request_parts();

            return ( !empty( $requestparts )
                && @$requestparts[ 0 ] === 'article'
                && @$requestparts[ 1 ] !== 'sitemap.xml'
            );
        }

        public function process_request( $request )
        {
            qa_set_template( 'article' );

            return require ARTICLES_DIR . '/pages/article.php';
        }
    }


    /*
        Omit PHP closing tag to help avoid accidental output
    */
