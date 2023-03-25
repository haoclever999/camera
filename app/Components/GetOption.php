<?php

namespace App\Components;

class GetOption
{
    private $data;
    private $htmlSelect = '';
    public function __construct($data)
    {
        $this->data = $data;
    }
    public function OptionDanhMuc($id)
    {
        foreach ($this->data as $value) {
            if ($value["id"] == $id)
                $this->htmlSelect .=  "<option selected value='" . $value['id'] . "'> " . $value["ten_dm"] . "</option>";
            else
                $this->htmlSelect .=  "<option value='" . $value['id'] . "'> " . $value["ten_dm"] . "</option>";
        }
        return $this->htmlSelect;
    }
    public function OptionThuongHieu($id)
    {
        foreach ($this->data as $value) {
            if ($value["id"] == $id)
                $this->htmlSelect .=  "<option selected value='" . $value['id'] . "'> " . $value["ten_thuong_hieu"] . "</option>";
            else
                $this->htmlSelect .=  "<option value='" . $value['id'] . "'> "  . $value["ten_thuong_hieu"] . "</option>";
        }
        return $this->htmlSelect;
    }
}
