<?php
require_once 'function.php';
class img_data
{
    public $id;
    public $img_path;
    public $upload_date;
    public $mainTag;
    public $secondaryTag;
    public $ArtistTag;
    public $anotherTag;
    public $creat_user_id;
    public $check_img_type;
    public $ispublic;
    public $source;

    function __construct( $id)
    {
        $this->id = $id;
    }
}
class singleIMGdb extends img_data
{
    function dis()
    {
        return $this->creat_user_id;
    }
    function query_img_db()
    {
        $sel = "SELECT * FROM `img_data`  WHERE `id` = {$this->id}";
        $img = queryimgids($sel);
        $this->img_path = $img[0]['img_path'];
        $this->upload_date = $img[0]['upload_date'];
        $this->mainTag = $img[0]['mainTag'];
        $this->secondaryTag = $img[0]['secondaryTag'];
        $this->ArtistTag = $img[0]['ArtistTag'];
        $this->anotherTag= $img[0]['anotherTag'];
        $this->creat_user_id = $img[0]['creat_user_id'];
        $this->check_img_type = $img[0]['check_img_type'];

        if ($img[0]['ispublic'] == "public") $this->ispublic = "公開";
        else $this->ispublic = "私人";

        $this->source = $img[0]['source'];
    }
}

