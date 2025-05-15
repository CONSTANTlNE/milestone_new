<?php

namespace App\DataTables;

use App\Models\Article;
use Illuminate\Database\Eloquent\Builder as QueryBuilder;
use Illuminate\Support\Arr;
use Yajra\DataTables\EloquentDataTable;
use Yajra\DataTables\Html\Builder as HtmlBuilder;
use Yajra\DataTables\Html\Column;
use Yajra\DataTables\Services\DataTable;
use Illuminate\Support\Str;

class VersusDataTable extends DataTable
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
                    return Str::limit($row->getTranslation('title', app()->getLocale()), 50);
                }
            })
            ->editColumn('verdict_id', function ($row) {
                return $row->verdict_id ? Str::limit($row->verdict()->first()->getTranslation('title', app()->getLocale()), 50) : '-';
            })
            ->filterColumn('verdict_id', function ($query, $keyword) {
                $query->whereHas('verdict', function ($query) use ($keyword) {
                    $query->where('title', 'like', "%{$keyword}%");
                });
            })
            ->editColumn('verdict_versus_id', function ($row) {
                return $row->verdict_versus_id ? Str::limit($row->verdictVersus()->first()->getTranslation('title', app()->getLocale()), 50) : '-';
            })
            ->filterColumn('verdict_versus_id', function ($query, $keyword) {
                $query->whereHas('verdictVersus', function ($query) use ($keyword) {
                    $query->where('title', 'like', "%{$keyword}%");
                });
            })
            ->editColumn('user_id', function ($row) {
                return $row->user_id ? Str::limit($row->reporter()->first()->getTranslation('title', app()->getLocale()), 50) : '-';
            })
            ->filterColumn('user_id', function ($query, $keyword) {
                $query->whereHas('reporter', function ($query) use ($keyword) {
                    $query->where('title', 'like', "%{$keyword}%");
                });
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
                $statusGate      = 'backend.versus.status';
                $showGate        = 'backend.versus.show';
                $editGate        = 'backend.versus.edit';
                $destroyGate     = 'backend.versus.destroy';

            return view('backend.partials.datatablesActions', compact(
                'statusGate',
                'showGate',
                'editGate',
                'destroyGate',
                'row'
            ));
        });
    }

    public function query(Article $model): QueryBuilder
    {
        return $model->newQuery()->where('type', 3);
    }

    public function html(): HtmlBuilder
    {
        return $this->builder()
        ->setTableId('articles_table')
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
            Column::make(['data' => 'user_id', 'title' => __('strings.Author')], 'user_id')->orderable(false),
            Column::make(['data' => 'verdict_id', 'title' => __('strings.Verdict')], 'verdict_id')->orderable(false),
            Column::make(['data' => 'verdict_versus_id', 'title' => __('strings.Verdict')], 'verdict_versus_id')->orderable(false),
            Column::make(['data' => 'created_at', 'title' => __('strings.Create Date')], 'created_at'),
            Column::computed('images', __('strings.Images')),
            Column::computed('actions', __('strings.Actions'))->width(250),
        ];
    }

    protected function filename(): string
    {
        return 'Articles_'.date('YmdHis');
    }
}
