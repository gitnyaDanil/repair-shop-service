@extends('App')

@section('content-header', 'Daftar Invoice')

@php
$optionsStatus = [
    ['value' => 'Lunas', 'text' => 'Lunas'],
    ['value' => 'Ditunda', 'text' => 'Ditunda'],
    ['value' => 'Gagal', 'text' => 'Gagal'],
];
@endphp

@section('content')
<x-content>
    <x-row>
        <x-card-collapsible>
            <x-row>
                <x-col class="mb-3">
                        <button type="button" class="btn btn-primary" data-toggle="modal" data-target="#add-modal">Tambah</button>
                </x-col>

                <x-col>
                    <x-table :thead="['Repair Order ID ', 'Nama Customer', 'Tanggal Dikeluarkan', 'Status Pembayaran', 'Aksi']">
                        @foreach ($invoices as $invoice)
                            <tr>
                                <td>{{ $loop->iteration }}</td>
                                <td>{{ $invoice->repair_order_id }}</td>
                                <td>{{ $invoice->first_name }} {{ $invoice->last_name }}</td>
                                <td>{{ $invoice->date_issued }}</td>
                                <td>
                                    @php
                                        $optionsStatusColl = collect($optionsStatus);
                                        $status = $optionsStatusColl->where('value', $invoice->payment_status)->first();
                                        if ($status) {
                                            echo $status['text'];
                                        }
                                    @endphp
                                </td>
                                <td>
                                    <a
                                    href="{{ route('invoice.show', $invoice->id) }}"
                                    class="btn btn-warning"
                                    title="Ubah"><i class="fas fa-pencil-alt"></i></a>

                                    <form style=" display:inline!important;" method="POST" action="{{ route('invoice.destroy', $invoice->id) }}">
                                        @csrf
                                        @method('DELETE')

                                        <button
                                            type="submit"
                                            class="btn btn-danger"
                                            onclick="return confirm('Apakah anda yakin ingin menghapus data ini?')"
                                            title="Hapus"><i class="fas fa-trash-alt"></i></button>
                                    </form>
                                </td>
                            </tr>
                        @endforeach
                    </x-table>
                </x-col>
            </x-row>
        </x-card-collapsible>
    </x-row>
</x-content>

<x-modal :title="'Tambah Data'" :id="'add-modal'" :size="'xl'">
    <form style="width: 100%" action="{{ route('invoice.store') }}" method="POST">
        @csrf
        @method('POST')
        <!-- belum selesai -->
        <x-row>
            <x-in-select
            :label="'Repair Order ID / Nama Customer'"
            :placeholder="'Pilih ID / Nama'"
            :col="6"
            :name="'repair_order_id'"
            :id="'repair_order_id'"
            :required="true"></x-in-select>
            <x-in-text col="6" :type="'date'" :label="'date_issued'" :id="'date_issued'" :name="'date_issued'" :required="true" />
            <!-- <x-in-text col="6" :type="'number'" :label="'total_amount'" :id="'total_amount'" :name="'total_amount'" :required="true" /> -->
            <x-in-select
                :label="'Payment Status'"
                :placeholder="'Select Payment Status'"
                :col="6"
                :name="'payment_status'"
                :id="'payment_status'"
                :required="true"
                :options="$optionsStatus" ></x-in-select>
        </x-row>

        <x-col class="text-right">
            <button type="button" class="btn btn-default" data-dismiss="modal">Tutup</button>
            <button type="submit" class="btn btn-primary">Simpan</button>
        </x-col>
    </form>
</x-modal>
@endsection

@push('js')
    <input type="hidden" id="url-invoices" value="{{ route('select2.repair-orders') }}">

    <script>
        $(function()
        {
            $('#repair_order_id').select2({
                theme: 'bootstrap4',
                allowClear: true,
                placeholder: {
                    id: '',
                    text: 'Pilih Repair Order'
                },
                ajax: {
                    url: $('#url-invoices').val(),
                    dataType: 'json',
                    delay: 500,
                    data: function (params) {
                        let query = {
                            search: params.term
                        }

                        return query;
                    },
                    processResults: function (data) {
                        const finalData = data.map(function(item) {
                            return {
                                id: item.id,
                                text: item.id + " / " + [item.first_name, item.last_name].join(' ')
                            }
                        });

                        return {
                            results: finalData
                        };
                    },
                    cache: false
                }
            });
        });
    </script>
@endpush