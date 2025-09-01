<?php

namespace App\DataTables;

use App\Helpers\AuthCommon;
use App\Helpers\ConstantUtility;
use App\Helpers\Util;
use App\Models\Event;
use Carbon\Carbon;
use Illuminate\Database\Eloquent\Builder as QueryBuilder;
use Yajra\DataTables\EloquentDataTable;
use Yajra\DataTables\Html\Builder as HtmlBuilder;
use Yajra\DataTables\Html\Button;
use Yajra\DataTables\Html\Column;
use Yajra\DataTables\Services\DataTable;

class EventDataTable extends DataTable
{
    /**
     * Build DataTable class.
     *
     * @param QueryBuilder $query Results from query() method.
     * @return \Yajra\DataTables\EloquentDataTable
     */

    public function dataTable(QueryBuilder $query): EloquentDataTable
    {
        return (new EloquentDataTable($query))
            ->addColumn('aksi', function ($data) {
                $html = '<div class="btn-group btn-group-sm" branch="group">';
                $html .= '<button onclick="edit('.$data->id.')" type="button" class="btn btn-sm btn-default" title="Ubah"><i class="fas fa-pen"></i></button>';
                $html .= '<button onclick="destroy('.$data->id.')" type="button" class="btn btn-sm btn-default" title="Hapus"><i class="fas fa-trash"></i></button>';
                $html .= '<button onclick="detail_event('.$data->id.')" type="button" class="btn btn-sm btn-default" title="Detail Event"><i class="fas fa-cog"></i></button>';
                $html .= '</div>';
                return $html;
            })
            ->editColumn('foto', function($item){
                return '<a href="javascript:show_gambar('.$item->id.')" class="btn btn-sm btn-success"><i class="fas fa-camera"></i> Lihat Gambar</a>';
            })
            ->editColumn('waktu_event', function ($data) {
                if ($data->waktu_event) {
                    return Carbon::parse($data->waktu_event)->format('d-m-Y H:i:s');
                }
                return '';
            })
            ->addColumn('lokasi', function($item){
                $html = '';
                if($item->kordinat){
                    $html .= '<a href="javascript:show_lokasi('.$item->id.')" class="mr-2" title="Lihat Lokasi"><i class="fas fa-map-marker-alt text-danger"></i></a>';
                }
                $html .= $item->lokasi;
                return $html;
            })
            ->editColumn('created_at', function ($data) {
                if ($data->created_at) {
                    return Carbon::parse($data->created_at)->format('d-m-Y H:i:s');
                }
                return '';
            })
            ->editColumn('updated_at', function ($data) {
                if ($data->updated_at) {
                    return Carbon::parse($data->updated_at)->format('d-m-Y H:i:s');
                }
                return '';
            })
            ->rawColumns(['aksi', 'foto', 'lokasi', 'status']);
    }

    /**
     * Get query source of dataTable.
     *
     * @param \App\Models\Event $model
     * @return \Illuminate\Database\Eloquent\Builder
     */
    public function query(Event $model): QueryBuilder
    {
        return $model->newQuery();
    }

    /**
     * Get the dataTable columns definition.
     *
     * @return array
     */
    public function getColumns(): array
    {
        return [
            Column::computed('aksi')
                ->title('aksi')
                ->exportable(false)
                ->printable(false)
                ->width(60)
                ->orderable(false)
                ->searchable(false),
            Column::make('foto'),
            Column::make('nama_event'),
            Column::make('waktu_event'),
            Column::make('lokasi'),
            Column::make('created_at'),
            Column::make('updated_at'),
        ];
    }

    /**
     * Get filename for export.
     *
     * @return string
     */
    protected function filename(): string
    {
        return 'Event_' . date('YmdHis');
    }
}
