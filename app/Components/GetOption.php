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

    public  function OptionDanhMuc($parentId, $id = 0, $text = '')
    {
        foreach ($this->data as $value) {
            if ($value['parent_id'] == $id) {
                if (!empty($parentId) && $parentId == $value['id'])
                    $this->htmlSelect .=  "<option selected value='" . $value['id'] . "'> " . $text . $value["ten_dm"] . "</option>";
                else
                    $this->htmlSelect .=  "<option value='" . $value['id'] . "'> " . $text . $value["ten_dm"] . "</option>";
                $this->OptionDanhMuc($parentId, $value['id'], $text . '--');
            }
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
