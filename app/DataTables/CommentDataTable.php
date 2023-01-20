<?php

namespace App\DataTables;

use App\Models\Category;
use App\Models\Comment;
use App\Traits\DataTableAssetsTrait;
use Illuminate\Support\Facades\Auth;
use Yajra\DataTables\Html\Button;
use Yajra\DataTables\Html\Column;
use Yajra\DataTables\Services\DataTable;

class CommentDataTable extends DataTable
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

            ->addColumn('action', function ($query) {
                $item = [
                    'action'=>route('comments.destroy',$query->id),
                    "can" =>true
                ];
                return view('partials.delete-btn',compact('item'));
            })
            ->rawColumns(['action']);
    }

    /**
     * Get query source of dataTable.
     *
     * @param \App\Models\Comment $model
     * @return \Illuminate\Database\Eloquent\Builder
     */
    public function query(Comment $model)
    {

        return $model->where('user_id',Auth::id())->newQuery();
    }

    /**
     * Optional method if you want to use html builder.
     *
     * @return \Yajra\DataTables\Html\Builder
     */
    public function html()
    {
        return $this->builder()
                    ->setTableId('categories-table')
                    ->columns($this->getColumns())
                    ->minifiedAjax()
                    ->orderBy(1)
                    ->selectStyleSingle()
                    ->buttons(           
                        Button::make('excel')->addClass('border border-white'),
                        Button::make('csv')->addClass('border border-white'),
                        // Button::make('pdf'),
                        Button::make('print')->addClass('border border-white'),
                        Button::make('reset')->addClass('border border-white'),
                        Button::make('reload')->addClass('border border-white'),);

    }

    /**
     * Get columns.
     *
     * @return array
     */
    protected function getColumns()
    {
        return [
            Column::make('comment')->title('Comment'),
            Column::make('date')->title('Date')->content('-'),
            Column::computed('action')->title( 'Actions')->content('-')->exportable(false)
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
        return 'Comment_'.date('YmdHis');
    }
}
