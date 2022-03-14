<?php

class SocialMeta {
    /* ------------------------------------------------ *\
            Private
    \* ------------------------------------------------ */
    // ___ VAR ___

    private $fileParam;

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

    private function remote_file_exists($url) {
        ini_set('allow_url_fopen', '1');
        try {
            @fclose(@fopen($url, 'r'));
            $exists =  true;
        } catch (\Throwable $th) {
            $exists =  false;
        }
        return $exists;
    }

    private function fileFind($url) {
        if (preg_match("/^https?:\/\/.*(\..*)/i", $url)) {
            if ($this->remote_file_exists($url)) {
                $this->SocialImages['google_img'] = $url;
                return $url;
            }else {
                return false;
            }
        } else {
            $path = $this->fileParam["img_folder_parent"].$this->fileParam["img_param"]["default_img"]."/socialMeta_img/".$url;
            if (file_exists($path)) {
                $this->SocialImages['google_img'] = $path;
                return $path;
            }else {
                return false;
            }
        }
    }

    /* ------------------------------------------------ *\
            Public
    \* ------------------------------------------------ */
    // ___ VAR ___

    /**
     * none
     */

    // ___ FUNCTION ___

    public static function install(){
        
        $fileParam = [
            "img_folder_parent" => "false",
            "img_param" => [
                "img_format_ignore" => false,
                "default_img" => ""
            ]
        ];

        if (!file_exists("socialMeta_param.json")) {
            file_put_contents("socialMeta_param.json", json_encode($fileParam));
        }
    }

    public function __construct(string $url, string $title, string $description) {
        $this->fileParam = json_decode(file_get_contents("socialMeta_param.json"), 1);
        
        // Verify if the images folder parent exists
        $ifp = $this->fileParam["img_folder_parent"];
        $ifp_given = ($ifp == "false") ? throw new Exception("You have to set the images folder parent on line 10", 1) : true;
        
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

    public function setGoogleImg (string $url){
        $file = $this->fileFind($url);
        if ($file) {
            $this->SocialImages["google_img"] = $file;
            return true;
        } else {
            throw new Exception("No file find", 1);
        }
    }

    public function setOgImg (string $url){
        $file = $this->fileFind($url);
        if ($file) {
            $this->SocialImages["og_img"] = $file;
            return true;
        } else {
            throw new Exception("No file find", 1);
        }
    }

    public function setTwitterImg (string $url){
        $file = $this->fileFind($url);
        if ($file) {
            $this->SocialImages["twitter_twitter"] = $file;
            return true;
        } else {
            throw new Exception("No file find", 1);
        }
    }
    
    public function setSameImg (string $url) {
        $file = $this->fileFind($url);
        if ($file) {
            $this->SocialImages["google_img"] = $file;
            $this->SocialImages["og_img"] = $file;
            $this->SocialImages["twitter_img"] = $file;
            return true;
        } else {
            throw new Exception("No file find", 1);
        }
    }

    /**
     * Getter
     */

    public function getCheckList(){
    }

    public function print() {
        $url = $this->commonParam['url'];
        $title = $this->commonParam['title'];
        $description = $this->commonParam['description'];


        $print = "<!-- Google+ -->";
	    $print .= "<meta itemprop='name'             content='".$title."'>";
	    $print .= "<meta itemprop='description'      content='".$description."'>";
	    
        $print .= "<meta itemprop='image'            content='".$this->SocialImages["google_img"]."'>";

	    $print .= "<!-- Facebook -->";
        $print .= "<meta property='og:title'         content='".$title."' />";
	    $print .= "<meta property='og:url'           content='".$url."' />";
        $print .= "<meta property='og:description'   content='".$description."' />";

        $print .= "<meta property='og:image'         content='".$this->SocialImages["og_img"]."'>";

        $print .= "<meta property='og:type'          content='website' />";

        $print .= "<!-- Twitter -->";
        $print .= "<meta name='twitter:title'        content='".$title."'>";
        $print .= "<meta name='twitter:url'          content='".$url."' />";
        $print .= "<meta name='twitter:description'  content='".$description."'>";

        $print .= "<meta name='twitter:image'        content='".$this->SocialImages["twitter_img"]."'>";

        $print .= "<meta name='twitter:card'         content='summary_large_image'>";
        
        echo htmlspecialchars($print);
    }
    
}



?>