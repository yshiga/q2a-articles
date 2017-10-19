<?php

require_once(ARTICLES_DIR.'/vendor/spyc/Spyc.php');

class ArticlesData {
    private $articles;
    private $paths;
    private $titles;

    public function __construct($yml)
    {
        $this->articles = array();
        $this->paths = array();
        $this->titles = array();
        if (file_exists($yml)) {
            $this->articles = Spyc::YAMLLoad($yml);
            $this->paths = array_column($this->articles, 'path');
            $this->titles = array_column($this->articles, 'title', 'path');
        }
    }

    /*
     * YMLから読み込んだarticles配列を返す
     */
    public function get_articles()
    {
        return $this->articles;
    }

    /*
     * $page が path に存在するかチェック
     */
    public function exists_path($page)
    {
        return in_array($page, $this->paths);
    }

    /*
     * $page の title を返す
     */
    public function get_article_title($page)
    {
        if(array_key_exists($this->titles, $page)) {
            return $this->titles[$page];
        } else {
            return '';
        }
    }

}