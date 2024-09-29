@extends('App')

@section('content-header', 'Daftar Pembayaran')

@php
$optionsPaymentMethod = [
    ['value' => 'Cash', 'text' => 'Cash'],
    ['value' => 'Credit Card', 'text' => 'Credit Card'],
    ['value' => 'Bank Transfer', 'text' => 'Bank Transfer'],
];
@endphp

@section('content')
<x-content>
    <x-row>
        <x-card-collapsible>
            <x-row>
                <x-col class="mb-3">
                    <button type="button" class="btn btn-primary" data-toggle="modal" data-target="#add-payment-modal">Tambah Pembayaran</button>
                </x-col>

                <x-col>
                    <x-table :thead="['Invoice ID', 'Nama Customer', 'Tanggal Dibayar', 'Metode Pembayaran', 'Jumlah Pembayaran', 'Aksi']">
                        @foreach ($payments as $payment)
                            <tr>
                                <td>{{ $loop->iteration }}</td>
                                <td>{{ $payment->invoice_id }}</td>
                                <td>{{ $payment->first_name }} {{ $payment->last_name }}</td>
                                <td>{{ $payment->date_paid }}</td>
                                <td>
                                    @php
                                        $optionsPaymentMethodColl = collect($optionsPaymentMethod);
                                        $paymentMethod = $optionsPaymentMethodColl->where('value', $payment->payment_method)->first();
                                        if ($paymentMethod) {
                                            echo $paymentMethod['text'];
                                        }
                                    @endphp
                                </td>
                                <td>{{ number_format($payment->payment_amount, 2) }}</td>
                                <td>
                                    <a
                                    href="{{ route('payment.show', $payment->id) }}"
                                    class="btn btn-warning"
                                    title="Ubah"><i class="fas fa-pencil-alt"></i></a>

                                    <form style=" display:inline!important;" method="POST" action="{{ route('payment.destroy', $payment->id) }}">
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

<x-modal :title="'Tambah Pembayaran'" :id="'add-payment-modal'" :size="'xl'">
    <form style="width: 100%" action="{{ route('payment.store') }}" method="POST">
        @csrf
        @method('POST')
        <x-row>
            <x-in-select
            :label="'Invoice ID / Nama Customer'"
            :placeholder="'Pilih Invoice / Nama Customer'"
            :col="6"
            :name="'invoice_id'"
            :id="'invoice_id'"
            :required="true"></x-in-select>
            <x-in-text col="6" :type="'date'" :label="'Tanggal Dibayar'" :id="'date_paid'" :name="'date_paid'" :required="true" />
            <x-in-text col="6" :type="'number'" :label="'Jumlah Pembayaran'" :id="'payment_amount'" :name="'payment_amount'" :required="true" />
            <x-in-select
                :label="'Metode Pembayaran'"
                :placeholder="'Pilih Metode Pembayaran'"
                :col="6"
                :name="'payment_method'"
                :id="'payment_method'"
                :required="true"
                :options="$optionsPaymentMethod" ></x-in-select>
        </x-row>

        <x-col class="text-right">
            <button type="button" class="btn btn-default" data-dismiss="modal">Tutup</button>
            <button type="submit" class="btn btn-primary">Simpan</button>
        </x-col>
    </form>
</x-modal>
@endsection

@push('js')
    <input type="hidden" id="url-invoices" value="{{ route('select2.invoices') }}">

    <script>
        $(function()
        {
            $('#invoice_id').select2({
                theme: 'bootstrap4',
                allowClear: true,
                placeholder: {
                    id: '',
                    text: 'Pilih Invoice'
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
