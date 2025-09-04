<?php

namespace App\DataTables;

use App\Helpers\AuthCommon;
use App\Helpers\ConstantUtility;
use App\Helpers\Util;
use App\Models\Event;
use App\Models\Transaksi;
use Carbon\Carbon;
use Illuminate\Database\Eloquent\Builder as QueryBuilder;
use Yajra\DataTables\EloquentDataTable;
use Yajra\DataTables\Html\Builder as HtmlBuilder;
use Yajra\DataTables\Html\Button;
use Yajra\DataTables\Html\Column;
use Yajra\DataTables\Services\DataTable;

class PesananPenggunaDataTable extends DataTable
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
                $html .= '</div>';
                return $html;
            })
            ->editColumn('bukti_transaksi', function($item){
                return '<a href="javascript:show_gambar('.$item->id.')" class="btn btn-sm btn-success"><i class="fas fa-camera"></i> Lihat Gambar</a>';
            })
            ->editColumn('status_transaksi', function($data){
                return Util::status_transaksi($data->status_transaksi);
            })
            ->editColumn('total_harga', function($data){
                return Util::rupiah(@$data->total_harga ?? 0);
            })
            ->editColumn('rejected_at', function ($data) {
                if ($data->rejected_at) {
                    return Carbon::parse($data->rejected_at)->format('d-m-Y H:i:s');
                }
                return '';
            })
            ->editColumn('approved_at', function ($data) {
                if ($data->approved_at) {
                    return Carbon::parse($data->approved_at)->format('d-m-Y H:i:s');
                }
                return '';
            })
            ->rawColumns(['aksi', 'bukti_transaksi', 'status_transaksi']);
    }

    /**
     * Get query source of dataTable.
     *
     * @param \App\Models\Transaksi $model
     * @return \Illuminate\Database\Eloquent\Builder
     */
    public function query(Transaksi $model): QueryBuilder
    {
        $query = $model->newQuery()->with('user')->with('approver')->with('rejector');
        return $query;
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
            Column::make('nomor_transaksi'),
            Column::make('bukti_transaksi'),
            Column::make('status_transaksi'),
            Column::make('kuantitas'),
            Column::make('total_harga'),
            Column::make('approved_at'),
            Column::make('approved_by'),
            Column::make('rejected_at'),
            Column::make('rejected_by'),

        ];
    }

    /**
     * Get filename for export.
     *
     * @return string
     */
    protected function filename(): string
    {
        return 'Transaksi_' . date('YmdHis');
    }
}
