<?php

class PageService
{
    protected const modelDir = "./views/models/";
    protected const baseUrl = "/"; // a single slash because the url always starts with a slash

    protected const acceptedFileTypes = ["php", "phtml", "html"];

    protected string $url;
    protected array $urlParts;
    protected string $loadedPage;

    function __construct()
    {
        // redirect url if set, otherwise request uri
        $this->url = $_SERVER["REDIRECT_URL"] ?? $_SERVER['REQUEST_URI'];

        // also use parse_url te remove $_GET variables
        $this->url = parse_url($this->url, PHP_URL_PATH);

        // remove trailing slashes
        $this->url = rtrim($this->url, "\/");

        // remove baseurl from url, but only first occurance
        $pos = strpos($this->url, self::baseUrl); //https://stackoverflow.com/a/1252710
        if ($pos !== false) { // if found (false is not found)
            $this->url = substr_replace($this->url, '', $pos, strlen(self::baseUrl));
        }

        // load url parts with parts of the url, by splitting it at every /
        $this->urlParts = explode('/', $this->url);

    }

    function loadModel()
    {
        $toLoad = self::findFile(self::modelDir . $this->url);
        if ( $toLoad ) // if truthy
        {
            $this->loadedPage = $toLoad;
            include $toLoad;
        }
        else // did not find file so...
        {
            $toLoad = self::findFile(self::modelDir . $this->url ."/index"); // ...try to look for index

            if ( $toLoad ) // if truthy
            {
                $this->loadedPage = $toLoad;
                include $toLoad;
            }
            else // did not find file nor index so 404
            {
                $this->loadedPage = $toLoad;
                include self::modelDir . "errors/404.html";
            }
        }
    }

    static function findFile(string $file): ?string
    {
        foreach (self::acceptedFileTypes as $type)
        {
            if ( file_exists("$file.$type") )
            {
                return "$file.$type";
            }
        }
        return false;
    }

    //region getter methods

    function getUrl(): string
    {
        return $this->url;
    }
    function getUrlParts(): array
    {
        return $this->urlParts;
    }
    function getLoadedPage(): string
    {
        return $this->loadedPage;
    }

    //endregion
}