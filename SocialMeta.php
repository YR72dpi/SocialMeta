<?php

class SocialMeta {
    /* ------------------------------------------------ *\
            Private
    \* ------------------------------------------------ */
    // ___ VAR ___

    private $fileParam = [
            "img_folder_parent" => ".",
            "img_format_ignore" => false
    ];

    private $commonParam = [
            "url" => null,
            "title" => null,
            "description" => null
    ];

    private $SocialImages = [
        "google_img" => null,
        "og_img" => null,
        "twitter_img" => null
    ];

    /**
     * can check if the values is correct in function "checkList"
     */
    private function check(){
        
    }


    // ___ FUNCTION ___

    /* ------------------------------------------------ *\
            Public
    \* ------------------------------------------------ */
    // ___ VAR ___

    /**
     * none
     */

    // ___ FUNCTION ___

    public function __construct(string $url, string $title, string $description) {
        $ifp = $this->fileParam["img_folder_parent"];
        $ifp_given = ($ifp == false) ? throw new Exception("<strong> You have to set the images folder parent on line 10</strong>", 1) : true;
        
        if ($ifp_given && file_exists($ifp)) {
            if (!file_exists($ifp."/socialMeta_img")) {
                mkdir($ifp."/socialMeta_img");
            }
        } else {
            throw new Exception($ifp." doesn't exists", 1);  
        }

        $this->commonParam = [
            "url" => $url,
            "title" => $title,
            "description" => $description
        ];

    }

    /**
     * Setter
     */

    
    /**
     * Getter
     */

    public function checkList(){

    }
    
}

$meta = new SocialMeta("http://www.ylanrousselle.fr/", "Portfolio", "Bienvenue sur mon portfolio");

?>