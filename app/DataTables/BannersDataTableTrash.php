<?php

namespace App\DataTables;

use App\Models\Banner;
use Illuminate\Database\Eloquent\Builder as QueryBuilder;
use Illuminate\Support\Arr;
use Yajra\DataTables\EloquentDataTable;
use Yajra\DataTables\Html\Builder as HtmlBuilder;
use Yajra\DataTables\Html\Column;
use Yajra\DataTables\Services\DataTable;
use Illuminate\Support\Str;

class BannersDataTableTrash extends DataTable
{
    public function dataTable(QueryBuilder $query): EloquentDataTable
    {
        return (new EloquentDataTable($query))
            ->setRowId('id')
            ->editColumn('title', function ($row) {
                if (Arr::get($row->getTranslations('title'), app()->getLocale()) === null) {
                    return __('strings.TranslationPermission'). ' ('. __('strings.Translated') . implode(', ', $row->locales()). ')';
                } else {
                    return Str::limit($row->getTranslation('title', app()->getLocale()), 30);
                }
            })
            ->editColumn('created_at', function ($row) {
                return $row->created_at->format('d-m-Y h:i:s');
            })
            ->editColumn('zone', function ($row) {
                return $row->zone = $row->zone == 1 ? 'Top Banner' : 'Bottom Banner';
            })
            ->editColumn('actions', function ($row) {
                $restoreGate      = 'backend.banners.restore';
                $removeGate    = 'backend.banners.remove';

                return view('backend.partials.datatablesActionsTrash', compact(
                    'restoreGate',
                    'removeGate',
                    'row'
                ));
            });
    }

    public function query(Banner $model): QueryBuilder
    {
        return $model->onlyTrashed()->newQuery();
    }

    public function html(): HtmlBuilder
    {
        return $this->builder()
            ->setTableId('banners_table')
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
            Column::make(['data' => 'title', 'title' => __('strings.Title')], 'title')->orderable(false),
            Column::make(['data' => 'zone', 'title' => __('strings.Zone')], 'zone')->orderable(false),
            Column::make(['data' => 'created_at', 'title' => __('strings.Create Date')], 'created_at'),
            Column::computed('actions', __('strings.Actions'))->width(200),
        ];
    }

    protected function filename(): string
    {
        return 'BannersTrash_'.date('YmdHis');
    }
}
