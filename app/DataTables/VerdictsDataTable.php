<?php

namespace App\DataTables;

use App\Models\Verdict;
use Illuminate\Database\Eloquent\Builder as QueryBuilder;
use Illuminate\Support\Arr;
use Yajra\DataTables\EloquentDataTable;
use Yajra\DataTables\Html\Builder as HtmlBuilder;
use Yajra\DataTables\Html\Column;
use Yajra\DataTables\Services\DataTable;
use Illuminate\Support\Str;

class VerdictsDataTable extends DataTable
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
            ->editColumn('parent_id', function ($row) {
                if ($row->rowParent === null) {
                    return __('strings.General Verdict Without');
                } else {
                    return $row->rowParent ? Str::limit($row->rowParent->getTranslation('title', app()->getLocale()), 30) : "";
                }

            })
            ->editColumn('created_at', function ($row) {
                return $row->created_at->format('d-m-Y h:i:s');
            })
            ->editColumn('actions', function ($row) {
                $statusGate      = 'backend.verdicts.status';
                $showGate      = 'backend.verdicts.show';
                $editGate      = 'backend.verdicts.edit';
                $destroyGate    = 'backend.verdicts.destroy';

            return view('backend.partials.datatablesActions', compact(
                'statusGate',
                'showGate',
                'editGate',
                'destroyGate',
                'row'
            ));
        });
    }

    public function query(Verdict $model): QueryBuilder
    {
        return $model->where("id", ">", 0)->newQuery();
    }

    public function html(): HtmlBuilder
    {
        return $this->builder()
        ->setTableId('verdicts_table')
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
            Column::make(['data' => 'parent_id', 'title' => __('strings.General Verdict')], 'parent_id'),
            Column::make(['data' => 'created_at', 'title' => __('strings.Create Date')], 'created_at'),
            Column::computed('actions', __('strings.Actions'))->width(250),
        ];
    }

    protected function filename(): string
    {
        return 'Verdicts_'.date('YmdHis');
    }
}
