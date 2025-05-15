<?php

namespace App\DataTables;

use App\Models\Permission;
use App\Models\Post;
use Illuminate\Database\Eloquent\Builder as QueryBuilder;
use Yajra\DataTables\EloquentDataTable;
use Yajra\DataTables\Html\Builder as HtmlBuilder;
use Yajra\DataTables\Html\Button;
use Yajra\DataTables\Html\Column;
use Yajra\DataTables\Services\DataTable;
use Illuminate\Support\Str;
class PostsDataTable extends DataTable
{
    public function dataTable(QueryBuilder $query): EloquentDataTable
    {
        return (new EloquentDataTable($query))
            ->setRowId('id')
            ->addColumn('placeholder', '&nbsp;')
            ->editColumn('title', function ($row) {
                return Str::limit($row->getTranslation('title', app()->getLocale()), 30);
            })
            ->editColumn('actions', function ($row) {
            $showGate      = 'backend.blogs.show';
            $editGate      = 'backend.blogs.edit';
            $destroyGate    = 'backend.blogs.destroy';
            $statusGate    = 'backend.blogs.status';

            return view('backend.partials.datatablesActions', compact(
                'statusGate',
                'showGate',
                'editGate',
                'destroyGate',
                'row'
            ));
        })
            ->rawColumns(['placeholder']);
    }

    public function query(Permission $model): QueryBuilder
    {
        return $model->newQuery();
    }

    public function html(): HtmlBuilder
    {
        return $this->builder()
        ->setTableId('permissions_table')
        ->columns($this->getColumns())
        ->minifiedAjax()
        ->orderBy(1)
        ->selectStyleSingle()
        ->responsive()
        ->parameters([
            'paging' => true,
            'searching' => true,
            'info' => true,
            'searchDelay' => 350,
            'language' => [
                'url' => url('/datatables/'.app()->getLocale().'.json'),
            ]
        ])
        ->dom('lBfrtip')
        ->buttons([
            Button::make('csv'),
            Button::make('reload'),
        ]);
    }

    public function getColumns(): array
    {
        return [
            Column::computed('placeholder', ""),
            Column::make('id'),
            Column::make(['data' => 'title', 'title' => __('strings.Title')], 'title'),
            Column::make(['data' => 'name', 'title' =>json_encode(__('strings.Route'), JSON_UNESCAPED_UNICODE)], 'name'),
            Column::computed('actions', __('strings.Actions')),
        ];
    }

    protected function filename(): string
    {
        return 'Permissions_'.date('YmdHis');
    }
}
