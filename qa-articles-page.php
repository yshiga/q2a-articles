<?php

    if ( !defined( 'QA_VERSION' ) ) { // don't allow this page to be requested directly from browser
        header( 'Location: ../' );
        exit;
    }

    class qa_articles_page
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
                    'request' => '/articles',
                    'nav'     => 'null', // 'M'=main, 'F'=footer, 'B'=before main, 'O'=opposite main, null=none
                ),
            );
        }

        public function match_request( $request )
        {
            $requestparts = qa_request_parts();

            return ( !empty( $requestparts )
                && @$requestparts[ 0 ] === 'articles'
            );
        }

        public function process_request( $request )
        {
            qa_set_template( 'articles' );
            $qa_content = qa_content_prepare(true);
            $qa_content['title'] = "まとめページ";
            $page = qa_request_part(1);
            $html = "<p>hello articles page.</p>";
            $html .= "<p>".$page."</p>";
            $qa_content['custom'] = $html;
            return $qa_content;
            // return require ARTICLES_DIR . '/pages/articles.php';
        }
    }


    /*
        Omit PHP closing tag to help avoid accidental output
    */
