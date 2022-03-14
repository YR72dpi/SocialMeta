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
            "img_folder_parent" => ".",
            "img_param" => [
                "img_format_ignore" => false,
                "default_img" => null
            ]
        ];

        if (!file_exists("socialMeta_param.json")) {
            file_put_contents("socialMeta_param.json", json_encode($fileParam));
        }
    }

    public function __construct(string $url, string $title, string $description) {
        $this->fileParam = json_decode(file_get_contents("socialMeta_param.json"), 1);

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

    public function setGoogleImg (string $url){
        
    }

    public function setOgImg (string $url){
        
    }

    public function setTwitterImg (string $url){
        
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
	    
        $print .= "<meta itemprop='image'            content='"."d"."'>";

	    $print .= "<!-- Facebook -->";
        $print .= "<meta property='og:title'         content='".$title."' />";
	    $print .= "<meta property='og:url'           content='".$url."' />";
        $print .= "<meta property='og:description'   content='".$description."' />";

        $print .= "<meta property='og:image'         content='"."d"."'>";

        $print .= "<meta property='og:type'          content='website' />";

        $print .= "<!-- Twitter -->";
        $print .= "<meta name='twitter:title'         content='".$title."'>";
        $print .= "<meta name='twitter:url'           content='".$url."' />";
        $print .= "<meta name='twitter:description'   content='".$description."'>";

        $print .= "<meta name='twitter:image'         content='"."d"."'>";

        $print .= "<meta name='twitter:card'          content='summary_large_image'>";
        
        echo htmlspecialchars($print);
    }
    
}



?>