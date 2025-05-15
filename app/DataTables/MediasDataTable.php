<?php

namespace App\DataTables;

use App\Models\Media;
use Illuminate\Database\Eloquent\Builder as QueryBuilder;
use Illuminate\Support\Arr;
use Yajra\DataTables\EloquentDataTable;
use Yajra\DataTables\Html\Builder as HtmlBuilder;
use Yajra\DataTables\Html\Column;
use Yajra\DataTables\Services\DataTable;
use Illuminate\Support\Str;
class MediasDataTable extends DataTable
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
            ->editColumn('source', function ($row) {
                if (Arr::get($row->getTranslations('source'), app()->getLocale()) === null) {
                    $keys = array_keys($row->getTranslations('source'));
                    return __('strings.TranslationSource'). ' ('. __('strings.Translated') . implode(', ', $keys). ')';
                } else {
                    return Str::limit($row->getTranslation('source', app()->getLocale()), 30);
                }
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
                $statusGate      = 'backend.medias.status';
                $showGate      = 'backend.medias.show';
                $editGate      = 'backend.medias.edit';
                $destroyGate    = 'backend.medias.destroy';

                return view('backend.partials.datatablesActions', compact(
                    'statusGate',
                    'showGate',
                    'editGate',
                    'destroyGate',
                    'row'
                ));
            });
    }

    public function query(Media $model): QueryBuilder
    {
        return $model->newQuery();
    }

    public function html(): HtmlBuilder
    {
        return $this->builder()
            ->setTableId('medias_table')
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
            Column::make(['data' => 'source', 'title' => __('strings.Source')], 'source')->orderable(false),
            Column::make(['data' => 'created_at', 'title' => __('strings.Create Date')], 'created_at'),
            Column::computed('images', __('strings.Images')),
            Column::computed('actions', __('strings.Actions'))->width(250),
        ];
    }

    protected function filename(): string
    {
        return 'Medias_'.date('YmdHis');
    }
}
