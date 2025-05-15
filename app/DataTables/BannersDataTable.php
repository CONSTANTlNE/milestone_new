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
class BannersDataTable extends DataTable
{
    public function dataTable(QueryBuilder $query): EloquentDataTable
    {
        return (new EloquentDataTable($query))
            ->setRowId('id')
            ->editColumn('title', function ($row) {
                if (Arr::get($row->getTranslations('title'), app()->getLocale()) === null) {
                    $keys = array_keys($row->getTranslations('title'));
                    return __('strings.TranslationTitle'). ' ('. __('strings.Translated') . implode(', ', $keys). ')';
                } else {
                    return Str::limit($row->getTranslation('title', app()->getLocale()), 30);
                }
            })
            ->editColumn('zone', function ($row) {
                return $row->zone = $row->zone == 1 ? 'Top Banner' : 'Bottom Banner';
            })
            ->editColumn('created_at', function ($row) {
                return $row->created_at->format('d-m-Y h:i:s');
            })
            ->editColumn('images', function ($row) {
                return view('backend.partials.datatablesImages', compact(
                    'row'
                ));
            })
            ->editColumn('actions', function ($row) {
                $statusGate      = 'backend.banners.status';
                $showGate      = 'backend.banners.show';
                $editGate      = 'backend.banners.edit';
                $destroyGate    = 'backend.banners.destroy';

                return view('backend.partials.datatablesActions', compact(
                    'statusGate',
                    'showGate',
                    'editGate',
                    'destroyGate',
                    'row'
                ));
            });
    }

    public function query(Banner $model): QueryBuilder
    {
        return $model->newQuery()->orderBy('position', 'asc');
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
            Column::computed('images', __('strings.Images')),
            Column::computed('actions', __('strings.Actions'))->width(250),
        ];
    }

    protected function filename(): string
    {
        return 'Banners_'.date('YmdHis');
    }
}
