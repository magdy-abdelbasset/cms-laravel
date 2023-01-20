<?php

namespace App\DataTables;

use App\Models\Post;
use App\Traits\DataTableAssetsTrait;
use Illuminate\Support\Facades\Auth;
use Yajra\DataTables\Html\Button;
use Yajra\DataTables\Html\Column;
use Yajra\DataTables\Services\DataTable;

class PostDataTable extends DataTable
{
    use DataTableAssetsTrait;

    /**
     * Build DataTable class.
     *
     * @param mixed $query Results from query() method.
     * @return \Yajra\DataTables\DataTableAbstract
     */
    public function dataTable($query)
    {
        return datatables()
            ->eloquent($query)
            ->addColumn('image', function ($query) {
                $image = $query->image;
                return !empty($query->image) ?  view("partials.img",compact('image')) : '';
            })
            ->addColumn('action', function ($query) {
                return $this->EditDeleteButtons($query, array(
                    'can' => 'posts',
                    'name' => 'posts'
                ));
            })
            ->rawColumns(['action']);
    }

    /**
     * Get query source of dataTable.
     *
     * @param \App\Models\Post $model
     * @return \Illuminate\Database\Eloquent\Builder
     */
    public function query(Post $model)
    {
        return $model->where('author',Auth::id())->newQuery();
    }

    /**
     * Optional method if you want to use html builder.
     *
     * @return \Yajra\DataTables\Html\Builder
     */
    public function html()
    {
        return $this->builder()
                    ->setTableId('posts-table')
                    ->columns($this->getColumns())
                    ->minifiedAjax()
                    ->orderBy(1)
                    ->selectStyleSingle()
                    ->buttons(   
                        Button::make('add')->addClass('btn-dark')            ,
                        Button::make('excel')->addClass('border border-white'),
                        Button::make('csv')->addClass('border border-white'),
                        // Button::make('pdf'),
                        Button::make('print')->addClass('border border-white'),
                        Button::make('reset')->addClass('border border-white'),
                        Button::make('reload')->addClass('border border-white'));

    }

    /**
     * Get columns.
     *
     * @return array
     */
    protected function getColumns()
    {
        return [
            Column::make('title')->title('Title'),
            Column::make('content')->title('Content')->content('-'),
            Column::make('date')->title('Date')->content('-'),
            Column::computed('image')->title('Image')->content('-')->exportable(false)
            ->printable(false)->width(100),
            Column::computed('action')->title("Actions")->content('-')->exportable(false)
            ->printable(false)
            ->width(60)
            ->addClass('text-center'),
        ];

    }

    /**
     * Get filename for export.
     *
     * @return string
     */
    // protected function filename()
    // {
    //     return '' . date('YmdHis');
    // }
    protected function filename(): string
    {
        return 'Posts_'.date('YmdHis');
    }
}
