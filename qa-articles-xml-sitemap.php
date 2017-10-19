<?php

    if ( !defined( 'QA_VERSION' ) ) { // don't allow this page to be requested directly from browser
        header( 'Location: ../' );
        exit;
    }

    class qa_articles_xml_sitemap
    {

        private $directory;
        private $urltoroot;


        public function load_module( $directory, $urltoroot )
        {
            $this->directory = $directory;
            $this->urltoroot = $urltoroot;
        }

        public function suggest_requests() // for display in admin interface
        {
            return array(
                array(
                    'title' => qa_lang('articles_lang/xml_sitemap'),
                    'request' => '/article/sitemap.xml',
                    'nav'     => null, // 'M'=main, 'F'=footer, 'B'=before main, 'O'=opposite main, null=none
                ),
            );
        }

        public function match_request( $request )
        {
            $requestparts = qa_request_parts();

            return ( !empty( $requestparts )
                && @$requestparts[ 0 ] === 'article'
                && @$requestparts[ 1 ] === 'sitemap.xml'
            );
        }

        public function process_request( $request )
        {
            @ini_set( 'display_errors', 0 ); // we don't want to show PHP errors inside XML

            return require ARTICLES_DIR . '/pages/xml-sitemap.php';
        }
    }


    /*
        Omit PHP closing tag to help avoid accidental output
    */
