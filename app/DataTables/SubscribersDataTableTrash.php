<?php

namespace App\DataTables;

use App\Models\Subscriber;
use Illuminate\Database\Eloquent\Builder as QueryBuilder;
use Illuminate\Support\Arr;
use Yajra\DataTables\EloquentDataTable;
use Yajra\DataTables\Html\Builder as HtmlBuilder;
use Yajra\DataTables\Html\Column;
use Yajra\DataTables\Services\DataTable;
use Illuminate\Support\Str;

class SubscribersDataTableTrash extends DataTable
{
    public function dataTable(QueryBuilder $query): EloquentDataTable
    {
        return (new EloquentDataTable($query))
            ->setRowId('id')
            ->editColumn('actions', function ($row) {
                $restoreGate      = 'backend.subscribers.restore';
                $removeGate    = 'backend.subscribers.remove';

                return view('backend.partials.datatablesActionsTrash', compact(
                    'restoreGate',
                    'removeGate',
                    'row'
                ));
            });
    }

    public function query(Subscriber $model): QueryBuilder
    {
        return $model->onlyTrashed()->newQuery();
    }

    public function html(): HtmlBuilder
    {
        return $this->builder()
            ->setTableId('subscribers_table')
            ->columns($this->getColumns())
            ->minifiedAjax()
            ->orderBy(0)
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
            ]);
    }

    public function getColumns(): array
    {
        return [
            Column::make('id')->width(50),
            Column::make(['data' => 'email', 'title' => __('strings.Email')], 'email')->orderable(false),
            Column::computed('actions', __('strings.Actions'))->width(200),
        ];
    }

    protected function filename(): string
    {
        return 'SubscribersTrash_'.date('YmdHis');
    }
}
