<?php

namespace App\Traits;

use Yajra\DataTables\Html\Column;
use Yajra\DataTables\Html\Editor\Editor;
use Yajra\DataTables\Html\Editor\Fields;

trait DataTableAssetsTrait
{
    public function EditDeleteButtons($row,$arr)
    {
        $item_edit = [
            "can" => true,
            "href" => route($arr['name'] . '.edit', $row->id)
        ];
        $item_delete = [
            "can" => true ,
            // auth()->user()->can('delete.'. $arr['can'] ),
            "action" => route($arr['name'] . '.destroy', $row->id),
        ];
        return '<span style="display:flex">' .
            view('partials.edit-btn', ["item" => $item_edit]) .
            view('partials.delete-btn', ["item" => $item_delete]) .
            '</span>';
    }
   
  
}
